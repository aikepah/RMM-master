<?php $this->load->view('template/header_nav'); ?>

<div id="content-header">
	<h1>View Contacts</h1>
</div>
<div id="breadcrumb">
	<a href="#" title="Go to Home" class="current"><i class="icon-home"></i> Home</a>
</div>
<div style='margin: 10px;'>
    <div id='uploadContacts'>Upload Contacts</div>
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
	<div id="popupWindow" class="modal fade" style="">
		<div class="modal-dialog" style="min-width: 600px; max-width: 800px; width: 100%;">
			<div class="modal-content">
    			<form id="contactForm" class="form-horizontal">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">×</button>
					<h3>Contact</h3>
				</div>
				<div class="modal-body">
						  <div style="display: inline-block;">
<?php
    foreach($contact_data['fields'] as $contact_field)
    {
        if($contact_field['edit_display'] && $contact_field['edit_col']==1)
        {
            if($contact_field['edit_field']=='date')
            {
                echo '<div class="control-group"><label class="control-label" for="'.$contact_field['field_name'].'_id">'.$contact_field['display_name'].'</label><div class="controls">';
                echo '<div id="'.$contact_field['field_name'].'_id"></div>';
                echo '</div></div>';
            }
            else
            {
                echo '<div class="control-group"><label class="control-label" for="'.$contact_field['field_name'].'_id">'.$contact_field['display_name'].'</label><div class="controls">';
                echo '<input type="text" id="'.$contact_field['field_name'].'_id">';
                echo '</div></div>';
            }
        }
    }
?>
						  </div>
						  <div style="display: inline-block;">
<?php
    foreach($contact_data['fields'] as $contact_field)
    {
        if($contact_field['edit_display'] && $contact_field['edit_col']==2)
        {
            if($contact_field['edit_field']=='date')
            {
                echo '<div class="control-group"><label class="control-label" for="'.$contact_field['field_name'].'_id">'.$contact_field['display_name'].'</label><div class="controls">';
                echo '<div id="'.$contact_field['field_name'].'_id"></div>';
                echo '</div></div>';
            }
            else
            {
                echo '<div class="control-group"><label class="control-label" for="'.$contact_field['field_name'].'_id">'.$contact_field['display_name'].'</label><div class="controls">';
                echo '<input type="text" id="'.$contact_field['field_name'].'_id">';
                echo '</div></div>';
            }
        }
    }
?>
						  </div>
				</div>
				<div class="modal-footer">
					<button type="submit" value="save" data-dismiss="modal" id="saveButton" class="btn btn-primary btn-small" href="#">Save</button>
					<a data-dismiss="modal" id="cancelButton" class="btn btn-default btn-small" href="#">Cancel</a>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div id="test1"></div>
