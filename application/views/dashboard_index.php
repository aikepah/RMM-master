<?php $this->load->view('template/header_nav'); ?>

<script src="<?php echo base_url();?>public/js/unicorn.wizard.js"></script>
<script>
var texts_left = <?php echo $texts_left ?>;
var userid = <?php echo $main_user->user_id; ?>;
function click_textmessage()
{
    if(!texts_left && userid != 1 && userid != 4)
    {
        alert('You can only send 2 text messages per month');
        return false;
    }
    $('#tmModal').modal('show');
    return false;
}

function click_email()
{
    $('#emailModal').modal('show');
    //alert('Email is currently unavailable.');
    return false;
}

</script>
<div id="content-header">
	<h1>Dashboard</h1>
</div>
<div id="breadcrumb">
	<a href="#" title="Go to Home" class="current"><i class="icon-home"></i> Home</a>
</div>

<div class="container-fluid">
	<div class="row">
		<div id="messageDiv" class="alert alert-info" style="margin-left: 20px; max-width: 750px; display: none;">
			<span id="messageSpan"></span>
			<a href="#" onclick="$('#messageDiv').hide(); return false;" class="close">×</a>
		</div>
		<div class="col-xs-12 col-sm-6 center" style="text-align: center; max-width: 700px;">
						<ul class="quick-actions">
							<li style="width: 180px; height: 95px; margin-bottom: 20px;">
								<a href="#ftModal" data-toggle="modal">
									<i class="icon-cal" style="background-image: url('/rmm/public/img/icons/32/emblem-notice.png');"></i>
									Facebook/Twitter Post
								</a>
							</li>
							<li style="width: 180px; height: 95px;">
								<a href="#tmModal" onclick="return click_textmessage();">
									<i class="icon-shopping-bag" style="background-image: url('/rmm/public/img/icons/32/ate3.png');"></i>
									Text Message<br />
									<span class="user-info"><?php echo $texts_left; ?> remaining this month</span>
								</a>
							</li>
							<li style="width: 180px; height: 95px;">
								<a href="#emailModal" onclick="return click_email();">
									<i class="icon-cal" style="background-image: url('/rmm/public/img/icons/32/emblem-mail.png');"></i>
									Send Email<br />
									<span class="user-info">&nbsp;</span>
								</a>
							</li>
							<!--
							<li style="width: 170px; height: 95px;">
								<a href="#postcardModal" data-toggle="modal">
									<i class="icon-mail"></i>
									Send Postcard<br />
									<span class="user-info">&nbsp;</span>
								</a>
							</li>
							-->
							<li style="width: 180px; height: 95px;">
								<a href="#apModal" data-toggle="modal">
									<i class="icon-web"></i>
									Auto-Pilot<br />
									<span class="user-info">Currently <?php echo ($main_user->auto_enable_monthly || $main_user->auto_enable_birthday || $main_user->auto_enable_anniversary ? "On" : "Off"); ?></span>
								</a>
							</li>
							<li style="width: 170px; border: 0px;">
							<li style="width: 170px; border: 0px;">
							</li>
						</ul>
		</div>					
	
	</div>
</div>
<?php $this->load->view('include/message_editor'); ?>

