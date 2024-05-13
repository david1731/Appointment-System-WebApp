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
    </style>
</head>

<body>
    <!-- user input to modify available days -->
    <div class="container">
        <h2>Modificar Dias</h2>
        <form action="añadirDia.php" method="post">
            <div class="row mb-3">
                <div class="col-6">
                    <label for="name" class="form-label">Fecha:</label>
                    <input type="text" name="fecha" placeholder="Mes/Dia/Año" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Modificar Dias</button>
        </form>
    </div>

    <!--- Display table of available days to cancel --->
    <div class="container">
        <h2>Eliminar Dias</h2>
        <table class="table table-striped table-bordered">
            <tr>
                <th>Fecha</th>
                <th>Eliminar</th>
            </tr>
            <?php
            include 'connection.php';

            $query = "SELECT fecha FROM fechas";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result)) {
                $fecha = $row['fecha'];
                
                echo "<tr>";
                echo "<td>" . $fecha ."</td>";
                echo "<td class = horizontal-buttons>";
                echo "<form action='eliminarDia.php' method='post'>";
                echo "<input type='hidden' name='fecha' value=" . $row['fecha'] . ">";
                echo "<button type='submit' class='btn btn-danger'>Eliminar</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        
    </div>
</body>

</html>