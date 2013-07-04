<?php 

// Create connection
$con=mysqli_connect("skyynet.cloudapp.net","jon","jon","print");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


$result = mysql_query("SELECT ip FROM file2"); ?>

<table>
  <tr>
    <td>Recent Posts</td>
  </tr>
  <?php while($row = mysql_fetch_array($result)) : ?>
  <tr>
    <td><?php echo $row['ip']; ?></td>
    
    
    <td>
      <form action="delete.php" method="post">
        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>" />
        <input type="submit" value="Delete" />
      </form>
    </td>
  </tr>
  <?php endwhile; ?>
</table>



<?PHP
 
$table = 'file2';
$database='print'; 
IF (!MYSQL_CONNECT("skyynet.cloudapp.net", "jon", "jon"))
    DIE("Can't connect to database");
 
IF (!MYSQL_SELECT_DB($database)) DIE("Can't select database");
 
// sending query
$result = MYSQL_QUERY("SELECT * FROM {$table}");
IF (!$result) {
    DIE("Query to show fields from table failed");
}
 
$fields_num = MYSQL_NUM_FIELDS($result);
 
ECHO "<h1>Table: {$table}</h1>";
ECHO "<table border='1'><tr>";
// printing table headers
FOR($i=0; $i<$fields_num; $i++)
{
    $field = MYSQL_FETCH_FIELD($result);
    ECHO "<td>{$field->name}</td>";
	echo '<td><input type="submit" name="deleteItem" value="'.$row['id'].'" /></td>"';
}
ECHO "</tr>\n";
// printing table rows
WHILE($row = MYSQL_FETCH_ROW($result))
{
    ECHO "<tr>";
 
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable
    FOREACH($row AS $cell)
        ECHO "<td>$cell</td>";
 
    ECHO "</tr>\n";
}
MYSQL_FREE_RESULT($result);
 
?>