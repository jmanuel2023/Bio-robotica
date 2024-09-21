<?php
include '../../../Bio-Robotica/database/Conexion.php';

if (isset($_POST['agregar_articulo'])) {
    $nombre_pdf_file = $_FILES['nuevo_articulo']['name'];
    $nombre_imagen_file = $_FILES['imagen_nuevo_articulo']['name'];
    $directorio_destino_pdf = "../../../Bio-Robotica/library/";
    $directorio_destino_imagen = "../../../Bio-Robotica/library/img/";

    if (!empty($nombre_pdf_file) && !empty($nombre_imagen_file)) {
        $nombre_pdf = uniqid() . '_' . $nombre_pdf_file;
        $nombre_imagen = uniqid() . '_' . $nombre_imagen_file;

        // Mover los archivos al directorio destino
        if (move_uploaded_file($_FILES['nuevo_articulo']['tmp_name'], $directorio_destino_pdf . $nombre_pdf) &&
            move_uploaded_file($_FILES['imagen_nuevo_articulo']['tmp_name'], $directorio_destino_imagen . $nombre_imagen)) {

            // Preparar la consulta para insertar en la tabla Biblioteca
            $stmt = $conn->prepare("INSERT INTO Biblioteca (nombre, imagen) VALUES (?, ?)");
            $stmt->bind_param("ss", $nombre_pdf, $nombre_imagen);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                header("Location: ../../../../../Bio-Robotica/admin/Materiales.php");
                exit();
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->error;
            }
        } else {
            echo "Error al subir los archivos.";
        }
    } else {
        echo "Por favor, seleccione tanto el PDF como la imagen.";
    }
}

$conn->close();
?>