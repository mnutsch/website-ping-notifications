<?php

//define the website that you want to check
//$URL = "http://www.mattnutsch.com/";
$URL = "http://www.fakewebsite.co/";

//check if the website is running
$homepage = file_get_contents($URL);

//send an email if the website did not answer
if($homepage === false)
{
	//Oh no! Our website is down. Send us an e-mail.
	
	//Note: you need to include the PHPMailer library. Get it here: http://phpmailer.worxware.com/0
	require_once('class.phpmailer.php');

	$to = 'mattnutsch@gmail.com';
	$from = 'mnwebsitemailer@gmail.com';
	$from_name = 'Matt Nutsch';
	$subject = 'Your Website is Down!';
	$body = 'The website at ' . $URL . ' is down! The last check was at ' . date("Y-m-d h:i:sa");

	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
	
	//Note: You also need an account with GMail, unless you have your own e-mail server.
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465;
	$mail->Username = 'youremail@gmail.com';  
	$mail->Password = 'password';      
	$mail->From = 'youremail@gmail.com';
	$mail->FromName = 'Website Monitor';    
	$mail->AddReplyTo($from, $from_name);
	$mail->Subject = $subject;
	$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
	$mail->Body = $body;
	$mail->AddAddress($to);

	if(!$mail->Send())
	{
		echo "Something went wrong and a message was not sent, but you wont see this anyway.<br/ >";
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
	else
	{
	   echo "The e-mail was sent successfully!";
	}
}
else
{
	echo "The website is running fine.";
}
?>