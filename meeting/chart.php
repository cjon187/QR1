<?php
header("Content-type: image/png");
include('graidle.php');
mysql_connect("localhost", "jon", "jon") or die(mysql_error());
mysql_select_db("meeting") or die(mysql_error());

$q1="Select * from 5tradition"; 
        $r1=  mysql_query($q1);
$data=array();
while ($row1 = mysql_fetch_array($r1)){
$data[$row1['id']]= $row1['cash'];
}

// array with data points for each name


// set 2 numeric arrays, one with names (for x-axis), another with the points (y-axis)
$names = array_keys($data);
$points = array_values($data);

// create object of graidle class (define Title)
$graph = new graidle('Cash');
$graph->setColor('#00000f');
$graph -> setValue($points,'b');      // set series values, type of graph (b=bar)

$graph -> setSecondaryAxis(1,0);          // display secondary x-axis grid
$graph -> setWidth(2000);                  // graphic chart width
$graph -> setHeight(600);                 // graphic chart height
$graph -> setXValue();              // add the names to x-axis
$graph->setDivision(20);                  // set division on scale axis
$graph->setBgCl('#ffffff');               // background color
$graph ->setFontSmallSize (11);
$graph -> setExtLegend();                 // to show values to each bar
$graph -> create();                       // create chart
$graph -> carry();                        // outputs the graph

/*
 To save the chart, use carry2file() method, with: 'dir_name', 'file_name' (without extension)
 Ex.: save "graphic_chart_1.png" in directory "charts/"
       $graph->carry2file('charts/', 'graphic_chart_1');
*/
?>

