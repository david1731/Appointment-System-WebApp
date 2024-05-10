<?php
// Establish connection to MySQL database
$conn = mysqli_connect("localhost", "david.mendez13", "801215508", "david.mendez13");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>