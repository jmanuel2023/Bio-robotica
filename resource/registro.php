<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../ico/icon-robots-16_98547.ico" type="image/x-icon">
    <title>Bio-Robotica</title>
    <link rel="stylesheet" href="../css/Panel.css">
    <link rel="stylesheet" href="../css/Usuarios.css">

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
                <form id="registro-form" action="../database/upload.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                <h1 class="titulo-derecha">Registro al club de Bio-Robotica</h1>
                <h5>IMPORTANTE es indispensable que para que tu registro sea validado todos los archivos cargados deben ser PDF, de no serlo tu registro no sera validado con exito.</h5>
                <div class="form-group">
                    <table>
                        <thead>
                            <tr>
                                <th><label for="nombre">Nombre:</label>
                                    <input type="text" id="nombre" name="nombre" required>
                                </th>
                                <th><label for="apellidos">Apellidos:</label>
                                    <input type="text" id="apellidos" name="apellidos" required></th>
                                <th><label for="boleta">Boleta:</label>
                                    <input type="text" id="boleta" name="boleta" required pattern="[0-9]{10}" title="El número de boleta debe tener 10 dígitos"></th>
                                <th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefono" name="telefono" required pattern="[0-9]{10}" title="El número de teléfono debe tener 10 dígitos"></th>
                                <th><label for="telefono_emer">Telefono de Emergencia:</label>
                                    <input type="text" id="telefono_emer" name="telefono_emer" required pattern="[0-9]{10}" title="El número de teléfono debe tener 10 dígitos"></th>
                                <th><label for="correo">Correo:</label>
                                    <input type="email" id="correo" name="correo" required></th>
                            </tr>
                            <tr>
                                <th><label for="contrasena">Contraseña:</label>
                                    <div style="position: relative;">
                                        <input type="password" id="contrasena" name="contrasena" required pattern=".{8,}" title="La contraseña debe tener al menos 8 caracteres">
                                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('contrasena', this)">
                                            <img src="../img/iconver2.png" alt="Toggle Password Visibility" id="ver">
                                        </button>
                                    </div></th>
                                <th><label for="verifica-contrasena">Verifica Contraseña:</label>
                                    <div style="position: relative;">
                                        <input type="password" id="verifica-contrasena" name="verifica-contrasena" required>
                                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('verifica-contrasena', this)">
                                            <img src="../img/iconver2.png" alt="Toggle Password Visibility" id="ver">
                                        </button>
                                    </div></th>
                                <th><label for="fecha_nacimiento">Fecha de nacimiento:</label>
                                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required></th>
                            </tr>
                            <tr>
                            <th><label for="genero">Genero:</label>
                                    <select id="genero" name="genero" required>
                                        <option value="" disabled selected>Selecciona una opción</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </th>
                                <th><label for="domicilio">Comprobante de domicilio:</label>
                                    <input type="file" id="domicilio" name="domicilio" required accept=".pdf"></th>
                                <th><label for="horario">Horario de clases:</label>
                                    <input type="file" id="horario" name="horario" required accept=".pdf"></th>
                            </tr>
                            <tr>
                                <th>
                                    <label for="imss">Comprobante del IMSS u otro:</label>
                                    <input type="file" id="imss" name="imss" required accept=".pdf"></th>
                                <th>
                                    <label for="ine">INE en PDF:</label>
                                    <input type="file" id="ine" name="ine" required accept=".pdf"></th>
                                <th><label for="ipn">Credencial de la escuela en PDF:</label>
                                    <input type="file" id="ipn" name="ipn" required accept=".pdf"></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th><button type="submit" name="submit" class="btn primary">Registrarse</button></th>
                                <th></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </form>
                <div id="mensaje-error" style="display: none; color: red;"></div>
            </div>
        </div>
    </div>
    <div id="boque-final">
        <div id="datos-contacto">
            <p>Derecho reservados del Club de Bio-Robotica ©℗®™</p>
        </div>
    </div>
    <script>

        function validarFormulario() {
            var archivos = document.querySelectorAll('input[type="file"]');
            var archivosValidos = true;

            archivos.forEach(function(archivo) {
                if (!archivo.files[0]) {
                    archivosValidos = false;
                } else {
                    var extension = archivo.files[0].name.split('.').pop().toLowerCase();
                    if (extension !== 'pdf') {
                        archivosValidos = false;
                    }
                }
            });

            if (!archivosValidos) {
                document.getElementById("mensaje-error").innerHTML = "Todos los archivos deben ser PDF.";
                document.getElementById("mensaje-error").style.display = "block"; // Mostrar el mensaje de error
                return false;
            }

            var contraseña = document.getElementById("contrasena").value;
            var verificarContraseña = document.getElementById("verifica-contrasena").value;

            if (contraseña !== verificarContraseña) {
                document.getElementById("mensaje-error").innerHTML = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
                document.getElementById("mensaje-error").style.display = "block"; // Mostrar el mensaje de error
                return false;
            }

            return true;
        }

        function togglePasswordVisibility(idCampo, boton) {
            var campo = document.getElementById(idCampo);
            var tipo = campo.getAttribute("type");
            if (tipo === "password") {
                campo.setAttribute("type", "text");
                boton.innerHTML = '<img src="../img/iconver.png" alt="icon see" id="ver">';
            } else {
                campo.setAttribute("type", "password");
                boton.innerHTML = '<img src="../img/iconver2.png" alt="icon see" id="ver">';
            }
        }
    </script>
</body>
</html>