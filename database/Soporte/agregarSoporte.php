<?php
include("../Conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);    
    
    $curso_nombre = $data['curso_nombre'];
    $profesor = $data['profesor'];
    $horario = $data['horario'];
    $correo = $data['correo'];

    $sql = "INSERT INTO soporte (curso_nombre, profesor, horario, correo) 
            VALUES ('$curso_nombre', '$profesor', '$horario', '$correo')";

    if (mysqli_query($conn,$sql)) {
        echo "Se ha guardado el profesor que imparte la materia $curso_nombre";
    } else {
        echo "Error al insertar datos: " . $conn->error;
    }
} else {
    
    echo "Error: No se recibieron datos.";
}
?>