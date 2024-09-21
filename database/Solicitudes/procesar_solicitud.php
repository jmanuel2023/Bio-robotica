<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/SMTP.php';
include '../Conexion.php';

// Verificar si se ha enviado la solicitud mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id']; // Obtener el ID del formulario que se está aceptando
    // Consulta SQL para obtener los datos del formulario que se está aceptando
    $sql = "SELECT * FROM solicitudes WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obtener los datos del formulario
        $row = $result->fetch_assoc();
        $correo = $row["correo"];
        $nombre = $row["nombre"];
        // Insertar los datos en la tabla "integrantes"
        $insert_sql = "INSERT INTO integrantes (nombre, apellidos, boleta, correo, contrasena, verifica_contrasena, fecha, telefono, telefono_emer, fecha_nacimiento, genero, nombre_imss, nombre_ine, nombre_credencial, nombre_domicilio, nombre_horario,rol)
                        VALUES ('".$row["nombre"]."', '".$row["apellidos"]."', '".$row["boleta"]."', '".$row["correo"]."','".$row["contrasena"]."','".$row["verifica_contrasena"]."', '".$row["fecha"]."', '".$row["telefono"]."', '".$row["telefono_emer"]."', '".$row["fecha_nacimiento"]."', '".$row["genero"]."', '".$row["nombre_imss"]."', '".$row["nombre_ine"]."', '".$row["nombre_credencial"]."', '".$row["nombre_domicilio"]."', '".$row["nombre_horario"]."','alumno')";

        if ($conn->query($insert_sql) === TRUE) {
            // Mover documentos a la nueva ubicación
            $old_document_path = "../../document/";
            $new_document_path = "../../documents/";

            // Obtener los nombres de los documentos de los campos relevantes
            $document_nombres = $row['nombre_imss'] . ',' . $row['nombre_ine'] . ',' . $row['nombre_credencial'] . ',' . $row['nombre_domicilio'] . ',' . $row['nombre_horario'];

            // Separar los nombres de los documentos en un array
            $document_array = explode(",", $document_nombres);

            // Recorrer y mover documentos
            foreach ($document_array as $documento) {
                $documento_con_extension = $documento . '.pdf';
                $old_file = $old_document_path . $documento_con_extension;
                $new_file = $new_document_path . $documento_con_extension;
                // Verificar si el archivo existe antes de moverlo
                if (file_exists($old_file)) {
                    // Mover el archivo
                    if (!rename($old_file, $new_file)) {
                        echo "Error al mover el archivo $documento_con_extension. Ruta original: $old_file, Ruta nueva: $new_file";
                        exit;
                    } else {
                        echo "Archivo $documento_con_extension movido correctamente.";
                    }
                } else {
                    echo "El archivo $documento_con_extension no existe en la ubicación original: $old_file";
                }
            }
            // Si la inserción fue exitosa, puedes eliminar la solicitud de la tabla "solicitudes"
            $delete_sql = "DELETE FROM solicitudes WHERE id = $id";
            if ($conn->query($delete_sql)) {
                    // Envío de correo electrónico al usuario registrado
                    $mail = new PHPMailer(true);
                    try {
                        // Configuración del servidor SMTP
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'escombio.robotica@gmail.com';
                        $mail->Password = 'vqsn ejla eell ltuo';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                        // Configuración del correo electrónico
                        $mail->setFrom('escombio.robotica@gmail.com', 'Bio-Robotica');
                        $mail->addAddress($correo, $nombre);
                        $mail->Subject = '¡En hora buena!';
                        $mail->Body = "Hola $nombre,\n\n ¡felicidades te admitieron en el club, podras iniciar sesion con tu correo y contraseña apartir de ahora, podras disfrutar del apartado de cursos y de materiales. \n\n ¡Bienvenido!";
                        // Adjuntar la imagen
                        $imagen_adjunta = '../../img/3D.png'; // Reemplaza '/ruta/a/tu/imagen.jpg' con la ruta de la imagen en tu servidor
                        $mail->addAttachment($imagen_adjunta, 'registrocorreo.jpg'); // Reemplaza 'nombre_personalizado.jpg' con el nombre que desees para el archivo adjunto
                        // Envío del correo electrónico
                        $mail->send();
                        // Redirigir a otra página
                        header("Location: ../../../../../Bio-Robotica/admin/Solicitudes.php");
                        exit();
                    } catch (Exception $e) {
                        echo "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
                    }
            } else {
                echo "Error al ejecutar la consulta de eliminación: " . $conn->error;
            }
        } else {
            echo "Error al insertar en la tabla de integrantes: " . $conn->error;
        }
    } else {
        echo "No se encontraron datos para la solicitud.";
    }
    $conn->close();
    exit; // Terminar el script después de procesar la solicitud AJAX
}
?>