<?php
    include '../../../Bio-Robotica/database/Conexion.php';
    if (isset($_POST['agregar_docente'])) {
        $nombre = $_POST['nombre_nuevo_docente'];
        $informacion = $_POST['informacion_nuevo_docente'];
        $nombre_imagen = $_FILES['imagen_nuevo_docente']['name'];
        $tipo_imagen = $_FILES['imagen_nuevo_docente']['type'];
        $tamano_imagen = $_FILES['imagen_nuevo_docente']['size'];
        $temp_imagen = $_FILES['imagen_nuevo_docente']['tmp_name'];
        $directorio_destino = "../../../Bio-Robotica/img/Historia/Profesores/";
        if (!empty($nombre_imagen)) {
            if (move_uploaded_file($temp_imagen, $directorio_destino . $nombre_imagen)) {
                $sql = "INSERT INTO docentes (nombre, informacion, imagen) VALUES ('$nombre', '$informacion', '$nombre_imagen')";
                if ($conn->query($sql) === TRUE) {
                    header("Location: ../../../../../Bio-Robotica/admin/Historia.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
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