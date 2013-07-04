<?php
 
require_once('padCrypt.php');
require_once('AES_Encryption.php');
 
$key 	          = "12345678901234561234567890123456";
$iv               = "1234567890123456";
$message          = "The quick brown fox jumped over the lazy dog";
 
$AES              = new AES_Encryption($key, $iv);
$encrypted        = $AES->encrypt($message);
$decrypted        = $AES->decrypt($encrypted);
$base64_encrypted = base64_encode($encrypted);
 
 echo $decrypted;
 echo "<br>";
 echo $base64_encrypted;
?>