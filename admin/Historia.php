<?php
    ob_start(); // Inicia el búfer de salida
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
    <link rel="stylesheet" href="../css/Historia.css">
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
    <div id="Encabezados">
        <?php
        include '../database/Conexion.php';
        $categoria = "historia";
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
    <?php
        include '../database/Historia/editar_historia.php'; // Incluye el archivo de procesamiento del formulario
    ?>
    <div id="editar-historia">
        <h2>Editar Historia</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nuevo_nombre">Nuevo Nombre:</label><br>
            <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $nombre; ?>"><br>
            <label for="nueva_descripcion">Nueva Descripción:</label><br>
            <textarea id="nueva_descripcion" name="nueva_descripcion"><?php echo $descripcion; ?></textarea><br>
            <input type="submit" class="btn2 generico" name="guardar_historia" value="guardar_historia">
        </form>
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
                    echo "<div>"; // Iniciar contenedor para botones
                    // Agregar botón de borrar
                    echo "<form method=\"post\" action=\"../database/Historia/borrar_docente.php\">";
                    echo "<input type=\"hidden\" name=\"nombre_docente\" value=\"$nombre\">";
                    echo "<input type=\"submit\" name=\"borrar_docente\" class=\"btn3 eliminarD\" value=\"Borrar\">";
                    echo "</form>";
                    // Agregar formulario de edición
                    echo "<button class=\"btn3 editarD\"  data-id=\"$contador\">Editar</button>";
                    echo "</div>"; // Cerrar contenedor de botones
                    echo "<form class=\"formulario_editar\" method=\"post\" action=\"../database/Historia/editar_docente.php\" enctype=\"multipart/form-data\">";
                    echo "<input type=\"hidden\" name=\"nombre_docente\" value=\"$nombre\">";
                    echo "<input type=\"text\" name=\"nuevo_nombre\" id=\"nuevo_nombre_$contador\" value=\"$nombre\" class=\"input-large ancho-200px\" style=\"display: none;\">";
                    echo "<textarea name=\"nueva_informacion\" id=\"nueva_informacion_$contador\" class=\"input-large ancho-2000px\" style=\"display: none;\">$informacion</textarea>";
                    echo "<input type=\"file\" name=\"nueva_imagen\" id=\"nueva_imagen_$contador\" class=\"input-large\" style=\"display: none;\">";
                    echo "<input type=\"submit\" name=\"editar_docente\" id=\"botonGuardar_$contador\" class=\"btn3 guardarD\" value=\"Guardar\" style=\"display: none;\">";
                    echo "</form>";
                    echo "<div id=\"info\">";
                    echo "<h2 id=\"nombre_$contador\">$nombre</h2>";
                    echo "<p id=\"informacion_$contador\">$informacion</p>";
                    echo "</div>";
                    echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\"></div>";
                    echo "</div>";
                } else {
                    echo "<div id=\"eventos2\">";
                    echo "<div>"; // Iniciar contenedor para botones
                    // Agregar botón de borrar
                    echo "<form method=\"post\" action=\"../database/Historia/borrar_docente.php\">";
                    echo "<input type=\"hidden\" name=\"nombre_docente\" value=\"$nombre\">";
                    echo "<input type=\"submit\" name=\"borrar_docente\" class=\"btn3 eliminarD\" value=\"Borrar\">";
                    echo "</form>";
                    // Agregar formulario de edición
                    echo "<button class=\"btn3 editarD\"  data-id=\"$contador\">Editar</button>";
                    echo "</div>"; // Cerrar contenedor de botones
                    echo "<form class=\"formulario_editar\" method=\"post\" action=\"../database/Historia/editar_docente.php\" enctype=\"multipart/form-data\">";
                    echo "<input type=\"hidden\" name=\"nombre_docente\" value=\"$nombre\">";
                    echo "<input type=\"text\" name=\"nuevo_nombre\" id=\"nuevo_nombre_$contador\" value=\"$nombre\" class=\"input-large ancho-200px\" style=\"display: none;\">";
                    echo "<textarea name=\"nueva_informacion\" id=\"nueva_informacion_$contador\" class=\"input-large ancho-2000px\" style=\"display: none;\">$informacion</textarea>";
                    echo "<input type=\"file\" name=\"nueva_imagen\" id=\"nueva_imagen_$contador\" class=\"input-large\" style=\"display: none;\">";
                    echo "<input type=\"submit\" name=\"editar_docente\" id=\"botonGuardar_$contador\" class=\"btn3 guardarD\" value=\"Guardar\" style=\"display: none;\">";
                    echo "</form>";
                    echo "<div id=\"info\">";
                    echo "<h2 id=\"nombre_$contador\">$nombre</h2>";
                    echo "<p id=\"informacion_$contador\">$informacion</p>";
                    echo "</div>";
                    echo "<div id=\"eventos\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Curso\"></div>";
                    echo "</div>";
                }
                $contador++;
            }
        } else {
            echo "<p>Informacion no disponible</p>";
        }
        $conn->close();
    ?>
    <button id="mostrar_formulario" class="btn5 AgregarD">Agregar Docente</button>

    <div id="formulario_agregar" style="display: none;">
        <h3>Agregar Nuevo Docente</h3>
        <div id="eventos3">
            <form method="post" action="../database/Historia/agregar_docente.php" enctype="multipart/form-data">
                <div id="info">
                    <input type="text" name="nombre_nuevo_docente" placeholder="Nombre del Docente" class="input-large ancho-300px" required>
                    <textarea name="informacion_nuevo_docente" placeholder="Información del Docente" class="input-large ancho-3000px" required></textarea>
                    <input type="file" name="imagen_nuevo_docente" class="input-large ancho-30000px" required>
                    <input type="submit" name="agregar_docente" class="btn5 AgregarD" value="Agregar Docente">
                </div>
            </form>
        </div>
    </div>
    <?php
        echo "</div>";
        echo "<div id=\"caja_de_antecedentes\">";
        include '../database/Conexion.php';
        $sql = "SELECT nombre, informacion, imagen FROM antecedentes";
        $result = $conn->query($sql);
        $contador2 = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombre2 = $row["nombre"];
                $informacion2 = $row["informacion"];
                $nombre_imagen2 = $row["imagen"];
                $ruta_imagen = "../img/Historia/Antecedentes/$nombre_imagen2";

                if ($contador2 % 2 != 0) {
                    echo "<div id=\"antecedente1\">";
                    echo "<div id=\"antecedente\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Antecedente\"></div>";
                    echo "<div id=\"infoA\">";
                    echo "<h2 id=\"nombre2_$contador2\">$nombre2</h2>";
                    echo "<p id=\"informacion2_$contador2\">$informacion2</p>";
                    echo "</div>";
                    // Agregar formulario de edición
                    echo "<form class=\"formulario_editar2\" method=\"post\" action=\"../database/Historia/editar_antecedente.php\" enctype=\"multipart/form-data\">";
                    echo "<input type=\"hidden\" name=\"nombre_antecedente\" value=\"$nombre2\">";
                    echo "<input type=\"text\" name=\"nuevo_nombre2\" id=\"nuevo_nombre2_$contador2\" value=\"$nombre2\" class=\"input-large ancho-a200px\" style=\"display: none;\">";
                    echo "<textarea name=\"nueva_informacion2\" id=\"nueva_informacion2_$contador2\" class=\"input-large ancho-a2000px\" style=\"display: none;\">$informacion2</textarea>";
                    echo "<input type=\"file\" name=\"nueva_imagen2\" id=\"nueva_imagen2_$contador2\" class=\"input-large\" style=\"display: none;\">";
                    echo "<input type=\"submit\" name=\"editar_antecedente\" id=\"botonGuardar2_$contador2\" class=\"btn3 guardarD\" value=\"Guardar\" style=\"display: none;\">";
                    echo "</form>";
                    echo "<div id=\"antecede\">"; // Iniciar contenedor para botones
                    echo "<button class=\"btn3 editarA\"  data-id=\"$contador2\">Editar</button>";
                    // Agregar botón de borrar
                    echo "<form method=\"post\" action=\"../database/Historia/borrar_antecedente.php\">";
                    echo "<input type=\"hidden\" name=\"nombre_antecedente\" value=\"$nombre2\">";
                    echo "<input type=\"submit\" name=\"borrar_antecedente\" class=\"btn3 eliminarD\" value=\"Borrar\">";
                    echo "</form>";

                    echo "</div>"; // Cerrar contenedor de botones
                    echo "</div>";
                }else{
                    echo "<div id=\"antecedente2\">";
                    echo "<div id=\"antecedente\"><img src=\"$ruta_imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Antecedente\"></div>";
                    echo "<div id=\"infoA\">";
                    echo "<h2 id=\"nombre2_$contador2\">$nombre2</h2>";
                    echo "<p id=\"informacion2_$contador2\">$informacion2</p>";
                    echo "</div>";
                    // Agregar formulario de edición
                    echo "<form class=\"formulario_editar2\" method=\"post\" action=\"../database/Historia/editar_antecedente.php\" enctype=\"multipart/form-data\">";
                    echo "<input type=\"hidden\" name=\"nombre_antecedente\" value=\"$nombre2\">";
                    echo "<input type=\"text\" name=\"nuevo_nombre2\" id=\"nuevo_nombre2_$contador2\" value=\"$nombre2\" class=\"input-large ancho-a200px\" style=\"display: none;\">";
                    echo "<textarea name=\"nueva_informacion2\" id=\"nueva_informacion2_$contador2\" class=\"input-large ancho-a2000px\" style=\"display: none;\">$informacion2</textarea>";
                    echo "<input type=\"file\" name=\"nueva_imagen2\" id=\"nueva_imagen2_$contador2\" class=\"input-large\" style=\"display: none;\">";
                    echo "<input type=\"submit\" name=\"editar_antecedente\" id=\"botonGuardar2_$contador2\" class=\"btn3 guardarD\" value=\"Guardar\" style=\"display: none;\">";
                    echo "</form>";
                    echo "<div id=\"antecede\">"; // Iniciar contenedor para botones
                    echo "<button class=\"btn3 editarA\"  data-id=\"$contador2\">Editar</button>";
                    // Agregar botón de borrar
                    echo "<form method=\"post\" action=\"../database/Historia/borrar_antecedente.php\">";
                    echo "<input type=\"hidden\" name=\"nombre_antecedente\" value=\"$nombre2\">";
                    echo "<input type=\"submit\" name=\"borrar_antecedente\" class=\"btn3 eliminarD\" value=\"Borrar\">";
                    echo "</form>";

                    echo "</div>"; // Cerrar contenedor de botones
                    echo "</div>";
                }
                $contador2++;
            }
        } else {
            echo "<p>No hay antecendentes disponibles.</p>";
        }
        $conn->close();
        echo "</div>";
        ?>
    </div>
    <button id="mostrar_formulario2" class="btn5 AgregarA">Agregar Antecedente</button>
    <div id="formulario_agregar2" style="display: none;">
        <h3>Agregar Nuevo Antecedente</h3>
        <div id="eventos3">
            <form method="post" action="../database/Historia/agregar_antecedente.php" enctype="multipart/form-data">
                <div id="info">
                    <input type="text" name="nombre_nuevo_antecedente" placeholder="Nombre del antecedente" class="input-large ancho-300px" required>
                    <textarea name="informacion_nuevo_antecedente" placeholder="Información del antecedente" class="input-large ancho-3000px" required></textarea>
                    <input type="file" name="imagen_nuevo_antecedente" class="input-large ancho-30000px" required>
                    <input type="submit" name="agregar_antecedente" class="btn5 AgregarD" value="Agregar Antecedente">
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
    document.addEventListener('DOMContentLoaded', function() {
        const botonesEditarD = document.querySelectorAll('.editarD');

    botonesEditarD.forEach(boton => {
        boton.addEventListener('click', () => {
            const id = boton.getAttribute('data-id');
            const nombre = document.getElementById(`nombre_${id}`);
            const informacion = document.getElementById(`informacion_${id}`);
            const nuevoNombre = document.getElementById(`nuevo_nombre_${id}`);
            const nuevaInformacion = document.getElementById(`nueva_informacion_${id}`);
            const nuevaImagen = document.getElementById(`nueva_imagen_${id}`);
            const botonGuardar = document.getElementById(`botonGuardar_${id}`);

            if (nombre && informacion && nuevoNombre && nuevaInformacion && nuevaImagen) {
                if (nombre.style.display === 'none') {
                    // Restaurar al estado original
                    nombre.style.display = 'block';
                    informacion.style.display = 'block';
                    nuevoNombre.style.display = 'none';
                    nuevaInformacion.style.display = 'none';
                    nuevaImagen.style.display = 'none';
                    boton.innerText = 'Editar'; // Restablecer el texto del botón
                    botonGuardar.style.display = 'none';
                } else {
                    // Mostrar campos de edición
                    nombre.style.display = 'none';
                    informacion.style.display = 'none';
                    nuevoNombre.style.display = 'block';
                    nuevoNombre.value = nombre.innerText;
                    nuevaInformacion.style.display = 'block';
                    nuevaInformacion.value = informacion.innerText;
                    nuevaImagen.style.display = 'block';
                    boton.innerText = 'Cancelar'; // Cambiar el texto del botón a "Cancelar"
                    botonGuardar.style.display = 'block';
                }
            } else {
                console.error('No se encontraron algunos elementos necesarios.');
            }
        });
    });

    const botonesEditarA = document.querySelectorAll('.editarA');

    botonesEditarA.forEach(boton => {
        boton.addEventListener('click', () => {
            const id = boton.getAttribute('data-id');
            const nombre2 = document.getElementById(`nombre2_${id}`);
            const informacion2 = document.getElementById(`informacion2_${id}`);
            const nuevoNombre2 = document.getElementById(`nuevo_nombre2_${id}`);
            const nuevaInformacion2 = document.getElementById(`nueva_informacion2_${id}`);
            const nuevaImagen2 = document.getElementById(`nueva_imagen2_${id}`);
            const botonGuardar2 = document.getElementById(`botonGuardar2_${id}`);

            if (nombre2 && informacion2 && nuevoNombre2 && nuevaInformacion2 && nuevaImagen2) {
                if (nombre2.style.display === 'none') {
                    // Si los elementos originales están ocultos, restablecer al estado original
                    nombre2.style.display = 'block';
                    informacion2.style.display = 'block';
                    nuevoNombre2.style.display = 'none';
                    nuevaInformacion2.style.display = 'none';
                    nuevaImagen2.style.display = 'none';
                    boton.innerText = 'Editar'; // Restaurar texto del botón si es necesario
                    botonGuardar2.style.display = 'none';
                } else {
                    // Ocultar elementos originales y mostrar campos de edición
                    nombre2.style.display = 'none';
                    informacion2.style.display = 'none';
                    nuevoNombre2.style.display = 'block';
                    nuevoNombre2.value = nombre2.innerText.trim();
                    nuevaInformacion2.style.display = 'block';
                    nuevaInformacion2.value = informacion2.innerText.trim();
                    nuevaImagen2.style.display = 'block';
                    boton.innerText = 'Cancelar'; // Cambiar texto del botón si es necesario
                    botonGuardar2.style.display = 'block';
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

        const mostrarFormulario2 = document.getElementById('mostrar_formulario2');
        if (mostrarFormulario2) {
            mostrarFormulario2.addEventListener('click', function() {
                const formulario2 = document.getElementById('formulario_agregar2');
                if (formulario2) {
                    formulario2.style.display = (formulario2.style.display === 'none') ? 'block' : 'none';
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