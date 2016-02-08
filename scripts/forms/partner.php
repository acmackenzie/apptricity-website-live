<?php
// check for the "BCC:" on all the vars.
$attemp_found = 0;		// assume a success
$input_fields = array();
foreach ($input_fields as $current) {
	if (preg_match('/[\r\n,;\'"]/',$_POST[$current])) {
		$attemp_found = 1;	// we got an attempt
	}
}	

$msg .= "Company: $_POST[company]\n";
$msg .= "Address: $_POST[address]\n";
$msg .= "Country: $_POST[country]\n";
$msg .= "Website: $_POST[website]\n";
$msg .= "Size of Organization: $_POST[organization]\n";
$msg .= "Annual Revenue: $_POST[revenue]\n";
$msg .= "Submitter's Name: $_POST[name]\n";
$msg .= "Email: $_POST[email]\n";
$msg .= "Landline: $_POST[landline]\n";
$msg .= "Mobile: $_POST[mobile]\n";

for ($i=0; $i<count($_POST["contact"]);$i++) {
	$msg .= "Are you the main partnership contact? " . $_POST["contact"][$i] . "\n\n";
}

$msg .= "If no, who is the main contact? $_POST[main_contact]\n\n";
$msg .= "What best explains your interest in applying? $_POST[interest]\n\n";
$msg .= "What are the TOP 3 verticals your organization addresses? $_POST[verticals]\n\n";

for ($i=0; $i<count($_POST["geographical"]);$i++) {
	$msg .= "Do you have a geographical focus? " . $_POST["geographical"][$i] . "\n";
}

for ($i=0; $i<count($_POST["where"]);$i++) {
	$msg .= "If so, where? " . $_POST["where"][$i] . "\n";
}

$msg .= "Does your organization have strategic industry focus? $_POST[strategic]\n";
$msg .= "Message: $_POST[message]\n";

$recipient = "amackenzie@apptricity.com,khartley@apptricity.com";
$subject = 'Partner Program Signup';
$mailheaders = "From: $_POST[email]\n";
$mailheaders .= "Reply-To: $_POST[email]\n\n";
if (!$attemp_found) {
	mail($recipient, $subject, $msg, $mailheaders);
}

//redirect to the 'thank you' page
header('Location: /../apptricity-confirmation.html');
?>