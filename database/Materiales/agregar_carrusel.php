<?php
include '../../../Bio-Robotica/database/Conexion.php';

if (isset($_POST['agregar_carrusel'])) {
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $nombre_imagen_file = $_FILES['imagen']['name'];
    $temp_imagen = $_FILES['imagen']['tmp_name'];
    $directorio_destino = "../../../Bio-Robotica/img/carrusel-materiales/";

    if (!empty($nombre_imagen_file)) {
        $nombre_imagen = uniqid() . '_' . $nombre_imagen_file;
¿
        if (move_uploaded_file($temp_imagen, $directorio_destino . $nombre_imagen)) {
            $stmt = $conn->prepare("INSERT INTO carrusel (categoria, nombre_imagen, descripcion) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $categoria, $nombre_imagen, $descripcion);

            if ($stmt->execute()) {
                header("Location: ../../../../../Bio-Robotica/admin/Materiales.php");
                exit();
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->error;
            }
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "Por favor, seleccione una imagen.";
    }
}

$conn->close();
?>