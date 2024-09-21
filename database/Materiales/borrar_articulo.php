<?php
// Verificar si se ha enviado el formulario para borrar el artículo
if (isset($_POST['borrar_articulo']) && isset($_POST['nombre_articulo'])) {
    $nombre_articulo = $_POST['nombre_articulo'];

    // Incluir el archivo de conexión a la base de datos
    include '../../../Bio-Robotica/database/Conexion.php';

    // Consulta SQL para obtener el nombre de la imagen asociada al artículo
    $sql_select = "SELECT imagen FROM Biblioteca WHERE nombre = ?";
    $stmt_select = $conn->prepare($sql_select);

    if ($stmt_select) {
        // Vincular parámetro y ejecutar la consulta para obtener el nombre de la imagen
        $stmt_select->bind_param("s", $nombre_articulo);
        $stmt_select->execute();
        $stmt_select->bind_result($nombre_imagen);

        // Obtener el resultado de la consulta
        $stmt_select->fetch();

        // Cerrar y liberar el resultado de la consulta SELECT
        $stmt_select->close();

        // Si se encontró un nombre de imagen asociado al artículo, proceder con la eliminación
        if ($nombre_imagen) {
            $ruta_imagen = "../../../Bio-Robotica/library/img/" . $nombre_imagen;
            if (file_exists($ruta_imagen)) {
                unlink($ruta_imagen); // Borrar la imagen del sistema de archivos si existe
            }
        }

        if ($nombre_articulo) {
            $ruta_imagen = "../../../Bio-Robotica/library/" . $nombre_articulo;
            if (file_exists($ruta_imagen)) {
                unlink($ruta_imagen); // Borrar la imagen del sistema de archivos si existe
            }
        }

        // Consulta SQL para eliminar el artículo por nombre
        $sql_delete = "DELETE FROM Biblioteca WHERE nombre = ?";
        $stmt_delete = $conn->prepare($sql_delete);

        if ($stmt_delete) {
            // Vincular parámetro y ejecutar la consulta de eliminación
            $stmt_delete->bind_param("s", $nombre_articulo);
            if ($stmt_delete->execute()) {
                // Borrado exitoso
                echo "Artículo y archivos asociados borrados correctamente.";
                // Redirigir a la página de lista de artículos
                header("Location: ../../../../../Bio-Robotica/admin/Materiales.php");
                exit();
            } else {
                // Error al ejecutar la consulta de eliminación
                echo "Error al intentar borrar el artículo: " . $stmt_delete->error;
            }
        } else {
            // Error al preparar la consulta de eliminación
            echo "Error al preparar la consulta de borrado: " . $conn->error;
        }
    } else {
        // Error al preparar la consulta para obtener el nombre de la imagen asociada al artículo
        echo "Error al obtener el nombre de la imagen asociada al artículo: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si no se han proporcionado los datos necesarios, mostrar un mensaje de error
    echo "Error: No se ha proporcionado el nombre del artículo a borrar.";
}
?>