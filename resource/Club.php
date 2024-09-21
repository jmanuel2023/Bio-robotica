<?php

include '../database/Conexion.php';
// Inicia la sesión
session_start();

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
    <link rel="stylesheet" href="../css/Club.css">
</head>
<body>
    <div id="Logo_Bio">
        <div id="logo1">
            <img src="../img/Logo.jpg" alt="LogoBio" id="Logo" >
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
    <?php
        // Incluir el archivo de conexión a la base de datos
        include '../database/Conexion.php';

        // Consulta para obtener las imágenes de la categoría "Club"
        $categoria = "Club"; // Cambia esto si necesitas otra categoría
        $sql = "SELECT nombre_imagen FROM carrusel WHERE categoria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $categoria);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $imagenes = array();

        if ($resultado->num_rows > 0) {
            // Guardar los nombres de las imágenes en un array
            while($row = $resultado->fetch_assoc()) {
                $imagenes[] = "../img/Club/carrusel-club/" . $row["nombre_imagen"];
            }
        }

        $stmt->close();
        $conn->close();
        ?>

        <div id="Carrusel">
            <button id="prevButton">&#10094;</button>
            <div id="Carrusel-mov">
                <?php foreach ($imagenes as $imagen) { ?>
                    <div class="carrusel-item">
                        <img src="<?php echo $imagen; ?>" alt="Imagen">
                    </div>
                <?php } ?>
            </div>
            <button id="nextButton">&#10095;</button>
        </div>
    <div id="historia">
        <?php
            include '../database/Conexion.php';
            $categoria = "club"; // Definir la categoría que deseas mostrar
            $sql = "SELECT nombre, descripcion FROM encabezados WHERE categoria = '$categoria'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $nombre = $row["nombre"];
                    $descripcion = $row["descripcion"];
                    echo "<div id=\"titulo\"><h1>$nombre</h1></div>";
                    echo "<div id=\"historia-bio\">";
                    echo "<p>$descripcion</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay encabezados disponibles para la categoría '$categoria'.</p>";
            }
            $conn->close();
        ?>
    </div>
    <div id="panel-fotos">
        <div id="fotos">
            <?php
                include '../database/Conexion.php';
                $categoria = "club"; // Definir la categoría que deseas mostrar
                $sql = "SELECT nombre FROM foros";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $nombre = $row["nombre"];
                        $ruta_imagen = "../img/Club/foro/$nombre";
                        echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Foro\" id=\"Foro\"></div>";
                    }
                } else {
                    echo "<p>No hay encabezados disponibles para la categoría '$categoria'.</p>";
                }
                $conn->close();
            ?>
        </div>
    </div>
    <?php
        echo "<div id=\"caja_de_eventos\">";
        include '../database/Conexion.php';
        $sql = "SELECT nombre_curso, nombre_curso, nombre_curso FROM cursos";
        $result = $conn->query($sql);
        $contador = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombre = $row["nombre_curso"];
                $descripcion = $row["nombre_curso"];
                $nombre_imagen = $row["nombre_curso"];
                $ruta_imagen = "../img/$nombre_imagen";

                if ($contador % 2 != 0) {
                    echo "<div id=\"eventos1\">";
                    echo "<div id=\"info\">";
                    echo "<h2>$nombre</h2>";
                    echo "<p>$descripcion</p>";
                    echo "<a href = \"./Materiales.php\"><button class=\"btn primary\">¡Saber más!</button></a>";
                    echo "</div>";
                    echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\"></div>";
                    echo "</div>";
                }else{
                    echo "<div id=\"eventos2\">";
                    echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\"></div>";
                    echo "<div id=\"info\">";
                    echo "<h2>$nombre</h2>";
                    echo "<p>$descripcion</p>";
                    echo "<a href = \"./Materiales.php\"><button class=\"btn secondary\">¡Saber más!</button></a>";
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
    ?>
    <div id="boque-final">
        <div id="datos-contacto">
            <p>Derechos reservados del Club de Bio-Robotica ©℗®™</p>
        </div>
    </div>
    <script>
        let carruselItems = document.querySelectorAll('.carrusel-item');
        let currentIndex = 0;
        let totalItems = carruselItems.length;

        function showItem(index) {
            if (index < 0) {
                index = totalItems - 1;
            } else if (index >= totalItems) {
                index = 0;
            }
            carruselItems.forEach((item, i) => {
                if (i === index) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
            currentIndex = index;
        }

        document.getElementById('prevButton').addEventListener('click', function() {
            showItem(currentIndex - 1);
        });

        document.getElementById('nextButton').addEventListener('click', function() {
            showItem(currentIndex + 1);
        });

        setInterval(function() {
            showItem(currentIndex + 1);
        }, 3000);

        // Inicializar el carrusel mostrando el primer elemento
        showItem(currentIndex);

        document.getElementById('cerrar-sesion').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('form-cerrar-sesion').submit();
        });
    </script>
</body>
</html>