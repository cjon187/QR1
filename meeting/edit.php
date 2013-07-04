<?php
session_start();

if ($_SESSION['check'] != "4"){
    
    header("Location: index.php");
    
}

else{
    
mysql_connect("localhost", "jon", "jon") or die(mysql_error());
echo "<font color=cyan><strong>";
echo "Connected to MySQL<br />";
mysql_select_db("meeting") or die(mysql_error());

echo "<center>";
echo "<font color=red size=6>5th Tradition 7th</font>";
echo "<br>";
echo "</font></strong>";
        $q1="select pkey,date_format(id,'%l:%i %p %M %d %Y %W') as date1, cash,notes from 5tradition"; 
        $r1=  mysql_query($q1);
                
        echo "<table CELLPADDING=1 border=6><tr>
		<th>Id</th>        
		<th>Date</th>
        <th>Cash Amount</th>
        <th>Notes</th>
        </tr>";
        
        while ($row1 = mysql_fetch_array($r1)){
        echo "<tr>";
		echo "<td>".$row1['pkey']."</td>";        
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
	echo "<br><br>";
	echo "<font color=red>Enter the cash amount. Also reminder notes can be added.</font><br>";  
        }
      
}#else
        ?>
<html>
    <head>
    <br>
       <SCRIPT language=Javascript>
       
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode !=45 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;
          return true;
       }
       
    </SCRIPT>
    </head>
    <body>
        <style>
            body{
                background-image:url(image.jpg);
                                
            }
        </style>
    </body>
    <form action="insert.php" method ="post">
    Cash Amount: <input type="text" onkeypress="return isNumberKey(event)"   name="money">
    Notes: <input type="text" name="notes">
    <input type="submit" value="Insert">
    </form>
<br>
<?php echo "<font color=red>Enter the ID number of entry to be deleted.</font><br><br>";?>
<form action="delete.php" method ="post">
    Enter Id # to delete:<input type="text" onkeypress="return isNumberKey(event)" name="delete" size=5>
    <input type="submit" value="Delete">
    </form>

<a href="hc.php"><button style="height:30px;width:100px"><strong>View Graph</strong></button></a>

</html>

