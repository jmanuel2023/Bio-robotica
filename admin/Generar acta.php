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

// Consulta para obtener los conteos
$query = "
    SELECT
        SUM(rol = 'docente' AND genero = 'masculimo') AS docentes_hombres,
        SUM(rol = 'docente' AND genero = 'femenino') AS docentes_mujeres,
        SUM(rol = 'alumno' AND genero = 'masculino') AS alumnos_hombres,
        SUM(rol = 'alumno' AND genero = 'femenino') AS alumnos_mujeres
    FROM integrantes
";

$result = $conn->query($query);
$row = $result->fetch_assoc();

// Variables para los conteos
$docentes_hombres = $row['docentes_hombres'] ?? 0;
$docentes_mujeres = $row['docentes_mujeres'] ?? 0;
$docentes_total = $docentes_hombres + $docentes_mujeres;
$alumnos_hombres = $row['alumnos_hombres'] ?? 0;
$alumnos_mujeres = $row['alumnos_mujeres'] ?? 0;
$alumnos_total = $alumnos_hombres + $alumnos_mujeres;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../ico/icon-robots-16_98547.ico" type="image/x-icon">
    <title>Bio-Robotica</title>
    <link rel="stylesheet" href="../css/Panel.css">
    <link rel="stylesheet" href="../css/Actas.css">
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
        <div id="Actas">
            <div id="Tablas">
                <table class="content-table">
                    <thead>
                        <tr>
                            <th colspan='6'>Participantes</th>
                        </tr>
                        <tr>
                            <th colspan='3'>Docentes</th>
                            <th colspan='3'>Alumnos</th>
                        </tr>
                        <tr>
                            <th>Hombres</th>
                            <th>Mujeres</th>
                            <th>Total</th>
                            <th>Hombres</th>
                            <th>Mujeres</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $docentes_hombres; ?></td>
                            <td><?php echo $docentes_mujeres; ?></td>
                            <td><?php echo $docentes_total; ?></td>
                            <td><?php echo $alumnos_hombres; ?></td>
                            <td><?php echo $alumnos_mujeres; ?></td>
                            <td><?php echo $alumnos_total; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
        document.getElementById('cerrar-sesion').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('form-cerrar-sesion').submit();
        });
    </script>
</body>
</html>