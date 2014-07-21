<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		// Load MongoDB library instead of native db driver if required
		//$this->config->item('use_mongodb', 'ion_auth') ?
		//$this->load->library('mongo_db') :

		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->helper('language');
	}

	//redirect if needed, otherwise display the user list
	function index($cachebuster=null)
	{
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$data = array();
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$main_user = $this->ion_auth->user($user->main_user_id)->row();
		$data['main_user'] = $main_user;
		$query = $this->db->query("select * from messages as m left join message_types as mt on (m.message_type_id = mt.message_type_id) where m.message_type_id in (1,2,3) and (m.inactive is null or m.inactive = 0) and m.main_user_id=".$user->main_user_id." group by m.message_id order by m.sent_date, m.scheduled_date");
		$data['scheduled_messages'] = $query->result_array();
		foreach($data['scheduled_messages'] as &$msg)
		{
			//quick bandaid, need to find a better way to do this
			if($msg['scheduled_date']=='0000-00-00 00:00:00')
			{
				$msg['scheduled_date'] = null;
			}
		}
		//var_dump($data['scheduled_messages']);
		//return;
		$query3 = $this->db->query("select et.email_template_id, et.template_name, et.template_category, et.template_active, et.template_category, et.template_category as 'group' from email_templates as et where et.template_active = 1 and (main_user_id is null or main_user_id = ".$user->main_user_id.") order by et.template_category, et.template_name");
		$data['email_templates'] = $query3->result_array();
		$query4 = $this->db->query("select * from message_types");
		$data['message_types'] = array();
		foreach($query4->result() as $row)
		{
			$data['message_types'][] = $row->message_type_name;
		}
        $query5 = $this->db->get_where('contact_groups',array('main_user_id'=>$user->main_user_id));
        $data['contact_groups'] = $query5->result_array();
		$this->load->view('messages/message_index', $data);
	}

	function templates()
	{
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$data = array();
		
		$this->load->view('dashboard_index', $data);
	}
	
	function save_message($messageId=null)
	{
        error_reporting(E_ERROR | E_PARSE);
        if(!isset($_POST) || empty($_POST))
		{
			echo 'ERROR: No message data found';
            return;
		}
		if(!$this->ion_auth->logged_in())
		{
			echo 'ERROR: You must login to save a message';
            return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$main_user = $this->ion_auth->user($user->main_user_id)->row();
        $zServer = date("Z", time());
        if($main_user->user_timezone)
        {
            date_default_timezone_set($main_user->user_timezone);
        }
        $zUser = date("Z", time());
        $dbData = $_POST;
		$dbData['main_user_id'] = $user->main_user_id;
		if(!$dbData['scheduled_date'] || $dbData['scheduled_date']=="" || $dbData['scheduled_date']=="0000-00-00 00:00:00")
			$dbData['scheduled_date'] = null;
        if($dbData['message_type_id']==2) // only if it's a text message do we limit the send time for now
        {
          if(!isset($dbData['scheduled_date']))
          {
              $t = time();
              $tHour = date('G',$t);
              if($tHour < 9) //it's before 9am, schedule for today at 9
              {
                    $dbData['scheduled_date'] = date('Y-m-d H:i:s',strtotime("09:00:00"));
              }
              else if($tHour >= 19) //it's after 7pm, schedule for tomorrow at 9
              {
                    $dbData['scheduled_date'] = date('Y-m-d H:i:s',strtotime("09:00:00 +1 day"));
              }
          }
        }
/*        
        //lets leave it in the user's timezone instead, then just look at the timezone of the user when the cron job runs, that way we don't get out of sync from daylight savings
        if(isset($dbData['scheduled_date'])) //convert from user's timezone to server timezone
        {
            $sTime = strtotime($dbData['scheduled_date'])-$zUser+$zServer;
            $dbData['scheduled_date'] = date('Y-m-d H:i:s',$sTime);
        }
*/
		if($messageId)
		{
			$this->db->update('messages',$dbData,array('message_id'=>$messageId,'main_user_id'=>$user->main_user_id));
            //if(!isset($_POST['scheduled_date']))
            //    redirect('message_manager/send_message/'.$messageId);
            echo $messageId;
		}
		else
		{
            if(!isset($dbData['scheduled_date']) && isset($dbData['send_timeframe']) && $dbData['send_timeframe'] > 0)
                $dbData['scheduled_date'] = date('Y-m-d',strtotime('+1 day'));

			//first check for an exact duplicate of this message that's already scheduled, to prevent double clicking and sending a message twice
            $dquery = $this->db->get_where('messages',array(
                'message_name'=>$dbData['message_name'],
                'message_type_id'=>$dbData['message_type_id'],
                'main_user_id'=>$dbData['main_user_id'],
                'scheduled_date'=> (isset($dbData['scheduled_date']) ? $dbData['scheduled_date'] : null),
                'message_timestamp >=' => date('Y-m-d H:i:s',strtotime('-1 minute')) ));
            if($dquery->num_rows())
            {
              echo 'DCLICK';
              return;
            }
            if($dbData['text_message'])
            {
                $dbData['text_message'] = '%firstname%, '.$dbData['text_message'].' -'.$main_user->text_name;
            } 
            $this->db->insert('messages',$dbData);
            $messageId = $this->db->insert_id();
            //if(!isset($_POST['scheduled_date']))
            //    redirect('message_manager/send_message/'.$messageId);
            echo $messageId;
		}
	}

	function delete_message($messageId=null)
	{
		if(!$messageId)
		{
			return;	
		}
		if(!$this->ion_auth->logged_in())
		{
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$this->db->update('messages',array('inactive'=>1),array('message_id'=>$messageId,'main_user_id'=>$user->main_user_id));
		//$this->db->delete('messages',array('message_id'=>$messageId,'main_user_id'=>$user->main_user_id));

	}
        
        function upload_image($messageId=null)
	{
        error_reporting(E_ERROR | E_PARSE);
        if(!isset($_POST) || empty($_POST))
		{
			echo 'ERROR: No message data found';
            return;
		}
		if(!$this->ion_auth->logged_in())
		{
			echo 'ERROR: You must login to save a message';
            return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$main_user = $this->ion_auth->user($user->main_user_id)->row();
        $zServer = date("Z", time());
        if($main_user->user_timezone)
        {
            date_default_timezone_set($main_user->user_timezone);
        }
        $zUser = date("Z", time());
        $dbData = $_POST;
		$dbData['main_user_id'] = $user->main_user_id;
		if(!$dbData['scheduled_date'] || $dbData['scheduled_date']=="" || $dbData['scheduled_date']=="0000-00-00 00:00:00")
			$dbData['scheduled_date'] = null;
        if($dbData['message_type_id']==2) // only if it's a text message do we limit the send time for now
        {
          if(!isset($dbData['scheduled_date']))
          {
              $t = time();
              $tHour = date('G',$t);
              if($tHour < 9) //it's before 9am, schedule for today at 9
              {
                    $dbData['scheduled_date'] = date('Y-m-d H:i:s',strtotime("09:00:00"));
              }
              else if($tHour >= 19) //it's after 7pm, schedule for tomorrow at 9
              {
                    $dbData['scheduled_date'] = date('Y-m-d H:i:s',strtotime("09:00:00 +1 day"));
              }
          }
        }
        
        $basePath = FCPATH . 'udata/';

        if (isset($_FILES['ftImage'])) {
            $error = $_FILES["ftImage"]["error"];
            $name = urlencode($_FILES['ftImage']['name']);
            $name = $user->main_user_id . '-' . time() . $name;
            //$filedata = file_get_contents($_FILES["file"]["tmp_name"]);
            move_uploaded_file($_FILES["ftImage"]["tmp_name"], $basePath . $name);
        }

/*        
        //lets leave it in the user's timezone instead, then just look at the timezone of the user when the cron job runs, that way we don't get out of sync from daylight savings
        if(isset($dbData['scheduled_date'])) //convert from user's timezone to server timezone
        {
            $sTime = strtotime($dbData['scheduled_date'])-$zUser+$zServer;
            $dbData['scheduled_date'] = date('Y-m-d H:i:s',$sTime);
        }
*/
		if($messageId)
		{
			$this->db->update('messages',$dbData,array('message_id'=>$messageId,'main_user_id'=>$user->main_user_id));
            //if(!isset($_POST['scheduled_date']))
            //    redirect('message_manager/send_message/'.$messageId);
            echo $messageId;
		}
		else
		{
            if(!isset($dbData['scheduled_date']) && isset($dbData['send_timeframe']) && $dbData['send_timeframe'] > 0)
                $dbData['scheduled_date'] = date('Y-m-d',strtotime('+1 day'));

			//first check for an exact duplicate of this message that's already scheduled, to prevent double clicking and sending a message twice
            $dquery = $this->db->get_where('messages',array(
                'message_name'=>$dbData['message_name'],
                'message_type_id'=>$dbData['message_type_id'],
                'main_user_id'=>$dbData['main_user_id'],
                'scheduled_date'=> (isset($dbData['scheduled_date']) ? $dbData['scheduled_date'] : null),
                'message_timestamp >=' => date('Y-m-d H:i:s',strtotime('-1 minute')) ));
            if($dquery->num_rows())
            {
              echo 'DCLICK';
              return;
            }
            if($dbData['text_message'])
            {
                $dbData['text_message'] = '%firstname%, '.$dbData['text_message'].' -'.$main_user->text_name;
            } 
            $dbData['image'] = $name;
            $this->db->insert('messages',$dbData);
            $messageId = $this->db->insert_id();
            //if(!isset($_POST['scheduled_date']))
            //    redirect('message_manager/send_message/'.$messageId);
            echo $messageId;
		}
	}
        
/*
	function index_old()
	{
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$data = array();
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$query = $this->db->query("select m.* from messages as m where m.message_type_id = 1 and m.main_user_id=".$user->main_user_id." group by m.message_id");
		$data['auto_messages'] = $query->result_array();
		$query = $this->db->query("select m.* from messages as m where m.message_type_id = 2 and m.main_user_id=".$user->main_user_id." group by m.message_id order by m.scheduled_date");
		$scheduled_messages = array();
		foreach($query->result_array() as $row)
		{
			$dateStr = date('Y-n-j',strtotime($row['scheduled_date']));
			if(!isset($scheduled_messages[$dateStr]) || !is_array($scheduled_messages[$dateStr]))
				$scheduled_messages[$dateStr] = array();
			$scheduled_messages[$dateStr][] = $row;
		}
		$data['scheduled_messages'] = $scheduled_messages;
		//var_dump($scheduled_messages);
		$query = $this->db->query("select * from distribution_lists where main_user_id=".$user->main_user_id);
		$data['distribution_lists'] = $query->result_array();
		$this->load->view('messages/message_index_old', $data);
	}
*/

}
