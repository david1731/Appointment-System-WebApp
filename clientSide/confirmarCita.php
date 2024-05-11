<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
//var_dump($_POST);
include 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientID = $conn->real_escape_string($_POST['clientID']);
    $slotID = $conn->real_escape_string($_POST['slotID']);
    $serviceID = $conn->real_escape_string($_POST['serviceID']);
    $levelID = $conn->real_escape_string($_POST['levelID']);
    $trainerID = $conn->real_escape_string($_POST['trainerID']);
    $date = $conn->real_escape_string($_POST['fecha']);

    // Verificar si la cita está disponible
    if (verificarCita($conn, $slotID, $date)) {
        $app_id = generateUniqueAppId($conn);
        $stmt = $conn->prepare("INSERT INTO appointmentSlots (appID, slotID, clientID, levelID, trainerID, serviceID, appDate) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('iiiiiis', $app_id, $slotID, $clientID, $levelID, $trainerID, $serviceID, $date);
        
        if ($stmt->execute()) {
            $message = "Su cita ha sido confirmada";
        } else {
            $message = "No se pudo confirmar su cita: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        $message = "La hora seleccionada ya está ocupada. Por favor, elija otra hora.";
        // Aquí podrías agregar un redireccionamiento o algún mecanismo para reintentar.
    }
    
    $conn->close();
} else {
    $message = "Oops, hubo un problema.";
}

function verificarCita($conn, $slotID, $date){
    $query = "SELECT * FROM appointmentSlots WHERE slotID = $slotID AND appDate = '$date'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) == 0; // devuelve false si la cita ya está ocupada
}

function generateUniqueAppId($conn) {
    $exists = true;
    $app_id = 0;

    while ($exists) {
        $app_id = mt_rand(100000, 999999);
        $query = "SELECT appID FROM appointmentSlots WHERE appID = $app_id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 0) {
            $exists = false;
        }
    }
    return $app_id;
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
        <h1>Confirmación de cita</h1>
        <p><?php echo $message; ?></p>

        <div class="d-flex flex-column align-items-center">
            <form action="sacarCita.php" method="post">
                <input type="hidden" name="clientID" value="<?=$clientID;?>">
                <button type="submit" class="btn btn-primary">Sacar Cita</button>
            </form>
        </div>

        <div class="d-flex flex-column align-items-center">
            <form action="verCitas.php" method="post">
                <input type="hidden" name="clientID" value="<?=$clientID;?>">
                <button type="submit" class="btn btn-primary">Ver/Cancelar Mis Citas</button>
            </form>
        </div>

        <div class="d-flex flex-column align-items-center">
            <form action="homePage.html">
                <button type="submit" class="btn btn-primary">Terminar</button>
            </form>
        </div>
    </div>

    
</body>
</html>

