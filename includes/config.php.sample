<?php
// $mysql_hostname = "localhost";
$mysql_hostname = "127.0.0.1";
//$mysql_user = "3rdlineart_root";
$mysql_user = "root";
// $mysql_password = "g3n0typ3";
$mysql_password = "password";
//$mysql_password = "password";
// $mysql_database = "3rdlineart9_db";
$mysql_database = "3rdlineart9";
// echo "mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database)";
$bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database)
or die("Oops some thing went very wrong");

// echo mysqli_connect_errno();

global $secretary_name, $email_secretary;
$SQL_secretary = "SELECT * FROM secretary limit 1";
$secretary = mysqli_query($bd, $SQL_secretary);
$row_secretary = mysqli_fetch_array($secretary);
// echo '>>>>>'.$row_secretary['email'];
$email_secretary = $row_secretary['email'];
$secretary_name = $row_secretary['fname'].' '.$row_secretary['lname'];
?>
