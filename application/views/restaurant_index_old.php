<?php $this->load->view('template/header_nav'); ?>

<script>

function toggle_hours()
{
	if($('#editHoursButton').text()=='Edit Hours')
	{
		$('#hoursEditor').show();
		$('#hoursText').hide();
		$('#editHoursButton').text('Save Info');
	}
	else
	{
		var hoursText = $('#hoursEditor').val();
		hoursText = hoursText.replace(/\n/g,"<br>");
		$('#hoursText').html(hoursText);
		$('#hoursEditor').hide();
		$('#hoursText').show();
		$('#editHoursButton').text('Edit Info');
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
		
	}
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
		<div class="col-xs-12 col-sm-6" style="max-width: 415px;">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="icon-time"></i></span><h5>Restaurant Information</h5></div>
				<div class="widget-content nopadding" style="text-align: center; margin-top: 20px; margin-bottom: 5px; margin-right: 10px;">
					<textarea id="hoursEditor" name="hoursEditor" rows="8" style="width: 360px; display: none; margin-bottom: 20px;"><?php echo str_replace("<br>","\n",$main_user->hours_text); ?></textarea>
					<div id="hoursText">
					<?php echo $main_user->hours_text; ?>
					</div>
					<div style="text-align: right;"><a id="editHoursButton" onclick="return toggle_hours();" class="btn btn-default btn-small" href="#">Edit Info</a></div>
				</div>
			</div>
		</div>
		<!--
		<div class="col-xs-12 col-sm-6" style="max-width: 415px;">
			<div class="widget-box">
				<div class="widget-title"><span class="icon"><i class="icon-list"></i></span><h5>Menu</h5></div>
				<div class="widget-content nopadding" style="text-align: left; margin-top: 20px; margin-bottom: 5px; margin-right: 10px; margin-left: 20px;">
					<?php
						$currCategory = "";
						foreach($menu_items as $item)
						{
							if($item['item_category'] != $currCategory)
							{
								echo "<h4>".$item['item_category'],"</h4>\n";
								$currCategory = $item['item_category'];
							}
							echo "<div><strong>". $item['item_name'] . "</strong>";
							if($item['item_price'])
							{
								echo " $".$item['item_price']."<br />\n";
							}
							else
							{
								echo "<br />\n";
							}
							if($item['item_description'])
							{
								echo $item['item_description']."</div>\n";
							}
							else
							{
								echo "</div>\n";
							}
								
						}
					?>
					<div style="text-align: right;"><?php echo anchor('restaurant','Edit Menu',array('class'=>'btn btn-default btn-small')); ?></div>
				</div>
			</div>
		</div>
		-->
	</div>
	<div class="row">
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
				<div class="modal-dialog" style="">
					<div class="modal-content">
						<div class="modal-header">
							<button data-dismiss="modal" class="close" type="button">×</button>
							<h3>Menu Item</h3>
						</div>
						<div class="modal-body">
							<form class="form-horizontal">
								  <div class="control-group">
								    <label class="control-label" for="itemName">Name</label>
								    <div class="controls">
								      <input type="text" id="itemName">
								    </div>
								  </div>
								  <div class="control-group">
								    <label class="control-label" for="itemDescription">Description</label>
								    <div class="controls">
								      <textarea id="itemDescription" rows="5" cols="50"></textarea>
								      
								    </div>
								  </div>
								  <div class="control-group">
								    <label class="control-label" for="itemPrice">Price</label>
								    <div class="controls">
								      <input type="text" id="itemPrice">
								    </div>
								  </div>
								  <div class="control-group">
								    <label class="control-label" for="itemCategory">Category</label>
								    <div class="controls">
								      <input type="text" id="itemCategory">
								    </div>
								  </div>
							</form>
						</div>
						<div class="modal-footer">
							<a data-dismiss="modal" id="Save" class="btn btn-primary btn-small" href="#">Save</a>
							<a data-dismiss="modal" id="Cancel" class="btn btn-default btn-small" href="#">Cancel</a>
						</div>
					</div>
				</div>
			</div>

			<div id="test1"></div>
		</div>
	</div>
</div>


     <script type="text/javascript">
        $(document).ready(function () {
			//$(window).resize(function(){
				//alert($(window).width());
			//});
			var newHeight = $(window).height()-450;
			if(newHeight < 250)
				newHeight = 250; 
			$("#jqxWidgetWrapper").height(newHeight);
            var theme = "arctic";
            //var data = generatedata(2500);

            var source =
            {
                //localdata: data,
                datafields:
                [
                  { name: 'menu_item_id', type: 'int' },
                  { name: 'item_name', type: 'string' },
                  { name: 'item_description', type: 'string' },
                  { name: 'item_category', type: 'string' },
                  { name: 'item_price', type: 'string' },
                ],
                datatype: "json",
//                url: '/rmm/index.php/contacts/load_contacts',
                localdata: <?php echo json_encode($menu_items); ?>,
                cache: false,
                id: 'menu_item_id',
//                root: 'data',
                //record: 'content',
                deleterow: function (rowid, commit) {
                    // synchronize with the server - send delete command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failed.
					$.ajax({
						url: "<?php echo site_url('restaurant/delete_menu_item'); ?>/"+rowid,
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
						url: "<?php echo site_url('restaurant/update_menu_item'); ?>/"+rowid,
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
                    var serializedData = $.param(rowdata);
                    //alert(serializedData);
					$.ajax({
						url: "<?php echo site_url('restaurant/update_menu_item'); ?>",
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
                width: 750, //$("#jqxWidgetWrapper").width()-50,
                height: $("#jqxWidgetWrapper").height()-30,
                source: adapter,
                theme: theme,
                columnsresize: true,
//                scrollmode: 'deferred',
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
                  { text: 'Category', datafield: 'item_category', width: 110 },
                  { text: 'Name', datafield: 'item_name', width: 160 },
                  { text: 'Description', datafield: 'item_description', width: 250 },
                  { text: 'Price', datafield: 'item_price', width: 100 },
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
	                    editrow = -1;
	                    $("#itemName").val(null);
	                    $("#itemDescription").val(null);
	                    $("#itemPrice").val(null);
	                    $("#itemCategory").val(null);
	                     // show the popup window.
	                    $("#popupWindow").modal('show');
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
                    $("#itemName").val(dataRecord.item_name);
                    $("#itemDescription").val(dataRecord.item_description);
                    $("#itemPrice").val(dataRecord.item_price);
                    $("#itemCategory").val(dataRecord.item_category);
                     // show the popup window.
                    $("#popupWindow").modal('show');
                    // show the popup window.
                    //$("#popupWindow").jqxWindow('show');
                }
                else 
                {
                    var rowid = $("#jqxgrid").jqxGrid('getrowid', rowindex);
                    $("#jqxgrid").jqxGrid('deleterow', rowid);
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
            $("#Save").click(function () {
                if (editrow >= -1) 
                {
                    var row = { 
                    	item_name: $("#itemName").val(), 
                    	item_description: $("#itemDescription").val(), 
                    	item_price: $("#itemPrice").val(),
                        item_category: $("#itemCategory").val(),
                    };
	                if (editrow == -1)
	                {
	                    $('#jqxgrid').jqxGrid('addrow', null, row);
	                }
	                else
	                {
	                    var rowID = $('#jqxgrid').jqxGrid('getrowid', editrow);
	                    $('#jqxgrid').jqxGrid('updaterow', rowID, row);
	                } 
                    $("#popupWindow").modal('hide');
                }
            });            
        });
    </script>


<?php $this->load->view('template/footer_nav'); ?>
