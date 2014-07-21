<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_two extends CI_Controller {

	var $contact_data = array(
          'grid_name' => 'jqxgrid',
          'fields' => array(
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


	
	//redirect if needed, otherwise display the user list
	function index($cachebuster=null)
	{
        
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$data = array();
		$query = $this->db->query('select distinct city from contacts where main_user_id = '. $user->main_user_id .' order by city asc');
		$data['cities'] = array();
		
		$query2 = $this->db->query("select count(contact_id) as contact_count from contacts where main_user_id=".$user->main_user_id);
		//$data['contact_list'] = $query2->result_array();
        $data['contact_count'] = $query2->row()->contact_count;
        
        $data['contact_data'] = $this->contact_data;
		$this->load->view('contacts/contact_index_2', $data);
	}
	
	
   
	
	
	
	
    
    
    
    

}
