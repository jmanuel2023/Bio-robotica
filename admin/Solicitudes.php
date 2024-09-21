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
    <link rel="stylesheet" href="../css/Solicitudes.css">
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
        <div id="Solicitudes">
            <?php
                include '../database/Conexion.php';
                // Consulta SQL para obtener los datos de la tabla solicitudes
                $sql = "SELECT * FROM solicitudes";
                $result = $conn->query($sql);

                // Verificar si hay resultados
                if ($result->num_rows > 0) {
                    // Imprimir encabezados de la tabla
                    echo "<table border='1' class=\"content-table\">";
                    echo "<thead>
                            <tr>
                            <td colspan='6'><center>Solicitudes al Club de Bio-Robotica</center></td>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Boleta</th>
                                <th>Correo</th>
                                <th>Fecha de registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>";
                    echo "<tbody>";
                    while($row = $result->fetch_assoc()) {
                        // Mostrar una fila de la tabla
                        echo "<tr>";
                        echo "<td>".$row["nombre"]."</td>";
                        echo "<td>".$row["apellidos"]."</td>";
                        echo "<td>".$row["boleta"]."</td>";
                        echo "<td>".$row["correo"]."</td>";
                        echo "<td>".$row["fecha"]."</td>";
                        // Botón "Ver más" que despliega más detalles
                        echo "<td><button class='ver-mas' data-id='".$row["id"]."'>Ver más</button></td>";
                        echo "</tr>";
                        // Detalles adicionales ocultos por defecto
                        echo "<tr class='detalles' id='detalles-".$row["id"]."' style='display: none;'>";
                        echo "<td colspan='6'>";
                        echo "<table border='1' class=\"content-table\">";
                        echo "<tr><td>Teléfono:</td><td>".$row["telefono"]."</td>";
                        echo "<td>Teléfono de Emergencia:</td><td>".$row["telefono_emer"]."</td>";
                        echo "<td>Fecha de Nacimiento:</td><td>".$row["fecha_nacimiento"]."</td></tr>";

                        echo "<tr>";
                        echo "<td>Género:</td><td>".$row["genero"]."</td>";
                        echo "<td>Comprobante IMSS:</td><td><a href='../document/".$row["nombre_imss"].".pdf' target='_blank'>Ver PDF</a></td>";
                        echo "<td>Comprobante INE:</td><td><a href='../document/".$row["nombre_ine"].".pdf' target='_blank'>Ver PDF</a></td></tr>";

                        echo "<tr><td>Comprobante Credencial:</td><td><a href='../document/".$row["nombre_credencial"].".pdf' target='_blank'>Ver PDF</a></td>";
                        echo "<td>Comprobante Domicilio:</td><td><a href='../document/".$row["nombre_domicilio"].".pdf' target='_blank'>Ver PDF</a></td>";
                        echo "<td>Comprobante Horario:</td><td><a href='../document/".$row["nombre_horario"].".pdf' target='_blank'>Ver PDF</a></td></tr>";

                        echo "<tr>";
                        echo "<td colspan='3'>
                                <form action='../database/Solicitudes/procesar_solicitud.php' method='post'>
                                    <input type='hidden' name='id' value='".$row["id"]."'>
                                    <button type='submit' class='btn2 generico'>Aceptar</button>
                                </form>
                            </td>";
                        echo "<td colspan='3'>
                            <form action='../database/Solicitudes/eliminar_solicitud.php' method='post'>
                                <input type='hidden' name='id' value='".$row["id"]."'>
                                <textarea name='motivo' placeholder='Motivo del rechazo' style='width: 100%; height: 100px; overflow-wrap: break-word;' required></textarea>
                                <button type='submit' class='btn2 rechazar'>Rechazar</button>
                            </form>
                            </td>
                            </tr>";
                        echo "</table>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    // Cerrar tabla
                    echo "</tbody></table>";
                } else {
                    echo "<h2>No existen solicitudes por el momento</h2>";
                }
                $conn->close();
            ?>
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
        // Script para mostrar/ocultar detalles al presionar el botón "Ver más"
        document.addEventListener('DOMContentLoaded', function() {
            var verMasButtons = document.querySelectorAll('.ver-mas');

            verMasButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var detallesId = 'detalles-' + button.getAttribute('data-id');
                    var detallesRow = document.getElementById(detallesId);
                    detallesRow.style.display = (detallesRow.style.display === 'none' ? '' : 'none');
                });
            });
        });
        document.getElementById('cerrar-sesion').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('form-cerrar-sesion').submit();
        });
    </script>
</body>
</html>