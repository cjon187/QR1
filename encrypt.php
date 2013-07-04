 <?php
// String EnCrypt + DeCrypt function
// Author: halojoy, July 2006

///////////////////////////////////

// Secret key to encrypt/decrypt with
$key='mysecretkey'; // 8-32 characters without spaces


 echo '<form action="encrypt.php" method="post">
        Data:&nbsp;<input name="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'').'" />&nbsp;
        &nbsp;
        &nbsp;
        <input type="submit" value="GENERATE"></form><hr/>';


// String to encrypt
$string1=$_REQUEST['data'];

//AES PART
include("./AES.class.php");

//$z = "abcdefgh01234567"; // 128-bit key
//$z = "abcdefghijkl012345678901"; // 192-bit key
//$z = "abcdefghijuklmno0123456789012345"; // 256-bit key

$aes = new AES($key);

$data = $string1;
$decryption= $aes->encrypt($data);

$decryption1 = base64_encode($data);



$start = microtime(true);

echo "\n\nPlain-Text:\n" . $aes->decrypt($decryption) . "\n";
print "Base 64: " . base64_encode($decryption) . "<br /><br />";
$end = microtime(true);

echo "\n\nExecution time: " . ($end - $start);




// Test output
echo '<span style="font-family:Courier">'."\n";
echo 'Key: '.$key.'<br>'."\n";
echo $string1.'<br>'."\n";
echo $string2.'<br>'."\n";
echo $string3.'<br>'."\n";
echo '</span>'."\n";
?> 
