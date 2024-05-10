<?php
//var_dump($_POST);
include 'index.php';
$clientID = isset($_POST['clientID']) ? $conn->real_escape_string($_POST['clientID']) : 'default_client_id';

$sql = "SELECT
cl.firstName AS ClientFirstName,
cl.lastName AS ClientLastName,
tr.trainerName AS TrainerName,
se.serviceName AS ServiceName,
le.level AS LevelName,
ts.startTime AS AppointmentStartTime,
ts.endTime AS AppointmentEndTime,
ap.appDate AS AppointmentDate
FROM
appointmentSlots ap
JOIN clients cl ON ap.clientID = cl.clientID
JOIN trainers tr ON ap.trainerID = tr.trainerID
JOIN service se ON ap.serviceID = se.serviceID
JOIN levels le ON ap.levelID = le.levelID
JOIN timeSlots ts ON ap.slotID = ts.slotID
WHERE
cl.clientID = $clientID
ORDER BY
ap.appDate, ts.startTime";

$res = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($res)) {
    echo "<div>";
    echo "<h1>Appointment Information</h1>";
    echo "<p>Client Name: " . $row['ClientFirstName'] . " " . $row['ClientLastName'] . "</p>";
    echo "<p>Trainer Name: " . $row['TrainerName'] . "</p>";
    echo "<p>Service Name: " . $row['ServiceName'] . "</p>";
    echo "<p>Level: " . $row['LevelName'] . "</p>";
    echo "<p>Appointment Date: " . $row['AppointmentDate'] . "</p>";
    echo "<p>Appointment Time: " . $row['AppointmentStartTime'] . " - " . $row['AppointmentEndTime'] . "</p>";
    echo "</div>";
}
?>