</div>


     <script type="text/javascript">  

        $(document).ready(function () {
            editrow = -2;
			$("#uploadContacts").uploadFile({
	            url:"<?php echo site_url('contacts/upload_contacts'); ?>",
                allowedTypes:"csv",
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
            
            //$(window).resize(function(){
				//alert($(window).width());
			//});
			$("#jqxWidgetWrapper").height($(window).height()-320);
            var theme = "arctic";
<?php
    foreach($contact_data['fields'] as $contact_field)
    {
        if($contact_field['edit_field']=='date')
        {
            echo "$('#".$contact_field['field_name']."_id').jqxDateTimeInput({width: '150px', height: '25px', theme: theme, formatString: 'MM/dd/yyyy', enableAbsoluteSelection: false});\n";
        }
    }
?>
            //var data = generatedata(2500);

            var source =
            {
                //localdata: data,
                datafields:
                [
<?php
    foreach($contact_data['fields'] as $contact_field)
    {
        echo '{ name: "'.$contact_field['field_name'].'", type: "'.$contact_field['field_type'].'" }, ';
    }
?>
/*
                  { name: 'first_name', type: 'string' },
                  { name: 'last_name', type: 'string' },
                  { name: 'email_address', type: 'string' },
                  { name: 'mobile_phone', type: 'string' },
                  { name: 'home_phone', type: 'string' },
                  { name: 'address1', type: 'string' },
                  { name: 'address2', type: 'string' },
                  { name: 'city', type: 'string' },
                  { name: 'state_region', type: 'string' },
                  { name: 'postal_code', type: 'string' },
                  { name: 'birthday', type: 'string' },
                  { name: 'anniversary', type: 'string' },
                  { name: 'loyalty_points', type: 'int' },
                  { name: 'group_name', type: 'string' },
*/
                ],
                datatype: "json",
                url: '/rmm/index.php/contacts/load_contacts',
//                localdata: <?php // echo json_encode($contact_list); ?>,
                cache: false,
                id: 'contact_id',
                totalrecords: <?php echo $contact_count; ?>,
//				beforeprocessing: function(data)
//				{		
//					source.totalrecords = data[0].total_rows;
//				},
                
                root: 'rows',
//                record: 'content',
        		filter: function()
        		{
        			// update the grid and send a request to the server.
        			$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
        		},
        		sort: function()
        		{
        			// update the grid and send a request to the server.
        			$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
        		},
                deleterow: function (rowid, commit) {
                    // synchronize with the server - send delete command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failed.
					$.ajax({
						url: "<?php echo site_url('contacts/delete_contact'); ?>/"+rowid,
						type: "get",
						//data: serializedData,
						// callback handler that will be called on success
						success: function(response, textStatus, jqXHR)
						{
		                    commit(true);
                			$("#jqxgrid").jqxGrid('updatebounddata');
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
                    var savedata = $.extend(true, {}, rowdata);
<?php
    foreach($contact_data['fields'] as $contact_field)
    {
        if($contact_field['edit_field']=='date')
        {
            echo "if(savedata['".$contact_field['field_name']."']){ savedata['".$contact_field['field_name']."'] = savedata['".$contact_field['field_name']."'].toISOString();}";
        }
    }
?>
                    var serializedData = $.param(savedata);
                    //alert(serializedData);
					$.ajax({
						url: "<?php echo site_url('contacts/update_contact'); ?>/"+rowid,
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
                addrow: function (rowid, rowdata, position, commit) {
                    // synchronize with the server - send update command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failder.
                    //alert(rowid);
                    //alert(JSON.stringify(rowdata));
                    //alert(commit);
                    var savedata = $.extend(true, {}, rowdata);
<?php
    foreach($contact_data['fields'] as $contact_field)
    {
        if($contact_field['edit_field']=='date')
        {
            echo "if(savedata['".$contact_field['field_name']."']){ savedata['".$contact_field['field_name']."'] = savedata['".$contact_field['field_name']."'].toISOString();}";
        }
    }
?>
                    var serializedData = $.param(savedata);
                    //alert(serializedData);
					$.ajax({
						url: "<?php echo site_url('contacts/update_contact'); ?>",
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

            $("#jqxgrid").jqxGrid(
            {
                width: $("#jqxWidgetWrapper").width()-30,
//                height: $("#jqxWidgetWrapper").height()-30,
                autoheight: true,
                source: adapter,
				rendergridrows: function(obj)
				{
					  return obj.data;     
				},
                theme: theme,
                columnsresize: true,
//                scrollmode: 'deferred',
//                deferreddatafields: ['firstname', 'lastname', 'productname'],
//                deferreddatafields: ['last_name'],
                sortable: true,
//                showfilterrow: false,
                filterable: true,
                //selectionmode: 'checkbox',
                showstatusbar: true,
                virtualmode: true,
                pageable: true,
                ready: function()
                {
                    // called when the Grid is loaded. Call methods or set properties here.         
                },
                altrows: true,
                pagesize: 10,
                pagesizeoptions: ['10', '20'],
//                groupable: true,
                columns: [
<?php
    foreach($contact_data['fields'] as $contact_field)
    {
        if($contact_field['grid_display'])
        {
            echo '{ text: "'.$contact_field['display_name'].'", datafield: "'.$contact_field['field_name'].'", width: '.$contact_field['grid_width'];
            if(isset($contact_field['custom_grid']) && $contact_field['custom_grid'] != '')
            {
                echo ', '. $contact_field['custom_grid'];
            }
            echo ' }, ';
        }
    }
?>
/*
                  { text: 'First Name', datafield: 'first_name', width: 100 },
                  { text: 'Last Name', datafield: 'last_name', width: 100 },
                  { text: 'Email Address', datafield: 'email_address', width: 180 },
                  { text: 'Mobile Phone', datafield: 'mobile_phone', width: 110 },
                  { text: 'Home Phone', datafield: 'home_phone', width: 110 },
                  { text: 'City', datafield: 'city', width: 120, filtertype: 'checkedlist', filteritems: ['<?php echo join("','",$cities); ?>'], },
                  { text: 'Group', datafield: 'group_name', width: 120 },
                  { text: 'Edit', datafield: 'Edit', columntype: 'button', cellsrenderer: function () {
                     return "Edit";
                  }, buttonclick: function (row) {
                     // open the popup window when the user clicks a button.
                     editrow = row;
                     var offset = $("#jqxgrid").offset();
                     $("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
                     // get the clicked row's data and initialize the input fields.
                     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
                     $("#firstName").val(dataRecord.first_name);
                     $("#lastName").val(dataRecord.last_name);
                     $("#emailAddress").val(dataRecord.email_address);
                     $("#cityName").val(dataRecord.city);
                     // show the popup window.
                     $("#popupWindow").jqxWindow('open');
	               }
                 },
*/
                  //{ text: 'Unit Price', datafield: 'price', width: 80, cellsalign: 'right', cellsformat: 'c2' },
                  //{ text: 'Total', datafield: 'total', cellsalign: 'right', cellsformat: 'c2' }
                ],
                showstatusbar: true,
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='vertical-align: baseline; position: relative; margin-top: 2px;' src='/rmm/public/img/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                    var addDistButton = $("<div style='float: right; margin-left: 5px;'><img style='vertical-align: baseline; position: relative; margin-top: 2px;' src='/rmm/public/img/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Save Distribution List</span></div>");
                    var clearFilterButton = $("<div style='float: right; margin-left: 5px;'><span style='margin-left: 4px;'>Clear Filters</span></div>");
                    var saveGroupButton = $("<div style='float: right; margin-left: 5px;'><img style='vertical-align: baseline; position: relative; margin-top: 2px;' src='/rmm/public/img/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Save Group</span></div>");
                    var deleteButton = $("<div style='float: left; margin-left: 5px;'><img style=' position: relative; margin-top: 2px;' src='../../images/close.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Delete</span></div>");
                    var reloadButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/refresh.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Reload</span></div>");
                    var searchButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/search.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Find</span></div>");
                    container.append(addButton);
                    //container.append(deleteButton);
                    //container.append(reloadButton);
                    //container.append(searchButton);
                    container.append(clearFilterButton);
                    container.append(saveGroupButton);
                    //container.append(addDistButton);

                    statusbar.append(container);
                    addButton.jqxButton({ theme: theme, width: 63, height: 26 });
                    //deleteButton.jqxButton({ theme: theme, width: 65, height: 20 });
                    //reloadButton.jqxButton({ theme: theme, width: 65, height: 20 });
                    //searchButton.jqxButton({ theme: theme, width: 50, height: 20 });
//                    addDistButton.jqxButton({ theme: theme, width: 180, height: 26 });
                    clearFilterButton.jqxButton({ theme: theme, width: 120, height: 26 });
                    saveGroupButton.jqxButton({ theme: theme, width: 120, height: 26 });
                    // add new row.
                    addButton.click(function (event) {
                        //var datarow = generatedata(1);
	                    editrow = -1;
<?php
    foreach($contact_data['fields'] as $contact_field)
    {
        if($contact_field['edit_display'])
        {
            if($contact_field['edit_field']=='date')
            {
                echo '$("#'.$contact_field['field_name'].'_id").val(null); ';
            }
            else
            {
                echo '$("#'.$contact_field['field_name'].'_id").val(null); ';
            }
        }
    }
?>
/*
	                    $("#firstName").val(null);
	                    $("#lastName").val(null);
	                    $("#emailAddress").val(null);
	                    $("#address1").val(null);
	                    $("#address2").val(null);
	                    $("#cityName").val(null);
	                    $("#stateName").val(null);
	                    $("#postalCode").val(null);
	                    $("#groupName").val(null);
	                    $("#birthday").val(null);
	                    $("#anniversary").val(null);
	                    $("#mobilePhone").val(null);
	                    $("#homePhone").val(null);
*/
	                     // show the popup window.
	                    $("#popupWindow").modal('show');
                    });
                    clearFilterButton.click(function (event) {
                        $("#jqxgrid").jqxGrid('removesort');
                        $("#jqxgrid").jqxGrid('clearfilters');
                        //var datarow = generatedata(1);
                        //$("#jqxgrid").jqxGrid('addrow', null, datarow[0]);
                    });
                    saveGroupButton.click(function (event) {
                        var groupName = prompt("Enter a name for the group you want to save");
                        if(!groupName)
                            return;
                        var filterGroups = $("#jqxgrid").jqxGrid('getfilterinformation');
                        var filterText = "";
                        var info = "";
                        var filterscount = 0;
                        for (var i = 0; i < filterGroups.length; i++) 
                        {
                            var filterGroup = filterGroups[i];
                            var filters = filterGroup.filter.getfilters();
                            for (var j = 0; j < filters.length; j++) 
                            {
                                info += '&filtervalue'+filterscount+'='+encodeURIComponent(filters[j].value);
                                info += '&filtercondition'+filterscount+'='+encodeURIComponent(filters[j].condition);
                                info += '&filterdatafield'+filterscount+'='+encodeURIComponent(filterGroup.filtercolumn);
                                info += '&filteroperator'+filterscount+'='+encodeURIComponent(filters[j].operator);
                                filterscount++;
                             }
                         }
                         info = 'filterscount='+filterscount+info;
                         info = 'groupname='+encodeURIComponent(groupName)+'&'+info;
                         //alert(info);
      					 $.ajax({
      						url: "<?php echo site_url('contacts/save_contact_group'); ?>",
      						type: "post",
      						data: info,
      						// callback handler that will be called on success
      						success: function(response, textStatus, jqXHR)
      						{
                            	$.gritter.add({
                            		title:	'Contact Group Save',
                               		text:	response,
                            		sticky: false
                	           });	
      						   //alert(response);
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
                    //$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
                     // get the clicked row's data and initialize the input fields.
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
<?php
    foreach($contact_data['fields'] as $contact_field)
    {
        if($contact_field['edit_display'])
        {
            if($contact_field['edit_field']=='date')
            {
                echo '$("#'.$contact_field['field_name'].'_id").val(dataRecord.'.$contact_field['field_name'].'); ';
            }
            else
            {
                echo '$("#'.$contact_field['field_name'].'_id").val(dataRecord.'.$contact_field['field_name'].'); ';
            }
        }
    }
?>
/*
                    $("#firstName").val(dataRecord.first_name);
                    $("#lastName").val(dataRecord.last_name);
                    $("#emailAddress").val(dataRecord.email_address);
                    $("#address1").val(dataRecord.address1);
                    $("#address2").val(dataRecord.address2);
                    $("#cityName").val(dataRecord.city);
                    $("#stateName").val(dataRecord.state_region);
                    $("#postalCode").val(dataRecord.postal_code);
                    $("#groupName").val(dataRecord.group_name);
                    $("#birthday").val(dataRecord.birthday);
                    $("#anniversary").val(dataRecord.anniversary);
                    $("#mobilePhone").val(dataRecord.mobile_phone);
                    $("#homePhone").val(dataRecord.home_phone);
*/
                     // show the popup window.
                    $("#popupWindow").modal('show');
                    //$("#popupWindow").jqxWindow('open');
                    // show the popup window.
                    //$("#popupWindow").jqxWindow('show');
                }
                else 
                {
                    var ans = confirm('Delete this contact?');
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
         
            //$("#cancelButton").jqxButton({ theme: theme });
            //$("#saveButton").jqxButton({ theme: theme });
            // update the edited row when the user clicks the 'Save' button.
            $("#saveButton").click(function () {
//            $("#contactForm").submit(function(event) {
                //event.preventDefault();
                if (editrow >= -1) 
                {
                    var row = { 
<?php
    foreach($contact_data['fields'] as $contact_field)
    {
        if($contact_field['edit_display'])
        {
            if($contact_field['edit_field']=='date')
            {
                echo $contact_field['field_name'].': $("#'.$contact_field['field_name'].'_id").jqxDateTimeInput("getDate"), ';
            }
            else
            {
                echo $contact_field['field_name'].': $("#'.$contact_field['field_name'].'_id").val(), ';
            }
       
        }
    }
?>
/*
                    	first_name: $("#firstName").val(), 
                    	last_name: $("#lastName").val(), 
                    	email_address: $("#emailAddress").val(),
                        address1: $("#address1").val(),
                        address2: $("#address2").val(),
                        city: $("#cityName").val(),
                        state_region: $("#stateName").val(),
                        postal_code: $("#postalCode").val(),
                        group_name: $("#groupName").val(),
//                        birthday: $("#birthday").val(),
//                        anniversary: $("#anniversary").val(),
                        mobile_phone: $("#mobilePhone").val(),
                        home_phone: $("#homePhone").val(),
*/
                    };
	                if(editrow == -1)
	                {
	                    $("#jqxgrid").jqxGrid('addrow', null, row);
	                }
	                else
	                {
	                    var rowID = $('#jqxgrid').jqxGrid('getrowid', editrow);
	                    $('#jqxgrid').jqxGrid('updaterow', rowID, row);
	                }
                    editrow = -2; 
                    $("#popupWindow").modal('hide');
                }
                return false;
            });            
        });
    </script>


<?php $this->load->view('template/footer_nav'); ?>
