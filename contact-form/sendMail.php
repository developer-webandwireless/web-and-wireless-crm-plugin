<?php 
/*  Ajax call to send email and insert contact into the database  */


$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

if($_POST["action"] == 'sendForm'){
	$name    = sanitize_text_field( $_POST["cname"] );
	$email   = sanitize_email( $_POST["email"] );
	$phone   = sanitize_text_field( $_POST["phone"] );
	$message = esc_textarea( $_POST["message"] );
	
	//echo 'name =  '. $name;
	//  echo ' email =  '. $email. ' phone =  '. $phone. ' message =  '. $message;
	 
/* Create contact Lead into the databse */	
	function insertuser( $name, $email, $phone, $message ) {
	  global $wpdb;
	  $current_date =  date('Y-m-d');
	  $table_name = $wpdb->prefix . 'contact_form';
	  $wpdb->insert( $table_name, array(
		'name' => $name,
		'email' => $email,
		'phone' => $phone,
		'message' => $message,
		'date_added' => $current_date,
		'type' => 'Website Lead'
	  ) );
	}

	insertuser( $name, $email, $phone, $message);
	
	
	/********  Email ************/
	$to = 'rajalbhave@gmail.com';
	$headers = "From: $name <$email>" . "\r\n";
	$subject = 'Web and Wireless lead';
	
	$body = 'Name : '. $name."\r\n";

	$body .= 'Email : '. $email."\r\n";
	
	if($phone != '')
	$body .= 'Phone : '. $phone."\r\n";

	if($message != '')
	$body .= 'Message : '. $message."\r\n";

	
	if ( wp_mail( $to, $subject, $body, $headers ) ) {
            echo 'success';
        } else {
            echo 'error';
        }
}
?>