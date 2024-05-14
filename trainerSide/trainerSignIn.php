<?php
include 'connection.php';
//var_dump($_POST);
$trainerID = isset($_POST['trainerID']) ? $conn->real_escape_string($_POST['trainerID']): 'trainerID';

function validarTrainer($conn, $trainerID) {
    $query = "SELECT trainerID FROM trainers WHERE trainerID = '$trainerID'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;
}

$validTrainer = validarTrainer($conn, $trainerID);
if (!$validTrainer) {
    header('Location: trainerSignIn.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Menu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <link href="trainerMenu.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
    <div class="container">
        <h1 class="display-1">¿Que desea hacer?</h1>

        <div class="container1">
            <div class="card" style="width: 18rem;">
                <img src="verCitas.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <form action="trainerCitas.php" method="post">
                        <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                        <button type="submit" class="btn btn-primary">Ver Citas</button>
                    </form>
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <img src="modificarHoras.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <form action="despliegaHoras.php" method="post">
                        <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                        <button type="submit" class="btn btn-primary">Modificar Horas</button>
                    </form>
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <img src="modificarDias.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <form action="modificarDias.php" method="post">
                        <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                        <button type="submit" class="btn btn-primary">Modificar Dias</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>
