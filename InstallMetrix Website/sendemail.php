<?php

/************************
* Variables you can change
*************************/

$mailto   = "contact@installmetrix.com"; // Enter your mail addres here. 
$name     = ucwords($_POST['name']); 
$subject  = "iMX Website Contact Form Message from $name"; // Enter the subject here.
$email    = $_POST['email'];
$message  = $_POST['message'];
$phone  = $_POST['phone'];

	if(strlen($_POST['name']) < 1 ){
		echo  'Please correct your name.';
	}
	
  else if(strlen($email) < 1 ) {
		echo  'Invalid e-mail address. Please correct your e-mail address.';
	}

  else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", $email)) {
		echo  'Invalid e-mail address. Plaes correct your e-mail address.';
  }

	else if(strlen($message) < 1 ){
		echo  'Please write something and send, thanks.';

  } else {

	// NOW SEND THE ENQUIRY

	$email_message="\n\n" .
		"Name: " .
		ucwords($name) .
		"\n" .
		"Phone: " .
		$phone .
		"\n" .
		"Email: " .
		$email .
		"\n" .
		"Comments: " .
		"\n" .
		$message .
		"\n" .
		"\n\n" ;

		$email_message = trim(stripslashes($email_message));
		mail($mailto, $subject, $email_message, "From: \"$vname\" <".$email.">\nReply-To: \"".ucwords($name)."\" <".$email.">\nX-Mailer: PHP/" . phpversion() );
		
		echo "Your message has been sent successfully. Thank you!";
		echo '<meta http-equiv=REFRESH CONTENT=3;url=index.html>';

}
?>