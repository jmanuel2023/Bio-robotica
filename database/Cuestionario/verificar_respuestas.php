<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['respuestas']) && isset($data['curso']) && isset($data['contenido'])) {
        $respuestas= $data['respuestas'];
        $curso = $data['curso'];
        $contenido = $data['contenido'];

        $rutaArchivo = '../../preguntasJSON/'. $curso .'/'. $contenido .'/'. $contenido .'.json';
        $jsonString = file_get_contents($rutaArchivo);
        $data2 = json_decode($jsonString, true);
        

        if ($data2) {
            $respuestas_correctas = array_column($data2['preguntas'], 'opcion_correcta');
            $puntuacion = 0;
            $resultados = [];

            foreach ($respuestas as $indice => $respuesta) {
                $opcionCorrecta = $respuestas_correctas[$indice];

                if ($respuesta == $opcionCorrecta) {
                    $puntuacion++;
                    $resultados[] = "Pregunta " . ($indice + 1) . ": ¡Correcto!";
                } else {
                    $resultados[] = "Pregunta " . ($indice + 1) . ": Incorrecto. La respuesta correcta era la opción " . $opcionCorrecta;
                }
            }

            $respuestaPHP = json_encode(['puntuacion' => $puntuacion, 'resultados' => $resultados ]);
            header('Content-Type: application/json');
            echo $respuestaPHP;
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al cargar el archivo JSON']);
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Respuestas no recibidas']);
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Metodo de solicitud no permitido']);
    exit;
}
?>
