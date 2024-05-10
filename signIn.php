<?php
include 'index.php';
// var_dump($_POST);
$clientName = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : 'clientName';
$clientLastName = isset($_POST['lastname']) ? $conn->real_escape_string($_POST['lastname']) : 'clientLastName';
$clientEmail = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : 'default@gmail.com';
$clientCell = isset($_POST['cellphone']) ? $conn->real_escape_string($_POST['cellphone']) : 'xxxxxxxx';

function clienteExiste($conn, $clientName, $clientLastName, $clientEmail, $clientCell) {
    $query = "SELECT clientID FROM clients WHERE email = '$clientEmail' AND cellphone = '$clientCell' AND firstName = '$clientName' AND lastName = '$clientLastName'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result)['clientID']; // returns clientID if exists
    }
    return false;
}

$clientID = clienteExiste($conn, $clientName, $clientLastName, $clientEmail, $clientCell);

if (!$clientID) {
    header('Location: crearCuenta.php'); // Redirect to create account page if client does not exist
    exit();
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Info del Cliente</title>
    <meta charset="UTF-8">
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
    </div>
</body>
</html>



