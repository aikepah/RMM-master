<?php $this->load->view('template/header_nav'); ?>
<script>

function save_settings()
{
	var serializedData = $('#settingsForm').serialize();
	$.ajax({
		url: '<?php echo site_url('settings/save_settings'); ?>',
		type: "post",
		data: serializedData,
		// callback handler that will be called on success
		success: function(response, textStatus, jqXHR)
		{
	       alert('Settings Saved');
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
	<h1>Settings</h1>
</div>
<div id="breadcrumb">
	<a href="#" title="Go to Home" class="current"><i class="icon-home"></i> Home</a>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-6" style="max-width: 600px;">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="icon-book"></i></span><h5>Email</h5></div>
				<div class="widget-content nopadding" style="margin-top: 20px; margin-bottom: 5px; margin-right: 10px; margin-left: 20px;">

					<form id="settingsForm" class="form-horizontal" action="<?php echo site_url('settings'); ?>" method="post">
						<div class="form-group">
							<label class="control-label" style="width: 300px; margin-right: 10px;">Enable email link to allow email recipients to update their contact information</label>
							<div class="controls">
								<input id="email_enable_contact_update" type="checkbox" name="email_enable_contact_update" <?php echo ($main_user->email_enable_contact_update ? "checked" : ""); ?> />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label" style="width: 300px; margin-right: 10px;">Enable email link to invite email recipients without a mobile phone number to receive text message promotions</label>
							<div class="controls">
								<input id="email_enable_text_invitation" type="checkbox" name="email_enable_text_invitation" <?php echo ($main_user->email_enable_text_invitation ? "checked" : ""); ?> />
                                <input type="hidden" name="formsubmit" value="1">
							</div>
						</div>
    					<div style="text-align: right;"><button type="submit" id="saveSettings" class="btn btn-default btn-small" >Save Changes</button></div>
					</form>
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
