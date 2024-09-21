<?php
    include("../Conexion.php");
    $nombreCurso = $_GET['curso_nombre'];
    $sql = "SELECT * FROM metodo_curso WHERE curso_nombre = '$nombreCurso'";
    $result = mysqli_query($conn, $sql);

    while ($arreglo_select = mysqli_fetch_array($result)){
        $curso = $arreglo_select['curso_nombre'];
        $inductivo = $arreglo_select['inductivo'];
        $deductivo = $arreglo_select['deductivo'];
        $heuristico = $arreglo_select['heuristico'];
        $analogico = $arreglo_select['analogico'];

        if($heuristico == '1'){
            echo "<div id='heuristico'><h2 class='in_der'>Heurístico</h2><p class='in_der'>
            Es una forma de aprender mediante el cual se le plantean a los aprendientes impulsos que 
            facilitan la búsqueda independiente de problemas y de soluciones, donde el maestro no les informa 
            a los alumnos conocimiento terminados, sino que los lleva al redescubrimiento de las suposiciones. 
            Esta construido sobre el uso de diversos procesos empíricos, es decir, estrategias basadas en la 
            experiencia, la práctica y la observación de los hechos, con el fin de llegar a la solución eficaz 
            de un problema determinado.</p></div>";
        }
        if($inductivo == '1'){
            echo "<div id='inductivo'><h2 class='in_der'>Inductivo</h2> <p class='in_der'>Es 
            una de las formas de aprendizaje, en la que el aprendiente realiza un proceso que parte de la 
            observación y el análisis de una característica de la lengua, hasta la formulación de una regla que 
            explique dichas características. Esta enseñanza pretende que el alumno se implique y tenga una actitud
            activa, lo cual tiene consecuencias positivas en el desarrollo de la autonomía en el aprendizaje, ya 
            que este se acostumbra a analizar la lengua, formular hipótesis y experimentar con ella.</p></div>";
        }
        if($deductivo == '1'){
            echo "<div id='deductivo'><h2 class='in_der'>Deductivo</h2><p class='in_der'>Es una forma de aprender 
            en la que el aprendiente realiza un proceso que aparte de la comprensión de una regla que explica una
            característica de la lengua, para por la observación de como funciona dicha regla mediante ejemplos, 
            para llegar a su práctica posterior. En comparación con la enseñanza inductiva, en el aprendizaje 
            deductivo el alumno tarda menos tiempo en comprender una característica de la lengua y en conocer una 
            regla, aunque se corra el riesgo de que sea un aprendizaje menos duradero. </p></div>";
        }
        if($analogico == '1'){
            echo "<div id='analogico'><h2 class='in_der'>Analógico</h2><p class='in_der'>Es una forma de aprender 
            basada en la capacidad de asociación de la mente, este proceso consiste en tomar una experiencia 
            pasada compararla con una experiencia actual, para llegar a conclusiones acerca de la experiencia actual
            apoyándose en otras experiencias ya ocurridas. Es un método utilizado ampliamente en ámbitos cotidianos,
            pero también es una herramienta fundamental en el ámbito profesional. Prácticamente, la enseñanza analógica, 
            es llegar a una conclusión al comparar dos elementos.</p></div>";
        }
    }

?>