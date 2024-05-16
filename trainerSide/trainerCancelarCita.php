<?php
//var_dump($_POST);
include 'connection.php';
//retrieve appID so trainer can delete a specific appointment
$appID = isset($_POST['appID']) ? $conn->real_escape_string($_POST['appID']) : 'appID';
$trainerID = isset($_POST['trainerID']) ? $conn->real_escape_string($_POST['trainerID']) : 'trainerID';

$sql = "DELETE FROM appointmentSlots WHERE appID = '$appID'"; //delete the appointment from the table appointmentSlots
if ($conn->query($sql) === TRUE) { //confirmation message if the query is executed correctly
    $message = "Cita cancelada correctamente.";
} else {
    $message =  "Error al cancelar cita: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
        }
        .container {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
        <h1>Cancelacion de Cita</h1>
        <p><?php echo $message; ?></p>
        <div class="d-flex flex-column align-items-center">
            <form action="trainerCitas.php" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Cancelar Otra Cita</button>
        </form>
        </div>
        <div class="d-flex flex-column align-items-center">
            <form action="trainerSignIn.html">
                <button type="submit" class="btn btn-primary">Terminar</button>
            </form>
        </div>
    </div>
</body>
</html>