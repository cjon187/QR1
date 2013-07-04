<?php
$pass = $_GET['pass'];

$what_visitor_typed = '5th';

if ($what_visitor_typed != $pass) {

print("You're not a valid user of this site!");

}
else {
    session_start();
    $check = 4;
    $_SESSION['check']=$check;
header("Location: edit.php");

}



?>
<html>
<style>
            body{
                background-image:url(image.jpg);
                                
            }
        </style>
</html>
