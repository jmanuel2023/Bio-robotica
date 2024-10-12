<?php
include '../Conexion.php';

if(isset($_POST['borrar_antecedente'])){
    $nombre_antecedente = $_POST['nombre_antecedente'];

    // Consulta para obtener el nombre de la imagen asociada al antecedente
    $sql_select_imagen = "SELECT imagen FROM antecedentes WHERE nombre='$nombre_antecedente'";
    $result = $conn->query($sql_select_imagen);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_imagen = $row['imagen'];

        // Procede con la eliminación del antecedente
        $sql_delete = "DELETE FROM antecedentes WHERE nombre='$nombre_antecedente'";
        if ($conn->query($sql_delete) === TRUE) {
            // Eliminar la imagen si existe
            $ruta_imagen = "../../img/Historia/Antecedentes/$nombre_imagen"; 
            if(file_exists($ruta_imagen)){
                unlink($ruta_imagen);
            }
            header("Location: ../../admin/Historia.php");
            exit();
        } else {
            echo "Error al borrar el antecedente: " . $conn->error;
            header("Location: ../../admin/Historia.php");
            exit();
        }
    } else {
        echo "No se encontró la información del antecedente.";
        header("Location: ../../admin/Historia.php");
        exit();
    }
}

?>