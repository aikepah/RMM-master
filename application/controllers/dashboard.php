<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->library('user_agent');

		// Load MongoDB library instead of native db driver if required
		//$this->config->item('use_mongodb', 'ion_auth') ?
		//$this->load->library('mongo_db') :

		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->helper('language');
		$this->load->helper('html');		
	}

	//redirect if needed, otherwise display the user list
	function index($cachebuster=null)
	{
		$data = array();
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		if(isset($_POST) && !empty($_POST))
		{
			$saveData['auto_enable_monthly'] = (isset($_POST['enable-auto-monthly']) ? 1 : 0);
			$saveData['auto_enable_birthday'] = (isset($_POST['enable-auto-birthday']) ? 1 : 0);
			$saveData['auto_enable_anniversary'] = (isset($_POST['enable-auto-anniversary']) ? 1 : 0);
			$saveData['auto_enable_welcome'] = (isset($_POST['enable-auto-welcome']) ? 1 : 0);
			$saveData['auto_welcome_template'] = $_POST['weTemplate'];
			$saveData['auto_welcome_subject'] = $_POST['weSubject'];
			$saveData['auto_welcome_body'] = $_POST['weBody'];
			$saveData['auto_birthday_template'] = $_POST['beTemplate'];
			$saveData['auto_birthday_subject'] = $_POST['beSubject'];
			$saveData['auto_birthday_body'] = $_POST['beBody'];
			$saveData['auto_anniversary_template'] = $_POST['aeTemplate'];
			$saveData['auto_anniversary_subject'] = $_POST['aeSubject'];
			$saveData['auto_anniversary_body'] = $_POST['aeBody'];
			$this->db->update('users',$saveData,array('user_id'=>$user->main_user_id));
			$data['message'] = 'Auto Pilot Settings Saved.';
		}
		$main_user = $this->ion_auth->user($user->main_user_id)->row();
		$data['main_user'] = $main_user;
		//if($this->agent->is_mobile())
		//{
		//	redirect('dashboard/mobile', 'refresh');
		//}		
		$query2 = $this->db->query("select * from menu_items where main_user_id=".$user->main_user_id." order by item_category, item_name");
		$data['menu_items'] = $query2->result_array();
		$query3 = $this->db->query("select et.email_template_id, et.template_name, et.template_category, et.template_active, et.template_category, et.template_category as 'group' from email_templates as et where et.template_active = 1 and (main_user_id is null or main_user_id = ".$user->main_user_id.") order by et.template_category, et.template_name");
		$data['email_templates'] = $query3->result_array();
		$query4 = $this->db->query("select count(message_id) as text_count from messages where main_user_id = ".$user->main_user_id." and message_type_id = 2 and month(sent_date) = month(curdate()) and year(sent_date) = year(curdate())");
        $data['texts_left'] = $main_user->monthly_text_messages - $query4->row()->text_count;
        if($data['texts_left'] < 0)
            $data['texts_left'] = 0;
        $query5 = $this->db->get_where('contact_groups',array('main_user_id'=>$user->main_user_id));
        $data['contact_groups'] = $query5->result_array();
		$this->load->view('dashboard_index', $data);
	}

	function mobile()
	{
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$data = array();
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$query2 = $this->db->query("select * from contacts where main_user_id=".$user->main_user_id," limit 40");
		$data['contact_list'] = $query2->result_array();
		
		$this->load->view('dashboard_mobile', $data);
	}
    
    function test_image()
    {
        $imagick = new Imagick();
        var_dump($imagick);
    }
	
	function email_preview($template_id=null)
	{
		if(!$template_id)
		{
			return;
		}
		if(!$this->ion_auth->logged_in())
		{
			return;
		}

		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$main_user = $this->ion_auth->user($user->main_user_id)->row();
		$data['main_user'] = $main_user;

		$query = $this->db->query("select * from email_templates as et where et.email_template_id = ".mysql_real_escape_string($template_id));
				
		$row = $query->row_array();
		if(isset($_POST) && !empty($_POST) && $_POST['email_body'])
		{
			$row['email_body'] = str_replace('%secondbody%',$_POST['email_body'],$row['email_body']);
		}
		else 
		{
			$row['email_body'] = str_replace('%secondbody%','',$row['email_body']);
		}
		if($main_user->email_enable_text_invitation)
        {
            $row['email_body'] = str_replace('%textinvitation%','<div>Did you know we have more special promotions available via text messages? <a id="subscribetexts" href="http://www.rmm-mail.com/rmm/index.php/contacts/text_signup/%supportid%" style="color: #0000FF">Click here to subscribe.</a></div>',$row['email_body']);
        }
        else
        {
            $row['email_body'] = str_replace('%textinvitation%','',$row['email_body']);
        }
		if($main_user->email_enable_contact_update)
        {
            $row['email_body'] = str_replace('%updatecontact%','<br>To update your contact information, <a id="updatecontact" href="http://www.rmm-mail.com/rmm/index.php/contacts/contact_update/%supportid%" style="color: #0000FF">click here.</a>',$row['email_body']);
        }
        else
        {
            $row['email_body'] = str_replace('%updatecontact%','',$row['email_body']);
        }

		if($main_user->hours_text)
        {
            $row['email_body'] = str_replace('%fourthbody%','<span style="font-weight: bold;"></span><br><span style="font-weight: normal;">'.$main_user->hours_text.'</span>',$row['email_body']);
        }
        else
        {
            $row['email_body'] = str_replace('%fourthbody%','<span></span>',$row['email_body']);
        }
		echo $row['email_body'];
	}

}
