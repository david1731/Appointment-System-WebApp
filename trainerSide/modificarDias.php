<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Dias</title>
    <link href="tablaHoras.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .container {
            margin-top: 100px;
        }
        .btn-primary{
            margin-left: 10px;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <!--- Display table of available days to cancel --->
    <div class="container">
        
        <table class="table table-striped table-bordered">
            <tr>
                <th>Fecha</th>
                <th>Eliminar</th>
            </tr>
            <?php
            //var_dump($_POST);
            include 'connection.php';
            $trainerID = isset($_POST['trainerID']) ? $conn->real_escape_string($_POST['trainerID']) : 'trainerID'; //not being used but is needed for the form
            $query = "SELECT fecha FROM fechas";
            $result = mysqli_query($conn, $query);
            echo "<div class='container'>";
            echo "<h2>Modificar Dias</h2>";
            echo "<form action='añadirDia.php' method='post'>";
            echo "<div class='row mb-3'>";
            echo "<div class='col-6'>";
            echo "<label for='name' class='form-label'>Fecha:</label>";
            echo "<input type='hidden' name='trainerID' value='$trainerID'>";
            echo "<input type='text' name='fecha' placeholder='Mes/Dia/Año' class='form-control' required>";
            echo "</div>";
            echo "</div>";
            echo "<button type='submit' class='btn btn-primary'>Modificar Dias</button>";
            echo "</form>";
            echo "</div>";
            echo "<h2>Eliminar Dias</h2>";
            while($row = mysqli_fetch_assoc($result)) {
                $fecha = $row['fecha'];
                
                echo "<tr>";
                echo "<td>" . $fecha ."</td>";
                echo "<td class = horizontal-buttons>";
                echo "<form action='eliminarDias.php' method='post'>";
                echo "<input type='hidden' name='fecha' value=" . $row['fecha'] . ">";
                echo "<input type='hidden' name='trainerID' value='$trainerID'>";
                echo "<button type='submit' class='btn btn-danger'>Eliminar</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <div class="d-flex flex-column align-items-center">
            <form action="trainerSignIn.php" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Volver a Menu</button>
            </form>
        </div>

        <div class="d-flex flex-column align-items-center">
            <form action="trainerSignIn.html" method="post">
                <input type="hidden" name="trainerID" value="<?=$trainerID;?>">
                <button type="submit" class="btn btn-primary">Terminar</button>
            </form>
        </div>
    </div>
        
</body>

</html>