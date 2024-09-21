<?php
include ("../Conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);    
    $nombre_curso = $data['nombre_curso'];
    $delete = "DELETE FROM curso WHERE nombre_curso='$nombre_curso'";
    $query = mysqli_query($conn, $delete);
    if($query){
        echo "Se ha eliminado correctamente el curso $nombre_curso";
        $ruta_videos = "../../videos/".$nombre_curso;
        $ruta_pre = "../../docs/".$nombre_curso;
        $ruta_recads = "../../docs/".$nombre_curso."/Recursos_adicionales";
        $ruta_evaluacion = "../../preguntasJSON/".$nombre_curso;

        // Función para eliminar directorios y su contenido
        function eliminar_directorio($dir) {
            if (!file_exists($dir)) {
                return true;
            }
            if (!is_dir($dir)) {
                return unlink($dir);
            }
            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') {
                    continue;
                }
                if (!eliminar_directorio($dir . DIRECTORY_SEPARATOR . $item)) {
                    return false;
                }
            }
            return rmdir($dir);
        }

        if(eliminar_directorio($ruta_videos) &&
           eliminar_directorio($ruta_pre) &&
           eliminar_directorio($ruta_recads) &&
           eliminar_directorio($ruta_evaluacion)) {
        } else {
            echo "Hubo un error al eliminar los directorios";
        }
    }
    else{
        echo "Ha ocurrido un error al eliminar el curso $nombre_curso". $conect->error;
    }
} else {
    
    echo "Error: No se recibieron datos.";
}

?>
