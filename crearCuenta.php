<?php
include 'index.php';

// Verify that the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract user inputs from the form
    $name = $conn->real_escape_string($_POST['name']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $cellphone = $conn->real_escape_string($_POST['cellphone']);

    // Check if the client already exists
    function checkIfClientExists($conn, $email, $cellphone) {
        $query = "SELECT clientId FROM clients WHERE email = '$email' AND cellphone = '$cellphone'";
        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }

    $existingClient = checkIfClientExists($conn, $email, $cellphone);

    if ($existingClient) {
        header('Location: signIn.html'); // Redirect to sign-in page if client exists
        exit;
    }

    // Function to generate a unique client ID
    function generateUniqueClientId($conn) {
        $exists = true;
        $user_id = 0;

        while ($exists) {
            $user_id = mt_rand(1000, 9999);
            $query = "SELECT clientId FROM clients WHERE clientId = $user_id";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {  // If no rows, the ID is unique
                $exists = false;
            }
        }
        return $user_id;
    }

    // Create the client ID
    $clientID = generateUniqueClientId($conn);

    // Insert the user information into the table
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


