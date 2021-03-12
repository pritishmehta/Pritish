<?php
/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "pritishmehta18@gmail.com";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$error_page = "error_message.html";
$thankyou_page = "thank_you.html";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$email_address = $_REQUEST['email'] ;
$comments = $_REQUEST['desc'] ;
$phone_no = $_REQUEST['contact_no'];
$first_name = $_REQUEST['first_name'] ;
$last_name = $_REQUEST['last_name'] ;
$country_code = $_REQUEST['country_code'] ;
$arrayc = array();
#if(isset($_POST["submit"]))
#{
	if(!empty($_POST["checkbox"]))
	foreach ($_POST["checkbox"] as $checkbox) {
		# code...
		$arrayc[]= $checkbox;
	}
#}
$v = implode(',', $arrayc);
#echo $v;
#$checkbox = $_REQUEST['checkbox'];

$subject = $_REQUEST['subject'];

$msg = 
"First Name: " . $first_name . "\r\n" . 
"Last Name: " . $last_name . "\r\n" .
"Email: " . $email . "\r\n" . 
"Country Code: " . $country_code . "\r\n". 
"Phone No: " . $contact_no . "\r\n" .
"Message: " . $desc ;


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
header( "Location: $thankyou_page" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($first_name) || empty($last_name) || empty($email) ||empty($country_code) || empty($contact_no) || empty($desc) ) {
header( "Location: $thankyou_page" );
}

/* 
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($email) || isInjected($first_name)  || isInjected($desc) || isInjected($contact_no) || isInjected($country_code) ) {
header( "Location: $thankyou_page" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

	mail( "$webmaster_email", "Feedback Form Results", $msg );

	header( "Location: $thankyou_page" );
}
?>