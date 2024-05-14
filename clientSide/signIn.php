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
    header('Location: redirectSigin.html'); // Redirect to create account page if client does not exist
    exit();
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Menu de Opciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
            margin: 0; /* Ensure there is no default margin */
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100% - 40px); /* Adjust height to account for h1 */
        }
        h1 {
            text-align: center;
            width: 100%; /* Ensure it spans the full width */
            position: absolute; /* Position it absolutely within the body */
            top: 0; /* Align it at the top */
            margin-top: 350px; /* Provide some space from the top */
        }
        .card {
            margin: 10px; /* Maintain margin for separation */
        }
        
    </style>
</head>
<body>
    <h1 class="display-1">¿Que desea hacer?</h1>
    <div class="container">

        <div class="card" style="width: 18rem;">
            <img src="verCitas.png" class="card-img-top" alt="...">
            <div class="card-body">
                <form action="sacarCita.php" method="post">
                    <input type="hidden" name="clientID" value="<?=$clientID;?>">
                    <button type="submit" class="btn btn-primary">Sacar Cita</button>
                </form>
            </div>
        </div>

        <div class="card" style="width: 18rem;">
            <img src="cancelarCita.png" class="card-img-top" alt="...">
            <div class="card-body">
                <form action="verCitas.php" method="post">
                    <input type="hidden" name="clientID" value="<?=$clientID;?>">
                    <button type="submit" class="btn btn-primary">Ver/Cancelar Mis Citas</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

