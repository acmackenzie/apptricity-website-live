<?php
// https://gist.github.com/optikalefx/5149537
// https://www.youtube.com/watch?v=As96Pem4bXQ&feature=youtu.be

error_reporting(E_ALL);
ini_set('display_errors', 1);
if(isset($_FILES) && (bool) $_FILES) {
$allowedExtensions = array("pdf","doc","docx");
$files = array();
foreach($_FILES as $name=>$file) {
$file_name = $file['name'];
$temp_name = $file['tmp_name'];
$file_type = $file['type'];
$path_parts = pathinfo($file_name);
$ext = $path_parts['extension'];
if(!in_array($ext,$allowedExtensions)) {
die("File $file_name has the extensions $ext which is not allowed");
}
array_push($files,$file);
}

// Email Fields: to, from, subject, and so on
$to = "rgent@apptricity.com,careers@apptricity.com";
$from = "<<FROM EMAIL>>";
$subject ="Job Candidate";
$message = "Please see attached resume for your review and consideration.\n";
$message .= "First Name: $_POST[name]\n";
$message .= "Position: $_POST[position]\n";
$message .= "Email: $_POST[email]\n";
$message .= "Phone: $_POST[phone]\n";
$message .= "Message: $_POST[message]\n";
$headers = "From: $from";

// Boundary
$semi_rand = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

// Headers for Attachment
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

// Multipart Boundary
$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
$message .= "--{$mime_boundary}\n";

// Preparing Attachments
for($x=0;$x<count($files);$x++){
$file = fopen($files[$x]['tmp_name'],"rb");
$data = fread($file,filesize($files[$x]['tmp_name']));
fclose($file);
$data = chunk_split(base64_encode($data));
$name = $files[$x]['name'];
$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$name\"\n" .
"Content-Disposition: attachment;\n" . " filename=\"$name\"\n" .
"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
$message .= "--{$mime_boundary}\n";
}

// Send
$ok = mail($to, $subject, $message, $headers);
}

// Redirect to the 'thank you' page
header('Location: /../confirmation.html');
?>