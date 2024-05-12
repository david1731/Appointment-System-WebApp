<?php
include 'connection.php';
//Cambiar cita de No disponible a Disponible
$slotID = isset($_POST['slotID']) ? $_POST['slotID'] : null;

$sql = "UPDATE timeSlots SET statusHora = 'Disponible' WHERE slotID = '$slotID'";

if ($conn->query($sql) === TRUE) {
    $message = "Hora cambiada a Disponible correctamente.";
} else {
    $message =  "Error al cambiar hora a Disponible: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Status de Hora</title>
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
        <h1>Cambio de Status</h1>
        <p><?php echo $message; ?></p>
        <div class="d-flex flex-column align-items-center">
            <form action="despliegaHoras.php" method="post">
                <button type="submit" class="btn btn-primary">Editar Otra Hora</button>
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

