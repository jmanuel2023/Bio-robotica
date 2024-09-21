<?php
    include '../database/Conexion.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_FILES["nueva_imagen"]["name"])) {
            include '../database/Conexion.php';
            $sql_delete = "DELETE FROM foros";
            if ($conn->query($sql_delete) === TRUE) {
                $target_dir = "../img/Club/foro/";
                $files = glob($target_dir . "*"); // Obtener todos los nombres de archivo
                foreach ($files as $file) { // Iterar sobre ellos
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
                $target_file = $target_dir . basename($_FILES["nueva_imagen"]["name"]);
                $nombre_imagen = $_FILES["nueva_imagen"]["name"];
                $imagen_tipo = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["nueva_imagen"]["tmp_name"]);
                if($check !== false) {
                    if($imagen_tipo == "jpg" || $imagen_tipo == "png" || $imagen_tipo == "jpeg"
                    || $imagen_tipo == "gif" ) {
                        move_uploaded_file($_FILES["nueva_imagen"]["tmp_name"], $target_file);
                        $sql_insert_imagen = "INSERT INTO foros (nombre) VALUES (?)";
                        $stmt_insert_imagen = $conn->prepare($sql_insert_imagen);
                        $stmt_insert_imagen->bind_param("s", $nombre_imagen);
                        $stmt_insert_imagen->execute();
                        $stmt_insert_imagen->close();
                        echo "La imagen ha sido subida correctamente.";
                        header("Location: {$_SERVER['PHP_SELF']}");
                        exit();
                    } else {
                        echo "Lo sentimos, solo se permiten archivos JPG, JPEG, PNG & GIF.";
                    }
                } else {
                    echo "El archivo no es una imagen real.";
                }
            } else {
                echo "Error al borrar los registros existentes: " . $conn->error;
            }
            $conn->close();
        } else {
            echo "Por favor, seleccione una imagen para subir.";
        }
    }
?>