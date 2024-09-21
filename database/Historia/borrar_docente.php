<?php
// Incluir archivo de conexión a la base de datos
include '../../../Bio-Robotica/database/Conexion.php';
    // Verificar si se está intentando borrar un docente
    if(isset($_POST['borrar_docente'])){
        // Obtener el nombre del docente a borrar
        $nombre_docente = $_POST['nombre_docente'];
        // Consulta SQL para obtener información del docente (incluida la imagen)
        $sql_select = "SELECT nombre, imagen FROM docentes WHERE nombre='$nombre_docente'";
        $result = $conn->query($sql_select);
        if ($result->num_rows > 0) {
            // Obtener datos del docente (en este caso, la imagen)
            $row = $result->fetch_assoc();
            $imagen_docente = $row['imagen'];

            // Consulta SQL para eliminar el docente de la base de datos
            $sql_delete = "DELETE FROM docentes WHERE nombre='$nombre_docente'";
            // Ejecutar la consulta de eliminación
            if ($conn->query($sql_delete) === TRUE) {
                // Ruta de la imagen asociada al docente
                $ruta_imagen = "../../../Bio-Robotica/img/Historia/Profesores/$imagen_docente";

                // Verificar si la imagen existe y eliminarla
                if(file_exists($ruta_imagen)){
                    unlink($ruta_imagen);
                }
                // Redirigir después de la eliminación exitosa
                header("Location: ../../../../../Bio-Robotica/admin/Historia.php");
                exit();
            } else {
                // Manejar errores durante la eliminación en la base de datos
                echo "Error al borrar el docente: " . $conn->error;
                header("Location: ../../../../../Bio-Robotica/admin/Historia.php");
                exit();
            }
        } else {
            // Manejar caso en el que no se encuentra el docente
            echo "No se encontró el docente a borrar.";
            header("Location: ../../../../../Bio-Robotica/admin/Historia.php");
            exit();
        }
    }
?>