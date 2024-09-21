<?php
// Detalles de la conexión
$servername = 'localhost';
$username = 'root';
$password = '1234';
$dbname = 'biorobotica';

$conn = new mysqli($servername, $username, $password, $dbname);


// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
