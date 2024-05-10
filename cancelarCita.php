<?php
include 'index.php':
$clientID = isset($_POST['clientID']) ? $conn->real_escape_string($_POST['clientID']) : 'default_client_id';
?>