<?php
include 'index.php';
//var_dump($_POST);
//para borrar la cita de un cliente necesito el appID
//pero para obtener el appID necesito el clientID, el slot id y la fecha
$clientId = isset($_POST['clientId']) ? $_POST['clientId'] : null;
$slotId = isset($_POST['slotID']) ? $_POST['slotID'] : null;
$appDate = isset($_POST['appDate']) ? $_POST['appDate'] : null;

$sql = "DELETE FROM appointmentSlots WHERE clientID = '$clientId' AND slotID = '$slotId' AND appDate = '$appDate'";
        
if ($conn->query($sql) === TRUE) {
    $message = "Cita cancelada correctamente.";
} else {
    $message =  "Error al cancelar cita: " . $conn->error;
}
?>

