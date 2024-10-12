<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/SMTP.php';
include '../Conexion.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = $_POST['id']; // Obtener el ID del formulario que se está aceptando
        $motivo = $_POST['motivo'];
        $select_sql = "SELECT correo, nombre, nombre_imss, nombre_ine, nombre_credencial, nombre_domicilio, nombre_horario FROM solicitudes WHERE id = $id";
        $result = $conn->query($select_sql);
        if ($result && $result->num_rows > 0) {
            // Obtener nombres de archivos
            $row = $result->fetch_assoc();
            $correo = $row["correo"];
            $nombre = $row["nombre"];
            $documentos = [
                $row['nombre_imss'],
                $row['nombre_ine'],
                $row['nombre_credencial'],
                $row['nombre_domicilio'],
                $row['nombre_horario']
            ];
            // Eliminar los documentos
            foreach ($documentos as $documento) {
                $ruta_documento = '../../document/' . $documento .'.pdf';
                if (file_exists($ruta_documento)) {
                    unlink($ruta_documento);
                }
            }
        }
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
                    $mail->Subject = '¡Oh algo no fue bien!';
                    $mail->Body = "Hola $nombre,\n\n Lamentamos informarte que algo en tu solucitud no salió bien :( \n\n Observaciones: \n\n $motivo \n\n Te invitamos a revisar tus documentos y volver a intentarlo.";
                    // Adjuntar la imagen
                    $imagen_adjunta = '../../img/3D.png'; // Reemplaza '/ruta/a/tu/imagen.jpg' con la ruta de la imagen en tu servidor
                    $mail->addAttachment($imagen_adjunta, 'registrocorreo.jpg'); // Reemplaza 'nombre_personalizado.jpg' con el nombre que desees para el archivo adjunto
                    // Envío del correo electrónico
                    $mail->send();
                    // Redirigir a otra página
                    header("Location: ../../admin/Solicitudes.php");
                    exit();
                } catch (Exception $e) {
                    echo "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
                }
            } else {
                echo "Error al ejecutar la consulta de eliminación: " . $conn->error;
            }
        $conn->close();
        exit; // Terminar el script después de procesar la solicitud AJAX
    }
?>