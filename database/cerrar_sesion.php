<?php
    // Función para cerrar sesión
    function cerrarSesion() {
        session_unset();
        session_destroy();
        header("Location: ../resource/Club.php"); // Redirige a la página de inicio o a donde desees
        exit();
    }

    // Verifica si se ha hecho clic en el botón de cerrar sesión
    if (isset($_GET['cerrar_sesion'])) {
        cerrarSesion();
    }
?>