<?php
include 'index.php'; 
// Define the function to check if a client exists
function clienteExiste($conn, $clientName, $clientLastName, $clientEmail, $clientCell) {
    // Properly escape all input to help prevent SQL injection
    $clientName = $conn->real_escape_string($clientName);
    $clientLastName = $conn->real_escape_string($clientLastName);
    $clientEmail = $conn->real_escape_string($clientEmail);
    $clientCell = $conn->real_escape_string($clientCell);

    // Query to check if the client exists
    $query = "SELECT clientID FROM clients WHERE email = '$clientEmail' AND cellphone = '$clientCell' AND firstName = '$clientName' AND lastName = '$clientLastName'";
    $result = mysqli_query($conn, $query); // Execute the query and store the result in a variable
    if (mysqli_num_rows($result) > 0) { // If the query returns more than 0 rows
        return mysqli_fetch_assoc($result)['clientID']; // returns clientID if exists
    }
    return false;
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract user inputs from the form
    $clientName = $_POST['name'];
    $clientLastName = $_POST['lastname'];
    $clientEmail = $_POST['email'];
    $clientCell = $_POST['cellphone'];

    // Check if client already exists
    $clientID = clienteExiste($conn, $clientName, $clientLastName, $clientEmail, $clientCell);

    if ($clientID) {
        // Client exists, redirect to sign in page
        header('Location: redirectSignUp.html');
        exit();
    } else {
        // Client does not exist, continue with registration
        // Function to generate a unique client ID
        function generateUniqueClientId($conn) {
            $exists = true;
            $user_id = 0;

            while ($exists) {
                $user_id = mt_rand(1000, 9999); //generates a random four digit ID
                $query = "SELECT clientId FROM clients WHERE clientId = $user_id"; // Query to check if the ID already exists
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 0) {  // If no rows, the ID is unique
                    $exists = false;
                }
            }
            return $user_id;
        }

        // Generate a new unique client ID
        $newClientID = generateUniqueClientId($conn);

        // Insert the new client into the database
        $sql = "INSERT INTO clients (clientId, firstName, lastName, email, cellphone) VALUES ('$newClientID', '$clientName', '$clientLastName', '$clientEmail', '$clientCell')";

        // Check if the client was created successfully
        if ($conn->query($sql) === TRUE) {
            $message = "Su cuenta se ha creado exitosamente.";
        } else {
            $message = "Error al crear cuenta: " . $conn->error;
        }

        $conn->close();
    }
} else {
    $message = "Por favor, envíe el formulario.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        .container{
            text-align: center;
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
                <input type="hidden" name="clientID" value="<?=$newClientID;?>">
                <button type="submit" class="btn btn-primary">Sacar Cita</button>
            </form>
        </div>
        <a href="homePage.html" class="button-link">Volver a la página principal</a>
    </div>
</body>
</html>


