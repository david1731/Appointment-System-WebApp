<?php
include 'index.php';

// verificar que el form fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extraere los user inputs del form
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $cellphone = $_POST['cellphone'];

    //Funcion que genera id unico para cada cliente
    function generateUniqueClientId($conn) {
        $exists = true;
        $user_id = 0;

        while ($exists) {
            $user_id = mt_rand(1000, 9999);  
            $query = "SELECT clientId FROM clients WHERE clientId = $user_id";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {  // Si no hay filas, el id es unico
                $exists = false;
            }
        }
        return $user_id;
    }

    // crear el id del cliente
    $clientID = generateUniqueClientId($conn);

    //Inserta la informacion del usuario a la tabla
    $sql = "INSERT INTO clients (clientId, firstName, lastName, email, cellphone) VALUES ($clientID, '$name', '$lastname', '$email', '$cellphone')";

    if ($conn->query($sql) === TRUE) {
        $message = "Su cuenta se ha creado.";
    } else {
        $message = "Error: " . $conn->error;
    }

    $conn->close();
} else {
    $message = "Please submit the form.";
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
        h1{
            background-color: white;
        }
        div{
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Status de Registración</h1>
        <p><?php echo $message; ?></p>
        <h1>Que desea hacer?</h1>
        <div class="d-flex flex-column align-items-center">
            <form action="sacarCita.php" method="post">
                <input type="hidden" name="clientID" value="<?=$clientID;?>">
                <button type="submit" class="btn btn-primary">Sacar Cita</button>
            </form>
        </div>
        <a href="homePage.html" class="button-link">Volver a la página principal</a>
    </div>
</body>
</html>


