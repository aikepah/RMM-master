<?php $this->load->view('template/header_nav'); ?>

<div id="content-header">
	<h1>Manage Users</h1>
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
				<li>Edit Selected User</li>
				<li>Inactivate Selected User</li>
				<li>Activate Selected User</li>
			</ul>
		</div>
	</div>
	<div id="popupWindow" class="modal fade" style="">
		<div class="modal-dialog" style="min-width: 600px; max-width: 800px; width: 100%;">
			<div class="modal-content">
    			<form id="userForm" class="form-horizontal" method="post" action="<?php echo site_url('site_admin/update_user'); ?>">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">x</button>
					<h3>User</h3>
				</div>
				<div class="modal-body">
						  <div style="display: inline-block;">
<?php
    foreach($user_data['fields'] as $user_field)
    {
        if($user_field['edit_display'] && $user_field['edit_col']==1)
        {
            if($user_field['edit_field']=='date')
            {
                echo '<div class="control-group"><label class="control-label" for="'.$user_field['field_name'].'_id">'.$user_field['display_name'].'</label><div class="controls">';
                echo '<div id="'.$user_field['field_name'].'_id"></div>';
                echo '</div></div>';
            }
            else if($user_field['edit_field']=='password')
            {
                echo '<div class="control-group"><label class="control-label" for="'.$user_field['field_name'].'_id">'.$user_field['display_name'].'</label><div class="controls">';
                echo '<input type="password" id="'.$user_field['field_name'].'_id">';
                echo '</div></div>';
            }
            else
            {
                echo '<div class="control-group"><label class="control-label" for="'.$user_field['field_name'].'_id">'.$user_field['display_name'].'</label><div class="controls">';
                echo '<input type="text" id="'.$user_field['field_name'].'_id">';
                echo '</div></div>';
            }
        }
    }
?>
						  </div>
						  <div style="display: inline-block;">
