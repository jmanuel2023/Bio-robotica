<?php
if(isset($_POST['submit_video'])){
    $nombre = $_POST['nombre_contenido'];
    $nombre_curso = $_POST['nombre_curso'];
    $directorio_destino = "../../videos/" . $nombre_curso . "/" . $nombre ."/";
    $nombre_archivo = basename($_FILES["archivo_mp4"]["name"]);
    $ruta_archivo = $directorio_destino . $nombre_archivo;

    if(move_uploaded_file($_FILES["archivo_mp4"]["tmp_name"], $ruta_archivo)){
        header("location: materia.php?nombre=$nombre_curso");
    } else {
        echo "Hubo un error al subir el archivo PDF.";
    }
}elseif(isset($_POST['submit_actividad'])){
    $nombre = $_POST['nombre_contenido'];
    $nombre_curso = $_POST['nombre_curso'];
    $directorio_destino = "../../docs/" . $nombre_curso . "/" . $nombre ."/Actividades/"; 
    $nombre_archivo = basename($_FILES["actividad_pdf"]["name"]);
    $ruta_archivo = $directorio_destino . $nombre_archivo;

    if(move_uploaded_file($_FILES["actividad_pdf"]["tmp_name"], $ruta_archivo)){
        header("location: materia.php?nombre=$nombre_curso");
    } else {
        echo "Hubo un error al subir el archivo PDF.";
    }
}elseif(isset($_POST['submit_info'])){
    $nombre = $_POST['nombre_contenido'];
    $nombre_curso = $_POST['nombre_curso'];
    $directorio_destino = "../../docs/" . $nombre_curso . "/" . $nombre ."/Infografias/"; 
    $nombre_archivo = basename($_FILES["infografia_pdf"]["name"]);
    $ruta_archivo = $directorio_destino . $nombre_archivo;

    if(move_uploaded_file($_FILES["infografia_pdf"]["tmp_name"], $ruta_archivo)){
        header("location: materia.php?nombre=$nombre_curso");
    } else {
        echo "Hubo un error al subir el archivo PDF.";
    }
} elseif(isset($_POST['submit_recomendacion'])){
    $nombre = $_POST['nombre_contenido'];
    $nombre_curso = $_POST['nombre_curso'];
    $directorio_destino = "../../docs/" . $nombre_curso . "/" . $nombre ."/Ejemplos/"; 
    $nombre_archivo = basename($_FILES["ejemplo_pdf"]["name"]);
    $ruta_archivo = $directorio_destino . $nombre_archivo;

    if(move_uploaded_file($_FILES["ejemplo_pdf"]["tmp_name"], $ruta_archivo)){
        header("location: materia.php?nombre=$nombre_curso");
    } else {
        echo "Hubo un error al subir el archivo PDF.";
    }
} elseif(isset($_POST['submit_programa'])){
    $nombre_curso = $_POST['nombre_curso'];
    $directorio_destino = "../../docs/" . $nombre_curso . "/"; 
    $nombre_archivo = "programa_sintetico.pdf";
    $ruta_archivo = $directorio_destino . $nombre_archivo;
    if(move_uploaded_file($_FILES["programa_pdf"]["tmp_name"], $ruta_archivo)){
        header("location: ./cursos2.php");
    } else {
        echo "Hubo un error al subir el archivo PDF.";
    }
} elseif(isset($_POST['submit_recad'])){
    $nombre_curso = $_POST['nombre_curso'];
    $directorio_destino = "../../docs/" . $nombre_curso . "/Recursos_adicionales/"; 
    $nombre_archivo = basename($_FILES["recad_pdf"]["name"]);
    $ruta_archivo = $directorio_destino . $nombre_archivo;
    if(move_uploaded_file($_FILES["recad_pdf"]["tmp_name"], $ruta_archivo)){
        header("location: ../../resources/cursos2.php");
    } else {
        echo "Hubo un error al subir el archivo PDF.";
    }
} 
?>