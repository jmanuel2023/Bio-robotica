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
    <link rel="stylesheet" href="../css/Materiales.css">
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
        $categoria = "materiales";
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
        include '../database/Materiales/editar-historia.php'; // Incluye el archivo de procesamiento del formulario
    ?>
    <div id="editar-historia">
        <h2>Editar Materiales</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nuevo_nombre">Nuevo Nombre:</label><br>
            <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $nombre; ?>"><br>
            <label for="nueva_descripcion">Nueva Descripción:</label><br>
            <textarea id="nueva_descripcion" name="nueva_descripcion"><?php echo $descripcion; ?></textarea><br>
            <input type="submit" class="btn2 generico" name="guardar_historia" value="guardar_historia">
        </form>
    </div>
    <?php
        include '../database/Conexion.php';
        $categoria = "Materiales"; // Cambia esto si necesitas otra categoría
        $sql = "SELECT nombre_imagen, descripcion FROM carrusel WHERE categoria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $categoria);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $imagenes = array();
        $descripciones = array();

        if ($resultado->num_rows > 0) {
            // Guardar los nombres de las imágenes y las descripciones en arrays separados
            while($row = $resultado->fetch_assoc()) {
                $imagenes[] = "../img/carrusel-materiales/" . $row["nombre_imagen"];
                $descripciones[] = $row["descripcion"];
            }
        }

        $stmt->close();
        $conn->close();
    ?>
    <div id="contendor-material">
        <div id="Carrusel">
            <button id="prevButton">&#10094;</button>
            <div id="Carrusel-mov">
                <?php foreach ($imagenes as $index => $imagen) { ?>
                    <div class="carrusel-item">
                        <img src="<?php echo $imagen; ?>" alt="Imagen"  style="width: 100%; height: 100%;">
                    </div>
                <?php } ?>
            </div>
            <button id="nextButton">&#10095;</button>
        </div>
        <div id="material">
            <p id="descripcion"><?php echo $descripciones[0]; ?></p>
        </div>
    </div>
    <div id="preview-images">
        <?php
            $previewCounter = 0;
            // Mostrar imágenes de vista previa
            foreach ($imagenes as $index => $imagen) {
                if ($index !== 0&& $previewCounter < 9) { // Excluir la imagen actualmente mostrada en el carrusel
                    ?>
                    <div class="preview-item">
                        <img src="<?php echo $imagen; ?>" alt="Imagen" style="padding-right: 10px; width: 105px; height: 100px;">
                    </div>
                    <?php
                    $previewCounter++;
                }
            }
        ?>
    </div>
    <div id="carruseledit">
        <h2>Editor de carrusel</h2>
        <?php
        include '../database/Conexion.php';
            if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
                $id = $_GET['id'];
                // Consulta SQL para borrar el registro por ID
                $sql_delete = "DELETE FROM nombre_de_tu_tabla WHERE id = $id";
                if ($conn->query($sql_delete) === TRUE) {
                    echo "Registro eliminado correctamente.";
                } else {
                    echo "Error al eliminar el registro: " . $conn->error;
                }
            }

            // Consulta SQL para seleccionar todos los registros de la categoría 'materiales'
            $sql_select = "SELECT id, nombre_imagen, descripcion FROM carrusel WHERE categoria = 'materiales'";
            $result = $conn->query($sql_select);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<table>"; // Inicia la tabla
                        echo "<tr>"; // Inicia una fila para cada registro
                        echo "<td>";
                        echo "<img src='../img/carrusel-materiales/" . $row['nombre_imagen'] . "' alt='Imagen' style='width: 100px; height: 100px;'><br>";
                        echo "</td>";
                        echo "<td>";
                        echo "<form method='post' action='../database/Materiales/editar_carrusel.php' enctype='multipart/form-data'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<textarea name='descripcion' style='width: 500px; height: 100px;' required>" . $row['descripcion'] . "</textarea>";
                        echo "</td>";
                        echo "<td>";
                        echo "<input type='file' name='nueva_imagen'><br>";
                        echo "<button type='submit' class='btn2 generico' name='submit'>Guardar</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "<td>";
                        echo "<form method='post' action='../database/Materiales/borrar_carrusel.php'>";
                        echo "<input type='hidden' name='action' value='delete'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<button type='submit' class='btn2 eliminarD' name='submit'>Eliminar</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>"; // Cierra la tabla
            } else {
                echo "No se encontraron registros.";
            }

            $conn->close();
        ?>
    </div>
    <button id="mostrar_formulario" class="btn5 AgregarD">Agregar Material</button>
    <div id="formulario_agregar" style="display: none;">
        <h3>Agregar Nuevo Material</h3>
        <div id="eventos3">
            <form method="post" action="../database/Materiales/agregar_carrusel.php" enctype="multipart/form-data">
                <div id="info">
                    <input type="hidden" name="categoria" value="Materiales">
                    <textarea name="descripcion" placeholder="Descripción" style='width: 500px; height: 100px;' required></textarea>
                    <input type="file" name="imagen" class="input-large ancho-300px" required>
                    <input type="submit" name="agregar_carrusel" class="btn5 AgregarD" value="Agregar al Carrusel">
                </div>
            </form>
        </div>
    </div>
    <div id="transparente"></div>
        <div id="historia">
        <?php
        echo "<div id=\"caja_de_antecedentes\">";
        include '../database/Conexion.php';
        $sql = "SELECT nombre, imagen FROM Biblioteca";
        $result = $conn->query($sql);
        $contador = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombre = $row["nombre"];
                $imagen = $row["imagen"];

                if ($contador % 2 != 0) {
                    echo "<div id=\"antecedente1\">";
                } else {
                    echo "<div id=\"antecedente2\">";
                }

                echo "<div id=\"antecedentes\"><img src=\"../library/img/$imagen\" alt=\"Imagen-Curso\" id=\"Imagen-Antecedente\"></div>";
                echo "<div id=\"infoA\">";
                echo "<h2><a href='../../Bio-Robotica/library/$nombre'>$nombre</a></h2>";

                // Agregar botón de borrado
                echo "<form method='post' action='../database/Materiales/borrar_articulo.php' style='display: inline;'>";
                echo "<input type='hidden' name='nombre_articulo' value='$nombre'>";
                echo "<button type='submit' name='borrar_articulo' class='btn2 eliminarD'>Borrar</button>";
                echo "</form>";

                echo "</div>";
                echo "</div>";

                $contador++;
            }
        } else {
            echo "<p>No hay libros disponibles.</p>";
        }
        $conn->close();
        echo "</div>";
        ?>
    </div>

    <button id="mostrar_formulario2" class="btn5 AgregarD">Agregar articulo</button>
    <div id="formulario_agregar2" style="display: none;">
    <h3>Agregar Nuevo Artículo</h3>
    <div id="eventos3">
        <form method="post" action="../database/Materiales/agregar_articulo.php" enctype="multipart/form-data">
            <div id="info">
                <label for="nuevo_articulo">Seleccione el Artículo (PDF):</label>
                <input type="file" name="nuevo_articulo" id="nuevo_articulo" class="input-large ancho-30000px" accept="application/pdf" required>
                <label for="imagen_nuevo_articulo">Seleccione la Imagen:</label>
                <input type="file" name="imagen_nuevo_articulo" id="imagen_nuevo_articulo" class="input-large ancho-30000px" accept="image/jpeg, image/png, image/jpg" required>
                <input type="submit" name="agregar_articulo" class="btn5 AgregarD" value="Agregar Artículo">
            </div>
        </form>
    </div>
