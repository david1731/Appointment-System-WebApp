<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tus Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
        }
        h1{
            background-color:white;
        }

        div{
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sus citas</h1>
        <table class="table table-striped">
                <tr>
                    <th>Nombre</th>
                    <th># Telefono Cliente</th>
                    <th>Entrenador</th>
                    <th>Servicio</th>
                    <th>Nivel</th>
                    <th>Fecha de Cita</th>
                    <th>Hora de Cita</th>
                    <th>Cancelar Cita</th>
                </tr>
                <?php
                // ini_set('display_errors', 1);
                // error_reporting(E_ALL);
                //var_dump($_POST);
                include 'connection.php';
                $trainerEmail = isset($_POST['trainerEmail']) ? $conn->real_escape_string($_POST['trainerEmail']) : 'trainerEmail';
                $trainerID = isset($_POST['trainerID']) ? $conn->real_escape_string($_POST['trainerID']) : 'trainerID';

                $sql = "SELECT
                clients.firstName AS ClientFirstName,
                clients.lastName AS ClientLastName,
                clients.cellphone AS ClientCellphone,
                trainers.trainerName AS TrainerName, 
                trainers.trainerLastName AS TrainerLastName, 
                trainers.trainerID AS TrainerID,            
                service.serviceName AS ServiceName,
                levels.level AS LevelName,
                timeSlots.startTime AS AppointmentStartTime,
                timeSlots.endTime AS AppointmentEndTime,
                appointmentSlots.appDate AS AppointmentDate,
                appointmentSlots.appID AS AppointmentID
                FROM
                appointmentSlots 
                JOIN clients ON appointmentSlots.clientID = clients.clientID
                JOIN trainers ON appointmentSlots.trainerID = trainers.trainerID
                JOIN service ON appointmentSlots.serviceID = service.serviceID
                JOIN levels ON appointmentSlots.levelID = levels.levelID
                JOIN timeSlots ON appointmentSlots.slotID = timeSlots.slotID
                ORDER BY
                appointmentSlots.appDate, timeSlots.startTime;
                ";

                $res = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($res)){
                    $clientFullName = $row['ClientFirstName'] . " " . $row['ClientLastName'];
                    $clientCellphone = $row['ClientCellphone'];
                    $trainerFullName = $row['TrainerName']. " " . $row['TrainerLastName'];
                    $trainerID = $row['TrainerID'];
                    $service = $row['ServiceName'];
                    $level = $row['LevelName'];
                    $appDate = $row['AppointmentDate'];
                    $appHour = $row['AppointmentStartTime'] . " - " . $row['AppointmentEndTime'];
                    $appID = $row['AppointmentID'];
                    echo "<tr>";
                    echo "<td>" . $clientFullName ."</td>";
                    echo "<td>" . $clientCellphone . "</td>";
                    echo "<td>" . $trainerFullName . "</td>";
                    echo "<td>" . $service . "</td>";
                    echo "<td>" . $level . "</td>";
                    echo "<td>" . $appDate . "</td>";
                    echo "<td>" . $appHour . "</td>";
                    echo "<td>";
                    echo "<form action='trainerCancelarCita.php' method='post'>";
                    echo "<input type='hidden' name='appID' value='$appID'>";
                    echo "<input type='hidden' name='trainerID' value='$trainerID'>";
                    echo "<button type='submit' class='btn btn-danger'>Cancelar Cita</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                //que este file lleve al trainer a ver sus citas y que pueda cancelarlas
                ?>
        </table>
        <div class="d-flex flex-column align-items-center">
            <form action="trainerSignIn.php" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Volver a Menu</button>
            </form>
        </div>
        
    </div>
</body>
</html>
