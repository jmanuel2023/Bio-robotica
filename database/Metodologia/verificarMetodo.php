<?php
include("../Conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $curso_nombre = $data['nombre_curso'];
    $sql = "SELECT COUNT(*) AS total FROM metodo_curso WHERE curso_nombre = '$curso_nombre'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['total'] > 0) {
        echo "1";
        } else {
            echo "0";
        }
    } else {
        echo "Error al insertar datos: " . $conn->error;
    }
} else {
    echo "Error: No se recibieron datos.";
}
?>
