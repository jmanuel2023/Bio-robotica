<?php
  include ("../Conexion.php");
    if(isset($_POST['submit'])) {
        $nombre = $_POST['nombre_leccion'];
        $nombre_curso = $_POST['nombre_curso'];
        $insert = "INSERT INTO contenido_curso(curso_nombre,nombre_contenido) VALUES ('$nombre_curso','$nombre')";
        $query = mysqli_query($conn,$insert);
        if($query){
            $ruta_videos="../../videos/".$nombre_curso."/".$nombre;
            $ruta_pre="../../docs/".$nombre_curso."/".$nombre;
            $ruta_infografias="../../docs/".$nombre_curso."/".$nombre."/Ejemplos";
            $ruta_ejemplos="../../docs/".$nombre_curso."/".$nombre."/Infografias";
            $ruta_actividades="../../docs/".$nombre_curso."/".$nombre."/Actividades";
            $ruta_evaluacion="../../preguntasJSON/".$nombre_curso."/".$nombre;
            if(mkdir($ruta_videos, 0777, true) &&
            mkdir($ruta_pre, 0777, true) &&
            mkdir($ruta_infografias, 0777, true) &&
            mkdir($ruta_ejemplos, 0777, true) &&
            mkdir($ruta_evaluacion, 0777, true) &&
            mkdir($ruta_actividades, 0777, true)
            ){
                header("location: materia.php?nombre=$nombre_curso");
            }else{
                echo"Hubo un error al crear los directorios";
            }
        }
        
    } else {
        echo "No se recibió ningún dato.";
    }
?>