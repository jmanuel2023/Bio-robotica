<?php

//Aqui inicializo el conector, revisalo ya que mi gestor tiene contraseña
  include ("../database/Conexion.php");
  session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'alumno') {
    header("Location: ../resource/inicio.php");
    exit();
}

  if($_SESSION['rol'] == "docente"){
    $rol = "docente";
  }
  else{
    $rol = "alumno";
  }
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../ico/icon-robots-16_98547.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/Maquetado.css">
  <title>Cursos Comunidad Politécnica</title>
</head>

<body>
  <header id="cabecera">
    <div id="d1">
      <img src="../img/icons/ipn.png" alt="logo del ipn" class="logoprincipal">
      <a href="../index.php"><img src="../img/icons/home.png" alt="home" class="logoprincipalsecundario"></a>
      <a href="./cursos2.php"><img src="../img/icons/regresar.png" alt="regresar" class="logoprincipalsecundario"></a>
      <div class="titulo">
        <h1 class="h11">Cursos</h1>
      </div>
    </div>
    <div id="d2"></div>
  </header>

  <nav id="navegacion">
    <div id="d3">
      <div>
        <p id="ncurso">Bienvenida</p>
      </div>
    </div>
  </nav>

  <main id="principal">
    <section id="izquierda">
      <div class="izq" id="izq-inicial">
        <h1>Lista de cursos</h1>
      </div>
      <?php
      if ($rol == "docente"){ 
        echo "<div class='izq' id='izq-inicial' onclick= \"agregarCurso()\">
          <p class='pizq' id='titleizq'><h1>Agregar Curso</h1></p>
        </div>";
      }
        ?>
      <nav class="nav-bar" id="nav-bar">
        <button id="cerrar-nav"><img src="../img/icons/cerrar.png" height="20px"></button>
        <?php
          $nivel = 3; //Este nivel nos servirá para que funcione el js, y se puedan desplegar los div
          $select = "SELECT * FROM curso";
          $resultado = mysqli_query($conn, $select);
            while ($arreglo_select = mysqli_fetch_array($resultado)) { //Se itera sobre todos los cursos existentes en la bd
              $nombre_curso = $arreglo_select['nombre_curso'];
              $practica = $arreglo_select['duracion_practica'];
              $teorica = $arreglo_select['duracion_teorica'];
              $dir = "../docs/$nombre_curso/Recursos_adicionales/";
            echo "<section class='izq-hijo' onclick='expandirSeccion($nivel)'>
            <div class='izq1' id='izq1'>
              <h1 class='pizq'>$nombre_curso</h1>
            </div>
            <div class='izq$nivel' id='izq$nivel'></div>
            <div class='izq$nivel' id='izq$nivel' onclick=\"mostrarObjetivos('$nombre_curso')\">
              <p class='pizq'><img src='../img/icons/objetivos.png' width='50px' height='50px' style='float:left'>
              <h1 class='pizq'>Objetivos de aprendizaje</h1>
              </p>
            </div>
            <div class='izq$nivel' id='izq$nivel' onclick=\"redireccionar('$nombre_curso')\">
              <p class='pizq'><img src='../img/icons/contenido.png' width='50px' height='50px' style='float:left'>
              <h1 class='pizq'>Contenido del curso</h1>
              </p>
            </div>
            <div class='izq$nivel' id='izq$nivel' onclick=\"mostrarMetodologia('$nombre_curso')\">
              <p class='pizq'><img src='../img/icons/metodologia.png' width='50px' height='50px' style='float:left'>
              <h1 class='pizq'>Metodologia de enseñanza</h1>
              </p>
            </div>"; //En este ultimo div de metodología aqui agregarás la parte del JSON DE metodología de enseñanza
            $archivos = scandir($dir);
            $rec_conter = 1;
            foreach ($archivos as $archivo) { //Escanea solo archivos pdf de recursos para mostrar, asi podrá mostrar tantos como se suban
              if(pathinfo($archivo, PATHINFO_EXTENSION) === 'pdf'){
              echo"<div class='izq$nivel' id='izq$nivel' onclick=\"mostrarRecursos('$nombre_curso','$archivo')\">
              <p class='pizq'><img src='../img/icons/recursos.png' width='50px' height='50px' style='float:left'>
              <h1 class='pizq'>Recursos adicionales $rec_conter</h1>
              </p>
            </div>";
            $rec_conter = $rec_conter + 1;
              }
            }
            //En lo que sigue igual tendrás que adaptar lo hecho
            echo"
            <div class='izq$nivel' id='izq$nivel' onclick=\"mostrarSoporte('$nombre_curso')\">
              <p class='pizq'><img src='../img/icons/soporte.png' width='50px' height='50px' style='float:left'>
              <h1 class='pizq'>Soporte</h1>
              </p>
            </div>";
            if ($rol == "alumno"){
            echo"<div class='izq$nivel' id='izq$nivel' onclick=\"interactividad('$nombre_curso')\">
            <p class='pizq'><img src='../img/icons/interactividad.png' width='50px' height='50px' style='float:left'>
            <h1 class='pizq'>Interactividad</h1>
            </p></div>";
            }
            echo "<div class='izq$nivel' id='izq$nivel' onclick=\"mostrarDuracion('$teorica','$practica')\">
              <p class='pizq'><img src='../img/icons/tiempos.png' width='50px' height='50px' style='float:left'>
              <h1 class='pizq'>Tiempos y duración</h1>
              </p>
            </div>";
            if ($rol == "docente"){ 
            echo "<div class='izq$nivel' id='izq$nivel' onclick=\"llamarFunciones('$nombre_curso')\">
                <p class='pizq'><img src='../img/icons/editar.png' width='50px' height='50px'
                    style='float:left; margin-top: 0px; margin-right: 5px'>Editar Curso</p>
              </div>
              <div class='izq$nivel' id='izq$nivel' onclick=\"eliminarCurso('$nombre_curso')\">
                <p class='pizq'><img src='../img/icons/borrar.png' width='50px' height='50px'
                    style='float:left; margin-top: 0px; margin-right: 5px'>Eliminar Curso</p>
              </div>
          </section>";
            }
          $nivel = $nivel + 1;
            }
        ?>
      </nav>
    </section>

    <section id="derecha">
      <div id="d6">
      </div>
    </section>
  </main>

  <footer id="pie">
    <div id="d7"></div>
  </footer>
  <script src="../JS/main.js"></script>
  <script src="../JS/index_js.js"></script>
</body>

</html>