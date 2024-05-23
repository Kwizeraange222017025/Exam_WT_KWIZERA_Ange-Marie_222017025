<?php
// Database credentials
$hostname = "localhost";
$username = "Ange";
$password = "222017025";
$database = "online_learning_management_system";

// Create connection
$connection = new mysqli($hostname, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>