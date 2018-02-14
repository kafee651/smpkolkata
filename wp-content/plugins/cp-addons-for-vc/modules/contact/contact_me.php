<?php
if($_POST)
{
	$to_email   	= $_POST["email_to"]; //Recipient email, Replace with own email here
	
	//check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
		
		$output = json_encode(array( //create JSON data
			'type'=>'error', 
			'text' => esc_html__('Sorry Request must be Ajax POST','theneeds')
		));
		die($output); //exit script outputting json data
    } 
	
	//Sanitize input data using PHP filter_var().
	$user_name		= filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
	$user_email		= filter_var($_POST["user_email"], FILTER_SANITIZE_EMAIL);
	$phone			= filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
	$accomodation	= filter_var($_POST["accomodation"], FILTER_SANITIZE_STRING);
	$trip_type		= filter_var($_POST["trip_type"], FILTER_SANITIZE_STRING);
	$destination	= filter_var($_POST["destination"], FILTER_SANITIZE_STRING);
	$peoplesize		= filter_var($_POST["peoplesize"], FILTER_SANITIZE_STRING);
	$comment		= filter_var($_POST["comment"], FILTER_SANITIZE_STRING);
	
	//additional php validation
	if(strlen($user_name)<4){ // If length is less than 4 it will output JSON error.
		$output = json_encode(array('type'=>'error', 'text' => 'Name is too short or empty!'));
		die($output);
	}
	if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){ //email validation
		$output = json_encode(array('type'=>'error', 'text' => 'Please enter a valid email!'));
		die($output);
	}
	if(!filter_var($phone, FILTER_VALIDATE_INT)){ //check for valid numbers in country code field
		$output = json_encode(array('type'=>'error', 'text' => 'Enter only digits in Phone'));
		die($output);
	}
	if(strlen($accomodation)<3){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Please Select Accomodation'));
		die($output);
	}
	if(strlen($trip_type)<3){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Please Select Trip Type'));
		die($output);
	}
	if(strlen($destination)<3){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Please Select Destination'));
		die($output);
	}
	if(strlen($peoplesize)<3){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Please Select Number of People'));
		die($output);
	}
	
	if(strlen($comment)<3){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Too short message! Please enter something.'));
		die($output);
	}
	
	$subject = "New Booking Form Received, Destination: ".$destination;
	
	$message_body = $message;
	$message_body .= '
		<table width="100%" border="1">
		  <tr>
			<td width="100"><strong>Name:</strong></td>
			<td>'.($user_name).'</td>
		  </tr>
		  <tr>
			<td><strong>Email:</strong></td>
			<td>'.($user_email).'</td>
		  </tr>
		  <tr>
			<td><strong>Phone:</strong></td>
			<td>'.($phone).'</td>
		  </tr>
		  <tr>
			<td><strong>Accomodation</strong></td>
			<td>'.($accomodation).'</td>
		  </tr>
		  <tr>
			<td><strong>Trip Type</strong></td>
			<td>'.($trip_type).'</td>
		  </tr>
		  <tr>
			<td><strong>Destination</strong></td>
			<td>'.($destination).'</td>
		  </tr>
		  <tr>
			<td><strong>Number Of People</strong></td>
			<td>'.($peoplesize).'</td>
		  </tr>
		  <tr>
			<td><strong>Message</strong></td>
			<td>'.($comment).'</td>
		  </tr>
		  <tr>
			<td><strong>IP Address:</strong></td>
			<td>'.($_SERVER["REMOTE_ADDR"]).'</td>
		  </tr>
		</table>
	';

	
	//email body
	//$message_body = $message."\r\n\r\n-".$user_name."\r\nEmail : ".$user_email."\r\nPhone Number : (".$phone.") ". $accomodation ;
	
	//proceed with PHP email.
	$headers = 'From: '.$user_name.'' . "\r\n" .
	'Reply-To: '.$user_email.'' . "\r\n" .
	'Content-type: text/html; charset=utf-8' . '\r\n'.
	'MIME-Version: 1.0' . '\r\n'.
	'X-Mailer: PHP/' . phpversion();
	
	
	$send_mail = mail($to_email, $subject, $message_body, $headers);
	
	if(!$send_mail)
	{
		//If mail couldn't be sent output error. Check your PHP email configuration (if it ever happens)
		$output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.'));
		die($output);
	}else{
		$output = json_encode(array('type'=>'message', 'text' => 'Hi '.$user_name .' Thank you for your email'));
		die($output);
	}
}
?>