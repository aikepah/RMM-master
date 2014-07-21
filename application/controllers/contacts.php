<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends CI_Controller {

	var $contact_data = array(
          'grid_name' => 'jqxgrid',
          'fields' => array(
              array(
                  'field_name' => 'contact_id', 
                  'display_name' => 'contact id',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 0,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 0,
                  'edit_field' => 'text',
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
                  'field_name' => 'email_address', 
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
                  'field_name' => 'mobile_phone', 
                  'display_name' => 'Mobile Phone',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 2,
              ),
              array(
                  'field_name' => 'home_phone', 
                  'display_name' => 'Home Phone',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 2,
              ),
              array(
                  'field_name' => 'address1', 
                  'display_name' => 'Address 1',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 0,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'address2', 
                  'display_name' => 'Address 2',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 0,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'city', 
                  'display_name' => 'City',
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
                  'field_name' => 'state_region', 
                  'display_name' => 'State',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 0,
                  'grid_width' => 80,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 1,
              ),
              array(
                  'field_name' => 'postal_code', 
                  'display_name' => 'Postal Code',
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
                  'field_name' => 'group_name', 
                  'display_name' => 'Group',
                  'field_type' => 'string',
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'text',
                  'edit_col' => 2,
              ),
              array(
                  'field_name' => 'birthday', 
                  'display_name' => 'Birthday',
                  'field_type' => 'date',
                  'custom_grid' => "cellsformat: 'MM/dd/yyyy'",
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'date',
                  'edit_col' => 2,
              ),
              array(
                  'field_name' => 'anniversary', 
                  'display_name' => 'Anniversary',
                  'field_type' => 'date',
                  'custom_grid' => "cellsformat: 'MM/dd/yyyy'",
                  'field_validation' => null,
                  'grid_display' => 1,
                  'grid_width' => 100,
                  'grid_other' => null,
                  'edit_display' => 1,
                  'edit_field' => 'date',
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
        if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$data = array();
		$query = $this->db->query('select distinct city from contacts where main_user_id = '. $user->main_user_id .' order by city asc');
		$data['cities'] = array();
		foreach($query->result() as $row)
		{
			if($row->city)
				$data['cities'][] = addslashes($row->city);
		}
		$query2 = $this->db->query("select count(contact_id) as contact_count from contacts where main_user_id=".$user->main_user_id);
		//$data['contact_list'] = $query2->result_array();
        $data['contact_count'] = $query2->row()->contact_count;
        
        $data['contact_data'] = $this->contact_data;
		$this->load->view('contacts/contact_index', $data);
	}
	
	function distribution_lists()
	{
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$data = array();
		$this->load->view('contacts/distribution_lists', $data);
	}
    
    function upload_contacts()
    {
		if(!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
        if(isset($_FILES["file"]))
        {
            $ret = array();
        
        	$error = $_FILES["file"]["error"];
            $filedata = file_get_contents($_FILES["file"]["tmp_name"]);
			$import_data = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $filedata));
			if(sizeof($import_data)<=1)
			{
				echo "ERROR: Invalid file.";
				return;
			}
			array_shift($import_data);

			// 0 - email address
            // 1 - first name
            // 2 - last name
            // 3 - mobile phone
            // 4 - home phone
            // 5 - address1
            // 6 - address2
            // 7 - city
            // 8 - state
            // 9 - postal code
            // 10 - birthday
            // 11 - anniversary
            // 12 - group
            
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            foreach($import_data as $row)
			{
				if(!isset($row[0]) && !isset($row[1])&& !isset($row[2])&& !isset($row[3])&& !isset($row[5]))
					continue;
                if(strlen($row[10]))
                    $birthdayDate = date_create($row[10]);
                else
                    $birthdayDate = null;
                if(strlen($row[11]))
                    $anniversaryDate = date_create($row[11]);
                else
                    $anniversaryDate = null;
                if(strlen($row[3]))
                    $mobilePhone = preg_replace("/[^0-9]/", "", $row[3]);
                else
                    $mobilePhone = null;
                if(strlen($row[4]))
                    $homePhone = preg_replace("/[^0-9]/", "", $row[4]);
                else
                    $homePhone = null;
                
				$this->db->insert('contacts',array(
                    'main_user_id' => $user->main_user_id,
                    'email_address' => trim($row[0]),
                    'first_name' => trim($row[1]),
                    'last_name' => trim($row[2]),
                    'mobile_phone' => trim($mobilePhone),
                    'home_phone' => trim($homePhone),
                    'address1' => trim($row[5]),
                    'address2' => trim($row[6]),
                    'city' => trim($row[7]),
                    'state_region' => trim($row[8]),
                    'postal_code' => trim($row[9]),
                    'birthday' => ($birthdayDate ? date_format($birthdayDate,'Y-m-d') : null),
                    'anniversary' => ($anniversaryDate ? date_format($anniversaryDate,'Y-m-d') : null),
                    'group_name' => trim($row[12]),
                ));
                
            }
            echo 'Import Complete';
            //var_dump($filedata);
            
         }
     }
	
	function load_contacts($data=null)
	{
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
		if(!$this->ion_auth->logged_in())
		{
			echo 'not logged in';
            //redirect them to the login page
			return;
		}
        $selectFields = array();
        foreach($this->contact_data['fields'] as $contact_field)
        {
            $selectFields[] = $contact_field['field_name'];
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
        $queryStr = "select ".implode(', ',$selectFields) ." from contacts where main_user_id=".$user->main_user_id.$where.$sortStr." limit ".$start.",".$pagesize;
        //var_dump($queryStr); 
		$query = $this->db->query($queryStr);
        $rowcount = 0;
		$data = array(
            'total_rows' => count($query->result_array()),
            'rows' => $query->result_array(),
        );
        //$this->db->insert('event_log',array('event_description'=>'debug contact load, user:'.$user->main_user_id.' pagesize:'.$pagesize.' pagenum:'.$pagenum,'event_data'=>json_encode($data)));
		echo json_encode($data);
	}
	
	function update_contact($contactId = null)
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
        if(isset($_POST['mobile_phone']))
        {
            $_POST['mobile_phone'] = preg_replace("/[^0-9]/", "", $_POST['mobile_phone']);
        }
        if(isset($_POST['home_phone']))
        {
            $_POST['home_phone'] = preg_replace("/[^0-9]/", "", $_POST['home_phone']);
        }
        if(!isset($_POST['birthday']) || !$_POST['birthday'])
        {
            $_POST['birthday'] = null;
        }
        if(!isset($_POST['anniversary']) || !$_POST['anniversary'])
        {
            $_POST['anniversary'] = null;
        }
		if($contactId)
		{
			$this->db->update('contacts',$_POST,array('contact_id'=>$contactId));
		}
		else
		{
			$this->db->insert('contacts',$_POST);
		}
	}
    
    function save_contact_group()
    {
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
		if(!$this->ion_auth->logged_in())
		{
			echo 'not logged in';
            //redirect them to the login page
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
    	if(!$this->input->post('filterscount') || $this->input->post('filterscount') < 1)
    	{
            return;
        }
        if(!$this->input->post('groupname'))
        {
            return;
        }
        $group_name = urldecode($this->input->post('groupname'));
  		$filterscount = $this->input->post('filterscount');
		$where = " and (";
		$tmpdatafield = "";
		$tmpfilteroperator = "";
		for ($i=0; $i < $filterscount; $i++)
	    {
			// get the filter's value.
			$filtervalue = urldecode($this->input->post("filtervalue" . $i));
			// get the filter's condition.
			$filtercondition = urldecode($this->input->post("filtercondition" . $i));
			// get the filter's column.
			$filterdatafield = 'c.'.urldecode($this->input->post("filterdatafield" . $i));
			// get the filter's operator.
			$filteroperator = urldecode($this->input->post("filteroperator" . $i));
			
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
        
        $dbData = array(
            'main_user_id' => $user->main_user_id,
            'group_name' => $group_name,
            'group_query' => $where,
        );
        $this->db->insert('contact_groups',$dbData);
        echo 'Contact group saved successfully';
    }
    
    function fix_phone()
    {
		$query = $this->db->query("select * from contacts");
        foreach($query->result() as $row)
        {
            if($row->mobile_phone || $row->home_phone)
            {
                $dbData = array();
                if($row->mobile_phone)
                {
                    $dbData['mobile_phone'] = preg_replace("/[^0-9]/", "",$row->mobile_phone); 
                }
                if($row->home_phone)
                {
                    $dbData['home_phone'] = preg_replace("/[^0-9]/", "",$row->home_phone); 
                }
                $this->db->update('contacts',$dbData,array('contact_id'=>$row->contact_id));
            }
        }
        echo 'complete';
    }

	function delete_contact($contactId = null)
	{
		if(!$this->ion_auth->logged_in())
		{
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		if($contactId)
		{
			$this->db->delete('contacts',array('contact_id'=>$contactId,'main_user_id'=>$user->main_user_id));
		}
	}
	
	function gen_contacts()
	{
		$fnames = array("Andrew", "Nancy", "Shelley", "Regina", "Yoshi", "Antoni", "Mayumi", "Ian", "Peter", "Lars", "Petra", "Martin", "Sven", "Elio", "Beate", "Cheryl", "Michael", "Guylene", "Tom");
		$lnames = array("Fuller", "Davolio", "Burke", "Murphy", "Nagase", "Saavedra", "Ohno", "Devling", "Wilson", "Peterson", "Winkler", "Bein", "Petersen", "Rossi", "Vileid", "Saylor", "Bjorn", "Nodier", "Test");
		$cities = array('Springville','Orem','Provo','Spanish Fork','Santaquin','Payson','American Fork','Lehi','Salt Lake City','Benjamin');
		for($i = 0; $i < 300; $i++)
		{
			$this->db->insert('contacts',array(
				'first_name' => $fnames[array_rand($fnames)], 
				'last_name' => $lnames[array_rand($lnames)],
				'city' => $cities[array_rand($cities)],
				'state_region' => 'UT',
				'country' => 'US',
				'main_user_id' => 1,
				));
		}
	}
    
    function text_signup($contactId=null,$emailAddress=null)
    {
		if(!$contactId || !$emailAddress)
			return;
        $data = array();
        $data['message'] = "";
        $data['subscribed'] = null;
        $emailAddress = urldecode($emailAddress);
        $query = $this->db->get_where('contacts',array('contact_id'=>$contactId,'email_address'=>$emailAddress));
        if(!$query->num_rows())
        {
            $contact = null;
            return;
        }
        else
        {
            $contact = $query->row();
        }
        $data['contact'] = $contact;
        if($this->input->post('mobile_phone'))
        {
            $mobilePhone = preg_replace("/[^0-9]/", "", $this->input->post('mobile_phone'));
            $dbData = array(
                'mobile_phone' => $mobilePhone,
            );
            if($contact)
            {
                $this->db->update('contacts',$dbData,array('contact_id'=>$contact->contact_id));
                $data['subscribed'] = 1;
            }
            else
            {
                // we dont know which user this is so can't insert with just this data
                //$this->db->insert('contacts',$dbData);
            }
        }
        $this->load->view('contacts/mobile_signup', $data);
    }
    
    function contact_update($contactId=null,$emailAddress=null)
    {
        if(!$contactId || !$emailAddress)
			return;
        $data = array();
        $data['message'] = "";
        $data['subscribed'] = null;
        $emailAddress = urldecode($emailAddress);
        $query = $this->db->get_where('contacts',array('contact_id'=>$contactId,'email_address'=>$emailAddress));
        if(!$query->num_rows())
        {
            $contact = null;
            return;
        }
        else
        {
            $contact = $query->row();
        }
        $data['contact'] = $contact;
        if(isset($_POST) && !empty($_POST))
        {
            $dbData = $_POST;
            $dbData['mobile_phone'] = preg_replace("/[^0-9]/", "", $dbData['mobile_phone']);
            if(isset($dbData['birthday']) && $dbData['birthday'] != "")
            {
                $dbData['birthday'] = date_format(date_create($dbData['birthday']),'Y-m-d');
            }
            if(isset($dbData['anniversary']) && $dbData['anniversary'] != "")
            {
                $dbData['anniversary'] = date_format(date_create($dbData['anniversary']),'Y-m-d');
            }

            if($contact)
            {
                $this->db->update('contacts',$dbData,array('contact_id'=>$contact->contact_id));
                $data['subscribed'] = 1;
            }
            else
            {
                // we dont know which user this is so can't insert with just this data
                //$this->db->insert('contacts',$dbData);
            }
        }
        $this->load->view('contacts/contact_update', $data);
    }
    

}
