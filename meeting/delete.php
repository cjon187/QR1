<html>
<?php
session_start();

if ($_SESSION['check'] != "4"){
    
    header("Location: index.php");
    
}

else{

$delete = $_POST['delete'];

mysql_connect(localhost, jon, jon) or die(mysql_error());
        mysql_select_db("meeting") or die(mysql_error());
$sql="DELETE FROM 5tradition WHERE pkey='$delete'";

if (!mysql_query($sql))
  {
  die('Error: ' . mysql_error());
  }
  echo"<br>";
 echo "The entry #:<font color=red>".$delete. "</font> Deleted";

mysql_close($con);
header("Location: edit.php");
}#else
?>
<FORM METHOD="LINK" ACTION="edit.php">
<INPUT TYPE="submit" VALUE="Back to Edit">
</FORM>
</html>
