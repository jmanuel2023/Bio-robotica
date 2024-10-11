<?php
include '../Conexion.php';

if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Consulta SQL para obtener el nombre de la imagen antes de borrar el registro
    $sql_select_imagen = "SELECT nombre_imagen FROM carrusel WHERE id = $id";
    $result = $conn->query($sql_select_imagen);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombreImagen = $row['nombre_imagen'];

        // Eliminar el registro de la base de datos
        $sql_delete = "DELETE FROM carrusel WHERE id = $id";

        if ($conn->query($sql_delete) === TRUE) {
            // Eliminar el archivo de imagen físico si existe
            if (!empty($nombreImagen) && file_exists('ruta_a_tu_directorio_de_imagenes/' . $nombreImagen)) {
                unlink('ruta_a_tu_directorio_de_imagenes/' . $nombreImagen);
            }
            echo "Registro eliminado correctamente.";
        } else {
            echo "Error al eliminar el registro: " . $conn->error;
        }
    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "Parámetros incorrectos para eliminar.";
}

// Redirigir de vuelta a la página principal después de la eliminación
header("Location: ../../../../../biorobotica2/admin/Materiales.php");
exit();
?>