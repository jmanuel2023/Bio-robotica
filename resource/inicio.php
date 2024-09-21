<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

// Incluye el archivo de conexión a la base de datos
include '../database/Conexion.php';

// Inicia la sesión
session_start();

// Verifica si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene las credenciales del formulario
    $correo = $_POST["Correo"];
    $contrasena = $_POST["Contrasena"];

    // Consulta la base de datos para encontrar un usuario con las credenciales ingresadas
    $sql = "SELECT * FROM integrantes WHERE correo = '$correo' AND contrasena = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Las credenciales son válidas, obtén el rol del usuario
        $row = $result->fetch_assoc();
        $rol = $row["rol"];

        // Guarda la información de sesión del usuario
        $_SESSION['loggedin'] = true;
        $_SESSION['correo'] = $correo;
        $_SESSION['rol'] = $rol;

        // Redirige al usuario a la página correspondiente según su rol
        if ($rol == "docente") {
            header("Location: ../admin/Club.php");
            exit();
        } elseif ($rol == "alumno") {
            header("Location: ./Club.php");
            exit();
        }
    } else {
        $mensaje_error = "Correo o contraseña incorrectos";
    }
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
    <link rel="stylesheet" href="../css/Inicio.css">
</head>
<body>
    <div id="Logo_Bio">
        <div id="logo1">
            <img src="../img/Logo.jpg" alt="LogoBio" id="Logo">
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
            <div id="usuarios-opciones" class="opcion">
                Usuarios
                <div id="usuarios-desplegable" class="desplegable">
                    <a href="inicio.php">Inicio</a>
                    <a href="registro.php">Registro</a>
                </div>
            </div>
        </div>
    </div>
    <div id="contenedor-registro">
        <div class="container">
            <div class="form-container">
                <form id="registro-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                <h1 class="titulo-derecha">Inicio de sesion del club de Bio-Robotica</h1>
                <?php if(isset($mensaje_error)) { ?>
                <div class="error"><?php echo $mensaje_error; ?></div>
                <?php } ?>
                <h5>IMPORTANTE: es indispensable que no compartas tu correo y mucho menos tu contraseña</h5>
                <div class="form-group">
                    <table>
                        <thead>
                            <tr>
                                <th><label for="Correo">Correo:</label>
                                    <input type="text" id="Correo" name="Correo" required>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><label for="Contrasena">Contraseña:</label>
                                <input type="password" id="Contrasena" name="Contrasena" required></th>
                            </tr>
                            <tr>
                            <th><button type="submit" name="submit" class="btn primary">Enviar</button></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div id="boque-final">
        <div id="datos-contacto">
            <p>Derecho reservados del Club de Bio-Robotica ©℗®™</p>
        </div>
    </div>
</body>
</html>