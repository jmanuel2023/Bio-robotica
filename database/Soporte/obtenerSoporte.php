<?php
    include("../Conexion.php");
    $nombreCurso = $_GET['curso_nombre'];
    $sql = "SELECT * FROM soporte WHERE curso_nombre = '$nombreCurso'";
    $result = mysqli_query($conn, $sql);
    $numeroFilas = mysqli_num_rows($result);

    if ($numeroFilas > 0) {
        $datos = array();
        while ($fila = mysqli_fetch_array($result)) {
            $datos[] = $fila;
        }
        $json_resultado = json_encode($datos);
        header('Content-Type: application/json');
        echo $json_resultado;
    } else {
        echo json_encode(array()); 
    }
?>