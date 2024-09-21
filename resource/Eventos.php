<?php

include '../database/Conexion.php';
// Inicia la sesión
session_start();

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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../ico/icon-robots-16_98547.ico" type="image/x-icon">
    <title>Bio-Robotica</title>
    <link rel="stylesheet" href="../css/Panel.css">
    <link rel="stylesheet" href="../css/Eventos.css">
    <script src="../JS/Eventos.js"></script>
    <style>
        #mas-informacion {
            display: none; /* Ocultar por defecto */
        }
    </style>
</head>
<body>
    <div class="main-content">
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
        <div id="contenedor-eventos">
            <div id="evento-proximo">
                <h1>Próximo Evento</h1>
                <div>
                    <?php
                    include '../database/Conexion.php';

                    $sql = "SELECT nombre, descripcion, fecha FROM Eventos WHERE fecha > NOW() ORDER BY fecha ASC LIMIT 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $nombre = $row["nombre"];
                        $descripcion = $row["descripcion"];
                        $fecha_evento = new DateTime($row["fecha"]);
                        $fecha_actual = new DateTime();
                        $intervalo = $fecha_actual->diff($fecha_evento);
                        $tiempo_restante = $intervalo->format('%a %h %i %s');

                        echo "<p class=\"tiempo\"><span id=\"tiempo_restante\">$tiempo_restante</span></p>";
                        echo "<p class=\"tiempo2\"> Dias Horas Minutos Segundos</strong></p>";
                            $masInformacion = "<p><strong>Evento más cercano:</strong> $nombre</p>" .
                                "<p><strong>Descripción:</strong> $descripcion</p>" .
                                "<p><strong>Fecha del evento:</strong> " . $fecha_evento->format('Y-m-d H:i:s') . "</p>";
                    } else {
                        echo "<p>No se encontraron eventos futuros.</p>";
                        $masInformacion = "";
                    }
                    $conn->close();
                    ?>
                </div>
                <button id="btn_mas" onclick="mostrarMasInformacion()">Saber más</button>
                <div id="mas-informacion">
                    <?php
                        echo $masInformacion;
                    ?>
                </div>
            </div>
        </div>
        <div id="caja_de_eventos">
            <?php
            include '../database/Conexion.php';
            $sql = "SELECT nombre, descripcion, fecha, imagen FROM Eventos WHERE fecha > NOW() ORDER BY fecha ASC LIMIT 3";
            $result = $conn->query($sql);
            $contador = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $nombre = $row["nombre"];
                    $descripcion = $row["descripcion"];
                    $fecha_event = new DateTime($row["fecha"]);
                    $nombre_imagen = $row["imagen"];
                    $ruta_imagen = "../img/Eventos/$nombre_imagen";
                    if ($contador % 2 != 0) {
                        echo "<div id=\"eventos1\">";
                        echo "<div id=\"info\">";
                        echo "<h2>$nombre</h2>";
                        echo "<p>$descripcion</p>";
                        echo "<p>Fecha del evento: " . $fecha_event->format('Y-m-d H:i:s') . "</p>";
                        echo "</div>";
                        echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\"></div>";
                        echo "</div>";
                    }else{
                        echo "<div id=\"eventos2\">";
                        echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\"></div>";
                        echo "<div id=\"info\">";
                        echo "<h2>$nombre</h2>";
                        echo "<p>$descripcion</p>";
                        echo "<p>Fecha del evento: " . $fecha_event->format('Y-m-d H:i:s') . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                    $contador++;
                }
            } else {
                echo "<p>No hay eventos futuros.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <div id="boque-final">
        <div id="datos-contacto">
            <p>Derecho reservados del Club de Bio-Robotica ©℗®™</p>
        </div>
    </div>
    <script>
        function actualizarTiempoRestante() {
            var tiempoRestanteElemento = document.getElementById("tiempo_restante");
            function actualizar() {
                var ahora = new Date().getTime();
                var diferencia = new Date('<?php echo $fecha_evento->format('Y-m-d H:i:s');?>').getTime() - ahora;
                var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
                var horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
                var segundos = Math.floor((diferencia % (1000 * 60)) / 1000);
                dias = agregarCero(dias);
                horas = agregarCero(horas);
                minutos = agregarCero(minutos);
                segundos = agregarCero(segundos);

                tiempoRestanteElemento.textContent = dias + " : " + horas + " : " + minutos + " : " + segundos;
                if (diferencia <= 0) {
                    clearInterval(intervalo);
                    tiempoRestanteElemento.textContent = "¡El evento ha comenzado!";
                }
            }
            actualizar();
            var intervalo = setInterval(actualizar, 1000);
        }

        actualizarTiempoRestante();
            function agregarCero(numero) {
            if (numero < 10) {
                return "0" + numero;
            } else {
                return numero;
            }
        }
        ////////////////mas informacion
        function mostrarMasInformacion() {
            var masInformacion = document.getElementById("mas-informacion");
            var btnMasInformacion = document.getElementById("btn_mas");
            var estiloMasInformacion = window.getComputedStyle(masInformacion); // Obtiene el estilo calculado del elemento
            if (estiloMasInformacion.display === "none") {
                masInformacion.style.display = "block";
                btnMasInformacion.textContent = "Ocultar";
            } else {
                masInformacion.style.display = "none";
                btnMasInformacion.textContent = "Saber más";
            }
        }

        document.getElementById('cerrar-sesion').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('form-cerrar-sesion').submit();
        });
    </script>
</body>
</html>