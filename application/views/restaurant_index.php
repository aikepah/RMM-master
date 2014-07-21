<?php $this->load->view('template/header_nav'); ?>

<script>

function save_restaurant_info()
{
	var hoursText = CKEDITOR.instances['hoursEditor'].getData();
	var serializedData = 'hours_text='+escape(hoursText);
	$.ajax({
		url: '<?php echo site_url('restaurant/update_hours'); ?>',
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
	<h1>Restaurant Information</h1>
</div>
<div id="breadcrumb">
	<a href="#" title="Go to Home" class="current"><i class="icon-home"></i> Home</a>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-6" style="max-width: 560px;">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="icon-time"></i></span><h5>Restaurant Information</h5></div>
				<div class="widget-content nopadding" style="text-align: center; margin-top: 20px; margin-bottom: 5px; margin-right: 10px; padding-left: 10px;">
					<textarea id="hoursEditor" name="hoursEditor" rows="8" style="width: 360px; margin-bottom: 20px;"><?php echo $main_user->hours_text; ?></textarea>
					<div style="text-align: right;"><a id="editHoursButton" onclick="return save_restaurant_info();" class="btn btn-default btn-small" href="#">Save Info</a></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
	       <div id='uploadMenu'>Upload Menu</div>
           <div>
           <?php echo ($main_user->menu_image_path ? '<img style="margin: 10px;" src="'.$main_user->menu_image_path.'">' :''); ?>
           </div>
    </div>
</div>


     <script type="text/javascript">
        $(document).ready(function () {
        	CKEDITOR.replace('hoursEditor');

			$("#uploadMenu").uploadFile({
	            url:"<?php echo site_url('restaurant/upload_menu'); ?>",
                allowedTypes:"png,jpg,jpeg,pdf",
                onSuccess:function(files,data,xhr)
                {
                	//files: list of files
                	//data: response from server
                	//xhr : jquer xhr object
                    //alert(data);
                    location.reload();
                },
                onError: function(files,status,errMsg)
                {
                	//files: list of files
                	//status: error status
                	//errMsg: error message
                },
	        });

        });
    </script>


<?php $this->load->view('template/footer_nav'); ?>
