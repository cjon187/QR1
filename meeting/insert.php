<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
<style>
            body{
                background-image:url(image.jpg);
                                
            }
        </style>
        <?php
        $money = $_POST['money'];
        $notes = $_POST['notes'];
        echo $money." & ".$notes." Added to database";
        
        mysql_connect(localhost, jon, jon) or die(mysql_error());
        mysql_select_db("meeting") or die(mysql_error());
        $sql="INSERT INTO 5tradition (cash, notes)
VALUES
('$money','$notes')";
if (!mysql_query($sql))
  {
  die('Error: ' . mysql_error());
  }
  echo"<br>";
  echo "1 record added";

mysql_close($con);
header("Location: edit.php");
        ?>
    </body>
<FORM METHOD="LINK" ACTION="edit.php">
<INPUT TYPE="submit" VALUE="Back to Edit">
</FORM>

</html>