<div id="apModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="form-wizard" class="form-horizontal" method="post">
			<div class="modal-header">
				<button data-dismiss="modal" class="close" type="button">×</button>
				<h3>Auto-Pilot</h3>
			</div>
			<div class="modal-body">
					<div id="form-wizard-1" class="step">
						<div class="form-group">
							<label class="control-label">Enable Automatic Welcome Email</label>
							<div class="controls">
								<input id="enable-auto-monthly" type="checkbox" name="enable-auto-welcome" <?php echo ($main_user->auto_enable_welcome ? "checked" : ""); ?> />
							</div>
						</div>
						<!--<div class="form-group">
							<label class="control-label">Enable Automatic Monthly Email</label>
							<div class="controls">
								<input id="enable-auto-monthly" type="checkbox" name="enable-auto-monthly" <?php echo ($main_user->auto_enable_monthly ? "checked" : ""); ?> />
							</div>
						</div>-->
						<div class="form-group">
							<label class="control-label">Enable Automatic Birthday Email</label>
							<div class="controls">
								<input id="enable-auto-birthday" type="checkbox" name="enable-auto-birthday" <?php echo ($main_user->auto_enable_birthday ? "checked" : ""); ?> />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">Enable Automatic Anniversary Email</label>
							<div class="controls">
								<input id="enable-auto-anniversary" type="checkbox" name="enable-auto-anniversary" <?php echo ($main_user->auto_enable_anniversary ? "checked" : ""); ?> />
							</div>
						</div>
					</div>
					<div id="form-wizard-2" class="step">
						<h3 style="margin-bottom: 20px;">Automatic Welcome Email</h3>
						<div>Welcome Email Template</div>
						<div id="weTemplate"></div>
						<div>Welcome Email Subject</div>
						<input type="text" id="weSubject" name="weSubject" style="width: 360px;" value="<?php echo $main_user->auto_welcome_subject; ?>">
						<div>Welcome Email Body</div>
						<textarea id="weBody" name="weBody" rows="5" style="width: 360px;"><?php echo $main_user->auto_welcome_body; ?></textarea>
		                <div><a href='javascript:void(0);' onclick='return view_preview("we");'>View Preview</a></div>
					</div>
					<div id="form-wizard-3" class="step">
						<h3 style="margin-bottom: 20px;">Birthday Email</h3>
						<div>Birthday Email Template</div>
						<div id="beTemplate"></div>
						<div>Birthday Email Subject</div>
						<input type="text" id="beSubject" name="beSubject" style="width: 360px;" value="<?php echo $main_user->auto_birthday_subject; ?>">
						<div>Birthday Email Body</div>
						<textarea id="beBody" name="beBody" rows="5" style="width: 360px;"><?php echo $main_user->auto_birthday_body; ?></textarea>
		                <div><a href='javascript:void(0);' onclick='return view_preview("be");'>View Preview</a></div>
					</div>
					<div id="form-wizard-4" class="step">
						<h3 style="margin-bottom: 20px;">Anniversary Email</h3>
						<div>Anniversary Email Template</div>
						<div id="aeTemplate"></div>
						<div>Anniversary Email Subject</div>
						<input type="text" id="aeSubject" name="aeSubject" style="width: 360px;" value="<?php echo $main_user->auto_anniversary_subject; ?>">
						<div>Anniversary Email Body</div>
						<textarea id="aeBody" name="aeBody" rows="5" style="width: 360px;"><?php echo $main_user->auto_anniversary_body; ?></textarea>
		                <div><a href='javascript:void(0);' onclick='return view_preview("ae");'>View Preview</a></div>
					</div>
					<div>
							<div id="status"></div>
					</div>
					<div id="submitted"></div>
			</div>
			<div class="modal-footer">
				<input id="back" class="btn btn-primary" type="reset" value="Back" />
				<input id="next" class="btn btn-primary" type="submit" value="Next" />
				<a data-dismiss="modal" class="btn btn-default btn-small" href="#">Cancel</a>
			</div>
			</form>
		</div>
	</div>
</div>
 


<script>

$(document).ready(function () {


	var theme = 'arctic';
	
	setup_email_form('we');
	setup_email_form('be');
	setup_email_form('ae');
	<?php
		if($main_user->auto_welcome_template)
		{
			echo '$("#weTemplate").jqxDropDownList("selectItem",$("#weTemplate").jqxDropDownList("getItemByValue",'.$main_user->auto_welcome_template.'));'."\n";
		}
		if($main_user->auto_birthday_template)
		{
			echo '$("#beTemplate").jqxDropDownList("selectItem",$("#beTemplate").jqxDropDownList("getItemByValue",'.$main_user->auto_birthday_template.'));'."\n";
		}
		if($main_user->auto_anniversary_template)
		{
			echo '$("#aeTemplate").jqxDropDownList("selectItem",$("#aeTemplate").jqxDropDownList("getItemByValue",'.$main_user->auto_anniversary_template.'));'."\n";
		}
	?>

});	
</script>

<?php $this->load->view('template/footer_nav'); ?>
