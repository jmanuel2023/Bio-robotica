<?php
 include '../database/Conexion.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['guardar_historia'])) {
            $nuevo_nombre = $_POST['nuevo_nombre'];
            $nueva_descripcion = $_POST['nueva_descripcion'];
            $sql_update = "UPDATE encabezados SET nombre = ?, descripcion = ? WHERE categoria = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("sss", $nuevo_nombre, $nueva_descripcion, $categoria);
            $stmt_update->execute();
            $stmt_update->close();
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        }
    }
?>