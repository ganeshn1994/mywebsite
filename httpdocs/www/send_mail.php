<?php
/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "ganeshn1994@gmail.com";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$contact_page= "index.html";
$error_page = "error_message.html";
$thankyou_page = "thank_you.html";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$name = $_REQUEST['name'] ;
$email = $_REQUEST['email'] ;
$website = $_REQUEST['website'] ;
$timeline = $_REQUEST['timeline'] ;
$budget = $_REQUEST['budget'] ;
$services = $_REQUEST['services'] ;
$comments = $_REQUEST['comments'] ;





/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['email'])) {
header( "Location: $contact_page" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($email) || empty($name) || empty($website) || empty($comments) || empty($timeline) || empty($budget) || empty($services) ) {
header( "Location: $error_page" );
}

// If email injection is detected, redirect to the error page.
elseif ( isInjected($email) ) {
header( "Location: $error_page" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {
mail( "$webmaster_email", "Feedback Form Results",
  $comments,$name,$services,$budget,$website,$timeline "From: $email" );
header( "Location: $thankyou_page" );
}
?>
