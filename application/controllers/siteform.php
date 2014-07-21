<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
//include_once './vendor/autoload.php';
class Siteform extends CI_Controller {

    function index($urlcode=null)
	{
                    $this->load->library('Securimage');

            if (!$urlcode) {
                echo "Failed to submit. Bad user_id!";
                exit;
            }
            
            
            $contact_data = array(
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
                
		//$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
                /*
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
                
                
    
    
$con=mysqli_connect('localhost','rmmuser','rurmm23338','rmm');
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

*/
if(isset($_POST) && isset($_POST['userId']))
{
 
    $user = $this->check_urlcode_unique($_POST['userId']);
    if (!$user) {
        echo 'Bad user_id!';
        die();
    }

// Captcha image    
//include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
$this->load->library('Securimage');
$securimage = new Securimage();
if ($securimage->check($_POST['captcha_code']) == false) {
  // the code was incorrect
  // you should handle the error so that the form processor doesn't continue
  // or you can use the following code if there is no validation or you do not know how
  echo "The security code entered was incorrect.<br /><br />";
  echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
  exit;
}

if(!isset($_POST['birthday']) || !$_POST['birthday'])
{
    $birthday = null;
} else {
    $birthday = ($_POST['birthday'] ? date_format((date_create($_POST['birthday'])),"Y-m-d H:i:s") : null);
}

if(!isset($_POST['anniversary']) || !$_POST['anniversary'])
{
    $anniversary = null;
} else {
    $anniversary = ($_POST['anniversary'] ? date_format((date_create($_POST['anniversary'])),"Y-m-d H:i:s") : null);
}

  $result = $this->db->query("insert into contacts (main_user_id,first_name,last_name,email_address,mobile_phone,birthday,anniversary) values ("
          .$this->db->escape_str($user)
          .",'". $this->db->escape_str($_POST['firstName'])
          ."','". $this->db->escape_str($_POST['lastName'])
          ."','". $this->db->escape_str($_POST['emailAddress'])
          ."','". $this->db->escape_str($_POST['mobilePhone'])
          ."','". $this->db->escape_str($birthday)
          ."','". $this->db->escape_str($anniversary)."')" );  
}
else
{
    
  //$result = mysqli_query($con,"select * from users where facebook_page_id = '".$signed_request['page']['id']."'");
  //$user = mysqli_fetch_array($result);

}
/*
//$base_url = 'www.einovie.com/';
*/
$base_url = '/rmm/';

?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<title>RMM</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?php echo $base_url;?>public/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $base_url;?>public/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo $base_url;?>public/css/icheck/flat/blue.css" />
		<link rel="stylesheet" href="<?php echo $base_url;?>public/css/fullcalendar.css" />
		<link rel="stylesheet" href="<?php echo $base_url;?>public/css/jquery.jscrollpane.css" />	
		<link rel="stylesheet" href="<?php echo $base_url;?>public/css/unicorn.css" />
		<link rel="stylesheet" href="<?php echo $base_url;?>public/css/unicorn.grey.css" class="skin-color" />

                
                
         

		<link rel="stylesheet" href="<?php echo base_url();?>public/js/jqwidgets/styles/jqx.base.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/js/jqwidgets/styles/jqx.arctic.css" />

        <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
        <script src="<?php echo base_url();?>public/js/fullcalendar.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jqwidgets/jqx-all.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.uploadfile.min.js"></script>


	</head>

        
 
	</head>
	<body style="background-color: inherit;">
	  <div style="padding: 20px;">
        <div class="container-fluid">
        	<div class="row">

        		<div class="col-xs-12 col-sm-6" style="max-width: 385px;">
        			<div class="widget-box">
        				<div class="widget-title"><span class="icon"><i class="icon-user"></i></span><h5>Sign Up For Our VIP Club</h5></div>
        				<div class="widget-content" style="margin-bottom: 5px; margin-right: 10px;">
<?php
                
if(isset($_POST) && isset($_POST['userId']))
{
    #Need to check if the database insert worked
    echo 'Thanks for signing up!';
}
else
{
?>

<div id='jqxWidgetWrapper' class='default' style="">
                          <form role="form" method="post" class="form-horizontal">
                            <div class="form-group">
                              <div>First Name</div>
                              <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
                              <div>Last Name</div>
                              <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                              <div>Email Address</div>
                              <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Email Address">
                              <div>Mobile Phone Number</div>
                              <input type="text" class="form-control" id="mobilePhone" name="mobilePhone" placeholder="Mobile Phone (Optional)">
                              
                              <div class="control-group">Birthday                                  
                              <div id="birthday_id" ></div>
                              </div>
                              <!-- style="padding: 3px 0px 3px 10px;" -->                                                           
                              <div class="control-group">Anniversary
                                <div id="anniversary_id"></div>
                              </div>
                            </div>
                              <div>Prove you're human</div>                           
                            <img id="captcha" src="/rmm/index.php/Securimage_show/index" alt="CAPTCHA Image" />
                            <input type="text" name="captcha_code" size="10" maxlength="6" />
                            <a href="#" onclick="document.getElementById('captcha').src = '/rmm/index.php/Securimage_show/index/' + Math.random(); return false">[ Different Image ]</a>
                            
                              <input type="hidden" name="birthday" id="birthday_val" value=''>
                              <input type="hidden" name="anniversary" id="anniversary_val" value=''>
                              <input type="hidden" name="userId" id="userId" value=<?=$urlcode?>>
                            </div>
                            <div style="text-align: right;">
                                <button type="submit" id="saveButton" class="btn btn-default">Submit</button>
                            </div>
                          </form>
    </div>
<?php } ?>
        				</div>
        			</div>
        		</div>
            </div>
        	<div class="row">
            </div>      
        </div>
      </div>    
    </body>
</html>

<script type="text/javascript">  

        $(document).ready(function () {
            
       
			
            var theme = "arctic";
<?php
    
    echo "$('#".'birthday'."_id').jqxDateTimeInput({width: '150px', height: '25px', theme: theme, formatString: 'MM/dd/yyyy', enableAbsoluteSelection: false});\n";
    echo "$('#".'anniversary'."_id').jqxDateTimeInput({width: '150px', height: '25px', theme: theme, formatString: 'MM/dd/yyyy', enableAbsoluteSelection: false});\n";
    echo '$("#birthday_id").val(null); ';            
    echo '$("#anniversary_id").val(null); ';

?>
           
            $("#saveButton").click(function () {
                $("#birthday_val").val($("#birthday_id").val());  
                $("#anniversary_val").val($("#anniversary_id").val());
            });
            
        });
        
        
    </script>







     


    
    
    

<?php
die();
}

function check_urlcode_unique($code='')
        {
            if ( strlen($code) != 10 ) {
                return;
            }
            $result = $this->db->query("select user_id from users where (urlcode = '". $code ."')");
            set_error_handler('var_dump', 0);
            $user = $result->row()->user_id;
            restore_error_handler();
            if (!$user) {
                return;
            }
            return $user;
        }

}
?>