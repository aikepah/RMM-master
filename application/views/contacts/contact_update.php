<!DOCTYPE html>
<html lang="en">
    <head>
        <title>RMM</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>public/css/font-awesome.css" />
		<!--<link rel="stylesheet" href="<?php echo base_url();?>public/js/jqwidgets/styles/jqx.base.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/js/jqwidgets/styles/jqx.arctic.css" />-->
    </head>
    <body>
        <div id="container">
            <div id="messageId" class="well" style="max-width: 560px; margin: 10px; margin-left: auto; margin-right: auto;">
<?php if($subscribed) { ?>
            <strong>Thank you for updating your information!</strong>
<?php } else { ?>            
              <div style="margin-bottom: 10px;">
              </div>
              <form role="form" method="post">
                <div style="width: 250px; display: inline-block;">
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?php echo $contact->first_name; ?>">
                  </div>
                  <div class="form-group">
                    <label for="email_address">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="<?php echo $contact->last_name; ?>">
                  </div>
                  <div class="form-group">
                    <label for="email_address">Email Address</label>
                    <input type="text" class="form-control" id="email_address" name="email_address" placeholder="Enter email address" value="<?php echo $contact->email_address; ?>">
                  </div>
                  <div class="form-group">
                    <div style="font-size: 85%">Enter your mobile phone number below to get special promotions via text message. Standard message and data rates may apply.</div>
                    <label for="mobile_phone">Mobile Phone</label>
                    <input type="text" class="form-control" id="mobile_phone" name="mobile_phone" placeholder="Enter 10 digit mobile phone number" value="<?php echo $contact->mobile_phone; ?>">
                  </div>
                </div>
                <div style="width: 250px; display: inline-block; margin-left: 10px;">
                  <div class="form-group">
                    <label for="address1">Address 1</label>
                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Enter address line 1" value="<?php echo $contact->address1; ?>">
                  </div>
                  <div class="form-group">
                    <label for="address2">Address 2</label>
                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Enter address line 2" value="<?php echo $contact->address2; ?>">
                  </div>
                  <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" value="<?php echo $contact->city; ?>">
                  </div>
                  <div class="form-group">
                    <label for="state_region">State</label>
                    <input type="text" class="form-control" id="state_region" name="state_region" placeholder="Enter state" value="<?php echo $contact->state_region; ?>">
                  </div>
                  <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter postal code" value="<?php echo $contact->postal_code; ?>">
                  </div>
                </div>
                
                <div></div>
                <button id="submitButton" type="submit" class="btn btn-default">Submit</button>
              </form>
<?php } ?>
            </div>
        </div>
        <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>  
        <script src="<?php echo base_url();?>public/js/jquery-ui.custom.min.js"></script>
        <!--<script src="<?php echo base_url();?>public/js/jqwidgets/jqxcore.js"></script>
        <script src="<?php echo base_url();?>public/js/jqwidgets/jqx-all.js"></script>
        <script src="<?php echo base_url();?>public/js/jqwidgets/globalization/globalize.js"></script> -->

    </body>
<script>

$(document).ready(function () {
    var theme = 'arctic';
<?php
/*
    $("#birthday").jqxDateTimeInput({width: '250px', height: '34px', theme: theme, formatString: 'MM/dd/yyyy', enableAbsoluteSelection: false<?php echo ($contact->birthday ? ", value: '".$contact->birthday."'" : "" ); ?>});
    $("#anniversary").jqxDateTimeInput({width: '250px', height: '34px',theme: theme, formatString: 'MM/dd/yyyy', enableAbsoluteSelection: false<?php echo ($contact->anniversary ? ", value: '".$contact->anniversary."'" : "" ); ?>});
*/
?>
});
    
</script>

</html>
