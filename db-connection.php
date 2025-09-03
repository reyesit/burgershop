<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "burgershop_db";

// Create connection
$dbCon = mysqli_connect($hostname, $username, $password, $database);
// Check connection
if (!$dbCon) {
   die("Connection failed: " . mysqli_connect_error());
} /* else {
echo "connected";
}*/

?>