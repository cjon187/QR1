<html>
<style>
body
{
background-image:url('lv1.jpg');

}
</style>
<script type="text/javascript">
 <!--
  var stile = "top=10, left=10, width=600, height=800 status=no, menubar=no, toolbar=no scrollbar=no";
     function Popup(apri) {
        window.open(apri, "", stile);
     }
 //-->
</script>
<div style="max-width:2000px;">
<img src="g.jpeg" width="1000" height="300" alt="" title="" />
</div>
<div><?php
 
    if (getenv('HTTP_X_FORWARDED_FOR')) {
        $pipaddress = getenv('HTTP_X_FORWARDED_FOR');
        $ipaddress = getenv('REMOTE_ADDR');
echo "Your Proxy IP address is : ".$pipaddress. "(via $ipaddress)" ;
    } else {
        $ipaddress = getenv('REMOTE_ADDR');
        //echo "Your IP address is : $ipaddress";
		echo "<font size='6' color='pink'>Your IP: $ipaddress </font>";
    }
?>
<br>
<form style="display: inline" method="get" action="index.php">
    <button style="height: 50px; width: 200px ; background: url(hk.jpeg)no-repeat" type="submit"><strong>Create QR</strong></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</form>
<form style="display: inline" method="get" action="decrypt.php">
    <button style="height: 50px; width: 200px ; background: url(hk.jpeg)no-repeat"type="submit"><strong>Encrypt/Decrypt</strong></button>
</form>

</html>

 <?php
echo '<h1><font color="pink">SKyynet Encryption/Decryption</h1>';
// String EnCrypt + DeCrypt function
// Author: halojoy, July 2006

///////////////////////////////////

// Secret key to encrypt/decrypt with




echo"</br>";
 echo '<strong>KEY</strong></br></br><form action="decrypt.php" method="post">
&nbsp;<input name="key" value="" />&nbsp;        
        &nbsp;
        &nbsp;</br><strong>DATA</strong></br>
		&nbsp;<textarea type="text" cols="50" rows="5" name="data" value="">'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'').'</textarea>&nbsp;
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

echo "<div><strong><a href=\"http://tts-api.com/tts.mp3?q=".$string."\"target=\"_blank\"style=\"color:red\">Click To Listen to Message </a></strong>\n</div>";







// Test output
echo '<span style="font-family:Courier">'."\n";
//echo 'Key: '.$key.'<br>'."\n";
//echo $string1.'<br>'."\n";

//echo $string3.'<br>'."\n";
//echo '</span>'."\n";
echo'<textarea font-size: 20pt; type="text" rows="5" cols="50" name="data1" value="'.$newClear.'">'.$newClear.'</textarea></font>&nbsp';
//db part

	$jon="jon";
	$chong="chong";
	$killer="killer";


mysql_connect("localhost:3306", "jon" , "jon") or die(mysql_error());
mysql_select_db("print") or die(mysql_error());
try{
mysql_query("Insert INTO logs (ip, message, key1) VALUES ('$ipaddress', '$string1' , '$key' )");
}
catch (Exception $e)
{
throw new Exception('Something wrong',0,$e);
}
?>
