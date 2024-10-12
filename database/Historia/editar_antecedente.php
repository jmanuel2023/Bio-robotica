<?php
// Verificar si se ha enviado el formulario de edición
if(isset($_POST['editar_antecedente'])) {
    // Incluir el archivo de conexión a la base de datos
    include '../Conexion.php';

    // Obtener los datos del formulario
    $nombre_docente = $_POST['nombre_antecedente'];
    $nuevo_nombre = $_POST['nuevo_nombre2'];
    $nueva_informacion = $_POST['nueva_informacion2'];
    $nombre_imagen = "";

    // Consultar la imagen actual asociada con el registro
    $sql_select = "SELECT imagen FROM antecedentes WHERE nombre='$nombre_docente'";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_imagen_actual = $row['imagen'];

        // Verificar si se cargó una nueva imagen
        if(isset($_FILES['nueva_imagen2']) && $_FILES['nueva_imagen2']['size'] > 0) {
            // Manejar la carga de la nueva imagen
            $nombre_imagen = $_FILES['nueva_imagen2']['name'];
            $ruta_temporal = $_FILES['nueva_imagen2']['tmp_name'];
            $ruta_destino = "../../img/Historia/Antecedentes/" . $nombre_imagen;

            // Eliminar la imagen anterior si existe
            if (!empty($nombre_imagen_actual) && file_exists("../../img/Historia/Antecedentes/" . $nombre_imagen_actual)) {
                unlink("../../img/Historia/Antecedentes/" . $nombre_imagen_actual);
            }

            // Mover la nueva imagen a la carpeta de destino
            if(move_uploaded_file($ruta_temporal, $ruta_destino)) {
                // Actualizar la ruta de la imagen en la base de datos
                $sql_update = "UPDATE antecedentes SET nombre='$nuevo_nombre', informacion='$nueva_informacion', imagen='$nombre_imagen' WHERE nombre='$nombre_docente'";
            } else {
                // Manejar errores de carga de imagen
                echo "Error al cargar la imagen.";
                exit();
            }
        } else {
            // Si no se cargó una nueva imagen, realizar la actualización sin cambiar la imagen
            $sql_update = "UPDATE antecedentes SET nombre='$nuevo_nombre', informacion='$nueva_informacion' WHERE nombre='$nombre_docente'";
        }

        // Ejecutar la consulta de actualización
        if ($conn->query($sql_update) === TRUE) {
            // Redirigir después de la actualización exitosa
            $conn->close();
            header("Location: ../../admin/Historia.php");
            exit();
        } else {
            // Manejar errores en la consulta SQL
            echo "Error al actualizar los datos del docente: " . $conn->error;
            $conn->close();
            exit();
        }
    } else {
        // Registro no encontrado
        echo "Registro no encontrado.";
        $conn->close();
        exit();
    }
} else {
    // Si no se envió el formulario correctamente, redirigir de vuelta
    header("Location: ../../admin/Historia.php");
    exit();
}
?>