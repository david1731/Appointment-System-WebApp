<?php 
include 'connection.php';
//This file is for the trainer to add which days will he be available to work
//var_dump($_POST);

//Fetch trainerID from post and the date from post 
$trainerID = isset($_POST['trainerID']) ? $conn->real_escape_string($_POST['trainerID']): 'trainerID';
$fecha = isset($_POST['fecha']) ? $conn->real_escape_string($_POST['fecha']): 'fecha';
$query = "INSERT INTO fechas (fecha) VALUES ('$fecha')"; //query to insert tha values into the table fechas

if ($conn->query($query) === TRUE) { //If query executes correctly, a confirmation messaged is displayed
    $message = "Dia añadido exitosamente";
} else {
    $message = "Error: " . $query . "<br>" . $conn->error;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modificación de Dias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        h1{
            background-color: white;
        }
        div{
            margin: 10px;
        }
        .container{
            text-align: center;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Modificación de Dias</h1>
        <p><?php echo $message; ?></p>
        <h1>Que desea hacer?</h1>
        <!--Modificar otro dia --->
        <!--Volver a menu --->
        <!--Terminar--->
        <div class="d-flex flex-column align-items-center">
            <form action="modificarDias.php" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Modificar Otro Dia</button>
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


