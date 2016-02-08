<?php
// check for the "BCC:" on all the vars.
$attemp_found = 0;		// assume a success
$input_fields = array();
foreach ($input_fields as $current) {
	if (preg_match('/[\r\n,;\'"]/',$_POST[$current])) {
		$attemp_found = 1;	// we got an attempt
	}
}	

$msg .= "Email: $_POST[newsletteremail]\n";

$recipient = "ehinson@apptricity.com";
$subject = 'Newsletter Signup';
$mailheaders = "From: $_POST[newsletteremail]\n";
$mailheaders .= "Reply-To: $_POST[newsletteremail]\n\n";
if (!$attemp_found) {
	mail($recipient, $subject, $msg, $mailheaders);
}

//redirect to the 'thank you' page
header('Location: /../apptricity-confirmation.html');
?>