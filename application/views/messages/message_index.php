<?php $this->load->view('template/header_nav'); ?>

<div id="content-header">
	<h1>Messages</h1>
</div>
<div id="breadcrumb">
	<a href="#" title="Go to Home" class="current"><i class="icon-home"></i> Home</a>
</div>
<div id='jqxWidgetWrapper' class='default' style="height: 500px; width: 100%; margin-left: 10px; margin-bottom: 10px;">
	<div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
	    <div id="jqxgrid"></div>
        <div style="margin-top: 30px;">
            <div id="cellbegineditevent"></div>
            <div style="margin-top: 10px;" id="cellendeditevent"></div>
        </div>
		<div id='Menu'>
			<ul>
				<li>Edit Selected Row</li>
				<li>Delete Selected Row</li>
			</ul>
		</div>
	</div>
	
	<div id="test1"></div>
</div>


     <script type="text/javascript">
     
        $(document).ready(function () {
			//$(window).resize(function(){
				//alert($(window).width());
			//});
			$("#jqxWidgetWrapper").height($(window).height()-220);
            var theme = "arctic";
            //var data = generatedata(2500);

            var source =
            {
                //localdata: data,
                datafields:
                [
                  { name: 'message_id', type: 'int' },
                  { name: 'message_name', type: 'string' },
                  { name: 'scheduled_date', type: 'date' },
                  { name: 'message_type_id', type: 'int' },
                  { name: 'message_type_name', type: 'string' },
                  { name: 'email_subject', type: 'string' },
                  { name: 'email_body_html', type: 'string' },
                  { name: 'text_message', type: 'string' },
                  { name: 'postcard_template_id', type: 'int' },
                  { name: 'facebook_post', type: 'string' },
                  { name: 'twitter_post', type: 'string' },
                  { name: 'sent_date', type: 'date' },
                  { name: 'send_timeframe', type: 'int' },
                  { name: 'email_template_id', type: 'int' },
                ],
                datatype: "json",
//                url: '/rmm/index.php/contacts/load_contacts',
                localdata: <?php echo json_encode($scheduled_messages); ?>,
                cache: false,
                id: 'message_id',
//                root: 'data',
                //record: 'content',
                deleterow: function (rowid, commit) {
                    // synchronize with the server - send delete command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failed.
					$.ajax({
						url: "<?php echo site_url('messages/delete_message'); ?>/"+rowid,
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
                    var saveData = $.extend({},rowdata);
                    delete saveData.message_type_name;
                    if(saveData.scheduled_date)
                    	saveData.scheduled_date = saveData.scheduled_date.getFullYear()+'-'+(saveData.scheduled_date.getMonth()+1)+'-'+saveData.scheduled_date.getDate()+' '+saveData.scheduled_date.getHours()+':00:00';
                    var serializedData = $.param(saveData);
                    //alert(serializedData);
					$.ajax({
						url: "<?php echo site_url('messages/save_message'); ?>/"+rowid,
						type: "post",
						data: serializedData,
						// callback handler that will be called on success
						success: function(response, textStatus, jqXHR)
						{
        					if(response.indexOf('DCLICK')!=-1)
                            {
                            }
        					else if(response.indexOf('ERROR:')!=-1)
                            {
                                alert(response);
                            }
                            else
                            {
                    			if(!saveData.scheduled_date || saveData.scheduled_date=='')
                                {
                                    $.ajax({
                            		    url: '<?php echo site_url('message_manager/ajax_send_message'); ?>/'+response,
                                    });
                                }
                                commit(true);
                            }
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

            $("#jqxgrid").jqxGrid(
            {
                width: $("#jqxWidgetWrapper").width()-30,
                height: $("#jqxWidgetWrapper").height()-30,
                source: adapter,
                theme: theme,
                columnsresize: true,
                scrollmode: 'deferred',
//                deferreddatafields: ['firstname', 'lastname', 'productname'],
//                deferreddatafields: ['last_name'],
                sortable: true,
                showfilterrow: false,
                filterable: true,
                //selectionmode: 'checkbox',
                showstatusbar: true,
                ready: function()
                {
                    // called when the Grid is loaded. Call methods or set properties here.         
                },
                altrows: true,
                groupable: true,
                columns: [
                  { text: 'Message Id', datafield: 'message_id', width: 180 },
                  { text: 'Message Name', datafield: 'message_name', width: 180 },
                  { text: 'Message Type', datafield: 'message_type_name', width: 200 },
                  { text: 'Scheduled Date', datafield: 'scheduled_date', width: 160 },
                  { text: 'Sent Date', datafield: 'sent_date', width: 160 },
                  { text: 'Send Timeframe', datafield: 'send_timeframe', width: 160 },
                ],
                showstatusbar: true,
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='vertical-align: baseline; position: relative; margin-top: 2px;' src='/rmm/public/img/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                    var addDistButton = $("<div style='float: right; margin-left: 5px;'><img style='vertical-align: baseline; position: relative; margin-top: 2px;' src='/rmm/public/img/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Save Distribution List</span></div>");
                    var clearFilterButton = $("<div style='float: right; margin-left: 5px;'><img style='vertical-align: baseline; position: relative; margin-top: 2px;' src='/rmm/public/img/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Clear Filters</span></div>");
                    var deleteButton = $("<div style='float: left; margin-left: 5px;'><img style=' position: relative; margin-top: 2px;' src='../../images/close.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Delete</span></div>");
                    var reloadButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/refresh.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Reload</span></div>");
                    var searchButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/search.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Find</span></div>");
                    container.append(addButton);
                    //container.append(deleteButton);
                    //container.append(reloadButton);
                    //container.append(searchButton);
                    container.append(clearFilterButton);
                    //container.append(addDistButton);

                    statusbar.append(container);
                    addButton.jqxButton({ theme: theme, width: 63, height: 26 });
                    //deleteButton.jqxButton({ theme: theme, width: 65, height: 20 });
                    //reloadButton.jqxButton({ theme: theme, width: 65, height: 20 });
                    //searchButton.jqxButton({ theme: theme, width: 50, height: 20 });
                    //addDistButton.jqxButton({ theme: theme, width: 180, height: 26 });
                    clearFilterButton.jqxButton({ theme: theme, width: 120, height: 26 });
                    // add new row.
                    addButton.click(function (event) {
                        //var datarow = generatedata(1);
                        //$("#jqxgrid").jqxGrid('addrow', null, datarow[0]);
                        window.location.href = '<?php echo site_url('dashboard'); ?>';
                    });
                    clearFilterButton.click(function (event) {
                        $("#jqxgrid").jqxGrid('clearfilters');
                        //var datarow = generatedata(1);
                        //$("#jqxgrid").jqxGrid('addrow', null, datarow[0]);
                    });
                    // delete selected row.
                    deleteButton.click(function (event) {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                        var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                        $("#jqxgrid").jqxGrid('deleterow', id);
                    });
                    // reload grid data.
                    reloadButton.click(function (event) {
                        $("#jqxgrid").jqxGrid({ source: getAdapter() });
                    });
                    // search for a record.
                    searchButton.click(function (event) {
                        var offset = $("#jqxgrid").offset();
                        $("#jqxwindow").jqxWindow('open');
                        $("#jqxwindow").jqxWindow('move', offset.left + 30, offset.top + 30);
                    });
                },
            });
            // create context menu
            var contextMenu = $("#Menu").jqxMenu({ width: 200, height: 58, autoOpenPopup: false, mode: 'popup', theme: theme });
            $("#jqxgrid").on('contextmenu', function () {
                return false;
            });
            // handle context menu clicks.
            $("#Menu").on('itemclick', function (event) {
                var args = event.args;
                var rowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                if ($.trim($(args).text()) == "Edit Selected Row") 
                {
                    editrow = rowindex;
                    var offset = $("#jqxgrid").offset();
                     // get the clicked row's data and initialize the input fields.
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
//                    $("#firstName").val(dataRecord.first_name);
//                    $("#lastName").val(dataRecord.last_name);
//                    $("#emailAddress").val(dataRecord.email_address);
//                    $("#cityName").val(dataRecord.city);
                     // show the popup window.
                    if(dataRecord.sent_date)
                    {
                    	alert('This message has already been sent so cannot be edited.');
                    	return false;
                    }
					message_id = dataRecord.message_id;
                    switch(dataRecord.message_type_id)
                    {
                    	case 1: //facebook/twitter
                    		$('#ftInput').val(dataRecord.facebook_post);
							if(!dataRecord.scheduled_date)
							{
								$('#ftScheduleGroup').jqxButtonGroup('setSelection',0);
							}
							else
							{
								$('#ftScheduleGroup').jqxButtonGroup('setSelection',1);
								$('#ftCalendar').jqxCalendar('setDate',dataRecord.scheduled_date);
								$('#ftCalendarTime').val(dataRecord.scheduled_date.getHours());
							}
                    		$('#ftModal').modal('show');
                    	break;
                    	case 2: //text message
                    		$('#tmInput').val(dataRecord.text_message);
                    		$('input:radio[name=tmRecipients]').val([dataRecord.send_timeframe]);
							if(!dataRecord.scheduled_date)
							{
								$('#tmScheduleGroup').jqxButtonGroup('setSelection',0);
							}
							else
							{
								$('#tmScheduleGroup').jqxButtonGroup('setSelection',1);
								$('#tmCalendar').jqxCalendar('setDate',dataRecord.scheduled_date);
								$('#tmCalendarTime').val(dataRecord.scheduled_date.getHours());
							}
                    		$('#tmModal').modal('show');
                    	break;
                    	case 3: //email

							var emailTemplate = $("#emailTemplate").jqxDropDownList('getItemByValue',dataRecord.email_template_id);
							if(emailTemplate)
							{
								$("#emailTemplate").jqxDropDownList('selectItem',emailTemplate);
							}
                    		$('#emailSubject').val(dataRecord.email_subject);
               				CKEDITOR.instances['emailBody'].setData(dataRecord.email_body_html);

                    		$('input:radio[name=emailRecipients]').val([dataRecord.send_timeframe]);
							if(!dataRecord.scheduled_date)
							{
								$('#emailScheduleGroup').jqxButtonGroup('setSelection',0);
							}
							else
							{
								$('#emailScheduleGroup').jqxButtonGroup('setSelection',1);
								$('#emailCalendar').jqxCalendar('setDate',dataRecord.scheduled_date);
								$('#emailCalendarTime').val(dataRecord.scheduled_date.getHours());
							}
                    		$('#emailModal').modal('show');
                    	break;
                    	case 4: //postcard
                    		$('#postcardModal').modal('show');
                    	break;
                    	default:
                    		message_id = null;
                    	break;
                    }
                }
                else 
                {
                    var ans = confirm('Delete this message?');
                    if(ans)
                    {
                      var rowid = $("#jqxgrid").jqxGrid('getrowid', rowindex);
                      $("#jqxgrid").jqxGrid('deleterow', rowid);
                    }
                }
            });
            $("#jqxgrid").on('rowclick', function (event) {
                if (event.args.rightclick) {
                    $("#jqxgrid").jqxGrid('selectrow', event.args.rowindex);
                    var scrollTop = $(window).scrollTop();
                    var scrollLeft = $(window).scrollLeft();
                    contextMenu.jqxMenu('open', parseInt(event.args.originalEvent.clientX) + 5 + scrollLeft, parseInt(event.args.originalEvent.clientY) + 5 + scrollTop);
                    return false;
                }
            });
         
            // update the edited row when the user clicks the 'Save' button.
//            $("#Save").click(function () {
//                if (editrow >= 0) 
//                {
//                    var row = { first_name: $("#firstName").val(), last_name: $("#lastName").val(), email_address: $("#emailAddress").val(),
//                        city: $("#cityName").val(),
//                    };
//                    var rowID = $('#jqxgrid').jqxGrid('getrowid', editrow);
//                    $('#jqxgrid').jqxGrid('updaterow', rowID, row);
//                }
//            });            
        });
    </script>

<?php $this->load->view('include/message_editor'); ?>
 

<?php $this->load->view('template/footer_nav'); ?>
