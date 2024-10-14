<?php
    ob_start();
    include '../database/Conexion.php';
    session_start();
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'docente') {
        header("Location: ../resource/inicio.php");
        exit();
    }
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
    <link rel="stylesheet" href="../css/Eventos.css">
    <script src="../JS/Eventos.js"></script>
    <style>
        #mas-informacion {
            display: none;
        }
    </style>
</head>
<body>

<div id="Logo_Bio">
        <div id="logo1">
            <img src="../img/Logo.jpg" alt="LogoBio" id="Logo">
        </div>
        <?php
            if (isset($_SESSION['loggedin'])) {
                echo '<div id="logo2">';
                echo '<img src="../img/user.png" alt="User" id="User">';
                echo '<h6 id="nivel"> Docente</h6>';
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
            <?php } else {?>
                <div id="usuarios-opciones" class="opcion">
                Gestión
                <div id="usuarios-desplegable" class="desplegable">
                    <a href="./Solicitudes.php">Solicitudes</a>
                    <a href="./Integrantes.php">Integrantes</a>
                    <a href="./Generar acta.php">Datos Club</a>
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
    <div id="blanco"></div>
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
                    echo "<p class=\"tiempo2\"> Dias Horas Minutos Segundos</p>";
                        $masInformacion = "<p><strong>Evento más cercano:</strong> $nombre</p>" .
                            "<p><strong>Descripción:</strong> $descripcion</p>" .
                            "<p><strong>Fecha del evento:</strong> " . $fecha_evento->format('Y-m-d H:i:s') . "</p>";
                } else {
                    echo "<p>No se encontraron eventos futuros.</p>";
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
        $sql = "SELECT id, nombre, descripcion, fecha, imagen, enlace, direccion, hora  FROM Eventos WHERE fecha ORDER BY fecha";
        $result = $conn->query($sql);
        $contador = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $nombre = $row["nombre"];
                $descripcion = $row["descripcion"];
                $fecha_event = new DateTime($row["fecha"]);
                $nombre_imagen = $row["imagen"];
                $enlace = $row["enlace"];
                $direccion = $row["direccion"];
                $hora = $row["hora"];

                $ruta_imagen = "../img/Eventos/$nombre_imagen";
                if ($contador % 2 != 0) {
                    echo "<div id=\"eventos1\">";
                    echo "<div>"; // Iniciar contenedor para botones
                    echo "<button class=\"btn3 editarD\"  data-id=\"$contador\">Editar</button>";
                    // Agregar botón de borrar
                    echo "<form method=\"post\" action=\"../database/Evento/borrar_evento.php\">";
                    echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
                    echo "<input type=\"submit\" name=\"borrar_evento\" class=\"btn3 eliminarD\" value=\"Borrar\">";
                    echo "</form>";
                    // Agregar formulario de edición
                    echo "<form class=\"formulario_editar\" method=\"post\" action=\"../database/Evento/editar_evento.php\" enctype=\"multipart/form-data\">";
                    echo "<input type=\"hidden\" name=\"nombre_evento\" value=\"$nombre\">";
                    echo "<input type=\"text\" name=\"nuevo_nombre\" id=\"nuevo_nombre_$contador\" value=\"$nombre\" class=\"input-large ancho-200px\" style=\"display: none;\">";
                    echo "<textarea name=\"nueva_informacion\" id=\"nueva_informacion_$contador\" class=\"input-large ancho-2000px\" style=\"display: none;\">$descripcion</textarea>";
                    echo "<input type=\"date\" name=\"fecha_nuevo_evento\" id=\"fecha_nuevo_evento_$contador\" class=\"input-large ancho-30003px\" style=\"display: none;\" required value=\"" . $fecha_event->format('Y-m-d') . "\">";
                    echo "<input type=\"file\" name=\"nueva_imagen\" id=\"nueva_imagen_$contador\" class=\"input-large\" style=\"display: none;\">";
                    echo "<input type=\"text\" name=\"nuevo_enlace\" id=\"nuevo_enlace_$contador\" value=\"$enlace\" class=\"input-large ancho-200px\" style=\"display: none;\">";
                    echo "<input type=\"submit\" name=\"editar_evento\" class=\"btn3 guardarD\" value=\"Guardar\">";
                    echo "</form>";
                    echo "</div>"; // Cerrar contenedor de botones
                    echo "<div id=\"info\">";
                    echo "<h2 id=\"nombre_$contador\">$nombre</h2>";
                    echo "<p id=\"informacion_$contador\">$descripcion</p>";
                    echo "<p id=\"fecha_evento_$contador\">Fecha del evento: " . $fecha_event->format('Y-m-d') . "</p>";
                    echo "<p id=\"hora_evento_$contador\">Hora del evento: $hora</p>";
                    echo "<p id=\"direccion_$contador\">Dirección: $direccion</p>";
                    echo "<p id=\"enlace_$contador\">Para saber más en: <a href=\"$enlace\" target=\"_blank\">$enlace</a></p>";
                    echo "</div>";
                    echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\"></div>";
                    echo "</div>";
                }else{
                    echo "<div id=\"eventos2\">";
                    echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\"></div>";
                    echo "<div id=\"info\">";
                    echo "<h2 id=\"nombre_$contador\">$nombre</h2>";
                    echo "<p id=\"informacion_$contador\">$descripcion</p>";
                    echo "<p id=\"fecha_evento_$contador\">Fecha del evento: " . $fecha_event->format('Y-m-d') . "</p>";
                    echo "<p id=\"hora_evento_$contador\">Hora del evento: $hora</p>";
                    echo "<p id=\"direccion_$contador\">Dirección: $direccion</p>";
                    echo "<p id=\"enlace_$contador\">Para saber más en: <a href=\"$enlace\" target=\"_blank\">$enlace</a></p>";
                    echo "</div>";
                    // Agregar botón de editar
                    echo "<div id=\"contenedor_editor\">"; // Iniciar contenedor para botones
                    echo "<button class=\"btn3 editarD\" data-id=\"$contador\">Editar</button>";
                    // Agregar botón de borrar
                    echo "<form method=\"post\" action=\"../database/Evento/borrar_evento.php\">";
                    echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
                    echo "<input type=\"submit\" name=\"borrar_evento\" class=\"btn3 eliminarD\" value=\"Borrar\">";
                    echo "</form>";
                    // Agregar formulario de edición
                    echo "<form class=\"formulario_editar\" method=\"post\" action=\"../database/Evento/editar_evento.php\" enctype=\"multipart/form-data\">";
                    echo "<input type=\"hidden\" name=\"nombre_evento\" value=\"$nombre\">";
                    echo "<input type=\"text\" name=\"nuevo_nombre\" id=\"nuevo_nombre_$contador\" value=\"$nombre\" class=\"input-large ancho-100px\" style=\"display: none;\">";
                    echo "<textarea name=\"nueva_informacion\" id=\"nueva_informacion_$contador\" class=\"input-large ancho-1000px\" style=\"display: none;\">$descripcion</textarea>";
                    echo "<input type=\"date\" name=\"fecha_nuevo_evento\" id=\"fecha_nuevo_evento_$contador\" class=\"input-large ancho-300px\" style=\"display: none;\" required value=\"" . $fecha_event->format('Y-m-d') . "\">";
                    echo "<input type=\"text\" name=\"nueva_direccion\" id=\"nueva_direccion_$contador\" value=\"$direccion\" class=\"input-large ancho-200px\" style=\"display: none;\">";
                    echo "<input type=\"time\" name=\"nueva_hora\" id=\"nueva_hora_$contador\" value=\"$hora\" class=\"input-large ancho-100px\" style=\"display: none;\">";
                    echo "<input type=\"file\" name=\"nueva_imagen\" id=\"nueva_imagen_$contador\" class=\"input-large\" style=\"display: none;\">";
                    echo "<input type=\"text\" name=\"nuevo_enlace\" id=\"nuevo_enlace_$contador\" value=\"$enlace\" class=\"input-large ancho-200px\" style=\"display: none;\">";
                    echo "<input type=\"submit\" name=\"editar_evento\" class=\"btn3 guardarD\" value=\"Guardar\">";
                    echo "</form>";
                    echo "</div>"; // Cerrar contenedor de botones
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
    <div id="formulario_agregar">
        <h3>Agregar Nuevo Evento</h3>
        <div id="eventos3">
        <form method="post" action="../database/Evento/agregar_evento.php" enctype="multipart/form-data">
            <div id="info">
                <input type="text" name="nombre_nuevo_evento" placeholder="Nombre del evento" class="input-large ancho-300px" required>
                <textarea name="informacion_nuevo_evento" placeholder="Información del evento" class="input-large ancho-300px" required></textarea>
                <input type="file" name="imagen_nuevo_evento" class="input-large ancho-300px" required>
                <input type="text" name="direccion_nuevo_evento" placeholder="Dirección del evento" class="input-large ancho-300px" required>
                <input type="date" name="fecha_nuevo_evento" placeholder="Fecha del evento" class="input-large ancho-300px" required>
                <input type="time" name="hora_nuevo_evento" placeholder="Hora del evento" class="input-large ancho-300px" required>
                <input type="text" name="enlace_nuevo_evento" placeholder="Enlace del evento" class="input-large ancho-300px" required>
                <input type="submit" name="agregar_evento" class="btn5 AgregarD" value="Agregar evento">
            </div>
        </form>
        </div>
    </div>
    <div id= "bloque-fantasma"></div>
    <div id="boque-final">
        <div id="datos-contacto">
            <p>Derecho reservados del Club de Bio-Robotica ©℗®™</p>
        </div>
    </div>
    <?php ob_end_flush(); ?>
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
        function mostrarMasInformacion() {
            var masInformacion = document.getElementById("mas-informacion");
            var btnMasInformacion = document.getElementById("btn_mas");
            var estiloMasInformacion = window.getComputedStyle(masInformacion);
            if (estiloMasInformacion.display === "none") {
                masInformacion.style.display = "block";
                btnMasInformacion.textContent = "Ocultar";
            } else {
                masInformacion.style.display = "none";
                btnMasInformacion.textContent = "Saber más";
            }
        }
    document.addEventListener('DOMContentLoaded', function() {
    const botonesEditarD = document.querySelectorAll('.editarD');
        botonesEditarD.forEach(boton => {
            boton.addEventListener('click', (e) => {
                e.preventDefault(); // Prevenir el comportamiento por defecto del botón
                const id = boton.getAttribute('data-id');
                const nombre = document.getElementById(`nombre_${id}`);
                const informacion = document.getElementById(`informacion_${id}`);
                const enlace = document.getElementById(`enlace_${id}`);
                const nuevoNombre = document.getElementById(`nuevo_nombre_${id}`);
                const nuevaInformacion = document.getElementById(`nueva_informacion_${id}`);
                const fechaEvent = document.getElementById(`fecha_evento_${id}`)
                const nuevaFecha = document.getElementById(`fecha_nuevo_evento_${id}`);
                const nuevaImagen = document.getElementById(`nueva_imagen_${id}`);
                const nuevoEnlace = document.getElementById(`nuevo_enlace_${id}`);
                const nuevahora = document.getElementById(`nueva_hora_${id}`);
                const nuevadireccion = document.getElementById(`nueva_direccion_${id}`);
                const hora = document.getElementById(`hora_evento_${id}`);
                const direccion = document.getElementById(`direccion_${id}`);

                if (nombre && informacion && nuevoNombre && nuevaInformacion && nuevaFecha && nuevaImagen) {
                if (nombre.style.display === 'none') {
                    // Si los elementos originales están ocultos, restablecer al estado original
                    nombre.style.display = 'block';
                    informacion.style.display = 'block';
                    nuevaFecha.style.display = 'none';
                    fechaEvent.style.display = 'block';
                    nuevoNombre.style.display = 'none';
                    nuevaInformacion.style.display = 'none';
                    nuevaImagen.style.display = 'none';
                    nuevoEnlace.style.display = 'none';
                    nuevahora.style.display = 'none';
                    nuevadireccion.style.display = 'none';
                    enlace.style.display = 'block';
                    nuevadireccion.style.display = 'none';
                    nuevahora.style.display = 'none';
                    direccion.style.display = 'block';
                    enlace.style.display = 'block';
                } else {
                    // Ocultar elementos originales y mostrar campos de edición
                    nombre.style.display = 'none';
                    informacion.style.display = 'none';
                    nuevaFecha.style.display = 'block';
                    fechaEvent.style.display = 'none';
                    nuevoNombre.style.display = 'block';
                    nuevoNombre.value = nombre.innerText.trim();
                    nuevaInformacion.style.display = 'block';
                    nuevaInformacion.value = informacion.innerText.trim();
                    nuevaImagen.style.display = 'block';
                    nuevoEnlace.style.display = 'block';
                    nuevahora.style.display = 'none';
                    nuevadireccion.style.display = 'none';
                    nuevadireccion.style.display = 'block';
                    nuevahora.style.display = 'block';
                    hora.style.display = 'none';
                    direccion.style.display = 'none';
                    enlace.style.display = 'none';
                }
            } else {
                console.error('No se encontraron algunos elementos necesarios.');
            }
        });
    });
    const mostrarFormulario = document.getElementById('mostrar_formulario');
        if (mostrarFormulario) {
            mostrarFormulario.addEventListener('click', function() {
                const formulario = document.getElementById('formulario_agregar');
                if (formulario) {
                    formulario.style.display = (formulario.style.display === 'none') ? 'block' : 'none';
                } else {
                    console.error('Elemento formulario_agregar no encontrado.');
                }
            });
        }
    });
    document.getElementById('cerrar-sesion').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('form-cerrar-sesion').submit();
    });
    </script>
</body>
</html>