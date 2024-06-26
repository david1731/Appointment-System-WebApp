<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <title>Tus Citas</title>
    <link href="crearCuenta.css" rel="stylesheet">
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
                    <th>Entrenador</th>
                    <th>Servicio</th>
                    <th>Nivel</th>
                    <th>Fecha de Cita</th>
                    <th>Hora de Cita</th>
                    <th>Cancelar Cita</th>
                </tr>
                <?php
                include 'index.php';
                //var_dump($_POST);
                //retrieve clientID from post to only display the appointments of that specific client
                $clientID = isset($_POST['clientID']) ? $conn->real_escape_string($_POST['clientID']) : 0000;
                
                //joining tables to display the appointments of the client with additional information
                $sql = "SELECT
                cl.clientID AS ClientID,
                cl.firstName AS ClientFirstName,
                cl.lastName AS ClientLastName,
                tr.trainerName AS TrainerName,
                tr.trainerLastName AS TrainerLast,
                se.serviceName AS ServiceName,
                le.level AS LevelName,
                ts.startTime AS AppointmentStartTime,
                ts.endTime AS AppointmentEndTime,
                ap.appDate AS AppointmentDate,
                ts.slotID As SlotID
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
                
                //execute and store query result
                $res = mysqli_query($conn, $sql);
                
                //dislpaye table of appointments
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
                    echo "<input type='hidden' name='clientId' value=" . $row['ClientID'] . ">";
                    echo "<input type='hidden' name='slotID' value=" . $row['SlotID'] . ">";
                    echo "<input type='hidden' name='appDate' value=" . $row['AppointmentDate'] . ">";
                    echo "<button type='submit' class='btn btn-danger'>Cancelar Cita</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
        </table>
        <div class="card" style="width: 18rem;">
            <img src="verCitas.png" class="card-img-top" alt="...">
            <div class="card-body">
                <form action="sacarCita.php" method="post">
                    <input type="hidden" name="clientID" value="<?=$clientID;?>">
                    <button type="submit" class="btn btn-primary">Sacar Otra Cita</button>
                </form>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center">
            <form action="homePage.html">
                <button type="submit" class="btn btn-primary">Terminar</button>
            </form>
        </div>
        
    </div>
</body>
</html>



