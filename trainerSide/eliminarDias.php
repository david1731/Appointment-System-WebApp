<?php 
include 'connection.php';
$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : 'Mes/Dia/Año';
$trainerID = isset($_POST['trainerID']) ? $_POST['trainerID'] : 00000;

$sql = "DELETE FROM fechas WHERE fecha = '$fecha'";

if ($conn->query($sql) === TRUE) {
    $message = "Dia eliminado correctamente.";
} else {
    $message =  "Error al eliminar dia: " . $conn->error;
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
        <h1>Eliminación de Dias</h1>
        <p><?php echo $message; ?></p>
        <div class="d-flex flex-column align-items-center">
            <form action="modificarDias.php" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Eliminar Otro Día</button>
            </form>
        </div>
        <div class="d-flex flex-column align-items-center">
            <form action="trainerSignIn.php" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Volver a Menu</button>
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


