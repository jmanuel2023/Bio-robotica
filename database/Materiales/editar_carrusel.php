<?php
include '../Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $nuevoNombreImagen = $_POST['nombre_imagen'];
        $nuevaDescripcion = $_POST['descripcion'];

        // Verificar si se ha subido una nueva imagen
        if ($_FILES['nueva_imagen']['name'] != '') {
            // Eliminar la imagen anterior
            $sql_select_imagen = "SELECT nombre_imagen FROM carrusel WHERE id = $id";
            $result = $conn->query($sql_select_imagen);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $imagenAnterior = $row['nombre_imagen'];
                // Eliminar el archivo físico de la imagen anterior si existe
                if (file_exists('../../img/carrusel-materiales/' . $imagenAnterior)) {
                    unlink('../../img/carrusel-materiales/' . $imagenAnterior);
                }
            }

            // Subir la nueva imagen
            $nombreArchivo = $_FILES['nueva_imagen']['name'];
            $rutaTemporal = $_FILES['nueva_imagen']['tmp_name'];
            $rutaDestino = '../../img/carrusel-materiales/'. $nombreArchivo ;

            // Mover el archivo temporal a la ubicación deseada
            move_uploaded_file($rutaTemporal, $rutaDestino);

            // Actualizar el registro en la base de datos con el nuevo nombre de imagen
            $sql_update = "UPDATE carrusel SET nombre_imagen = '$nombreArchivo', descripcion = '$nuevaDescripcion' WHERE id = $id";
        } else {
            // No se subió una nueva imagen, solo actualizar la descripción
            $sql_update = "UPDATE carrusel SET descripcion = '$nuevaDescripcion' WHERE id = $id";
        }

        // Ejecutar la consulta de actualización
        if ($conn->query($sql_update) === TRUE) {
            echo "Registro actualizado correctamente.";
        } else {
            echo "Error al actualizar el registro: " . $conn->error;
        }
    }
}

// Redirigir de vuelta a la página principal después de la actualización
header("Location: ../../../../../Bio-Robotica/admin/Materiales.php");
exit();
?>