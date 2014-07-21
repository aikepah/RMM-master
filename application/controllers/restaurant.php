<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant extends CI_Controller {

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
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$main_user = $this->ion_auth->user($user->main_user_id)->row();
		$data = array();
		$query2 = $this->db->query("select * from menu_items where main_user_id=".$user->main_user_id." order by item_category, item_name");
		$data['menu_items'] = $query2->result_array();
		$data['main_user'] = $main_user;
		$this->load->view('restaurant_index', $data);
	}

	function update_menu_item($menuItemId = null)
	{
		if(!isset($_POST) || empty($_POST))
		{
			return;
		}
		if(!$this->ion_auth->logged_in())
		{
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$_POST['main_user_id'] = $user->main_user_id;
		if($menuItemId)
		{
			$this->db->update('menu_items',$_POST,array('menu_item_id'=>$menuItemId));
		}
		else
		{
			$this->db->insert('menu_items',$_POST);
		}
	}
	
	function delete_menu_item($menuItemId = null)
	{
		if(!$this->ion_auth->logged_in())
		{
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		if($menuItemId)
		{
			$this->db->delete('menu_items',array('menu_item_id'=>$menuItemId,'main_user_id'=>$user->main_user_id));
		}
	}
	
	function update_hours()
	{		if(!isset($_POST) || empty($_POST))
		{
			return;
		}
		if(!$this->ion_auth->logged_in())
		{
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$this->db->update('users',array('hours_text'=>$_POST['hours_text']),array('user_id'=>$user->main_user_id));
		
	}

    function upload_menu()
    {
        // TODO: allow pdfs and auto convert them to pngs for display purposes
        $basePath = FCPATH.'udata/';
        $baseUrl = "http://image.einovie.com/rmm/udata/";
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			return;
		}
        if(!isset($_FILES["file"]))
        {
            // echo '<html><body><form action="'. site_url('restaurant/upload_menu') .'" method="post" enctype="multipart/form-data"><label for="file">Filename:</label><input type="file" name="file" id="file"><br><input type="submit" name="submit" value="Submit"></form></body></html>';
            return;
        }
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$main_user = $this->ion_auth->user($user->main_user_id)->row();
        
        $error = $_FILES["file"]["error"];
        $name = $_FILES['file']['name'];
        $name = $user->main_user_id . '-'. time() . $name;
        //$filedata = file_get_contents($_FILES["file"]["tmp_name"]);
      	move_uploaded_file($_FILES["file"]["tmp_name"], $basePath . $name);
        if(strtolower(pathinfo($name, PATHINFO_EXTENSION))=='pdf')
        {
            $oldname = $name;
            $name = str_ireplace('.pdf','.png',$name);
            exec('convert -alpha deactivate -append '.$basePath.$oldname.' '.$basePath.$name);
        }
        $dbData = array(
            'menu_image_path' => $baseUrl . $name,
        );
        $this->db->update('users',$dbData,array('user_id'=>$user->main_user_id));
        
    }

	
}
