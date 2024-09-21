<?php
  include ("../Conexion.php");
    if(isset($_POST['submit'])) {
        $nombre_curso = $_POST['nombre_curso'];
        $duraciont = $_POST['duraciont'];
        $duracionp = $_POST['duracionp'];
        $insert = "INSERT INTO curso(nombre_curso,duracion_practica,duracion_teorica) VALUES ('$nombre_curso',$duracionp,$duraciont)";
        $query = mysqli_query($conn,$insert);
        if($query){
            $ruta_videos="../../videos/".$nombre_curso;
            $ruta_pre="../../docs/".$nombre_curso;
            $ruta_recads="../../docs/".$nombre_curso."/Recursos_adicionales";
            $ruta_evaluacion="../../preguntasJSON/".$nombre_curso;
            if(mkdir($ruta_videos, 0777, true) &&
            mkdir($ruta_pre, 0777, true) &&
            mkdir($ruta_recads, 0777, true) &&
            mkdir($ruta_evaluacion, 0777, true)
            ){
                header("location: ../../resource/cursos2.php");
            }else{
                echo"Hubo un error al crear los directorios";
            }
        }
        
    } else {
        echo "No se recibió ningún dato.";
    }
?>