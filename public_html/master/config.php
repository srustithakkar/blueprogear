<?php
//include('mysql.php');
function connect()
{
$server="mysql.hostinger.in";
$username="u993134792_blue";
$password="Admin@2701";
$DBName="u993134792_live";
$con=mysqli_connect($server,$username,$password,$DBName);

return $con;
} 

?>