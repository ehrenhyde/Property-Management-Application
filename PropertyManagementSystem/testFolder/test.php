<?php  
include('Mail.php');
  
$from    = "lucas.nielsen459@gmail.com";  
$to      = "lucas_nielsen1@hotmail.com";  
$subject = "Hi!";  
$body    = "Hi,\n\nHow are you?";  
  
/* SMTP server name, port, user/passwd */  
$smtpinfo["host"] = "ssl://smtp.gmail.com";  
$smtpinfo["port"] = "465";  
$smtpinfo["auth"] = true;  
$smtpinfo["username"] = "lucas.nielsen459@gmail.com";  
$smtpinfo["password"] = "trillionaire1";  
  
$headers = array ('From' => $from,'To' => $to,'Subject' => $subject);  
$smtp = &Mail::factory('smtp', $smtpinfo );  
  
$mail = $smtp->send($to, $headers, $body);  
  
if (PEAR::isError($mail)) {  
  echo("<p>" . $mail->getMessage() . "</p>");  
 } else {  
  echo("<p>Message successfully sent!</p>");  
 }  
?>  