<script>
    function view_preview(idPrefix)
    {
        var templateId = $('#' + idPrefix + 'Template').val();
        if (!templateId)
        {
            alert('You must select an email template to view the preview.');
            return false;
        }
        var emailData = CKEDITOR.instances[idPrefix + 'Body'].getData();
        var serializedData = 'email_body=' + escape(emailData);
        $.ajax({
            url: '<?php echo site_url('dashboard/email_preview'); ?>/' + templateId,
            type: "post",
            data: serializedData,
            // callback handler that will be called on success
            success: function(response, textStatus, jqXHR)
            {
                $('#previewWindowContentIframe').contents().find('body').html(response);
                //$('#previewWindowContentIframe').document.write(response);
                //$('#previewWindowContentIframe').document.close();

                $('#previewWindow').jqxWindow('open');
                //var win=window.open('about:blank');
                //with(win.document)
                //{
                //  open();
                //  write(response);
                // close();
                //}
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

<div id="previewWindow">
    <div id="previewWindowHeader">
        <span>
            &nbsp;
        </span>
    </div>
    <div style="overflow: hidden;" id="previewWindowContent">
        <iframe id='previewWindowContentIframe' frameborder=0 style='width: 100%; height: 100%; border: 0px;'></iframe>  
    </div>
</div> 

<div id="ftModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Facebook/Twitter Post</h3>
            </div>
            <div class="modal-body">
                <textarea maxlength="140" id="ftInput" name="ftInput" rows="3" style="width: 360px;"></textarea>
                <div id="ftCharCount">140 characters remaining</div>
                <input type="file" id="ftImage" name="ftImage"/>
                <div id='ftScheduleGroup' style="margin-bottom: 20px;">
                    <button style="padding:4px 16px;" id="ft-send-now">
                        Post Now</button>
                    <button style="padding:4px 16px;" id="ft-send-later">
                        Schedule for Later</button>
                </div>
                <div id="ftCalendar"></div>
                <div>
                    <select id="ftCalendarTime" style="margin-top: 10px;">
                        <option value='9'>9:00am</option>
                        <option value='10'>10:00am</option>
                        <option value='11'>11:00am</option>
                        <option value='12'>12:00pm</option>
                        <option value='13'>1:00pm</option>
                        <option value='14'>2:00pm</option>
                        <option value='15'>3:00pm</option>
                        <option value='16'>4:00pm</option>
                        <option value='17'>5:00pm</option>
                        <option value='18'>6:00pm</option>
                        <option value='19'>7:00pm</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <div style="float: left; width: 340px;"><strong>Scheduled For:</strong> <span id="ftSendDate"></span></div>
                <a id="ftSave" class="btn btn-primary btn-small" href="#">Post</a>
                <a data-dismiss="modal" class="btn btn-default btn-small" href="#">Cancel</a>
            </div>
        </div>
    </div>
</div>

<div id="tmModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Send Text Message</h3>
            </div>
            <div class="modal-body">
                <textarea type="text" id="tmInput" name="tmInput" rows="3" maxlength="<?php echo (144 - strlen($main_user->text_name)); ?>" style="width: 360px;"></textarea>
                <div id="tmCharCount"><?php echo (144 - strlen($main_user->text_name)); ?> characters remaining</div>
                <div id="tmExample" style="margin-top: 10px;"><strong>Example:</strong></div>
                <div>
                    Send to: <select id="tmContactGroup" style="margin-top: 15px;">
                        <option value='0'>Everyone</option>
                        <?php
                        if (isset($contact_groups) && count($contact_groups) >= 1) {
                            foreach ($contact_groups as $contact_group) {
                                echo "<option value='" . $contact_group['contact_group_id'] . "'>" . $contact_group['group_name'] . "</option>";
                            }
                        }
                        ?>                        
                    </select>
                </div>
                <div style="margin-top: 15px;" id="tmGroup1">
                    <input type="radio" name="tmRecipients" value="0">Send to everyone at once</br>
                    <input type="radio" name="tmRecipients" value="7">Send to everyone spread over 1 week<br />
                    <input type="radio" name="tmRecipients" style="margin-bottom: 15px;" value="14">Send to everyone spread over 2 weeks
                </div>
                <div id='tmScheduleGroup' style="margin-bottom: 20px;">
                    <button style="padding:4px 16px;" id="send-now">
                        Send Now</button>
                    <button style="padding:4px 16px;" id="send-later">
                        Schedule for Later</button>
                </div>
                <div id="tmCalendar"></div>
                <div>
                    <select id="tmCalendarTime" style="margin-top: 10px;">
                        <option value='9'>9:00am</option>
                        <option value='10'>10:00am</option>
                        <option value='11'>11:00am</option>
                        <option value='12'>12:00pm</option>
                        <option value='13'>1:00pm</option>
                        <option value='14'>2:00pm</option>
                        <option value='15'>3:00pm</option>
                        <option value='16'>4:00pm</option>
                        <option value='17'>5:00pm</option>
                        <option value='18'>6:00pm</option>
                        <option value='19'>7:00pm</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <div style="float: left; width: 340px;"><strong>Scheduled For:</strong> <span id="tmSendDate"></span></div>
                <a id="tmSave" class="btn btn-primary btn-small" href="#">Send</a>
                <a data-dismiss="modal" class="btn btn-default btn-small" href="#">Cancel</a>
            </div>
        </div>
    </div>
</div>

<div id="emailModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Send Email</h3>
            </div>
            <div class="modal-body">
                <div>Email Template</div>
                <div id="emailTemplate"></div>
                <div>Email Subject</div>
                <input type="text" id="emailSubject" name="emailSubject" style="width: 360px;">
                <div>Email Body</div>
                <textarea id="emailBody" name="emailBody" rows="5" style="width: 360px;"></textarea>
                <div><a href='javascript:void(0);' onclick='return view_preview("email");'>View Preview</a></div>
                <div>
                    Send to: <select id="emailContactGroup" style="margin-top: 15px;">
                        <option value='0'>Everyone</option>
<?php
if (isset($contact_groups) && count($contact_groups) >= 1) {
    foreach ($contact_groups as $contact_group) {
        echo "<option value='" . $contact_group['contact_group_id'] . "'>" . $contact_group['group_name'] . "</option>";
    }
}
?>                        
                    </select>
                </div>
                <div style="margin-top: 15px;" id="emailGroup1">
                    <input type="radio" name="emailRecipients" value="0">Send to everyone at once</br>
                    <input type="radio" name="emailRecipients" value="7">Send to everyone spread over 1 week<br />
                    <input type="radio" name="emailRecipients" style="margin-bottom: 15px;" value="14">Send to everyone spread over 2 weeks
                </div>
                <div id='emailScheduleGroup' style="margin-bottom: 20px;">
                    <button style="padding:4px 16px;" id="send-now">
                        Send Now</button>
                    <button style="padding:4px 16px;" id="send-later">
                        Schedule for Later</button>
                </div>
                <div id="emailCalendar"></div>
                <div>
                    <select id="emailCalendarTime" style="margin-top: 10px;">
                        <option value='9'>9:00am</option>
                        <option value='10'>10:00am</option>
                        <option value='11'>11:00am</option>
                        <option value='12'>12:00pm</option>
                        <option value='13'>1:00pm</option>
                        <option value='14'>2:00pm</option>
                        <option value='15'>3:00pm</option>
                        <option value='16'>4:00pm</option>
                        <option value='17'>5:00pm</option>
                        <option value='18'>6:00pm</option>
                        <option value='19'>7:00pm</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <div style="float: left; width: 340px;"><strong>Scheduled For:</strong> <span id="emailSendDate"></span></div>
                <a id="emailSave" class="btn btn-primary btn-small" href="#">Send</a>
                <a data-dismiss="modal" class="btn btn-default btn-small" href="#">Cancel</a>
            </div>
        </div>
    </div>
</div>

<div id="postcardModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Send Postcard</h3>
            </div>
            <div class="modal-body">
                <div>Postcard preview</div>
                <div id='postcardScheduleGroup' style="margin-bottom: 20px;">
                    <button style="padding:4px 16px;" id="send-now">
                        Send Now</button>
                    <button style="padding:4px 16px;" id="send-later">
                        Schedule for Later</button>
                </div>
                <div id="postcardCalendar"></div>
                <div id="postcardCalendarTime" style="margin-top: 10px;">
                    <select>
                        <option value='9'>9:00am</option>
                        <option value='10'>10:00am</option>
                        <option value='11'>11:00am</option>
                        <option value='12'>12:00pm</option>
                        <option value='13'>1:00pm</option>
                        <option value='14'>2:00pm</option>
                        <option value='15'>3:00pm</option>
                        <option value='16'>4:00pm</option>
                        <option value='17'>5:00pm</option>
                        <option value='18'>6:00pm</option>
                        <option value='19'>7:00pm</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <div style="float: left; width: 340px;"><strong>Scheduled For:</strong> <span id="postcardSendDate"></span></div>
                <a id="postcardSave" class="btn btn-primary btn-small" href="#">Mail</a>
                <a data-dismiss="modal" class="btn btn-default btn-small" href="#">Cancel</a>
            </div>
        </div>
    </div>
</div>

<script>

    var dayList = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var monthList = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var message_id = null;
    var theme = 'arctic';

    function setup_date_selector(idPrefix)
    {
        var theme = 'arctic';
        $('#' + idPrefix + 'ScheduleGroup').jqxButtonGroup({theme: theme, mode: 'radio'});
        $('#' + idPrefix + 'ScheduleGroup').on('selected', function() {
            var schGroup = $('#' + idPrefix + 'ScheduleGroup').jqxButtonGroup('getSelection');
            if (schGroup == 1)
            {
                $('#' + idPrefix + 'CalendarTime').show();
                $('#' + idPrefix + 'Calendar').show();
                var date = $('#' + idPrefix + 'Calendar').jqxCalendar('getDate');
                var dateStr = dayList[date.getDay()] + ', ' + monthList[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear();
                $('#' + idPrefix + 'SendDate').text(dateStr);
            }
            else
            {
                $('#' + idPrefix + 'CalendarTime').hide();
                $('#' + idPrefix + 'Calendar').hide();
                $('#' + idPrefix + 'SendDate').text('Today');
            }

        });

        $('#' + idPrefix + 'CalendarTime').hide();

        $('#' + idPrefix + 'Calendar').jqxCalendar({width: 180, height: 180, theme: theme, min: new Date(new Date().setDate(new Date().getDate() - 1))});
        $('#' + idPrefix + 'Calendar').hide();
        $('#' + idPrefix + 'Calendar').on('change viewChange', function(event) {
            var date = event.args.date;
            var view = event.args.view;
            var viewFrom = view.from;
            var viewTo = view.to;

            var dateStr = dayList[date.getDay()] + ', ' + monthList[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear();
            $('#' + idPrefix + 'SendDate').text(dateStr);
        });

    }

    var emailTemplates = [<?php
                        foreach ($email_templates as $template) {
                            echo '{';
                            $arr = array();
                            foreach ($template as $key => $val) {
                                echo $key . ': "' . $val . '", ';
                            }
                            //echo implode(',',$arr);
                            echo '},';
                        }
?>];

    function setup_email_form(idPrefix)
    {
        var theme = 'arctic';
        $('#' + idPrefix + 'Template').jqxDropDownList({selectedIndex: -1, theme: theme, source: emailTemplates, displayMember: "template_name", valueMember: "email_template_id", height: 25, width: 300,
            renderer: function(index, label, value) {
                if (index == -1)
                    return label;
                var datarecord = emailTemplates[index];
                var imgurl = '<?php echo base_url('public/img/email_template'); ?>/' + value + '.png';
                var img = '<img height="50" width="120" src="' + imgurl + '"/>';
                var table = '<table style="min-width: 225px;"><tr><td style="width: 130px;" rowspan="2">' + img + '</td><td>' + datarecord['template_name'] + '</td></tr><tr><td></td></tr></table>';
                return table;
            }
        });

        CKEDITOR.replace(idPrefix + 'Body');
        // workaround to fix bug in ckeditor so it is editable in all browsers
        setTimeout(function() {
            CKEDITOR.instances[idPrefix + 'Body'].setReadOnly(false);
            CKEDITOR.instances[idPrefix + 'Body'].setMode('source');
            CKEDITOR.instances[idPrefix + 'Body'].setMode('wysiwyg');
        }, 500);
        setTimeout(function() {
            CKEDITOR.instances[idPrefix + 'Body'].setReadOnly(false);
            CKEDITOR.instances[idPrefix + 'Body'].setMode('source');
            CKEDITOR.instances[idPrefix + 'Body'].setMode('wysiwyg');
        }, 3000);
    }

    $(document).ready(function() {

        var theme = 'arctic';

        $('#previewWindow').jqxWindow({
            showCollapseButton: false, theme: theme, autoOpen: false, maxHeight: 2000, maxWidth: 2000, minHeight: 200, minWidth: 200, height: 600, width: 800,
            initContent: function() {
                $('#previewWindow').jqxWindow('focus');
            }
        });
        //$('#previewWindow').jqxWindow('close');

        setup_date_selector('tm');
        setup_date_selector('ft');
        setup_date_selector('email');
        //setup_date_selector('postcard');

        setup_email_form('email');

        $('#ftInput').keyup(function(e) {
            var count = 140 - $('#ftInput').val().length;
            if (count == 1)
            {
                $('#ftCharCount').text("1 character remaining");
            }
            else
            {
                $('#ftCharCount').text(count + " characters remaining");
            }
        });
        $('#tmInput').keyup(function(e) {
            var text_name = "<?php echo $main_user->text_name; ?>";
            var count = 144;
            count -= text_name.length;
            var count = count - $('#tmInput').val().length;
            if (count == 1)
            {
                $('#tmCharCount').text("1 character remaining");
            }
            else
            {
                $('#tmCharCount').text(count + " characters remaining");
            }
            $('#tmExample').html('<strong>Example:</strong> Firstname, ' + $('#tmInput').val() + " -" + text_name);
        });

        $("#ftSave").click(function() {
            var ftPost = $('#ftInput').val();
            var ftImage = $('#ftImage').val();
            if (!ftPost)
            {
                alert("You must enter a message to post");
                return false;
            }
            var ftSched = $('#ftScheduleGroup').jqxButtonGroup('getSelection');
            if (ftSched != 0 && ftSched != 1)
            {
                alert("Select when to post your message");
                return false;
            }
            var ftPostClean = escape(ftPost);
            var serializedData = 'message_type_id=1&twitter_post=' + escape(ftPost) + '&facebook_post=' + escape(ftPost) + '&message_name=' + escape(ftPost);
            if (ftSched == 1)
            {
                var ftDate = $('#ftCalendar').jqxCalendar('getDate');
                ftDate.setHours($('#ftCalendarTime').val());
                var saveDate = ftDate.getFullYear() + '-' + (ftDate.getMonth() + 1) + '-' + ftDate.getDate() + ' ' + ftDate.getHours() + ':00:00';
                serializedData += '&scheduled_date=' + saveDate;
            }
            else
            {
                var saveDate = '';
            }
            if (message_id)
            {
                var row = {
                    message_type_id: '1',
                    message_type_name: 'Facebook/Twitter Post',
                    facebook_post: ftPost,
                    twitter_post: ftPost,
                    message_name: ftPost,
                    scheduled_date: ftDate,
                };
                $('#jqxgrid').jqxGrid('updaterow', message_id, row);
            }
            else
            {

                if (ftImage) {

                    /*
                     prepareing ajax file upload
                     url: the url of script file handling the uploaded files
                     fileElementId: the file type of input element id and it will be the index of  $_FILES Array()
                     dataType: it support json, xml
                     secureuri:use secure protocol
                     success: call back function when the ajax complete
                     error: callback function when the ajax failed
                     
                     */
                    $.ajaxFileUpload({
                        url: '<?php echo site_url('messages/upload_image'); ?>',
                        secureuri: false,
                        fileElementId: 'ftImage',
                        dataType: 'json',
                        data: {message_type_id: '1', twitter_post: ftPost, facebook_post: ftPost, message_name: ftPost, scheduled_date: saveDate},
                        success: function(response, data, status)
                        {
                            if (typeof(data.error) != 'undefined')
                            {
                                if (data.error != '')
                                {
                                    alert(data.error);
                                    return false;
                                } else
                                {
                                }
                            }
                            if (ftSched == 0)
                            {
                                $.ajax({
                                    url: '<?php echo site_url('message_manager/ajax_send_message'); ?>/' + response,
                                });
                            }
                            $('#messageSpan').html('Facebook/Twitter Post Scheduled');
                            $('#messageDiv').show();
                        },
                        error: function(data, status, e)
                        {
                            alert(e);
                            return false;
                        }
                    });
                } else {
                    $.ajax({
                        url: '<?php echo site_url('messages/save_message'); ?>' + (message_id ? '/' + message_id : ''),
                        type: "post",
                        data: serializedData,
                        // callback handler that will be called on success
                        success: function(response, textStatus, jqXHR)
                        {
                            if (response.indexOf('DCLICK') != -1)
                            {
                            }
                            else if (response.indexOf('ERROR:') != -1)
                            {
                                alert(response);
                            }
                            else
                            {
                                $('#ftInput').val(null);
                                if (ftSched == 0)
                                {
                                    $.ajax({
                                        url: '<?php echo site_url('message_manager/ajax_send_message'); ?>/' + response,
                                    });
                                }
                                $('#messageSpan').html('Facebook/Twitter Post Scheduled');
                                $('#messageDiv').show();
                                //alert('saved');
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
                }
            }
            $("#ftModal").modal('hide');
            message_id = null;
            return false;
        });
        $("#tmSave").click(function() {
            var tmPost = $('#tmInput').val();
            if (!tmPost)
            {
                alert("You must enter a message to send");
                return false;
            }
            var tmRecipients = $('input:radio[name=tmRecipients]:checked').val();
            if (tmRecipients == null)
            {
                alert("You must select the timeframe to send your message over.");
                return false;
            }
            var tmSched = $('#tmScheduleGroup').jqxButtonGroup('getSelection');
            if (tmSched != 0 && tmSched != 1)
            {
                alert("Select when to send your message");
                return false;
            }
            var serializedData = 'message_type_id=2&send_timeframe=' + tmRecipients + '&text_message=' + escape(tmPost) + '&message_name=' + escape(tmPost);
            if (tmSched == 1)
            {
                var tmDate = $('#tmCalendar').jqxCalendar('getDate');
                tmDate.setHours($('#tmCalendarTime').val());
                var saveDate = tmDate.getFullYear() + '-' + (tmDate.getMonth() + 1) + '-' + tmDate.getDate() + ' ' + tmDate.getHours() + ':00:00';
                serializedData += '&scheduled_date=' + saveDate;
            }
            else
            {
                var tmDate = '';
            }
            if ($('#tmContactGroup').length)
            {
                var tmContactGroup = $('#tmContactGroup').val();
                if (tmContactGroup)
                {
                    serializedData += '&contact_group_id=' + tmContactGroup;
                }
            }
            if (message_id)
            {
                var row = {
                    message_type_id: '2',
                    message_type_name: 'Text Message',
                    send_timeframe: tmRecipients,
                    text_message: tmPost,
                    message_name: tmPost,
                    scheduled_date: tmDate,
                };
                $('#jqxgrid').jqxGrid('updaterow', message_id, row);
            }
            else
            {
                $.ajax({
                    url: '<?php echo site_url('messages/save_message'); ?>' + (message_id ? '/' + message_id : ''),
                    type: "post",
                    data: serializedData,
                    // callback handler that will be called on success
                    success: function(response, textStatus, jqXHR)
                    {
                        if (response.indexOf('DCLICK') != -1)
                        {
                        }
                        else if (response.indexOf('ERROR:') != -1)
                        {
                            alert(response);
                        }
                        else
                        {
                            $('#tmInput').val(null);
                            if (tmSched == 0)
                            {
                                var d = new Date();
                                if (d.getHours() > 8 && d.getHours() < 19)
                                {
                                    $.ajax({
                                        url: '<?php echo site_url('message_manager/ajax_send_message'); ?>/' + response,
                                    });
                                }
                            }
                            $('#messageSpan').html('Text Message Scheduled');
                            $('#messageDiv').show();
                            //alert('saved');
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
            }
            $("#tmModal").modal('hide');
            message_id = null;
            return false;
        });
        $("#emailSave").click(function() {

            var emailTemplate = $("#emailTemplate").jqxDropDownList('getSelectedItem');
            if (!emailTemplate)
            {
                alert("You must select an email template");
                return false;
            }
            var emailSubject = $('#emailSubject').val();
            if (!emailSubject)
            {
                alert("You must enter an email subject");
                return false;
            }
            var emailBody = CKEDITOR.instances['emailBody'].getData();
            if (!emailBody)
            {
                alert("You must enter an email body");
                return false;
            }
            var emailRecipients = $('input:radio[name=emailRecipients]:checked').val();
            if (emailRecipients == null)
            {
                alert("You must select the timeframe to send your email over.");
                return false;
            }
            var emailSched = $('#emailScheduleGroup').jqxButtonGroup('getSelection');
            if (emailSched != 0 && emailSched != 1)
            {
                alert("Select when to send your email");
                return false;
            }
            var serializedData = 'message_type_id=3&email_template_id=' + emailTemplate.value + '&send_timeframe=' + emailRecipients + '&email_subject=' + escape(emailSubject) + '&message_name=' + escape(emailSubject) + '&email_body_html=' + escape(emailBody);
            if (emailSched == 1)
            {
                var emailDate = $('#emailCalendar').jqxCalendar('getDate');
                emailDate.setHours($('#emailCalendarTime').val());
                var saveDate = emailDate.getFullYear() + '-' + (emailDate.getMonth() + 1) + '-' + emailDate.getDate() + ' ' + emailDate.getHours() + ':00:00';
                serializedData += '&scheduled_date=' + saveDate;
            }
            else
            {
                var emailDate = null;
            }
            if ($('#emailContactGroup').length)
            {
                var emailContactGroup = $('#emailContactGroup').val();
                if (emailContactGroup)
                {
                    serializedData += '&contact_group_id=' + emailContactGroup;
                }
            }
            if (message_id)
            {
                var row = {
                    message_type_id: '3',
                    message_type_name: 'Email',
                    email_template_id: emailTemplate.value,
                    send_timeframe: emailRecipients,
                    email_subject: emailSubject,
                    message_name: emailSubject,
                    email_body_html: emailBody,
                    scheduled_date: emailDate,
                };
                $('#jqxgrid').jqxGrid('updaterow', message_id, row);
            }
            else
            {
                $.ajax({
                    url: '<?php echo site_url('messages/save_message'); ?>' + (message_id ? '/' + message_id : ''),
                    type: "post",
                    data: serializedData,
                    // callback handler that will be called on success
                    success: function(response, textStatus, jqXHR)
                    {
                        if (response.indexOf('DCLICK') != -1)
                        {
                        }
                        else if (response.indexOf('ERROR:') != -1)
                        {
                            alert(response);
                        }
                        else
                        {
                            $('#emailSubject').val(null);
                            CKEDITOR.instances['emailBody'].setData(null);
                            if (emailSched == 0)
                            {
                                $.ajax({
                                    url: '<?php echo site_url('message_manager/ajax_send_message'); ?>/' + response,
                                });
                            }

                            $('#messageSpan').html('Email Scheduled');
                            $('#messageDiv').show();
                            //alert('saved');
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
            }
            $("#emailModal").modal('hide');
            message_id = null;
            return false;
        });
        $("#postcardSave").click(function() {
            $("#postcardModal").modal('hide');
            message_id = null;
            return false;
        });


    });
</script>


