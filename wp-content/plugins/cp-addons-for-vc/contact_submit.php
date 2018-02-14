<?php /************* Contact Form 1 (Working) *****************/

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'consulation_submit_form'){
	
	$name = $_REQUEST['name'];
	$sender_name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$subject = $_REQUEST['subject'];
	$message = $_REQUEST['message'];
	$email_cc_admin = $_REQUEST['email_to'];
	$to = $email_cc_admin;
	
	
	$formatted_message = '
			<table width="100%" border="1">
			  <tr>
				<td width="100"><strong>Name:</strong></td>
				<td>'.esc_attr($sender_name).'</td>
			  </tr>
			  <tr>
				<td><strong>Email:</strong></td>
				<td>'.esc_attr($email).'</td>
			  </tr>
			   <tr>
				<td><strong>Subject:</strong></td>
				<td>'.esc_attr($subject).'</td>
			  </tr>
			  <tr>
				<td><strong>Message:</strong></td>
				<td>'.esc_attr($message).'</td>
			  </tr>
			  <tr>
				<td><strong>IP Address:</strong></td>
				<td>'.esc_attr($_SERVER["REMOTE_ADDR"]).'</td>
			  </tr>
			</table>
			';

	$headers = "From: " . esc_attr($sender_name) . "\r\n";
	$headers .= "Reply-To: " . esc_attr($email) . "\r\n";
	$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";

	
	$send_mail = @mail( $to, $subject, $formatted_message, $headers); 
	
	if(!$send_mail){
		
		echo "Could not send mail! Please check your PHP mail configuration.";
	}else{
		echo "Thank you for your email";
	} 
	
	die();
}

/************* Contact Form 2 (Working) *****************/

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'form2_submission'){
	
	$name = $_REQUEST['name'];
	$sender_name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$subject = $_REQUEST['subject'];
	$contact = $_REQUEST['contact'];
	$message = $_REQUEST['message'];
	$email_cc_admin = $_REQUEST['email_to'];
	$to = $email_cc_admin;
	
	$formatted_message = '
			<table width="100%" border="1">
			  <tr>
				<td width="100"><strong>Name:</strong></td>
				<td>'.esc_attr($sender_name).'</td>
			  </tr>
			  <tr>
				<td><strong>Email:</strong></td>
				<td>'.esc_attr($email).'</td>
			  </tr>
			   <tr>
				<td><strong>Subject:</strong></td>
				<td>'.esc_attr($subject).'</td>
			  </tr>
			  <tr>
				<td><strong>Contact:</strong></td>
				<td>'.esc_attr($contact).'</td>
			  </tr>
			  <tr>
				<td><strong>Message:</strong></td>
				<td>'.esc_attr($message).'</td>
			  </tr>
			  <tr>
				<td><strong>IP Address:</strong></td>
				<td>'.esc_attr($_SERVER["REMOTE_ADDR"]).'</td>
			  </tr>
			</table>
			';

	$headers = "From: " . esc_attr($sender_name) . "\r\n";
	$headers .= "Reply-To: " . esc_attr($email) . "\r\n";
	$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";

	
	$send_mail = @mail( $to, $subject, $formatted_message, $headers); 
	
	if(!$send_mail){
		
		echo "Could not send mail! Please check your PHP mail configuration.";
	}else{
		echo "Thank you for your email";
	} 
	
	die();
}

/************* Career Form (Working) *****************/

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'career_form_submit'){
	
	$name = $_REQUEST['name'];
	$sender_name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$designation = $_REQUEST['designation'];
	$contact = $_REQUEST['contact'];
	$message = $_REQUEST['message'];
	$email_cc_admin = $_REQUEST['email_to'];
	$to = $email_cc_admin;
	
	$formatted_message = '
			<table width="100%" border="1">
			  <tr>
				<td width="100"><strong>Name:</strong></td>
				<td>'.esc_attr($sender_name).'</td>
			  </tr>
			  <tr>
				<td><strong>Email:</strong></td>
				<td>'.esc_attr($email).'</td>
			  </tr>
			   <tr>
				<td><strong>designation:</strong></td>
				<td>'.esc_attr($designation).'</td>
			  </tr>
			  <tr>
				<td><strong>Contact:</strong></td>
				<td>'.esc_attr($contact).'</td>
			  </tr>
			  <tr>
				<td><strong>Message:</strong></td>
				<td>'.esc_attr($message).'</td>
			  </tr>
			  <tr>
				<td><strong>IP Address:</strong></td>
				<td>'.esc_attr($_SERVER["REMOTE_ADDR"]).'</td>
			  </tr>
			</table>
			';

	$headers = "From: " . esc_attr($sender_name) . "\r\n";
	$headers .= "Reply-To: " . esc_attr($email) . "\r\n";
	$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";

	
	$send_mail = @mail( $to, $designation, $formatted_message, $headers); 
	
	if(!$send_mail){
		
		echo "Could not send mail! Please check your PHP mail configuration.";
	}else{
		echo "Thank you for your email";
	} 
	
	die();
}
?>