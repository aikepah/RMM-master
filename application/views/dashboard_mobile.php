<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <title id='Description'>Restaurant Money Machine</title>
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/fullcalendar.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/jquery.jscrollpane.css" />	
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/unicorn.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/unicorn.grey.css" class="skin-color" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/js/jqwidgets/styles/jqx.base.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/js/jqwidgets/styles/jqx.arctic.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/js/jqwidgets/styles/jqx.android.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>public/js/jqwidgets/styles/jqx.mobile.css" />
        <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jqwidgets/jqxcore.js"></script>
        <script src="<?php echo base_url();?>public/js/jqwidgets/jqx-all.js"></script>
    <style>
        #list div
        {
            margin-top: 19px;
            margin-left: 20px;
        }
        .jqx-listmenu-item
        {
            padding: 0px;
            font-size: 16px;
            min-height: 57px;
        }
    	
    </style>
</head>
<body>
	<div id="header">
		<h1 style="margin-left: auto; margin-right: auto; left: 0px;"></h1>
	</div>
	<div style="height: 500px;">
		<ul id="list" data-role="listmenu">
			<li>
				<div>Facebook/Twitter Post</div>
					<ul data-role="listmenu"><li>
						<div data-role="content">
							<div style="margin-left: 10px; margin-right: 10px;">
								<h4 style="margin-bottom: 20px;">Post to Facebook/Twitter</h4>
								<input type="text" maxlength="140" id="ftInput" name="ftInput" style="width: 100%;">
								<span id="ftCharCount">140 characters remaining</span>
			                    <button style="margin-top: 30px; margin-left: 10%;" id="ftButton">Submit Post</button>
							</div>
						</div>
					</li></ul>
			</li>
			<li>
				<div>Send Text Message</div>
					<ul data-role="listmenu"><li>
						<div data-role="content">
							<div style="margin-left: 10px; margin-right: 10px;">
								<h4 style="margin-bottom: 20px;">Send SMS Text Message</h4>
								<input type="text" id="tmInput" name="tmInput" style="width: 100%;">
								<span id="tmCharCount">160 characters remaining</span>
			                    <div style="margin-top: 15px;" id="tmGroup1">
			                        <input type="radio" name="tmRecipients" value="now">Send to everyone now</br>
				                    <input type="radio" name="tmRecipients" style="margin-bottom: 15px;" value="spread">Send to everyone spread over 2 weeks
			                    </div>
			                    <button style="margin-top: 20px; margin-left: 10%;" id="tmButton">Send Message</button>
							</div>
						</div>
					</li></ul>
			</li>
			<li>
				<div>Hours</div>
					<ul data-role="listmenu"><li>
						<div data-role="content">
							<div style="margin-left: 10px; margin-right: 10px;">
								<h4 style="margin-bottom: 20px;">Hours</h4>
								<div style="text-align: center; margin: 20px;">
									Monday-Friday<br />
									11:00am - 9:00pm<br /><br />
									Saturday<br />
									11:00am - 11:00pm<br /><br />
									Closed Sunday
								</div>

							</div>
						</div>
					</li></ul>
			</li>
			<li>
				<div>Menu</div>
					<ul data-role="listmenu"><li>
						<div data-role="content">
							<div style="margin-left: 10px; margin-right: 10px;">
								<h4 style="margin-bottom: 20px;">Menu</h4>
							</div>
						</div>
					</li></ul>
			</li>
			<li>
				<div>Contacts</div>
					<ul data-role="listmenu"><li>
						<div data-role="content">
							<div style="margin-left: 10px; margin-right: 10px;">
								<h4 style="margin-bottom: 20px;">Contacts</h4>
							    <div id="contactgrid"></div>
							</div>
						</div>
					</li></ul>
			</li>
		</ul>
	</div>
</body>
    <script type="text/javascript">
        $(document).ready(function () {
            //var theme = prepareSimulator("list");
            var theme = "mobile";
            $('#list').jqxListMenu({ theme: theme, autoSeparators: false, showFilter: false, showHeader: true, width: '100%', height: '100%', backLabel: 'Home' });
//            $('.home-link').click(function(){
//            	$('#list').jqxListMenu('back');
//            	return false;
//            });
             $('#ftInput').keyup(function (e) {
                var count = 140 - $('#ftInput').val().length;
                if(count == 1)
                {
                	$('#ftCharCount').text("1 character remaining");
                }
                else
                {
                	$('#ftCharCount').text(count+" characters remaining");
                }
            });
             $('#tmInput').keyup(function (e) {
                var count = 160 - $('#tmInput').val().length;
                if(count == 1)
                {
                	$('#tmCharCount').text("1 character remaining");
                }
                else
                {
                	$('#tmCharCount').text(count+" characters remaining");
                }
            });

            //$("#tmGroup1a").jqxRadioButton({ groupName: 'messageRecipients', theme: theme, checked: true });
            //$("#tmGroup1b").jqxRadioButton({ groupName: 'messageRecipients', theme: theme, checked: false });

 
            $("#ftButton").jqxButton({ enableHover: false, theme: 'android', width: '80%' });
            $("#tmButton").jqxButton({ enableHover: false, theme: 'android', width: '80%' });
            //initSimulator("list");
            
            //var theme = "arctic";
            //var data = generatedata(2500);

            var source =
            {
                //localdata: data,
                datafields:
                [
                  { name: 'first_name', type: 'string' },
                  { name: 'last_name', type: 'string' },
                  { name: 'email_address', type: 'string' },
                  { name: 'mobile_phone', type: 'string' },
                  { name: 'home_phone', type: 'string' },
                  { name: 'city', type: 'string' },
                  { name: 'loyalty_points', type: 'int' },
                ],
                datatype: "json",
//                url: '/rmm/index.php/contacts/load_contacts',
                localdata: <?php echo json_encode($contact_list); ?>,
                cache: false,
                id: 'contact_id',
//                root: 'data',
                //record: 'content',
                deleterow: function (rowid, commit) {
                    // synchronize with the server - send delete command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failed.
					$.ajax({
						url: "/rmm/index.php/contacts/delete_contact/"+rowid,
						type: "get",
						//data: serializedData,
						// callback handler that will be called on success
						success: function(response, textStatus, jqXHR)
						{
		                    commit(true);
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
                    //commit(true);
                },
                updaterow: function (rowid, rowdata, commit) {
                    // synchronize with the server - send update command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failder.
                    //alert(rowid);
                    //alert(JSON.stringify(rowdata));
                    //alert(commit);
                    var serializedData = $.param(rowdata);
                    //alert(serializedData);
					$.ajax({
						url: "/rmm/index.php/contacts/update_contact/"+rowid,
						type: "post",
						data: serializedData,
						// callback handler that will be called on success
						success: function(response, textStatus, jqXHR)
						{
		                    commit(true);
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
                },
            };
            var adapter = new $.jqx.dataAdapter(source);

            $("#contactgrid").jqxGrid(
            {
                width: '100%', //1000, //$("#jqxWidgetWrapper").width()-50,
                height: '100%',//$("#jqxWidgetWrapper").height()-30,
                source: adapter,
                theme: theme,
                //selectionmode: 'checkbox',
                showstatusbar: true,
                ready: function()
                {
                    // called when the Grid is loaded. Call methods or set properties here.         
                },
                altrows: true,
                columnsheight: 40,
                columnsmenuwidth: 40,
                rowsheight: 34,
//                selectionmode: 'none',
                columns: [
                  { text: 'First Name', datafield: 'first_name', width: '50%' },
                  { text: 'Last Name', datafield: 'last_name', width: '50%' },
                ],
            });
            
        });
    </script>


</html>