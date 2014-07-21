<?php $this->load->view('template/header_nav'); ?>
<script>

function save_facebook_settings()
{
	var serializedData = $('#facebook-enable').serialize();
	$.ajax({
		url: '<?php echo site_url('social_media/save_facebook_settings'); ?>',
		type: "post",
		data: serializedData,
		// callback handler that will be called on success
		success: function(response, textStatus, jqXHR)
		{
	    },
		// callback handler that will be called on error
		error: function(jqXHR, textStatus, errorThrown)
		{
			alert('error');
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete: function()
		{
			//alert('complete');
		}
	});
	return false;
}
	
</script>
<div id="content-header">
	<h1>Social Media</h1>
</div>
<div id="breadcrumb">
	<a href="#" title="Go to Home" class="current"><i class="icon-home"></i> Home</a>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-6" style="max-width: 600px;">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="icon-book"></i></span><h5>Facebook</h5></div>
				<div class="widget-content nopadding" style="margin-top: 20px; margin-bottom: 5px; margin-right: 10px; margin-left: 20px;">
					<?php 
                        if(!isset($main_user->facebook_user_id) || !strlen($main_user->facebook_user_id))
                        {
    		  			       ?>
                               <div style="text-align: left;"><a class="btn btn-default btn-small" href="http://www.facebook.com/dialog/pagetab?app_id=495711410548329&next=https://www.einovie.com/rmm/fbauthtab.php">Authorize Facebook Account</a> <strong>Please Note:</strong> You must have a page for your restaurant created on facebook before attempting to authorizing your facebook account.</div>
                               <?php
                        }
                        else
                        {
                            echo '<strong>Facebook User Id:</strong> '.$main_user->facebook_user_id;
                        }
                    ?>

					<form id="facebook-enable" class="form-horizontal" method="post">
						<div class="form-group">
							<label class="control-label">Show Restaurant Info on Facebook Page</label>
							<div class="controls">
								<input id="facebook-enable-hours" type="checkbox" name="facebook-enable-hours" <?php echo ($main_user->facebook_enable_hours ? "checked" : ""); ?> />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">Show Menu on Facebook Page</label>
							<div class="controls">
								<input id="facebook-enable-menu" type="checkbox" name="facebook-enable-menu" <?php echo ($main_user->facebook_enable_menu ? "checked" : ""); ?> />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">Allow VIP Signup on Facebook Page</label>
							<div class="controls">
								<input id="facebook-enable-vip" type="checkbox" name="facebook-enable-vip" <?php echo ($main_user->facebook_enable_vip ? "checked" : ""); ?> />
							</div>
						</div>
					</form>
					<div style="text-align: right;"><a id="saveFacebook" onclick="return save_facebook_settings();" class="btn btn-default btn-small" href="#">Save Changes</a></div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6" style="max-width: 600px;">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="icon-book"></i></span><h5>Twitter</h5></div>
				<div class="widget-content" style="margin-top: 20px; margin-bottom: 5px; margin-right: 10px; margin-left: 20px;">
					<?php 
                        if(!isset($main_user->twitter_name))
                        {
                            echo anchor('social_media/authorize_twitter','Authorize Twitter Account',array('class'=>'btn btn-default btn-small')); 
                        }
                        else
                        {
                            echo '<strong>Twitter Account:</strong> '.$main_user->twitter_name;
                        }
                    ?>
				</div>
			</div>
		</div>

	</div>
</div>
<script>
$(document).ready(function(){
	
//	$('input[type=checkbox],input[type=radio]').iCheck({
//    	checkboxClass: 'icheckbox_flat-blue',
//    	radioClass: 'iradio_flat-blue'
//	});
	$('input[type=checkbox]').iCheck({
    	checkboxClass: 'icheckbox_flat-blue',
    	radioClass: 'iradio_flat-blue'
	});
});	
</script>
<?php $this->load->view('template/footer_nav'); ?>
