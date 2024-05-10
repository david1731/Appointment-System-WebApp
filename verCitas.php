<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Confirmation</title>
    <link href="crearCuenta.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        h1{
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Appointment Information</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Entrenador</th>
                    <th>Servicio</th>
                    <th>Nivel</th>
                    <th>Fecha de Cita</th>
                    <th>Hora de Cita</th>
                    <th>Cancelar Cita</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'index.php';
                $clientID = isset($_POST['clientID']) ? $conn->real_escape_string($_POST['clientID']) : 'default_client_id';
                
                $sql = "SELECT
                cl.firstName AS ClientFirstName,
                cl.lastName AS ClientLastName,
                tr.trainerName AS TrainerName,
                tr.trainerLastName AS TrainerLast,
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
                cl.clientID = '$clientID'
                ORDER BY
                ap.appDate, ts.startTime";
                
                $res = mysqli_query($conn, $sql);
                
                while($row = mysqli_fetch_assoc($res)) {
                    $clientFullName = $row['ClientFirstName'] . " " . $row['ClientLastName'];
                    $trainerFullName = $row['TrainerName'] . " " . $row['TrainerLast'];
                    $service = $row['ServiceName'];
                    $level = $row['LevelName'];
                    $appDate = $row['AppointmentDate'];
                    $appHour = $row['AppointmentStartTime'] . " - " . $row['AppointmentEndTime'];
                    
                    echo "<tr>";
                    echo "<td>" . $clientFullName ."</td>";
                    echo "<td>" . $trainerFullName . "</td>";
                    echo "<td>" . $service . "</td>";
                    echo "<td>" . $level . "</td>";
                    echo "<td>" . $appDate . "</td>";
                    echo "<td>" . $appHour . "</td>";
                    echo "<td>";
                    echo "<form action='cancelarCita.php' method='post'>";
                    echo "<input type='hidden' name='clientId' value='" . $row['clientID'] . "'>";
                    echo "<button type='submit' class='btn btn-danger'>Cancelar Cita</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>



