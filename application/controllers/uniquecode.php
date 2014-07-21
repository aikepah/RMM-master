<?php defined('BASEPATH') OR exit('No direct script access allowed');

//include_once './vendor/autoload.php';
class UniqueCode extends CI_Controller {

    function index()
    {
        $code = $this->generateRandomString();
        echo $code;
    }
        
    function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
        
        
        
        
        
    /*        if (!$user) {
                echo "Failed to submit. Bad user_id!";
                exit;
            }
                
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

*//*
if(isset($_POST) && isset($_POST['userId']))
{
  $con=mysqli_connect('localhost','rmmuser','rurmm23338','rmm');
  
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  //$result = mysqli_query($con,"insert into contacts (main_user_id,first_name,last_name,email_address,mobile_phone) values (".mysqli_real_escape_string($con,$_POST['userId']).",'".mysqli_real_escape_string($con,$_POST['firstName'])."','".mysqli_real_escape_string($con,$_POST['lastName'])."','".mysqli_real_escape_string($con,$_POST['emailAddress'])."','".mysqli_real_escape_string($con,$_POST['mobilePhone'])."')" );
//die();
  echo $_POST['birthday'];
  die();
  $result = mysqli_query($con,"insert into contacts (main_user_id,first_name,last_name,email_address,mobile_phone,birthday,anniversary) values ("
          .mysqli_real_escape_string($con,$_POST['userId'])
          .",'".mysqli_real_escape_string($con,$_POST['firstName'])
          ."','".mysqli_real_escape_string($con,$_POST['lastName'])
          ."','".mysqli_real_escape_string($con,$_POST['emailAddress'])
          ."','".mysqli_real_escape_string($con,$_POST['mobilePhone'])
          ."','".mysqli_real_escape_string($con,$_POST['birthday'])
          ."','".mysqli_real_escape_string($con,$_POST['anniversary'])."')" );
}
else
{
  
  //$result = mysqli_query($con,"select * from users where facebook_page_id = '".$signed_request['page']['id']."'");
  //$user = mysqli_fetch_array($result);

}
/*
//$base_url = 'www.einovie.com/';
*//*
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

	</head>
	<body style="background-color: inherit;">
	  <div style="padding: 20px;">
        <div class="container-fluid">
        	<div class="row">
<?php


?>
        		<div class="col-xs-12 col-sm-6" style="max-width: 385px;">
        			<div class="widget-box">
        				<div class="widget-title"><span class="icon"><i class="icon-user"></i></span><h5>Sign Up For Our VIP Club</h5></div>
        				<div class="widget-content" style="margin-bottom: 5px; margin-right: 10px;">
<?php
if(isset($_POST) && isset($_POST['userId']))
{
    echo 'Thanks for signing up!';
}
else
{
?>

                          <form role="form" method="post">
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
                              <div>Birthday</div>
                              <input type="date" class="form-control" id="birthday" name="birthday" placeholder="MM/DD/YYYY">
                              <div>Anniversary</div>
                              <input type="date" class="form-control" id="anniversary" name="anniversary" placeholder="MM/DD/YYYY">
                              <input type="hidden" name="userId" id="userId" value=<?=$user?>>
                            </div>
                            <div style="text-align: right;">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                          </form>
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


<?php
die();
}
}
*/
}
?>