<?php
    include '../../../Bio-Robotica/database/Conexion.php';
    if (isset($_POST['agregar_antecedente'])) {
        $nombre = $_POST['nombre_nuevo_antecedente'];
        $informacion = $_POST['informacion_nuevo_antecedente'];
        $nombre_imagen = $_FILES['imagen_nuevo_antecedente']['name'];
        $tipo_imagen = $_FILES['imagen_nuevo_antecedente']['type'];
        $tamano_imagen = $_FILES['imagen_nuevo_antecedente']['size'];
        $temp_imagen = $_FILES['imagen_nuevo_antecedente']['tmp_name'];
        $directorio_destino = "../../../Bio-Robotica/img/Historia/Antecedentes/";
        if (!empty($nombre_imagen)) {
            if (move_uploaded_file($temp_imagen, $directorio_destino . $nombre_imagen)) {
                $sql = "INSERT INTO antecedentes (nombre, informacion, imagen) VALUES ('$nombre', '$informacion', '$nombre_imagen')";
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