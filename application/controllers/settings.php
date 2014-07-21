<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

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
		if(isset($_POST) && !empty($_POST))
		{
            $dbData = array(
                'email_enable_contact_update' => (isset($_POST['email_enable_contact_update']) ? 1 : 0),
                'email_enable_text_invitation' => (isset($_POST['email_enable_text_invitation']) ? 1 : 0),
            );
			$this->db->update('users',$dbData,array('user_id'=>$user->main_user_id));
			$data['message'] = 'Settings Saved.';
		}
		$main_user = $this->ion_auth->user($user->main_user_id)->row();
		$data['main_user'] = $main_user;
		
		$this->load->view('settings_index', $data);
	}
    
    function test_timezone()
    {
        $zServer = date("Z", time());
        date_default_timezone_set('America/Denver');
        $zUser = date("Z", time());
        echo date_default_timezone_get() . ' date and time is ' . date('Y-m-d H:i:s') . '<br />';
        $query = $this->db->get_where('message_log',array('message_log_id'=>1));
        $rec = $query->row();
        //var_dump($rec);
        echo date('Y-m-d H:i:s',strtotime($rec->sent_date)) . '<br>';
        
        //Get the timestamp
$t = time();

//Calculate how much the timestamp is off of GMT
$z = date ("Z", $t);
echo "$z";
echo "
";

$gmt = $t-$z;
//Show the GMT time
echo "GMT Time: ";
echo date ("h:i A", $gmt);
echo "<br>";

//Shows time in the state of WI at -6 GMT
echo "Wisconsin Time: ";
echo date ("h:i A" , $gmt-21600);
echo "<br>";

//Shows time in China at +8 GMT
echo "China Time: ";
echo date ("h:i A", $gmt+28800);
echo "<br>";
echo 'hours: '.date('G',$t).'<br>';
//echo 'test: '.date('Y-m-d H:i:s',strtotime("09:00:00 +1 day")).'<br>';
$sTime = strtotime("09:00:00")-$zUser+$zServer;
echo 'test: '.date('Y-m-d H:i:s',$sTime).'<br>';
    }

	function save_settings()
	{
		$data = array();
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			//redirect('auth/login', 'refresh');
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		if(isset($_POST) && !empty($_POST))
		{
			$dbData = array(
                'email_enable_contact_update' => (isset($_POST['email_enable_contact_update']) ? 1 : 0),
                'email_enable_text_invitation' => (isset($_POST['email_enable_text_invitation']) ? 1 : 0),
            );
			$this->db->update('users',$dbData,array('user_id'=>$user->main_user_id));
			//$data['message'] = 'Auto Pilot Settings Saved.';
		}
		echo 'Settings Updated';
		
	}


}
