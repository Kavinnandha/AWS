<?php
// Configuration for database connection
$host = "localhost"; 
$dbname = "sms";
$username = "sammy"; 
$password = "password"; 

// MySQLi connection
$connection = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
