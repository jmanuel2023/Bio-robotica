<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir la biblioteca PHPMailer

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

//require 'path/to/PHPMailer/src/Exception.php';
//require 'path/to/PHPMailer/src/PHPMailer.php';
//require 'path/to/PHPMailer/src/SMTP.php';

// Detalles de la conexión
$servername = 'localhost';
$username = 'root';
$password = '030217';
$dbname = 'bio_robotica';

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if(isset($_POST["submit"])) {
    // Preparar los datos del formulario para la inserción en la base de datos
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $boleta = $_POST["boleta"];
    $telefono = $_POST["telefono"];
    $telefono_emer = $_POST["telefono_emer"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $verifica_contrasena = $_POST["verifica-contrasena"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $genero = $_POST["genero"];

    // Verificar si el correo o la boleta ya existen en la base de datos
    $checkQuery = "SELECT * FROM solicitudes WHERE correo = '$correo' OR boleta = '$boleta'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Si ya existe un registro con el correo o la boleta, redirigir al usuario a aviso.php
        header("Location: ../resource/existente.php");
        exit();
    } else {
        // Insertar los datos del formulario en la tabla 'solicitudes'
        $sql = "INSERT INTO solicitudes (nombre, apellidos, boleta, telefono, telefono_emer, correo, contrasena, verifica_contrasena,fecha_nacimiento,genero,
                nombre_imss, nombre_ine, nombre_credencial, nombre_domicilio, nombre_horario)
                VALUES ('$nombre', '$apellidos', '$boleta', '$telefono', '$telefono_emer', '$correo', '$contrasena', '$verifica_contrasena','$fecha_nacimiento','$genero',
                '" . generateUniqueFileName($boleta, "imss") . "', '" . generateUniqueFileName($boleta, "ine") . "',
                '" . generateUniqueFileName($boleta, "ipn") . "', '" . generateUniqueFileName($boleta, "domicilio") . "',
                '" . generateUniqueFileName($boleta, "horario") . "')";

        if ($conn->query($sql) === TRUE) {
            // Manejar cada archivo individualmente
            $target_dir = "../document/";
            $uploadSuccess = true; // Inicializar la variable de éxito de carga
            foreach ($_FILES as $fieldName => $file) {
                $uploadOk = 1;
                // Configurar la ruta de destino para guardar el archivo
                $target_file = $target_dir . generateUniqueFileName($boleta, $fieldName) . "." . pathinfo($file["name"], PATHINFO_EXTENSION);

                // Verificar si el archivo ya existe
                if (file_exists($target_file)) {
                    echo "Lo siento, el archivo ya existe.";
                    $uploadOk = 0;
                }

                // Limitar el tamaño del archivo
                if ($file["size"] > 5000000) { // 5MB
                    echo "Lo siento, el archivo es demasiado grande.";
                    $uploadOk = 0;
                }

                // Permitir ciertos formatos de archivo
                $allowedExtensions = array("pdf", "doc", "docx", "txt");
                $fileExtension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if (!in_array($fileExtension, $allowedExtensions)) {
                    echo "Lo siento, solo se permiten archivos PDF";
                    $uploadOk = 0;
                }

                if ($uploadOk == 0) {
                    echo "Lo siento, tu archivo no fue cargado.";
                    $uploadSuccess = false; // Establecer la variable a false si hay un error de carga
                } else { // Si todo está bien, intenta cargar el archivo
                    if (move_uploaded_file($file["tmp_name"], $target_file)) {
                        echo "El archivo ha sido cargado como '" . basename($target_file) . "'.";
                    } else {
                        echo "Lo siento, hubo un error al cargar tu archivo.";
                        $uploadSuccess = false; // Establecer la variable a false si hay un error de carga
                    }
                }
            }
            if ($uploadSuccess) {
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
                    $mail->Subject = '¡Registro exitoso!';
                    $mail->Body = "Hola $nombre,\n\nGracias por registrarte a el Club de BioRobotica.\n\n No te desesperes!, estamos validando tus documentos en breve terminamos \n\n ¡Bienvenido!";

                    // Adjuntar la imagen
                    $imagen_adjunta = '../img/registrocorreo.jpg'; // Reemplaza '/ruta/a/tu/imagen.jpg' con la ruta de la imagen en tu servidor
                    $mail->addAttachment($imagen_adjunta, 'registrocorreo.jpg'); // Reemplaza 'nombre_personalizado.jpg' con el nombre que desees para el archivo adjunto
                    // Envío del correo electrónico
                    $mail->send();

                    // Redirigir a otra página
                    header("Location: ../resource/registrado.php");
                    exit();
                } catch (Exception $e) {
                    echo "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
                }
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Función para generar un nombre de archivo único
function generateUniqueFileName($boleta, $fieldName) {
    return $boleta . "_" . $fieldName . "_" . time(); // Usamos el tiempo para hacerlo único
}
?>