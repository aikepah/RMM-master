<!DOCTYPE html>
<html lang="en">
    <head>
        <title>RMM</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/font-awesome.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/jqwidgets/styles/jqx.base.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/jqwidgets/styles/jqx.arctic.css" />
        <script src="<?php echo base_url(); ?>public/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery-ui.custom.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jqwidgets/jqxcore.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jqwidgets/jqx-all.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jqwidgets/globalization/globalize.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/additional-methods.js"></script>
    </head>
    <body>
        <div id="container">
            <div id="messageId" class="well" style="max-width: 560px; margin: 10px; margin-left: auto; margin-right: auto;">
                <?php if ($subscribed) { ?>
                    <strong>Thank you for signing up!</strong>
                <?php } else { ?>            
                    <div style="margin-bottom: 10px;">
                    </div>
                    <form role="form" method="post" id="newSubForm">
                        <div style="width: 250px; display: inline-block;">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                            </div>
                            <div class="form-group">
                                <label for="email_address">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
                            </div>
                            <div class="form-group">
                                <label for="email_address">Email Address</label>
                                <input type="email" class="form-control" id="email_address" name="email_address" placeholder="Enter email address">
                            </div>
                            <div class="form-group">
                                <label for="home_phone">Home Phone</label>
                                <input type="text" class="form-control" id="home_phone" name="home_phone" placeholder="Enter 10 digit home phone number">
                            </div>
                            <div class="form-group">
                                <div style="font-size: 85%">Enter your mobile phone number below to get special promotions via text message. Standard message and data rates may apply.</div>
                                <label for="mobile_phone">Mobile Phone</label>
                                <input type="text" class="form-control" id="mobile_phone" name="mobile_phone" placeholder="Enter 10 digit mobile phone number">
                            </div>
                        </div>
                        <div style="width: 250px; display: inline-block; margin-left: 10px;">
                            <div class="form-group">
                                <label for="address1">Address 1</label>
                                <input type="text" class="form-control" id="address1" name="address1" placeholder="Enter address line 1">
                            </div>
                            <div class="form-group">
                                <label for="address2">Address 2</label>
                                <input type="text" class="form-control" id="address2" name="address2" placeholder="Enter address line 2">
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
                            </div>
                            <div class="form-group">
                                <label for="state_region">State</label>
                                <input type="text" class="form-control" id="state_region" name="state_region" placeholder="Enter state">
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Postal Code</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter postal code">
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Birthday <span style="font-weight: normal;">(mm/dd/yyyy)</span></label>

                                <div id="birthday"></div>
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Anniversary <span style="font-weight: normal;">(mm/dd/yyyy)</span></label>
                                <div id="anniversary"></div>
                            </div>
                        </div>

                        <div></div>
                        <input id="submitButton" type="submit" class="btn btn-default submit" value="Submit"/>
                    </form>
                    <script>

                        $(document).ready(function() {
                            var theme = 'arctic';

                            $("#birthday").jqxDateTimeInput({width: '200px', height: '27px', formatString: 'MM/dd/yyyy', theme: theme});
                            $("#anniversary").jqxDateTimeInput({width: '200px', height: '27px', formatString: 'MM/dd/yyyy', theme: theme});
                            $("#newSubForm").validate({
                                debug: true,
                                rules: {
                                    first_name: "required",
                                    home_phone: {
                                        phoneUS: true
                                    }
                                }
                            });
                        });

                    </script>
                <?php } ?>
            </div>
        </div>

    </body>

</html>
