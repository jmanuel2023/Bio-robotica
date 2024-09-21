<?php

include '../database/Conexion.php';

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
    <link rel="stylesheet" href="../css/Cursos.css">
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
    <?php
    if (!isset($_SESSION['loggedin'])) {
        echo '<div class="modal-background" id="myModal">
                <div class="modal-content">
                    <h2>Necesitas iniciar sesión</h2>
                    <p>Para acceder a este contenido es indisplensable que formes parte del club de bio-robotica.</p>
                    <button class="btn secondary" onclick="redirectToLogin()">¡Vamos!</button>
                </div>
            </div>';
    }
    ?>
    <div id="bloque-cursos">
        <div id="titulo-general"><h1>Club de BIO-ROBOTICA</h1></div>
        <img src="../img/Cursos/Fondo/fondo_cursos.jpg" alt="Imagen Cursos" id="cursos-imagen">
        <div id="contenedor_targetas">
            <?php
                include '../database/Conexion.php';
                $sql = "SELECT * FROM cursos";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $nombre_curso = htmlspecialchars($row["nombre_curso"]);
                        $descripcion_curso = htmlspecialchars($row["descripcion_curso"]);
                        $fecha_inicio = htmlspecialchars((new DateTime($row["fecha_inicio"]))->format('Y-m-d'));
                        $fecha_termino = htmlspecialchars((new DateTime($row["fecha_termino"]))->format('Y-m-d'));
                        $icono = htmlspecialchars($row["icono"]);
                        $descripcion_leccion1 = htmlspecialchars($row["descripcion_leccion1"]);
                        $documento_leccion1 = htmlspecialchars($row["documento_leccion1"]);
                        $descripcion_leccion2 = htmlspecialchars($row["descripcion_leccion2"]);
                        $documento_leccion2 = htmlspecialchars($row["documento_leccion2"]);
                        $nota1 = htmlspecialchars($row["nota1"]);
                        $documento_nota1 = htmlspecialchars($row["documento_nota1"]);
                        $nota2 = htmlspecialchars($row["nota2"]);
                        $documento_nota2 = htmlspecialchars($row["documento_nota2"]);
                        $descripcion_actividades = htmlspecialchars($row["descripcion_actividades"]);
                        $documento_actividades = htmlspecialchars($row["documento_actividades"]);
                        $evaluacion = htmlspecialchars($row["evaluacion"]);
                        $documento_pdf = htmlspecialchars($row["documento_pdf"]);
                        $ruta_imagen = "../img/icons/$icono";

                        echo "<div class=\"targeta-curso\" 
                                data-curso=\"$nombre_curso\"
                                data-descripcion=\"$descripcion_curso\"
                                data-fecha-inicio=\"$fecha_inicio\"
                                data-fecha-termino=\"$fecha_termino\"
                                data-icono=\"$ruta_imagen\"
                                data-descripcion-leccion1=\"$descripcion_leccion1\"
                                data-documento-leccion1=\"$documento_leccion1\"
                                data-descripcion-leccion2=\"$descripcion_leccion2\"
                                data-documento-leccion2=\"$documento_leccion2\"
                                data-nota1=\"$nota1\"
                                data-documento-nota1=\"$documento_nota1\"
                                data-nota2=\"$nota2\"
                                data-documento-nota2=\"$documento_nota2\"
                                data-descripcion-actividades=\"$descripcion_actividades\"
                                data-documento-actividades=\"$documento_actividades\"
                                data-evaluacion=\"$evaluacion\"
                                data-documento-pdf=\"$documento_pdf\"
                              >";
                        echo "<img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\">";
                        echo "<h3>$nombre_curso</h3>";
                        echo "<p id=\"Texto-Curso\">$descripcion_curso</p>";
                        echo "<p id=\"Texto-Curso\">Disponible del: $fecha_inicio a $fecha_termino</p>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </div>
    <div id="bloque-cursos-informacion">
        <!-- Aquí se mostrará la información del curso seleccionado -->
    </div>
    <div id="boque-final">
        <div id="datos-contacto">
            <p>Derecho reservados del Club de Bio-Robotica ©℗®™</p>
        </div>
    </div>
    <script>
        function redirectToLogin() {
            window.location.href = './inicio.php';
        }

        window.onload = function() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'block'; // Mostrar el modal
        };

        document.getElementById('cerrar-sesion').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('form-cerrar-sesion').submit();
        });

        document.addEventListener('DOMContentLoaded', function() {
            var tarjetasCurso = document.querySelectorAll('.targeta-curso');
            var informacionCurso = document.getElementById('bloque-cursos-informacion');

            tarjetasCurso.forEach(function(tarjeta) {
                tarjeta.addEventListener('click', function() {
                    var nombreCurso = this.getAttribute('data-curso');
                    var descripcionCurso = this.getAttribute('data-descripcion');
                    var fechaInicio = this.getAttribute('data-fecha-inicio');
                    var fechaTermino = this.getAttribute('data-fecha-termino');
                    //var icono = this.getAttribute('data-icono');
                    var descripcionLeccion1 = this.getAttribute('data-descripcion-leccion1');
                    var documentoLeccion1 = this.getAttribute('data-documento-leccion1');
                    var descripcionLeccion2 = this.getAttribute('data-descripcion-leccion2');
                    var documentoLeccion2 = this.getAttribute('data-documento-leccion2');
                    var nota1 = this.getAttribute('data-nota1');
                    var documentoNota1 = this.getAttribute('data-documento-nota1');
                    var nota2 = this.getAttribute('data-nota2');
                    var documentoNota2 = this.getAttribute('data-documento-nota2');
                    var descripcionActividades = this.getAttribute('data-descripcion-actividades');
                    var documentoActividades = this.getAttribute('data-documento-actividades');
                    var evaluacion = this.getAttribute('data-evaluacion');
                    var documentoPdf = this.getAttribute('data-documento-pdf');

                    informacionCurso.innerHTML = `
                        <div id="morado"></div>
                        <h2>${nombreCurso}</h2>
                        <div id="contenedor_targetas_2">
                            <div class="targeta-curso">
                                <img src="../img/icons/leccion.png" alt="Imagen-Curso" id="Imagen-Curso">
                                <h4>Lección 1:</h4>
                                <p>${descripcionLeccion1} (<a href="${documentoLeccion1}" target="_blank">Documento</a>)</p>
                            </div>
                            <div class="targeta-curso">
                                <img src="../img/icons/leccion.png" alt="Imagen-Curso" id="Imagen-Curso">
                                <h4>Lección 2:</h4>
                                <p>${descripcionLeccion2} (<a href="${documentoLeccion2}" target="_blank">Documento</a>)</p>
                            </div>
                            <div class="targeta-curso">
                                <img src="../img/icons/Nota.png" alt="Imagen-Curso" id="Imagen-Curso">
                                <h4>Nota 1:</h4>
                                <p> ${nota1} (<a href="${documentoNota1}" target="_blank">Documento</a>)</p>
                            </div>
                            <div class="targeta-curso">
                                <img src="../img/icons/Nota.png" alt="Imagen-Curso" id="Imagen-Curso">
                                <h4>Nota 2:</h4>
                                <p> ${nota2} (<a href="${documentoNota2}" target="_blank">Documento</a>)</p>
                            </div>
                            <div class="targeta-curso">
                                <img src="../img/icons/Actividades.jpg" alt="Imagen-Curso" id="Imagen-Curso">
                                <h4>Descripcion de actividades:</h4>
                                <p>${descripcionActividades} (<a href="${documentoActividades}" target="_blank">Documento</a>)</p>
                            </div>
                            <div class="targeta-curso">
                            <img src="../img/icons/Examen.png" alt="Imagen-Curso" id="Imagen-Curso">
                            <h4>Evaluacion:</h4>
                            <p>${evaluacion} (<a href="${documentoPdf}" target="_blank">Documento PDF</a>)</p>
                            </div>
                        </div>
                    `;
                });
            });
        });
    </script>
</body>
</html>