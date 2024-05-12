<?php
include 'connection.php';
$trainerID = isset($_POST['trainerID']) ? $conn->real_escape_string($_POST['trainerID']): 'trainerID';

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Menu</title>
    <meta charset="UTF-8">
    <link href="menu.css" rel="stylesheet">
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
        div{
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Que desea hacer?</h1>
        <div class="d-flex flex-column align-items-center">
            <form action="trainerCitas.php" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Ver Citas</button>
            </form>
        </div>

        <div class="d-flex flex-column align-items-center">
            <form action="despliegaHoras.php" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Modificar Horas</button>
            </form>
        </div>

        <div class="d-flex flex-column align-items-center">
            <form action="modificarDias.php" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Modificar Dias</button>
            </form>
        </div>
    </div>
</body>
</html>
