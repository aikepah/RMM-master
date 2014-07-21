<?php

require_once('ses.php');

$ses = new SimpleEmailService('AKIAJJDGPOVWJXW4FEHA', 'srEHdt/kEh3ApNRhKoCLyaV7EOC6gBkL0L8wNrDO');

$m = new SimpleEmailServiceMessage();
$m->addTo('troy@restaurantmoneymachine.com');
$m->setFrom('RMM <troy@restaurantmoneymachine.com>');
$m->setSubject('SES Test Email');
$m->setMessageFromString('Test message');
$ses->sendEmail($m);


echo 'done2';

//require 'Send_Mail.php';
//$to = "troy@restaurantmoneymachine.com";
//$subject = "Test Mail Subject";
//$body = "Hi<br/>Test Mail<br/>Amazon SES"; // HTML  tags
//Send_Mail($to,$subject,$body);
//echo 'done1';
?>