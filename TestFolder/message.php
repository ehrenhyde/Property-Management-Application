<?php
if(!isset($_POST['submit']))
{
	echo "You are required to Submit Form!!";
}
$Fullname = $_POST['fullname'];
$sender_email = $_POST['emailaddress'];
$message = $_POST['message'];

if(empty($Fullname)||empty($sender_email)) 
{
    echo "Both Email and Fullname Fields are mandatory!";
    exit;
}
$email_from = "lucas_nielsen1@hotmail.com";
$email_subject = "You have a new Message";
$email_body = "This is a message from user $Fullname.\n".
    "Here is the message:\n $message".
    
$signature = "From: $email_from \r\n";

mail($sender_email,$email_subject,$email_body,$signature);
   
?> 