<?php
    foreach($user_data['fields'] as $user_field)
    {
        if($user_field['edit_display'] && $user_field['edit_col']==2)
        {
            if($user_field['edit_field']=='date')
            {
                echo '<div class="control-group"><label class="control-label" for="'.$user_field['field_name'].'_id">'.$user_field['display_name'].'</label><div class="controls">';
                echo '<div id="'.$user_field['field_name'].'_id"></div>';
                echo '</div></div>';
            }
            else if($user_field['edit_field']=='password')
            {
                echo '<div class="control-group"><label class="control-label" for="'.$user_field['field_name'].'_id">'.$user_field['display_name'].'</label><div class="controls">';
                echo '<input type="password" id="'.$user_field['field_name'].'_id">';
                echo '</div></div>';
            }
            else
            {
                echo '<div class="control-group"><label class="control-label" for="'.$user_field['field_name'].'_id">'.$user_field['display_name'].'</label><div class="controls">';
                echo '<input type="text" id="'.$user_field['field_name'].'_id">';
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

			$("#jqxWidgetWrapper").height($(window).height()-320);
            var theme = "arctic";
<?php
    foreach($user_data['fields'] as $user_field)
    {
        if($user_field['edit_field']=='date')
        {
            echo "$('#".$user_field['field_name']."_id').jqxDateTimeInput({width: '150px', height: '25px', theme: theme, formatString: 'MM/dd/yyyy', enableAbsoluteSelection: true});\n";
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
    foreach($user_data['fields'] as $user_field)
    {
        echo '{ name: "'.$user_field['field_name'].'", type: "'.$user_field['field_type'].'" }, ';
    }
?>
                ],
                datatype: "json",
                url: '/rmm/index.php/site_admin/load_users',
                cache: false,
                id: 'user_id',
                totalrecords: <?php echo $user_count; ?>,
                
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
						url: "<?php echo site_url('site_admin/inactivate_user'); ?>/"+rowid,
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
    foreach($user_data['fields'] as $user_field)
    {
        if($user_field['edit_field']=='date')
        {
            echo "if(savedata['".$user_field['field_name']."']){ savedata['".$user_field['field_name']."'] = savedata['".$user_field['field_name']."'].toISOString();}";
        }
    }
?>
                    var serializedData = $.param(savedata);
                    //alert(serializedData);
                    $.ajax({
						url: "<?php echo site_url('site_admin/update_user'); ?>/"+rowid,
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
                            $('#test1').html(jqXHR.responseText);
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
    foreach($user_data['fields'] as $user_field)
    {
        if($user_field['edit_field']=='date')
        {
            echo "if(savedata['".$user_field['field_name']."']){ savedata['".$user_field['field_name']."'] = savedata['".$user_field['field_name']."'].toISOString();}";
        }
    }
?>
                    var serializedData = $.param(savedata);
                    //alert(serializedData);
					$.ajax({
						url: "<?php echo site_url('site_admin/update_user'); ?>",
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
                sortable: true,
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
                pagesizeoptions: ['10', '25', '50'],
//                groupable: true,
                columns: [
<?php
    foreach($user_data['fields'] as $user_field)
    {
        if($user_field['grid_display'])
        {
            echo '{ text: "'.$user_field['display_name'].'", datafield: "'.$user_field['field_name'].'", width: '.$user_field['grid_width'];
            if(isset($user_field['custom_grid']) && $user_field['custom_grid'] != '')
            {
                echo ', '. $user_field['custom_grid'];
            }
            echo ' }, ';
        }
    }
?>
                ],
                showstatusbar: true,
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='vertical-align: baseline; position: relative; margin-top: 2px;' src='/rmm/public/img/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                    var addDistButton = $("<div style='float: right; margin-left: 5px;'><img style='vertical-align: baseline; position: relative; margin-top: 2px;' src='/rmm/public/img/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Save Distribution List</span></div>");
                    var clearFilterButton = $("<div style='float: right; margin-left: 5px;'><span style='margin-left: 4px;'>Clear Filters</span></div>");
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
//                    addDistButton.jqxButton({ theme: theme, width: 180, height: 26 });
                    clearFilterButton.jqxButton({ theme: theme, width: 120, height: 26 });
                    // add new row.
                    addButton.click(function (event) {
                        //var datarow = generatedata(1);
	                    editrow = -1;
<?php
    foreach($user_data['fields'] as $user_field)
    {
        if($user_field['edit_display'])
        {
            if($user_field['edit_field']=='date')
            {
                echo '$("#'.$user_field['field_name'].'_id").val(null); ';
            }
            else
            {
                echo '$("#'.$user_field['field_name'].'_id").val(null); ';
            }
        }
    }
?>
	                     // show the popup window.
	                    $("#popupWindow").modal('show');
                    });
                    clearFilterButton.click(function (event) {
                        $("#jqxgrid").jqxGrid('removesort');
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
            var contextMenu = $("#Menu").jqxMenu({ width: 200, height: 87, autoOpenPopup: false, mode: 'popup', theme: theme });
            $("#jqxgrid").on('contextmenu', function () {
                return false;
            });
            // handle context menu clicks.
            $("#Menu").on('itemclick', function (event) {
                var args = event.args;
                var rowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                if ($.trim($(args).text()) == "Edit Selected User") 
                {
                    editrow = rowindex;
                    var offset = $("#jqxgrid").offset();
                    //$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
                     // get the clicked row's data and initialize the input fields.
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
<?php
    foreach($user_data['fields'] as $user_field)
    {
        if($user_field['edit_display'])
        {
            if($user_field['edit_field']=='date')
            {
                echo '$("#'.$user_field['field_name'].'_id").val(dataRecord.'.$user_field['field_name'].'); ';
            }
            else
            {
                echo '$("#'.$user_field['field_name'].'_id").val(dataRecord.'.$user_field['field_name'].'); ';
            }
        }
    }
?>
                     // show the popup window.
                    $("#popupWindow").modal('show');
                    //$("#popupWindow").jqxWindow('open');
                    // show the popup window.
                    //$("#popupWindow").jqxWindow('show');
                }
                else if ($.trim($(args).text()) == "Activate Selected User")
                {
                    editrow = rowindex;
                    var ans = confirm('Activate this user?');
                    if(ans)
                    {
                      var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
                      dataRecord.active = 1;
                      delete dataRecord.uid;
                      var rowID = $('#jqxgrid').jqxGrid('getrowid', editrow);
                      $('#jqxgrid').jqxGrid('updaterow', rowID, dataRecord);
                    }
                }
                else 
                {
                    editrow = rowindex;
                    var ans = confirm('Inactivate this user?');
                    if(ans)
                    {
                      var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
                      dataRecord.active = 0;
                      delete dataRecord.uid;
                      var rowID = $('#jqxgrid').jqxGrid('getrowid', editrow);
                      $('#jqxgrid').jqxGrid('updaterow', rowID, dataRecord);
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
                if (editrow >= -1) 
                {
                    var row = { 
<?php
    foreach($user_data['fields'] as $user_field)
    {
        if($user_field['edit_display'])
        {
            if($user_field['edit_field']=='date')
            {
                echo $user_field['field_name'].': $("#'.$user_field['field_name'].'_id").jqxDateTimeInput("getDate"), ';
            }
            else
            {
                echo $user_field['field_name'].': $("#'.$user_field['field_name'].'_id").val(), ';
            }
       
        }
    }
?>
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
