<?php

$db_host="localhost";
$db_username="root";
$db_pass="";
$db_name="sannibh";

//Run the actual connection here

$conn=mysqli_connect($db_host,$db_username,$db_pass,$db_name); //If using mysqli(improved version of mysql)

//mysql_connect($db_host,$db_username,$db_pass); 
//mysql_select_db($db_name) or die("no database");  For Old version of mysql

return $conn;

mysqli_close();


?>