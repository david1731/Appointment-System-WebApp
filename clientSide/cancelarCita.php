<?php
include 'index.php';
//var_dump($_POST);


//To delete the appointment of a client I need the appID but to find the appId I need the clientID, the slot id and the date

//retrieve the clientID, slotID and appDate from the POST request
$clientId = isset($_POST['clientId']) ? $_POST['clientId'] : 0000;
$slotId = isset($_POST['slotID']) ? $_POST['slotID'] : null;
$appDate = isset($_POST['appDate']) ? $_POST['appDate'] : null;

//delete the appointment from the database
$sql = "DELETE FROM appointmentSlots WHERE clientID = '$clientId' AND slotID = '$slotId' AND appDate = '$appDate'";
 
//check if the appointment was deleted successfully
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cancelación de Citas</title>
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
        <h1 class="display-1">Cancelación de Cita</h1>
        <p><?php echo $message; ?></p>
        <div class="card" style="width: 18rem;">
            <img src="cancelarCita.png" class="card-img-top" alt="...">
            <div class="card-body">
                <form action="verCitas.php" method="post">
                    <input type="hidden" name="clientID" value="<?=$clientId;?>">
                    <button type="submit" class="btn btn-primary">Cancelar Otra Cita</button>
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


