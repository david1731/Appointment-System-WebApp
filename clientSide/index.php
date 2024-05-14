<?php
// Display all errors
error_reporting(E_ALL);

// Display errors on the webpage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Establish connection to MySQL database
$conn = mysqli_connect("localhost", getenv("user"), getenv("dbpassword"), getenv("user"));

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>