<?php
/**
* @package ContactFormPlugin
*/
/*
Plugin Name: Contact Form Plugin
Plugin URI: localhost
Description: This is my first attempt
Version: 4.9.2
Author: Kashish Goyal
Author URI: http://www.kashishgoyal.in
License: GPLv2 or later
Text Domain: contact_form_plugin
*/
function contactForm() {
	//setting form action to current page
	// esc_url escapes html characters that may brake the page
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	/* Name Field in contact form */
	echo '<p>';
	echo 'Your Name<br/>';
	echo '<input type="text" name="name" pattern="[a-zA-Z0-9 ]+" value="';
	if(isset($_POST["name"])) 
		{
			echo esc_attr($_POST["name"]);
		}
	else
		{
			echo '';
		}
	echo '" size="40"  required/>';
	echo '</p>';
	/* Email Field in contact form */
	echo '<p>';
	echo 'Your Email<br/>';
	echo '<input type="email" name="email" value="';
	if(isset($_POST["email"]))
		{
			echo esc_attr($_POST["email"]);
		}
	else
		{
			echo '';
		}
	echo '" size="40"  required/>';
	echo '</p>';
	/*Subject Field in Contact Form */

	echo '<p>';
	echo 'Subject<br/>';
	echo '<input type="text" name="subject" pattern="[a-zA-Z ]+" value="';
	if(isset($_POST["subject"]))
		{
			 echo esc_attr($_POST["subject"]);
		}
	else
		{
			echo '';
		}
	echo '" size="40"  required/>';
	echo '</p>';
	/*Message Field in Contact Form */
	echo '<p>';
	echo 'Your Message<br/>';
	echo '<textarea rows="12" cols="40" name="message" required>';
	if(isset($_POST["message"]))
		{
			echo esc_attr($_POST["message"]);
		}
	else
		{
			echo '';
		}
	echo '</textarea>';
	echo '</p>';
	/*Submit Button */
	echo '<p>';
	echo 'All the above mentioned fields are neccessary<br/>';
	echo '<input type="submit" name="form_submit" value="Send"></p>';
	echo '</form>';
}

/* In case we want to mail the contact form */
function sendmail() {

	// if the submit button is clicked, send the email
	if ( isset( $_POST['form_submit'] ) ) {

		// sanitize form values. 
		// validating email value.
		$name    = sanitize_text_field( $_POST["name"] );
		$email   = sanitize_email( $_POST["email"] );
		if(filter_var($email, FILTER_VALIDATE_EMAIL)===false)
			exit('Invalid Email address');
		$subject = sanitize_text_field( $_POST["subject"] );
		$message = esc_textarea($_POST["message"] );

		
		$to ='kashishgoyal3171@gmail.com';

		$headers = "From: $name <$email>" . "\r\n";

		// to check if mail sending was successful or not
		if ( wp_mail( $to, $subject, $message, $headers ) ) {
			echo '<div>';
			echo '<p>Thanks for contacting me.</p>';
			echo '</div>';
		} else {
			echo 'Mail sent failed';
		}
	}
}

function lastfunction() {
	//starting the output buffer
	ob_start();
	sendmail();
	contactForm();
	// cleaning the output buffer
	return ob_get_clean();
}

add_shortcode( 'contactKashish', 'lastfunction' );
// to use this plugin activate it and then add [contactKashish]
?>