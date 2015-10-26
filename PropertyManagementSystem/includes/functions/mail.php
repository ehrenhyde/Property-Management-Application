<?php 

function mail_super_switch($email,$message,$firstName,$subject){
	
	$mailer = new PHPMailer();  
	
	$mailer->IsSMTP();   
	$mailer->IsHTML(); 
	$mailer->SMTPAuth = true;       
	$mailer->SMTPDebug = 2;  
	$mailer->SMTPSecure = "ssl";       
	$mailer->Host = "smtp.gmail.com";  
	$mailer->Port = 465;  

	$mailer->Username   = "lucas.nielsen459@gmail.com"; 
	$mailer->Password   = "F22Raptor"; 
	  

	$mailer->From='lucas.nielsen459@gmail.com';
	$mailer->FromName='SMELT Management';
	$mailer->AddReplyTo("lucas.nielsen459@gmail.com",null);
		
	$mailer->Subject = $subject;        
	$mailer->MsgHTML($message);
 
   
	$mailer->AddAddress($email,$firstName); 
	if($mailer->Send()){
		echo 'Your Confirmation has been sent!';
		
	}else {
		echo'Email Not sent! Please Try again';
		
	}	// Send! 
}

function mail_send_registration_code($confirmCode,$email,$fullName,$firstName,$isOwner){
	
	// Your message
	$message="Hi ". $firstName." <p>\n";
	$message.="<br>Welcome to the Property Management Application (SMELT) Community <br>\n";
	$message.="<br>To Activate your Account, Click on the link below: <br>\n";
	$message.="http://52.26.240.26/confirmation.php?confirmCode=$confirmCode&owner=$isOwner<br>";
	$message.="<br>From the SMELT Management Team";
	
	$subject = "Account Registration for SMELT";
	
	
	
	mail_super_switch($email,$message,$firstName,$subject);
		 			
}

function mail_acknowledge_password_reset($email,$firstName,$lastName)
{	
	// Your message
	$message="Hi ". $firstName." <p>\n";
	$message.="<br>Your password has been changed.<br>\n";
	$message.="<br>If this was not expected you have a problem...<br>\n";
	$message.="<br>From the SMELT Management Team";

	$subject = "SMELT Password Reset";   
	
	
	//doesn't work don't know why
	mail_super_switch($email,$message,$firstName,$subject);
	
}

?>