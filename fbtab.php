<?php

include_once './vendor/autoload.php';


$con=mysqli_connect('localhost','rmmuser','rurmm23338','rmm');
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


if(isset($_POST) && isset($_POST['userId']))
{
  $con=mysqli_connect('localhost','rmmuser','rurmm23338','rmm');
  
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $result = mysqli_query($con,"insert into contacts (main_user_id,first_name,last_name,email_address,mobile_phone) values (".mysqli_real_escape_string($con,$_POST['userId']).",'".mysqli_real_escape_string($con,$_POST['firstName'])."','".mysqli_real_escape_string($con,$_POST['lastName'])."','".mysqli_real_escape_string($con,$_POST['emailAddress'])."','".mysqli_real_escape_string($con,$_POST['mobilePhone'])."')" );
  
  $result = mysqli_query($con,"select * from users where user_id = ".mysqli_real_escape_string($con,$_POST['userId']));
  $user = mysqli_fetch_array($result);

}
else
{
  $facebook = new Facebook(array(
          'appId' => '495711410548329',
          'secret' => 'c5fabf1c6f825e04b67439eefca8ef65',
  ));
  $signed_request = $facebook->getSignedRequest();
  
  $result = mysqli_query($con,"select * from users where facebook_page_id = '".$signed_request['page']['id']."'");
  $user = mysqli_fetch_array($result);

}

//$base_url = 'www.einovie.com/';

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
if($user['facebook_enable_hours'])
{
?>
        		<div class="col-xs-12 col-sm-6" style="max-width: 325px;">
        			<div>
        				<div style="margin-top: 20px; margin-bottom: 5px; margin-right: 10px; padding-top: 20px;">
        					<div id="hoursText">
        					<?php echo $user['hours_text']; ?>
        					</div>
        				</div>
        			</div>
        		</div>
<?php
}
if($user['facebook_enable_vip'])
{
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
                              <input type="hidden" name="userId" id="userId" value="<?php echo $user['main_user_id']; ?>">
                            </div>
                            <div style="text-align: right;">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                          </form>
<?php } ?>
        				</div>
        			</div>
        		</div>
<?php
}
?>
            </div>
        	<div class="row">
<?php

if($user['facebook_enable_menu'] && $user['menu_image_path'])
{
  echo "<h3>Our Menu</h3>";
  echo '<img src="'.$user['menu_image_path'].'">'; 

}
?>
            </div>
            
        </div>
      </div>    
    </body>
</html>


<?php

mysqli_close($con);

?>