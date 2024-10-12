<?php
// Verificar si se ha enviado el formulario de edición
if (isset($_POST['editar_evento'])) {
    // Incluir el archivo de conexión a la base de datos
    include '../../../biorobotica2/database/Conexion.php';

    // Obtener los datos del formulario (después de validar y limpiarlos)
    $nombre_evento = $_POST['nombre_evento'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nueva_informacion = $_POST['nueva_informacion'];
    $nuevo_fecha = $_POST['fecha_nuevo_evento'];
    $nueva_direccion = $_POST['nueva_direccion'];
    $nueva_hora = $_POST['nueva_hora'];
    $nuevo_enlace = $_POST['nuevo_enlace'];

    // Consultar la imagen actual asociada con el evento
    $sql_select = "SELECT imagen FROM eventos WHERE nombre=?";
    $stmt = $conn->prepare($sql_select);
    $stmt->bind_param("s", $nombre_evento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_imagen_actual = $row['imagen'];

        // Verificar si se cargó una nueva imagen
        if (!empty($_FILES['nueva_imagen']['name'])) {
            // Manejar la carga de la nueva imagen
            $nombre_imagen = $_FILES['nueva_imagen']['name'];
            $ruta_temporal = $_FILES['nueva_imagen']['tmp_name'];
            $ruta_destino = "../../img/Eventos/" . $nombre_imagen;

            // Eliminar la imagen anterior si existe
            if (!empty($nombre_imagen_actual) && file_exists("../../img/Eventos/" . $nombre_imagen_actual)) {
                unlink("../../img/Eventos/" . $nombre_imagen_actual);
            }

            // Mover la nueva imagen a la carpeta de destino
            if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
                // Actualizar la ruta de la imagen en la base de datos
                $sql_update = "UPDATE eventos SET nombre=?, descripcion=?, fecha=?, direccion=?, hora=?, imagen=?, enlace=? WHERE nombre=?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ssssssss", $nuevo_nombre, $nueva_informacion, $nuevo_fecha, $nueva_direccion, $nueva_hora, $nombre_imagen, $nuevo_enlace, $nombre_evento);
            } else {
                // Manejar errores de carga de imagen
                echo "Error al cargar la nueva imagen.";
                exit();
            }
        } else {
            // Si no se cargó una nueva imagen, realizar la actualización sin cambiar la imagen
            $sql_update = "UPDATE eventos SET nombre=?, descripcion=?, fecha=?, direccion=?, hora=?, enlace=? WHERE nombre=?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("sssssss", $nuevo_nombre, $nueva_informacion, $nuevo_fecha, $nueva_direccion, $nueva_hora, $nuevo_enlace, $nombre_evento);
        }

        // Ejecutar la consulta de actualización
        if ($stmt_update->execute()) {
            // Redirigir después de la actualización exitosa
            $stmt_update->close();
            $conn->close();
            header("Location: ../../admin/Eventos.php");
            exit();
        } else {
            // Manejar errores en la consulta SQL
            echo "Error al actualizar los datos del evento: " . $stmt_update->error;
            $stmt_update->close();
            $conn->close();
            exit();
        }
    } else {
        // Registro no encontrado
        echo "Registro de evento no encontrado.";
        $conn->close();
        exit();
    }
} else {
    // Si no se envió el formulario correctamente, redirigir de vuelta
    header("Location: ../../admin/Eventos.php");
    exit();
}
?>