<?php
include '../../../biorobotica2/database/Conexion.php';

if(isset($_POST['borrar_evento'])){
    $id = $_POST['id'];
    $sql_select_imagen = "SELECT imagen FROM eventos WHERE id='$id'";
    $result = $conn->query($sql_select_imagen);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_imagen = $row['imagen'];

        // Procede con la eliminación del antecedente
        $sql_delete = "DELETE FROM eventos WHERE id='$id'";
        if ($conn->query($sql_delete) === TRUE) {
            // Eliminar la imagen si existe
            $ruta_imagen = "../../img/Eventos/$nombre_imagen"; 
            if(file_exists($ruta_imagen)){
                unlink($ruta_imagen);
            }
            header("Location: ../../admin/Eventos.php");
            exit();
        } else {
            echo "Error al borrar el antecedente: " . $conn->error;
            header("Location: ../../admin/Eventos.php");
            exit();
        }
    } else {
        echo "No se encontró la información del antecedente.";
        header("Location: ../../admin/Eventos.php");
        exit();
    }
}

?>