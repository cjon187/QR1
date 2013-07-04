<?php
$to = "cjon187@gmail.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "cjon187@gmail.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?>
<html>
<a href="mailto:cjon187@gmail.com?subject=SweetWords
&body=Please send me a copy of your new program!">Email Me</a>
</html>