<html>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<style>
body
{
background-image:url('lv1.jpg');
a {color:pink;}
}
</style>
<div style="max-width:2000px;">
<img src="g.jpeg" width="1000" height="300" alt="" title="" />
</div><?php
 
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
&nbsp&nbsp&nbsp<div class="fb-send" data-href="http://skyynet.cloudapp.net/QR" data-colorscheme="dark" data-font="verdana"></div>

</html>



 <?php
echo '</br><font size="6" color="pink">Skyynet Secret QR Maker</font></br></br>';
// String EnCrypt + DeCrypt function
// Author: halojoy, July 2006

///////////////////////////////////

// Secret key to encrypt/decrypt with





echo '<strong><font color="pink">KEY</strong></br></br><form style="display: inline" action="index.php" method="post">
&nbsp;<input name="key" value="" />&nbsp;        
        &nbsp;
        &nbsp;</br><strong><font color="pink">DATA</font></strong></a></br>
		&nbsp;<textarea type="text" rows="5" cols="50" name="data" value="http://skyynet.dyndns.biz:8080/decrypt.php?data='.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'').'">'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'').'</textarea>&nbsp;
        <input type="submit" value="GENERATE"></form><hr/>';
echo "</br>";


$key=$_REQUEST['key']; // 8-32 characters without spaces
// String to encrypt
$string1=$_REQUEST['data'];

//aes part
$Pass = $key;
$Clear = $string1;        

$crypted = fnEncrypt($Clear, $Pass);
echo "Encrypred: ".$crypted."</br>";
$a= urlencode($crypted);

$e ="http://skyynet.cloudapp.net:8080/adecrypt.php?data='.$a.'";
 

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




 
/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
    
    
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 10;
    //if (isset($_REQUEST['size']))
    //    $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($e)) { 
    
        //it's very important!
        if (trim($e) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($e.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($e, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
        //default data
         
        QRcode::png('Skyynet QR Encryption', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
        
    //display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
    
    //config form
    echo '<strong>Encrypted Output</strong></br><form style="display: inline"action="index.php" method="post">
        &nbsp;<textarea type="text" rows="5" cols="50" name="data" value="">'.$crypted.'</textarea>&nbsp;
        &nbsp;
        &nbsp;
        </form></font><hr/>';
        
    // benchmark
    //QRtools::timeBenchmark();    

	
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

 

