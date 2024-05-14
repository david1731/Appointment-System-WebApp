<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <title>Disponibilidad de Horas</title>
    <link href="tablaHoras.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Disponibilidad de horas</h1>
        <table class="table table-striped table-bordered">
                <tr>
                    <th>Hora</th>
                    <th>Status</th>
                    <th>Cambiar Disponibilidad</th>
                </tr>
                <?php
                include 'connection.php';
                //var_dump($_POST);
                $trainerID = isset($_POST['trainerID']) ? $conn->real_escape_string($_POST['trainerID']) : 'trainerID'; //not being used but is needed for the form 

                $query = "SELECT slotID, startTime, endTime, statusHora FROM timeSlots";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($result)) {
                    $hora = $row['startTime'] . " - " . $row['endTime'];
                    $status = $row['statusHora'];
                    
                    echo "<tr>";
                    echo "<td>" . $hora ."</td>";
                    echo "<td>" . $status . "</td>";
                    echo "<td class = horizontal-buttons>";
                    echo "<form action='cambiaDispo.php' method='post'>";
                    echo "<input type='hidden' name='slotID' value=" . $row['slotID'] . ">";
                    echo "<input type='hidden' name='trainerID' value='$trainerID'>";
                    echo "<button type='submit' class='btn btn-success'>Disponible</button>";
                    echo "</form>";
                    echo "<form action='cambiaNoDispo.php' method='post'>";
                    echo "<input type='hidden' name='slotID' value=" . $row['slotID'] . ">";
                    echo "<input type='hidden' name='trainerID' value='$trainerID'>";
                    echo "<button type='submit' class='btn btn-danger'>No Disponible</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
        </table>
        <div class="d-flex flex-column align-items-center">
            <form action="trainerSignIn.php" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Volver a Menu</button>
            </form>
        </div>

        <div class="d-flex flex-column align-items-center">
            <form action="trainerSignIn.html" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Terminar</button>
            </form>
        </div>
    </div>
</body>
</html>



