<?php
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
header ('Pragma: no-cache'); // HTTP/1.0

$userdata = $this->ion_auth->user($this->session->userdata('user_id'))->row();

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>RMM</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/uploadfile.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/icheck/flat/blue.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/fullcalendar.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/jquery.jscrollpane.css" />	
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/jquery.gritter.css" />	
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/unicorn.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/unicorn.grey.css" class="skin-color" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/js/jqwidgets/styles/jqx.base.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/js/jqwidgets/styles/jqx.arctic.css" />

        <script src="<?php echo base_url();?>public/js/excanvas.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery-ui.custom.js"></script>
        <script src="<?php echo base_url();?>public/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.flot.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.flot.resize.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.gritter.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.sparkline.min.js"></script>
        <script src="<?php echo base_url();?>public/js/fullcalendar.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.icheck.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.validate.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.wizard.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.jpanelmenu.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.nicescroll.min.js"></script>
        <script src="<?php echo base_url();?>public/js/unicorn.js"></script>
        <script src="<?php echo base_url();?>public/js/jqwidgets/jqxcore.js"></script>
        <script src="<?php echo base_url();?>public/js/jqwidgets/jqx-all.js"></script>
        <script src="<?php echo base_url();?>public/js/jqwidgets/globalization/globalize.js"></script>
        <script src="<?php echo base_url();?>public/ckeditor/ckeditor.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery.uploadfile.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/ajaxfileupload.js"></script>

        <script src="<?php echo base_url();?>public/js/jqwidgets/generatedata.js"></script>

	</head>
	<body>
		<div id="header">
			<h1><a href="./dashboard.html">RMM Admin</a></h1>	
			<a id="menu-trigger" href="#"><i class="icon-align-justify"></i></a>	
		</div>
		
		<div id="user-nav">
            <ul class="btn-group">

<?php if($this->ion_auth->is_admin()) { ?>
                <li class="btn"><?php echo anchor("site_admin/users/".time(),'<span class="text">User Accounts</span>'); ?></li>
                <li class="btn"></li>
<?php } ?>
                <li class="btn"><?php echo anchor("settings/index/".time(),'<i class="icon-cog"></i> <span class="text">Settings</span>'); ?></li>
                <li class="btn"><?php echo anchor('auth/logout','<i class="icon-share-alt"></i> <span class="text">Logout: '.$userdata->email.'</span>'); ?></li>
            </ul>
        </div>
            
		<div id="sidebar">
			<ul>
				<li <?php echo (strpos(uri_string(),'dashboard') !== false ? 'class="active"' : ''); ?>><?php echo anchor("dashboard/index/".time(),'<i class="icon-home"></i> <span>Dashboard</span>'); ?></li>
				<li <?php echo (strpos(uri_string(),'contacts') !== false  ? 'class="active"' : ''); ?>><?php echo anchor("contacts/index/".time(),'<i class="icon-book"></i> <span>Contacts</span>'); ?></li>
				<li  <?php echo (strpos(uri_string(),'messages') !== false ? 'class="active"' : 'class=""'); ?>>
					<?php echo anchor("messages/index/".time(),'<i class="icon-envelope"></i> <span>Messages</span>'); ?>
				</li>
				<li <?php echo (strpos(uri_string(),'restaurant') !== false ? 'class="active"' : ''); ?>>
					<?php echo anchor("restaurant/index/".time(),'<i class="icon-list"></i> <span>Restaurant Information</span>'); ?>
				</li>
				<li <?php echo (strpos(uri_string(),'social_media') !== false ? 'class="active"' : ''); ?>>
					<?php echo anchor("social_media/index/".time(),'<i class="icon-group"></i> <span>Social Media</span>'); ?>
				</li>
				
				<!-- <li <?php echo (uri_string() == 'reputation' ? 'class="active"' : ''); ?>>
					<?php echo anchor("reputation",'<i class="icon-comments"></i> <span>Reputation Monitoring</span>'); //<span class="label">5</span> ?>
				</li> --> 
				<!--<li>
					<a href="charts.html"><i class="icon-signal"></i> <span>Reports</span></a>
				</li> -->
			</ul>
		
		</div>
		
		<div id="content">
