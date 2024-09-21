<?php
include '../../../Bio-Robotica/database/Conexion.php';

if (isset($_POST['agregar_evento'])) {
    $nombre = $_POST['nombre_nuevo_evento'];
    $informacion = $_POST['informacion_nuevo_evento'];
    $nombre_imagen = $_FILES['imagen_nuevo_evento']['name'];
    $tipo_imagen = $_FILES['imagen_nuevo_evento']['type'];
    $tamano_imagen = $_FILES['imagen_nuevo_evento']['size'];
    $temp_imagen = $_FILES['imagen_nuevo_evento']['tmp_name'];
    $fecha = $_POST['fecha_nuevo_evento'];
    $direccion = $_POST['direccion_nuevo_evento']; // Nueva variable para la dirección
    $hora = $_POST['hora_nuevo_evento']; // Nueva variable para la hora
    $enlace = $_POST['enlace_nuevo_evento'];

    $directorio_destino = "../../../Bio-Robotica/img/Eventos/";

    if (!empty($nombre_imagen)) {
        if (move_uploaded_file($temp_imagen, $directorio_destino . $nombre_imagen)) {
            // Modificamos la consulta SQL para incluir los nuevos campos direccion y hora
            $sql = "INSERT INTO eventos (nombre, descripcion, fecha, direccion, hora, imagen, enlace)
                    VALUES ('$nombre', '$informacion', '$fecha', '$direccion', '$hora', '$nombre_imagen', '$enlace')";

            if ($conn->query($sql) === TRUE) {
                header("Location: ../../../../../Bio-Robotica/admin/Eventos.php");
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