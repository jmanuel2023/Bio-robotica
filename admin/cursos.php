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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['agregar_curso'])) {
            $nombre_curso = $_POST['nombre_curso'];
            $descripcion_curso = $_POST['descripcion_curso'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_termino = $_POST['fecha_termino'];

            // Manejo de archivos subidos
            $icono = subirArchivo('icono');
            $documento_leccion1 = subirArchivo('documento_leccion1');
            $documento_leccion2 = subirArchivo('documento_leccion2');
            $documento_nota1 = subirArchivo('documento_nota1');
            $documento_nota2 = subirArchivo('documento_nota2');
            $documento_actividades = subirArchivo('documento_actividades');
            $documento_pdf = subirArchivo('documento_pdf');

            // Insertar el nuevo curso en la base de datos
            $sql = "INSERT INTO cursos (nombre_curso, descripcion_curso, fecha_inicio, fecha_termino, icono, descripcion_leccion1, documento_leccion1, descripcion_leccion2, documento_leccion2, nota1, documento_nota1, nota2, documento_nota2, descripcion_actividades, documento_actividades, evaluacion, documento_pdf) 
                    VALUES ('$nombre_curso', '$descripcion_curso', '$fecha_inicio', '$fecha_termino', '$icono', '$_POST[descripcion_leccion1]', '$documento_leccion1', '$_POST[descripcion_leccion2]', '$documento_leccion2', '$_POST[nota1]', '$documento_nota1', '$_POST[nota2]', '$documento_nota2', '$_POST[descripcion_actividades]', '$documento_actividades', '$_POST[evaluacion]', '$documento_pdf')";

            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif (isset($_POST['eliminar_curso'])) {
            $curso_id = $_POST['curso_id'];
            $sql = "DELETE FROM cursos WHERE id = $curso_id";

            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error al eliminar el curso: " . $conn->error;
            }
        }
    }

    function subirArchivo($campo) {
        if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = basename($_FILES[$campo]['name']);
            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
            $nombreBase = pathinfo($nombreArchivo, PATHINFO_FILENAME);
            $nombreUnico = $nombreBase . "_" . uniqid() . "." . $extension;
            $rutaDestino = '../docs/' . $nombreUnico;

            if (move_uploaded_file($_FILES[$campo]['tmp_name'], $rutaDestino)) {
                return $nombreUnico;
            } else {
                echo "Error al subir el archivo $campo.";
            }
        }
        return null;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../ico/icon-robots-16_98547.ico" type="image/x-icon">
    <title>Gestionar Cursos - Bio-Robotica</title>
    <link rel="stylesheet" href="../css/Panel.css">
    <link rel="stylesheet" href="../css/Cursos.css">
</head>
<body>
    <div class="main-content">
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
        <div id="Cursos">
            <?php
                // Consulta SQL para obtener los datos de la tabla cursos
                $sql = "SELECT * FROM cursos";
                $result = $conn->query($sql);
            ?>
            <div id="Editables">
                <?php
                // Verificar si hay menos de 6 cursos
                $num_cursos = $result->num_rows;
                if ($num_cursos < 6): ?>
                    <h3>Agregar Nuevo Curso</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <label for="nombre_curso">Nombre del Curso:</label>
                        <input type="text" name="nombre_curso" id="nombre_curso" required>

                        <label for="descripcion_curso">Descripción:</label>
                        <textarea name="descripcion_curso" id="descripcion_curso"></textarea>

                        <label for="fecha_inicio">Fecha de Inicio:</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio">

                        <label for="fecha_termino">Fecha de Término:</label>
                        <input type="date" name="fecha_termino" id="fecha_termino">

                        <label for="icono">Ícono:</label>
                        <input type="file" name="icono" id="icono">

                        <label for="descripcion_leccion1">Descripción Lección 1:</label>
                        <textarea name="descripcion_leccion1" id="descripcion_leccion1"></textarea>

                        <label for="documento_leccion1">Documento Lección 1:</label>
                        <input type="file" name="documento_leccion1" id="documento_leccion1">

                        <label for="descripcion_leccion2">Descripción Lección 2:</label>
                        <textarea name="descripcion_leccion2" id="descripcion_leccion2"></textarea>

                        <label for="documento_leccion2">Documento Lección 2:</label>
                        <input type="file" name="documento_leccion2" id="documento_leccion2">

                        <label for="nota1">Nota 1:</label>
                        <textarea name="nota1" id="nota1"></textarea>

                        <label for="documento_nota1">Documento Nota 1:</label>
                        <input type="file" name="documento_nota1" id="documento_nota1">

                        <label for="nota2">Nota 2:</label>
                        <textarea name="nota2" id="nota2"></textarea>

                        <label for="documento_nota2">Documento Nota 2:</label>
                        <input type="file" name="documento_nota2" id="documento_nota2">

                        <label for="descripcion_actividades">Descripción Actividades:</label>
                        <textarea name="descripcion_actividades" id="descripcion_actividades"></textarea>

                        <label for="documento_actividades">Documento Actividades:</label>
                        <input type="file" name="documento_actividades" id="documento_actividades">

                        <label for="evaluacion">Evaluación:</label>
                        <textarea name="evaluacion" id="evaluacion"></textarea>

                        <label for="documento_pdf">Documento Evaluación:</label>
                        <input type="file" name="documento_pdf" id="documento_pdf">

                        <input type="submit" name="agregar_curso" value="Agregar" class="btn secondary">
                    </form>
                <?php endif; ?>
            </div>
            <div id="Editable2">
                <h3>Cursos Existentes</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Curso</th>
                            <th>Descripción</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Término</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($num_cursos > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['nombre_curso']; ?></td>
                                    <td><?php echo $row['descripcion_curso']; ?></td>
                                    <td><?php echo $row['fecha_inicio']; ?></td>
                                    <td><?php echo $row['fecha_termino']; ?></td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="curso_id" value="<?php echo $row['id']; ?>">
                                            <input type="submit" name="eliminar_curso" value="X" class="btn secondary">
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No hay cursos disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id= "bloque-fantasma"></div>
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
