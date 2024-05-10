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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Confirmation</title>
    <link href="crearCuenta.css" rel="stylesheet">
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
            <form action="homePage.html">
                <button type="submit" class="btn btn-primary">Terminar</button>
            </form>
        </div>
    </div>
</body>
</html>


