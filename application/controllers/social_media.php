<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Social_media extends CI_Controller {

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
		
		$this->load->view('social_media_index', $data);
	}

	function authorize_twitter($text_data=null)
	{
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$data = array();
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		//$main_user = $this->ion_auth->user($user->main_user_id)->row();

        $tmhOAuth = new tmhOAuth(array(
		  'consumer_key' => 'skN6wo6LuAQUXWhk3liw',
		  'consumer_secret' => 'uuxCmdY0omdMsReJB3jlqkAEROcOzeUZestdJtVDwM',
//		  'token' => '2280167384-mw4bfClSP7ufSOnlfy1OeRjOusZm60pO7oP3e4g',
//		  'secret' => 'niJQedyNlH8BvsZyPptDtTfHvD3Ol96Ozm45r1Oxl8mm7',
		));
        if(!$this->input->get())
        {
        	  $code = $tmhOAuth->apponly_request(array(
        	    'without_bearer' => true,
        	    'method' => 'POST',
        	    'url' => $tmhOAuth->url('oauth/request_token', ''),
        	    'params' => array(
        	      'oauth_callback' => 'https://www.einovie.com/rmm/index.php/social_media/authorize_twitter/',
        	    ),
        	  ));
        	
        	  if ($code != 200) {
        	    error("There was an error communicating with Twitter. ". $tmhOAuth->response['response']);
        	    return;
        	  }
        	
        	  // store the params into the session so they are there when we come back after the redirect
        	  $_SESSION['oauth'] = $tmhOAuth->extract_params($tmhOAuth->response['response']);
        	
        	  // check the callback has been confirmed
        	  if ($_SESSION['oauth']['oauth_callback_confirmed'] !== 'true') 
              {
        	    echo('The callback was not confirmed by Twitter so we cannot continue.');
        	  } 
              else 
              {
        	    $url = $tmhOAuth->url('oauth/authorize', '') . "?oauth_token=".$_SESSION['oauth']['oauth_token'];
                redirect($url);
        	  }
        }
        else
        {
/*
            $params = array();
            $text_data = str_replace('','?',$text_data);
            foreach (explode('&', $text_data) as $p) 
            {
                $arr = explode('=', $p);
                if(isset($arr[1]))
                    $params[$arr[0]] = $arr[1];
            }
*/
            if(!$this->input->get('oauth_token') || !$this->input->get('oauth_verifier'))
            {
                redirect('social_media');
                return;
            }
          
            // update with the temporary token and secret
            $tmhOAuth->reconfigure(array_merge($tmhOAuth->config, array(
              'token'  => $this->input->get('oauth_token'),
              'secret' => $this->input->get('oauth_verifier'),
            )));
          
            $code = $tmhOAuth->user_request(array(
              'method' => 'POST',
              'url' => $tmhOAuth->url('oauth/access_token', ''),
              'params' => array(
                'oauth_verifier' => trim($this->input->get('oauth_verifier')),
              )
            ));
          
            if ($code == 200) 
            {
              $oauth_creds = $tmhOAuth->extract_params($tmhOAuth->response['response']);
              $dbData = array(
                'twitter_name' => $oauth_creds['screen_name'],
                'twitter_token' => $oauth_creds['oauth_token'],
                'twitter_secret' => $oauth_creds['oauth_token_secret'],
              );
              
    		  $this->db->update('users',$dbData,array('user_id'=>$user->main_user_id));
              
              redirect('social_media');
              
            }
        }
        
    }
    
    function fbtab()
    {
        echo 'fbtab info';
    }

	function authorize_facebook($text_data=null)
	{
		$data = array();
		if(isset($_POST) && !empty($_POST))
		{
			$saveData['facebook_user_id'] = $_POST['facebook_user_id'];
			$saveData['facebook_token'] = $_POST['facebook_token'];
			$saveData['facebook_page_token'] = $_POST['facebook_page_token'];
			$this->db->update('users',$saveData,array('user_id'=>$_POST['userid'])); //need to make this more secure
            
			//$data['message'] = 'Auto Pilot Settings Saved.';
		}
        //redirect('social_media');
    
    }

	function authorize_facebook_tab($pageId=null)
	{
		if(!$pageId)
            return;
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			//redirect('auth/login', 'refresh');
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
        $data = array();
		$saveData['facebook_page_id'] = $pageId;
		$this->db->update('users',$saveData,array('user_id'=>$user->main_user_id)); //need to make this more secure
        redirect('https://www.facebook.com/dialog/oauth?scope=manage_pages,publish_stream&client_id=495711410548329&response_type=code&redirect_uri=https://www.einovie.com/rmm/fbauth.php?userid='.$user->main_user_id.'_'.$pageId);
    
    }

	
	function save_facebook_settings()
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
			$saveData['facebook_enable_hours'] = (isset($_POST['facebook-enable-hours']) ? 1 : 0);
			$saveData['facebook_enable_menu'] = (isset($_POST['facebook-enable-menu']) ? 1 : 0);
			$saveData['facebook_enable_vip'] = (isset($_POST['facebook-enable-vip']) ? 1 : 0);
			$this->db->update('users',$saveData,array('user_id'=>$user->main_user_id));
			//$data['message'] = 'Auto Pilot Settings Saved.';
		}
		echo 'Settings Updated';
		
	}
    
    function facebook_tab($text_data=null)
    {
        echo '<p>test: '.$text_data,'</p>';
        if(isset($_POST))
		{
			var_dump($_POST);
		}
    }

}