</div>
<div id="transparente"></div>
    <div id="boque-final">
        <div id="datos-contacto">
            <p>Derecho reservados del Club de Bio-Robotica ©℗®™</p>
        </div>
    </div>
    <?php ob_end_flush(); ?>
    <script>
    let carruselItems = document.querySelectorAll('.carrusel-item');
    let currentIndex = 0;
    let totalItems = carruselItems.length;
    let previewImages = document.querySelectorAll('.preview-item img');

    function showItem(index) {
        if (index < 0) {
            index = totalItems - 1;
        } else if (index >= totalItems) {
            index = 0;
        }
        let offset = -index * 100;
        document.querySelector('#Carrusel-mov').style.transform = 'translateX(' + offset + '%)';
        currentIndex = index;
        updateDescripcion(index);
        updatePreview();
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

    var descripciones = <?php echo json_encode($descripciones); ?>;

    function updateDescripcion(index) {
        var descripcionElement = document.getElementById('descripcion');
        descripcionElement.textContent = descripciones[index];
    }

    function updatePreview() {
        for (let i = 0; i < previewImages.length; i++) {
            let previewIndex = (currentIndex + i) % (totalItems - 1) + 1;
            if (previewIndex === 0) {
                previewIndex = totalItems - 1;
            }
            previewImages[i].src = carruselItems[previewIndex].querySelector('img').src;
        }
    }

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
        document.getElementById('cerrar-sesion').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('form-cerrar-sesion').submit();
        });
</script>
</body>
</html>