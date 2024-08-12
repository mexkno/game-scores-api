<?php
$servername = "mysql-xyz.clever-cloud.com";  // Host proporcionado por Clever Cloud
$username = "tu_usuario";                    // Usuario MySQL proporcionado
$password = "tu_contraseña";                 // Contraseña proporcionada
$dbname = "GameScores";                      // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos enviados desde la aplicación
$player_name = $_POST['player_name'];
$score = $_POST['score'];
$time_played = $_POST['time_played'];

// Verificar si el jugador ya existe
$sql = "SELECT * FROM scores WHERE player_name = '$player_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Si el jugador ya existe, verificar si la nueva puntuación es mayor
    $row = $result->fetch_assoc();
    if ($score > $row['score']) {
        // Actualizar la puntuación existente
        $update_sql = "UPDATE scores SET score = '$score', time_played = '$time_played', date = NOW() WHERE player_name = '$player_name'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Puntuación actualizada exitosamente";
        } else {
            echo "Error actualizando la puntuación: " . $conn->error;
        }
    } else {
        echo "Puntuación no actualizada. La nueva puntuación no es mayor.";
    }
} else {
    // Insertar nuevo registro
    $insert_sql = "INSERT INTO scores (player_name, score, time_played) VALUES ('$player_name', '$score', '$time_played')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "Puntuación registrada exitosamente";
    } else {
        echo "Error registrando la puntuación: " . $conn->error;
    }
}

$conn->close();
?>
