<html>
<style>
body
{
background-image:url('lv1.jpg');

}
</style>

</div>
<div>
<br>
<form style="display: inline" method="get" action="index.php">
    <button style="height: 50px; width: 200px ; background: url(hk.jpeg)no-repeat" type="submit"><strong>Create QR</strong></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</form>
<form style="display: inline" method="get" action="decrypt.php">
    <button style="height: 50px; width: 200px ; background: url(hk.jpeg)no-repeat"type="submit"><strong>Encrypt/Decrypt</strong></button>
</form>
</html><?php
 
    if (getenv('HTTP_X_FORWARDED_FOR')) {
        $pipaddress = getenv('HTTP_X_FORWARDED_FOR');
        $ipaddress = getenv('REMOTE_ADDR');
echo "Your Proxy IP address is : ".$pipaddress. "(via $ipaddress)" ;
    } else {
        $ipaddress = getenv('REMOTE_ADDR');
       
		
    }
?>

 <?php
echo '<style type="text/css">
textarea {
   font-size: 20pt;
   font-family: Arial;
} 
input {
   font-size: 20pt;
   font-family: Arial;
} 
</style>';
echo "<h1><font size='6' color='pink'>Your IP: $ipaddress </font></br>";
echo '<font color="pink">SKyynet Encryption/Decryption</h1>';
// String EnCrypt + DeCrypt function
// Author: halojoy, July 2006

///////////////////////////////////

// Secret key to encrypt/decrypt with




echo"</br>";
 echo '<strong><font size="8">KEY</strong><form action="adecrypt.php" method="post">
&nbsp;<input type="text" size="35" rows="1" name="key" value="" />&nbsp;        
        &nbsp;
        &nbsp;</br></br><strong>DATA</strong></br>
		&nbsp;<textarea type="text" cols="65" rows="5" name="data" value="">'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'').'</textarea>&nbsp;
        <input type="submit" value="GENERATE"></form><hr/>';
echo "</br>";

$key=$_REQUEST['key']; // 8-32 characters without spaces
// String to encrypt
$string1=$_REQUEST['data'];

//AES PART

$Pass = $key;
$Clear = $string1;        

$crypted = fnEncrypt($Clear, $Pass);


$newClear = fnDecrypt($string1, $Pass);
     

function fnEncrypt($sValue, $sSecretKey)
{
    return rtrim(
        base64_encode(
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_256,
                $sSecretKey, $sValue, 
                MCRYPT_MODE_ECB, 
                mcrypt_create_iv(
                    mcrypt_get_iv_size(
                        MCRYPT_RIJNDAEL_256, 
                        MCRYPT_MODE_ECB
                    ), 
                    MCRYPT_RAND)
                )
            ), "\0"
        );
}

function fnDecrypt($sValue, $sSecretKey)
{
    return rtrim(
        mcrypt_decrypt(
            MCRYPT_RIJNDAEL_256, 
            $sSecretKey, 
            base64_decode($sValue), 
            MCRYPT_MODE_ECB,
            mcrypt_create_iv(
                mcrypt_get_iv_size(
                    MCRYPT_RIJNDAEL_256,
                    MCRYPT_MODE_ECB
                ), 
                MCRYPT_RAND
            )
        ), "\0"
    );
}


$string = str_replace(' ', '+', $newClear);

echo "<strong><a href=\"http://tts-api.com/tts.mp3?q=".$string."\"target=\"_blank\"style=\"color:red\">Click To Listen to Message </a></strong></br>";




// Test output


echo '<strong>DeCrypted Message</strong></br>';
echo'<textarea type="text" rows="5" cols="65" name="data1" value="'.$newClear.'">'.$newClear.'</textarea></font>&nbsp';

?>
