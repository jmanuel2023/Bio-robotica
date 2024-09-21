<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data === null) {
        http_response_code(400);
        echo "Error: Datos JSON no válidos.";
        exit;
    }

    if (!isset($data['numPreguntas'])) {
        http_response_code(400); 
        echo "Error: Falta el número de preguntas.";
        exit;
    }
    $cuestionario = [];
    $numPreguntas = intval($data['numPreguntas']);
    $nombreContenido = $data['nombre_contenido'];
    $nombreCurso = $data['nombre_curso'];

    for ($i = 1; $i <= $numPreguntas; $i++) {
        $pregunta = $data["pregunta_$i"];
        $opciones = [];
        for ($j = 1; $j <= 4; $j++) {
            $opciones[] = $data["opcion_${i}_${j}"];
        }
        $opcionCorrecta = $data["opcion_correcta_$i"];
        $questions = [
            'pregunta' => $pregunta,
            'opciones' => $opciones,
            'opcion_correcta' => intval($opcionCorrecta)
        ];
        $cuestionario['preguntas'][] = $questions;
    }

    $jsonCuestionario = json_encode($cuestionario, JSON_PRETTY_PRINT);

    $nombreArchivo = "$nombreContenido.json";
    $rutaArchivo = '../../preguntasJSON/'.$nombreCurso.'/'.$nombreContenido.'/'. $nombreArchivo;
    file_put_contents($rutaArchivo, $jsonCuestionario);
    http_response_code(200); // OK
    echo "Cuestionario guardado correctamente";
} else {
    http_response_code(405); 
    echo "Error: Método de solicitud no permitido.";
}
?>
