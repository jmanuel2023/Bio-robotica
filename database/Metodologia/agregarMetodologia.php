<?php
include("../Conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);    
    if (isset($data['opciones'])) {
        $opciones = $data['opciones'];
        $curso_nombre = $data['curso_nombre'];
        $inductiva = isset($opciones['inductivo']) ? $opciones['inductivo'] : 0;
        $deductiva = isset($opciones['deductivo']) ? $opciones['deductivo'] : 0;
        $heuristica = isset($opciones['heuristico']) ? $opciones['heuristico'] : 0;
        $analogico = isset($opciones['analogico']) ? $opciones['analogico'] : 0;


    
    $sql = "INSERT INTO metodo_curso (curso_nombre, inductivo, deductivo, heuristico, analogico) 
            VALUES ('$curso_nombre', $inductiva, $deductiva, $heuristica, $analogico)";

    if (mysqli_query($conn,$sql)) {
        echo "Se ha guardado la metodologia de enseñanza de la materia $curso_nombre";
    } else {
        echo "Error al insertar datos: " . $conn->error;
    }
}else {
    
    echo "Error: No se recibieron opciones.";
}
} else {
    
    echo "Error: No se recibieron datos.";
}
?>