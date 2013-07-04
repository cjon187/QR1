<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>5th Tradition 7th</title>
        <LINK rel="stylesheet" type="text/css" media="screen"
      href="global.css">
        <style>
            body{
                background-image:url(image.jpg);
                                
            }
        </style>
    </head>
    
    <body>
     
       <?php
mysql_connect("localhost", "jon", "jon") or die(mysql_error());
echo "<font color=cyan><strong>";
echo "Connected to MySQL<br />";
mysql_select_db("meeting") or die(mysql_error());

echo "<center>";
echo "<font color=red size=6>5th Tradition 7th</font>";
echo "<br>";
echo "</font></strong>";
        $q1="select date_format(id,'%l:%i %p %M %d %Y %W') as date1, cash,notes from 5tradition"; 
        $r1=  mysql_query($q1);
               
        echo "<table CELLPADDING=1 border=6><tr>
        <th>Date</th>
        <th>Cash Amount</th>
        <th>Notes</th>
        </tr>";
        
        while ($row1 = mysql_fetch_array($r1)){
        echo "<tr>";
        echo "<td>".$row1['date1']."</td>";
        echo "<td>".$row1['cash']."</td>";
        echo "<td>".$row1['notes']."</td>";
        echo "</tr>";
        }
        echo "</table>";
        echo "</center>";
					       
        ?>
        <?php
        #for total
        $q = "Select sum(cash) as total from 5tradition";
        $r = mysql_query($q) or die(mysql_error());
        while($row = mysql_fetch_assoc($r)){
	echo "<font size=5>The Total is: $".$row["total"]."</font>";
	echo "<br />";
        }
        ?>
    </body>
    <form name ="input" action="add.php" method="get">
        <br>
Password: <input type="password" name="pass">
<input type="submit" value="Submit">

</form>
</html>
