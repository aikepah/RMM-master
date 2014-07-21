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
            <div id="messageId" class="well" style="max-width: 300px; margin: 10px;">
            <?php echo $message; ?>
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