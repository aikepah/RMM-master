<?php
function Send_Mail($to,$subject,$body)
{
require 'class.phpmailer.php';
$from = "troy@restaurantmoneymachine.com";
$mail = new PHPMailer();
$mail->IsSMTP(true); // SMTP
$mail->SMTPAuth   = true;  // SMTP authentication
$mail->Mailer = "smtp";
$mail->Host       = "tls://email-smtp.us-east-1.amazonaws.com"; // Amazon SES server, note "tls://" protocol
$mail->Port       = 465;                    // set the SMTP port
$mail->Username   = "AKIAJ7XVO2WQ7J54LB3Q";  // SES SMTP  username
$mail->Password   = "AhRxjgeD+7L+C1AFQyeH+97O3K1R4Fd4Z0l/7TxGAUSX";  // SES SMTP password
$mail->SetFrom($from, 'RMM');
$mail->AddReplyTo($from,'RMM');
$mail->Subject = $subject;
$mail->MsgHTML($body);
$address = $to;
$mail->AddAddress($address, $to);

if(!$mail->Send())
return false;
else
return true;

}
?>