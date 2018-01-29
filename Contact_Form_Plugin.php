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
	echo '<form action="'.esc_url($_SERVER['PHP_SELF']).'" method="post">';
	/* Name Field in contact form */
	echo '<p>';
	echo 'Your Name<br/>';
	echo '<input type="text" name="name" pattern="[a-zA-Z0-9 ]+" value="" size="40"  required/>';
	echo '</p>';
	/* Email Field in contact form */
	echo '<p>';
	echo 'Your Email<br/>';
	echo '<input type="email" name="email" value="" size="40"  required/>';
	echo '</p>';
	/*Submit Button*/
	echo '<p>';
	echo 'All the above mentioned fields are neccessary<br/>';
	echo '<input type="submit" name="form_submit" value="Send"></p>';
	echo '</form>';
}
//if the user has submitted the form
if(isset($_POST['form_submit']))
{  
	global $wpdb;
	

	$table = $wpdb->prefix."user_details";
	$name=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
	$email=filter_var($_POST['email'],FILTER_SANITIZE_STRING);
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)===false)
	{
	
		$wpdb->insert( 
		$table, 
		array( 
				'name' => $name,
				'email' =>$email

			 )
			);
		
	}
	header('Location: ' . $_SERVER["HTTP_REFERER"]);
	exit;
}
// creates user_details in database if not exists
function tablecheck()
{  
	global $wpdb;
	$table = $wpdb->prefix . "user_details"; 
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE IF NOT EXISTS $table (
	`id` mediumint(9) NOT NULL AUTO_INCREMENT,
	`name` text NOT NULL,
	`email` text NOT NULL,
	UNIQUE (`id`)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
//fetches data from database
function fetchdata()
{  	global  $wpdb;
	$table_name=$wpdb->prefix . "user_details";

	$results = $wpdb->get_results( "SELECT * FROM $table_name");

	echo "<table style='border:2px solid black;padding:25px;width:100%;background-color: #0393f414;'>";
	foreach($results as $row)
		{	
				echo "<tr style='border:2px solid black;padding:25px;'>";
				echo "<td style='border:2px solid black;padding:25px;'>".$row->name."</td>";

				echo "<td style='border:2px solid black;padding:25px;'>".$row->email."</td>";

				echo "</tr>";
	
		}
	echo "</table>";
}

//this function is called firstly
function lastFunction()
{   tablecheck();
	contactform();
	fetchdata();

}

add_shortcode( 'contactKashish', 'lastFunction' );
// to use this plugin activate it and then add [contactKashish]
?>