<?php
// Database connection setup
include 'index.php'; 

// extraer la data que se va usar 
$timeSlotsQuery = "SELECT slotID, startTime, endTime FROM timeSlots WHERE status = 'Disponible'";
$timeSlotsResult = $conn->query($timeSlotsQuery);

$servicesQuery = "SELECT serviceID, serviceName FROM service";
$servicesResult = $conn->query($servicesQuery);

$levelsQuery = "SELECT levelID, level FROM levels";
$levelsResult = $conn->query($levelsQuery);

$trainersQuery = "SELECT trainerID, trainerName, trainerLastName FROM trainers";
$trainersResult = $conn->query($trainersQuery);

$fechasQuery = "SELECT fecha FROM fechas";
$fechasResult = $conn->query($fechasQuery);


// Extraer el clientID y limpiarlo
//Si el clientID fue enviado por el post y no es nuelo, se limpia para evitar injection attacks
//Si el clientID no fue enviado por post, se asigna un valor por defecto
//var_dump($_POST);

$clientID = isset($_POST['clientID']) ? $conn->real_escape_string($_POST['clientID']) : 'default_client_id';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saca tu Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Separa tu cita</h2>
    <form action="confirmarCita.php" method="post">
        <input type="hidden" name="clientID" value="<?= $clientID; ?>">
        <div class="mb-3">
            <label for="timeSlot" class="form-label">Seleccione una hora:</label>
            <select name="slotID" class="form-select">
                <?php while($row = $timeSlotsResult->fetch_assoc()): ?>
                    <option value="<?= $row['slotID']; ?>"><?= $row['startTime'] . " - " . $row['endTime']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="service" class="form-label">Seleccione un Servicio:</label>
            <select name="serviceID" class="form-select">
                <?php while($row = $servicesResult->fetch_assoc()): ?>
                    <option value="<?= $row['serviceID']; ?>"><?= $row['serviceName']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="level" class="form-label">Seleccion su grado de experiencia:</label>
            <select name="levelID" class="form-select">
                <?php while($row = $levelsResult->fetch_assoc()): ?>
                    <option value="<?= $row['levelID']; ?>"><?= $row['level']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="trainer" class="form-label">Selecciona un entrenador:</label>
            <select name="trainerID" class="form-select">
                <?php while($row = $trainersResult->fetch_assoc()): ?>
                    <option value="<?= $row['trainerID']; ?>"><?= $row['trainerName'] . ' ' . $row['trainerLastName']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Selecciona una fecha:</label>
            <select name="fecha" class="form-select">
                <?php while($row = $fechasResult->fetch_assoc()): ?>
                    <option value="<?= $row['fecha']; ?>"><?= $row['fecha']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Confirmar Cita</button>
    </form>
    
</div>
</body>
</html>
