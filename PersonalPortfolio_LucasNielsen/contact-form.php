<?php
if(isset($_POST['submit'])) 
{

$message=
'Full Name:	'.$_POST['fullname'].'<br />
Subject:	'.$_POST['subject'].'<br />
Phone:	'.$_POST['phone'].'<br />
Email:	'.$_POST['emailid'].'<br />
Comments:	'.$_POST['comments'].'
';
    require "phpmailer/class.phpmailer.php"; 
      
     
    $mail = new PHPMailer();  
      
     
    $mail->IsSMTP();                  
    $mail->SMTPAuth = true;            
    $mail->SMTPSecure = "ssl";       
    $mail->Host = "smtp.gmail.com";  
    $mail->Port = 465;  
  
    
    
    $mail->Username   = "lucas.nielsen459@gmail.com"; 
    $mail->Password   = ""; 
      
   
    $mail->SetFrom($_POST['emailid'], $_POST['fullname']);
    $mail->AddReplyTo($_POST['emailid'], $_POST['fullname']);
    $mail->Subject = "Enquiry Form";        
    $mail->MsgHTML($message);
 
   
    $mail->AddAddress("lucas.nielsen459@gmail.com", "Lucas Nielsen"); 
    $result = $mail->Send();		// Send!  
	    
	unset($mail);

}
?>
<html>
<head>
  <title>Contact Form</title>
</head>
<body>
					
		<div style="margin: 100px auto 0;width: 300px;">
			<h3>Contact Form</h3>
			<form name="form1" id="form1" action="" method="post">
					<fieldset>
					  <input type="text" name="fullname" placeholder="Full Name" />
					  <br />
					  <input type="text" name="subject" placeholder="Subject" />
					  <br />
					  <input type="text" name="phone" placeholder="Phone" />
					  <br />
					  <input type="text" name="emailid" placeholder="Email" />
					  <br />
					  <textarea rows="4" cols="20" name="comments" placeholder="Comments"></textarea>
					  <br />
					  <input type="submit" name="submit" value="Send" />
					</fieldset>
			</form>
			<p><?php if(!empty($message)) echo $message; ?></p>
		</div>
					
</body>
</html>