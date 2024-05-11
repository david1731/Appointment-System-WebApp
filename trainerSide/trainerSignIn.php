<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'connection.php';
$trainerName = isset($_POST['trainerName']) ? $conn->real_escape_string($_POST['trainerName']) : 'trainerName';
$trainerID = isset($_POST['trainerID']) ? $conn->real_escape_string($_POST['trainerID']) : 'trainerID';

?>