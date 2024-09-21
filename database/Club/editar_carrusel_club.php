<?php
    include '../database/Conexion.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['agregar_imagen'])) {
            $nombre_imagen = $_FILES['nueva_imagen']['name'];
            $target_dir = "../img/Club/carrusel-club/";
            $original_nombre = $nombre_imagen;
            $contador = 1;
            $target_file = $target_dir . basename($_FILES["nueva_imagen"]["name"]);
            move_uploaded_file($_FILES["nueva_imagen"]["tmp_name"], $target_file);
            $categoria = "Club";
            $sql_insert = "INSERT INTO carrusel (categoria, nombre_imagen) VALUES (?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ss", $categoria, $nombre_imagen);
            $stmt_insert->execute();
            $stmt_insert->close();
        }
        if (isset($_POST['eliminar_imagenes'])) {
            if (!empty($_POST['eliminar_imagen'])) {
                foreach ($_POST['eliminar_imagen'] as $imagen_a_eliminar) {
                    $ruta_info = pathinfo($imagen_a_eliminar);
                    $nombre_imagen = $ruta_info['basename'];
                    $categoria = "Club";
                    $sql_delete = "DELETE FROM carrusel WHERE nombre_imagen = ? AND categoria = ?";
                    $stmt_delete = $conn->prepare($sql_delete);
                    $stmt_delete->bind_param("ss", $nombre_imagen, $categoria);
                    $stmt_delete->execute();
                    $stmt_delete->close();
                    unlink($imagen_a_eliminar);
                }
            }
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        }
    }
?>