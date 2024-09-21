<?php
if (isset($_POST['editar_docente'])) {
    include '../../../Bio-Robotica/database/Conexion.php';

    $nombre_docente = $_POST['nombre_docente'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nueva_informacion = $_POST['nueva_informacion'];

    $nombre_imagen = '';

    if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['size'] > 0) {
        // Obtener la imagen actual del docente antes de la actualización
        $sql_select_imagen = "SELECT imagen FROM docentes WHERE nombre=?";
        $stmt = $conn->prepare($sql_select_imagen);
        $stmt->bind_param('s', $nombre_docente);
        $stmt->execute();
        $resultado_select_imagen = $stmt->get_result();

        if ($resultado_select_imagen->num_rows > 0) {
            $fila_imagen = $resultado_select_imagen->fetch_assoc();
            $nombre_imagen_anterior = $fila_imagen["imagen"];

            if (!empty($nombre_imagen_anterior)) {
                $ruta_imagen_anterior = "../../../Bio-Robotica/img/Historia/Profesores/" . $nombre_imagen_anterior;
                if (file_exists($ruta_imagen_anterior)) {
                    unlink($ruta_imagen_anterior);
                }
            }
        }

        // Mover la nueva imagen a la carpeta de destino
        $nombre_imagen = $_FILES['nueva_imagen']['name'];
        $ruta_temporal = $_FILES['nueva_imagen']['tmp_name'];
        $ruta_destino = "../../../Bio-Robotica/img/Historia/Profesores/" . $nombre_imagen;

        if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
            $sql = "UPDATE docentes SET nombre=?, informacion=?, imagen=? WHERE nombre=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $nuevo_nombre, $nueva_informacion, $nombre_imagen, $nombre_docente);
        } else {
            echo "Error al mover la imagen.";
            exit();
        }
    } else {
        $sql = "UPDATE docentes SET nombre=?, informacion=? WHERE nombre=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $nuevo_nombre, $nueva_informacion, $nombre_docente);
    }

    if ($stmt->execute()) {
        echo "Los datos del docente se actualizaron correctamente.";
        header("Location: ../../../../../Bio-Robotica/admin/Historia.php");
        exit();
    } else {
        echo "Error al actualizar los datos del docente: " . $conn->error;
        header("Location: ../../../../../Bio-Robotica/admin/Historia.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>