<?php
 
if(isset($_POST["Submit"]))
{
require("C:\inetpub\wwwroot\PropertyManagementSystem\Property-Management-Application\TestFolder\PHPMailer_5.2.4\class.phpmailer.php");
 
$mail = new PHPMailer();

$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host       = "smtp.gmail.com";      // SMTP server example, use smtp.live.com for Hotmail
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = 465;                   // SMTP port for the GMAIL server 465 or 587
$mail->Username   = "lucas.nielsen459@gmail.com";  // SMTP account username example
$mail->Password   = "trillionaire1";  

$mail->From     = "lucas_nielsen1@hotmail.com";
$mail->AddAddress("lucas.nielsen459@gmail");  
 
$mail->Subject  = "First PHPMailer Message";
$mail->Body     = "Hi! \n\n This is my first e-mail sent through PHPMailer.";
$mail->WordWrap = 50; 
 
if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}
 
echo "Thank you, your message has been sent!";
}
 
?>
 
<html><body>
<form name="SendEmail01" method="post">
<table border=0>
<tr>
        <td>Name:</td>
        <td><input type="text" name="TName" size="30"></td>
</tr>
<tr>
        <td>Email:</td>
        <td><input type="text" name="TEmail" size="30"></td>
</tr>
<tr>
        <td>Body:</td>
        <td><textarea rows="4" name="TBody" cols="30"></textarea></td>
</tr>
<tr>
        <td><input type="submit" name="Submit" value="Submit"></td>
</tr>
</table>
</form>
</body></html>