<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
//var_dump($_POST);
include 'index.php';

//exectute only if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //retrieve the clientID, slotID, serviceID, levelID, trainerID and date from the POST request
    $clientID = $conn->real_escape_string($_POST['clientID']);
    $slotID = $conn->real_escape_string($_POST['slotID']);
    $serviceID = $conn->real_escape_string($_POST['serviceID']);
    $levelID = $conn->real_escape_string($_POST['levelID']);
    $trainerID = $conn->real_escape_string($_POST['trainerID']);
    // $date = $conn->real_escape_string($_POST['fecha']): "Fecha Vacia";
    $date = isset($_POST['fecha']) ? $_POST['fecha'] : 'Fecha Vacia';

    // Check if appointment slot is available
    if (verificarCita($conn, $slotID, $date)) {
        $app_id = generateUniqueAppId($conn); // Generate a unique appointment ID
        $stmt = $conn->prepare("INSERT INTO appointmentSlots (appID, slotID, clientID, levelID, trainerID, serviceID, appDate) VALUES (?, ?, ?, ?, ?, ?, ?)"); // Prepare an insert statement
        $stmt->bind_param('iiiiiis', $app_id, $slotID, $clientID, $levelID, $trainerID, $serviceID, $date); // Bind variables to the prepared statement as parameters
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $message = "Su cita ha sido confirmada";
        } else {
            $message = "No se pudo confirmar su cita: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        // If the appointment slot is not available
        $message = "La hora seleccionada ya está ocupada. Por favor, elija otra hora.";
       }
    
    $conn->close();
} else {
    $message = "Oops, hubo un problema.";
}

//function to check if the appointment slot is available
function verificarCita($conn, $slotID, $date){
    $query = "SELECT * FROM appointmentSlots WHERE slotID = $slotID AND appDate = '$date'"; // Query to check if the appointment slot is available
    $result = mysqli_query($conn, $query); // Execute the query
    return mysqli_num_rows($result) == 0; // returns ture if the query returns 0 rows, the appointment slot is available or false if the query returns more than 0 rows, the appointment slot is not available
}

//function to generate a unique appointment ID
function generateUniqueAppId($conn) {
    $exists = true;
    $app_id = 0; //id initiliazed to 0

    while ($exists) {
        $app_id = mt_rand(100000, 999999); //built in function to generate random number in the given range
        $query = "SELECT appID FROM appointmentSlots WHERE appID = $app_id"; // Query to check if the appointment ID already exists
        $result = mysqli_query($conn, $query); //exectue the query and store the result in $result

        if (mysqli_num_rows($result) == 0) { //if the query returns 0 rows, the appointment ID is unique
            $exists = false;
        }
    }
    return $app_id;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <title>Confirmacion de Cita</title>
    <link href="crearCuenta.css" rel="stylesheet">
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
        .container1 {
            display: flex;
            flex-direction: row;
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
        <h1 class="display-1">Confirmación de cita</h1>
        <p><?php echo $message; ?></p>
        
        <div class="container1">
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
        

        <div class="d-flex flex-column align-items-center">
            <form action="homePage.html">
                <button type="submit" class="btn btn-primary">Terminar</button>
            </form>
        </div>
    </div>

    
</body>
</html>

