<!DOCTYPE html>
<html lang="en">
    <head>
        <title>RMM</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>public/css/font-awesome.css" />
    </head>
    <body>
        <div id="container">
            <div id="messageId" class="well" style="max-width: 400px; margin: 10px;">
<?php if($subscribed) { ?>
            <strong>Thank you for subscribing!</strong>
<?php } else if($contact->mobile_phone) { ?>            
    You've already subscribed to receive text messages.
<?php } else { ?>            
              <div><strong><?php echo ($contact && $contact->first_name ? $contact->first_name : ''); ?></strong></div>
              <div style="margin-bottom: 10px;">
              Enter your mobile phone number below to get special promotions via text message.
              </div>
              <form role="form" method="post">
                <div class="form-group">
                  <label for="mobile_phone">Mobile Phone</label>
                  <input type="text" class="form-control" id="mobile_phone" name="mobile_phone" placeholder="Enter 10 digit mobile phone number">
                </div>
                <div>Standard message and data rates may apply.</div>
                <button type="submit" class="btn btn-default">Submit</button>
              </form>
<?php } ?>
            </div>
        </div>
        <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>  
        <script src="<?php echo base_url();?>public/js/jquery-ui.custom.min.js"></script>
    </body>
</html>
<script>
$(window).resize(function(){

    $('#messageId').css({
        position:'absolute',
        left: ($(window).width() - $('#messageId').outerWidth())/2,
        top: ($(window).height() - $('#messageId').outerHeight())/2
    });

});

// To initially run the function:
$(window).resize();
    
</script>