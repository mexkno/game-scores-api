<?php
$servername = "mysql-xyz.clever-cloud.com";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "GameScores";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener las puntuaciones ordenadas de mayor a menor
$sql = "SELECT player_name, score, time_played, date FROM scores ORDER BY score DESC";
$result = $conn->query($sql);

$scores = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $scores[] = $row;
    }
}

echo json_encode($scores);

$conn->close();
?>
