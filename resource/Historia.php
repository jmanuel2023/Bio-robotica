<?php

include '../database/Conexion.php';
// Inicia la sesión
session_start();

// Función para cerrar sesión
function cerrarSesion() {
    session_unset();
    session_destroy();
    header("Location: ../resource/Club.php");
    exit();
}
if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../ico/icon-robots-16_98547.ico" type="image/x-icon">
    <title>Bio-Robotica</title>
    <link rel="stylesheet" href="../css/Panel.css">
    <link rel="stylesheet" href="../css/Historia.css">
</head>
<body>

    <div id="Logo_Bio">
        <div id="logo1">
            <img src="../img/Logo.jpg" alt="LogoBio" id="Logo">
        </div>
        <?php
            // Verifica si se ha iniciado sesión para mostrar el botón de cerrar sesión
            if (isset($_SESSION['loggedin'])) {
                // Si se ha iniciado sesión, muestra el botón de cerrar sesión
                echo '<div id="logo2">';
                echo '<img src="../img/user.png" alt="User" id="User">';
                echo '<h6 id="nivel"> Alumno</h6>';
                echo '</div>';
            }
        ?>
    </div>

    <div id="panel-contenedor">
        <div id="opciones-panel">
            <a href="club.php" class="opcion">Club</a>
            <a href="historia.php" class="opcion">Historia</a>
            <div id="usuarios-opciones" class="opcion">
                Cursos
                <div id="usuarios-desplegable" class="desplegable">
                    <a href="./cursos.php">Cursos Bio-Robotica</a>
                    <a href="./cursos2.php">Cursos Comunidad Politecnica</a>
                </div>
            </div>
            <a href="eventos.php" class="opcion">Eventos</a>
            <a href="materiales.php" class="opcion">Materiales</a>
            <?php if(!isset($_SESSION['loggedin'])) { ?>
            <div id="usuarios-opciones" class="opcion">
                Usuarios
                <div id="usuarios-desplegable" class="desplegable">
                    <a href="inicio.php">Inicio</a>
                    <a href="registro.php">Registro</a>
                </div>
            </div>
            <?php }?>
            <?php if(isset($_SESSION['loggedin'])) { ?>
                <div id="usuarios-opciones" class="opcion">
                    <a href="#" id="cerrar-sesion" class="opcion">Salir</a>
                    <form id="form-cerrar-sesion" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="display: none;">
                        <input type="hidden" name="cerrar_sesion" value="1">
                    </form>
                </div>
            <?php }?>
        </div>
    </div>
    <div id="Encabezados">
        <?php
        include '../database/Conexion.php';
        $categoria = "historia"; // Definir la categoría que deseas mostrar
        $sql = "SELECT nombre, descripcion FROM encabezados WHERE categoria = '$categoria'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombre = $row["nombre"];
                $descripcion = $row["descripcion"];
                echo "<h2>$nombre</h2>";
                echo "<p>$descripcion</p>";
            }
        } else {
            echo "<p>No hay encabezados disponibles para la categoría '$categoria'.</p>";
        }
        $conn->close();
        ?>
    </div>

    <div id="historia">
        <?php
        echo "<div id=\"caja_de_eventos\">";
        include '../database/Conexion.php';
        $sql = "SELECT nombre, informacion, imagen FROM docentes";
        $result = $conn->query($sql);
        $contador = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombre = $row["nombre"];
                $informacion = $row["informacion"];
                $nombre_imagen = $row["imagen"];
                $ruta_imagen = "../img/Historia/Profesores/$nombre_imagen";

                if ($contador % 2 != 0) {
                    echo "<div id=\"eventos1\">";
                    echo "<div id=\"info\">";
                    echo "<h2>$nombre</h2>";
                    echo "<p>$informacion</p>";
                    echo "</div>";
                    echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\"></div>";
                    echo "</div>";
                }else{
                    echo "<div id=\"eventos2\">";
                    echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\"></div>";
                    echo "<div id=\"info\">";
                    echo "<h2>$nombre</h2>";
                    echo "<p>$informacion</p>";
                    echo "</div>";
                    echo "</div>";
                }
                $contador++;
            }
        } else {
            echo "<p>Informacion no disponible</p>";
        }
        $conn->close();

        echo "</div>";
        echo "<div id=\"caja_de_antecedentes\">";
        include '../database/Conexion.php';
        $sql = "SELECT nombre, informacion, imagen FROM antecedentes";
        $result = $conn->query($sql);
        $contador = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombre = $row["nombre"];
                $informacion = $row["informacion"];
                $nombre_imagen = $row["imagen"];
                $ruta_imagen = "../img/Historia/Antecedentes/$nombre_imagen";

                if ($contador % 2 != 0) {
                    echo "<div id=\"antecedente1\">";
                    echo "<div id=\"infoA\">";
                    echo "<h2>$nombre</h2>";
                    echo "<p>$informacion</p>";
                    echo "</div>";
                    echo "<div id=\"antecedentes\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Antecedente\"></div>";
                    echo "</div>";
                }else{
                    echo "<div id=\"antecedente2\">";
                    echo "<div id=\"eantecedente\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Antecedente\"></div>";
                    echo "<div id=\"infoA\">";
                    echo "<h2>$nombre</h2>";
                    echo "<p>$informacion</p>";
                    echo "</div>";
                    echo "</div>";
                }
                $contador++;
            }
        } else {
            echo "<p>No hay antecendentes disponibles.</p>";
        }
        $conn->close();
        echo "</div>";
        ?>
    </div>

    <div id="boque-final">
        <div id="datos-contacto">
            <p>Derecho reservados del Club de Bio-Robotica ©℗®™</p>
        </div>
    </div>

    <script>
        document.getElementById('cerrar-sesion').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('form-cerrar-sesion').submit();
        });
    </script>
</body>
</html>