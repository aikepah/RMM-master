<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Site_admin extends CI_Controller {

	var $user_data = array(
          'grid_name' => 'jqxgrid',
          'fields' => array(
              array(
                  'field_name' => 'user_id', 
                  'display_name' => 'User Id',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 0,
                  'edit_field' => 'text',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'active', 
                  'display_name' => 'Active',
                  'field_type' => 'int',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 50,
                  'grid_other' => null,
                  'edit_display' => 0,
                  'edit_field' => 'text',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'email', 
                  'display_name' => 'Email Address',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 200,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'new_password', 
                  'display_name' => 'New Password',
                  'query_name' => '"" as new_password', 
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 0,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'password',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'confirm_password', 
                  'query_name' => '"" as confirm_password', 
                  'display_name' => 'Confirm Password',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 0,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'password',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'first_name', 
                  'display_name' => 'First Name',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'last_name', 
                  'display_name' => 'Last Name',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'company', 
                  'display_name' => 'Company',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 180,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'phone', 
                  'display_name' => 'Phone',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 120,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'from_email', 
                  'display_name' => 'From Email',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 0,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 2,
              ),
              array(
                  'field_name' => 'text_name', 
                  'display_name' => 'Text Message Name',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 0,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 2,
              ),
              array(
                  'field_name' => 'user_timezone', 
                  'display_name' => 'Time Zone',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 140,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 2,
              ),
              array(
                  'field_name' => 'urlcode', 
                  'display_name' => 'Embed code',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 140,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 2,
              ),

          ),
      );


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
		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	}
	
	function users($cachebuster=null)
	{
		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$data = array();
		$query2 = $this->db->query("select count(user_id) as user_count from users where user_id is not null");
        $data['user_count'] = $query2->row()->user_count;
        
        $data['user_data'] = $this->user_data;
		$this->load->view('site_admin/users', $data);
	}
	
	function load_users($data=null)
	{
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			echo 'not logged in';
			return;
		}
        $selectFields = array();
        foreach($this->user_data['fields'] as $user_field)
        {
            if(isset($user_field['query_name']))
                $selectFields[] = $user_field['query_name'];
            else
                $selectFields[] = $user_field['field_name'];
        }
        
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
        //$getVars = $this->input->get();
        if($this->input->get('pagesize'))
        {
            $pagesize = $this->input->get('pagesize');
        }
        else
        {
            $pagesize = 10;
        }
        if($this->input->get('pagenum'))
        {
            $pagenum = $this->input->get('pagenum');
        }
        else
        {
            $pagenum = 0;
        }
        if($this->input->get('sortdatafield'))
        {
            $sortfield = $this->input->get('sortdatafield');
            $sortorder = $this->input->get('sortorder');
            if($sortorder=='desc')
                $sortStr = " order by ".$sortfield." desc";
            else
                $sortStr = " order by ".$sortfield." asc";
        }
        else
        {
            $sortStr = "";
        }
    	if($this->input->get('filterscount'))
    	{
    		$filterscount = $this->input->get('filterscount');
    		
    		if($filterscount > 0)
    		{
    			$where = " and (";
    			$tmpdatafield = "";
    			$tmpfilteroperator = "";
    			for ($i=0; $i < $filterscount; $i++)
    		    {
    				// get the filter's value.
    				$filtervalue = $this->input->get("filtervalue" . $i);
    				// get the filter's condition.
    				$filtercondition = $this->input->get("filtercondition" . $i);
    				// get the filter's column.
    				$filterdatafield = $this->input->get("filterdatafield" . $i);
    				// get the filter's operator.
    				$filteroperator = $this->input->get("filteroperator" . $i);
    				
    				if ($tmpdatafield == "")
    				{
    					$tmpdatafield = $filterdatafield;			
    				}
    				else if ($tmpdatafield <> $filterdatafield)
    				{
    					$where .= ") and (";
    				}
    				else if ($tmpdatafield == $filterdatafield)
    				{
    					if ($tmpfilteroperator == 0)
    					{
    						$where .= " and ";
    					}
    					else $where .= " or ";	
    				}
    				
    				// build the "WHERE" clause depending on the filter's condition, value and datafield.
    				switch($filtercondition)
    				{
    					case "NOT_EMPTY":
    					case "NOT_NULL":
    						$where .= " " . $filterdatafield . " not like '" . "" ."'";
    						break;
    					case "EMPTY":
    					case "NULL":
    						$where .= " " . $filterdatafield . " like '" . "" ."'";
    						break;
    					case "CONTAINS_CASE_SENSITIVE":
    						$where .= " BINARY  " . $filterdatafield . " like '%" . $filtervalue ."%'";
    						break;
    					case "CONTAINS":
    						$where .= " " . $filterdatafield . " like '%" . $filtervalue ."%'";
    						break;
    					case "DOES_NOT_CONTAIN_CASE_SENSITIVE":
    						$where .= " BINARY " . $filterdatafield . " not like '%" . $filtervalue ."%'";
    						break;
    					case "DOES_NOT_CONTAIN":
    						$where .= " " . $filterdatafield . " not like '%" . $filtervalue ."%'";
    						break;
    					case "EQUAL_CASE_SENSITIVE":
    						$where .= " BINARY " . $filterdatafield . " = '" . $filtervalue ."'";
    						break;
    					case "EQUAL":
    						$where .= " " . $filterdatafield . " = '" . $filtervalue ."'";
    						break;
    					case "NOT_EQUAL_CASE_SENSITIVE":
    						$where .= " BINARY " . $filterdatafield . " <> '" . $filtervalue ."'";
    						break;
    					case "NOT_EQUAL":
    						$where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";
    						break;
    					case "GREATER_THAN":
    						$where .= " " . $filterdatafield . " > '" . $filtervalue ."'";
    						break;
    					case "LESS_THAN":
    						$where .= " " . $filterdatafield . " < '" . $filtervalue ."'";
    						break;
    					case "GREATER_THAN_OR_EQUAL":
    						$where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";
    						break;
    					case "LESS_THAN_OR_EQUAL":
    						$where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";
    						break;
    					case "STARTS_WITH_CASE_SENSITIVE":
    						$where .= " BINARY " . $filterdatafield . " like '" . $filtervalue ."%'";
    						break;
    					case "STARTS_WITH":
    						$where .= " " . $filterdatafield . " like '" . $filtervalue ."%'";
    						break;
    					case "ENDS_WITH_CASE_SENSITIVE":
    						$where .= " BINARY " . $filterdatafield . " like '%" . $filtervalue ."'";
    						break;
    					case "ENDS_WITH":
    						$where .= " " . $filterdatafield . " like '%" . $filtervalue ."'";
    						break;
    				}
    								
    				if ($i == $filterscount - 1)
    				{
    					$where .= ")";
    				}
    				
    				$tmpfilteroperator = $filteroperator;
    				$tmpdatafield = $filterdatafield;			
    			}
    		}
            else
            {
                $where = "";
            }
    	}
        
        $start = $pagesize * $pagenum;
        $queryStr = "select ".implode(', ',$selectFields) ." from users where user_id is not null ".$where.$sortStr." limit ".$start.",".$pagesize;
        //var_dump($queryStr); 
		$query = $this->db->query($queryStr);
        $rowcount = 0;
		$data = array(
            'total_rows' => count($query->result_array()),
            'rows' => $query->result_array(),
        );
		echo json_encode($data);
	}
    
	function update_user($userId = null)
	{
        if(!isset($_POST) || empty($_POST))
		{
            return;
		}
		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
            return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$dbData = $_POST;
        if(isset($dbData['new_password']) && $dbData['new_password'] != "" && $dbData['new_password'] == $dbData['confirm_password'])
        {
            $dbData['password'] = $this->ion_auth->hash_password($dbData['new_password']);
        }
        unset($dbData['new_password']);
        unset($dbData['confirm_password']);
        if(isset($dbData['from_email']))
        {
            $dbData['first_from_email'] = str_replace('rmm-mail.com','rmm-mail2.com',$dbData['from_email']);
        }
		if($userId)
		{
            $this->db->update('users',$dbData,array('user_id'=>$userId));
		}
		else
		{
			$dbData['active'] = 1;
			$dbData['monthly_text_messages'] = 2;
			$this->db->insert('users',$dbData);
            $newUserId = $this->db->insert_id();
            $dbData2 = array(
                'main_user_id' => $newUserId
            );            
			$this->db->update('users',$dbData2,array('user_id'=>$newUserId));
            $this->assign_user_twilio_number($newUserId);
            
		}
        echo 'Save Complete';
	}

	function delete_user($userId = null)
	{
		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		if($userId)
		{
			$this->db->delete('users',array('user_id'=>$userId));
		}
	}
	
	function inactivate_user($userId = null)
	{
		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			return;
		}
		if($userId)
		{
			$dbData = array(
                'active' => 0,
            );
            $this->db->update('users',$dbData,array('user_id'=>$userId));
		}
	}
	
	function activate_user($userId = null)
	{
		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			return;
		}
		if($userId)
		{
			$dbData = array(
                'active' => 1,
            );
            $this->db->update('users',$dbData,array('user_id'=>$userId));
			$query = $this->db->query('select utp.* from user_text_phones as utp left join users as u on (utp.main_user_id = u.main_user_id) where u.user_id='. mysql_escape_string($userId));
			if(!$query->num_rows())
			{
				$this->assign_user_twilio_number($userId);
			}
		}
	}
    
    function assign_user_twilio_number($userId = null)
    {
        if(!$userId)
            return;
		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			return;
		}
        $query = $this->db->get_where('users',array('user_id'=>$userId));
        if(!$query->num_rows())
        {
            return;
        }
        $user = $query->row();
        if(!$user->phone)
        {
            return;
        }
        $userPhone = preg_replace("/[^0-9]/", "", $user->phone); //filter our everything but the digits
        if(strlen($userPhone)<3) //if they don't at least have an area code we can't assign them a local number
        {
            return;
        }
        require_once(FCPATH.'application/third_party/twilio-php/Services/Twilio.php');

        $account_sid = 'AC054fe6e551a13f868ec822d4288d854f'; 
        $auth_token = '7e67b139e61a6e26a5b985db95cae5e5'; 
        $client = new Services_Twilio($account_sid, $auth_token); 
        $phoneNumber = $client->account->incoming_phone_numbers->create(array(  
        	'AreaCode' => substr($userPhone,0,3),      
        	'SmsMethod' => "post", 
        	'SmsUrl' => "https://www.einovie.com/rmm/index.php/message_manager/rec_text_message",         
        ));
        if(!isset($phoneNumber->phone_number))
        {
            return;
        } 
        $dbData = array(
            'main_user_id' => $userId,
            'twilio_number' => $phoneNumber->phone_number,
        );
        $this->db->insert('user_text_phones',$dbData);
    }
	

}
