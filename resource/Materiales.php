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
    <link rel="stylesheet" href="../css/Materiales.css">
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
    // Verifica si el usuario no ha iniciado sesión
    if (!isset($_SESSION['loggedin'])) {
        // Muestra el modal si el usuario no ha iniciado sesión
        echo '<div class="modal-background" id="myModal">
                <div class="modal-content">
                    <h2>Necesitas iniciar sesión</h2>
                    <p>Para acceder a este contenido es indisplensable que formes parte del club de bio-robotica.</p>
                    <button class="btn secondary" onclick="redirectToLogin()">¡Vamos!</button>
                </div>
            </div>';
    }
    ?>
    <div id="Encabezados">
        <?php
        include '../database/Conexion.php';
        $categoria = "materiales"; // Definir la categoría que deseas mostrar
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
        // Incluir el archivo de conexión a la base de datos
        include '../database/Conexion.php';

        // Consulta para obtener las imágenes y descripciones de la categoría "Materiales"
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
                        <img src="<?php echo $imagen; ?>" alt="Imagen" class="carruimage">
                    </div>
                <?php } ?>
            </div>
            <button id="nextButton">&#10095;</button>
        </div>
        <div id="material">
            <p id="descripcion"><?php echo $descripciones[0]; ?></p> <!-- Mostrar la primera descripción por defecto -->
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
    <div id="boque-final">
        <div id="datos-contacto">
            <p>Derecho reservados del Club de Bio-Robotica ©℗®™</p>
        </div>
    </div>
    <script>
    // Función para cerrar el modal al hacer clic en el botón de cerrar
    function closeModal() {
        var modal = document.getElementById('myModal');
        modal.style.display = 'none';
    }

    // Función para redireccionar al usuario a la página de inicio de sesión
    function redirectToLogin() {
        window.location.href = './inicio.php';
    }

    // Función para mostrar el modal si el usuario no ha iniciado sesión
    window.onload = function() {
        var modal = document.getElementById('myModal');
        modal.style.display = 'block'; // Mostrar el modal
    };

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

    document.getElementById('cerrar-sesion').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('form-cerrar-sesion').submit();
        });
</script>
</body>
</html>