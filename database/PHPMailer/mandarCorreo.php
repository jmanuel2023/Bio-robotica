<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'SMTP.php';
require 'PHPMailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);    
    
    $curso_nombre = $data['nombre_curso'];
    $nombre = $data['name'];
    $correo = $data['email'];
    $message = $data['message'];

    $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'escombio.robotica@gmail.com';                     //correo remitente
    $mail->Password   = 'vqsn ejla eell ltuo';                               //contraseña remitente
    $mail->SMTPSecure = 'tls';                               
    $mail->Port       = 587;                                    

    //Recipients
    $mail->setfrom('escombio.robotica@gmail.com', 'Bio-Robotica'); //aqui va correo y contraseña del remitente
    $mail->addAddress($correo, $nombre);

    $mail->isHTML(true);
    $mail->Subject = 'Duda o aclaracion por parte del alumno '.$nombre. ' de la materia '. $curso_nombre;
    $mail->Body    = $message;

    $mail->send();
    echo "SE HA MANDADO EL CORREO";
} catch (Exception $e) {
    echo "HUBO UN ERROR AL MANDAR EL CORREO: {$mail->ErrorInfo}";
}

} else {
    
    echo "Error: No se recibieron datos.";
}

