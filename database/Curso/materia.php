<?php
  include ("../Conexion.php");
    if(isset($_GET['nombre'])) {
        $nombre = $_GET['nombre'];
    } else {
        echo "No se recibió ningún dato.";
    }
    session_start();
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
  <link rel="icon" href="../../ico/icon-robots-16_98547.ico" type="image/x-icon">
  <link rel="stylesheet" href="../../css/Maquetado.css">
  <title>Cursos Comunidad Politécnica</title>
</head>

<body>
  <header id="cabecera">
    <div id="d1">
      <img src="../../img/icons/ipn.png" alt="logo del ipn" class="logoprincipal">
      <?php
      if($rol == "docente"){
        echo "<a href='../../admin/Club.php'><img src='../../img/icons/home.png' alt='home' class='logoprincipalsecundario'></a>";
        echo "<a href='../../admin/cursos2.php'><img src='../../img/icons/regresar.png' alt='regresar' class='logoprincipalsecundario'></a>";
      }
      else {
        echo "<a href='../../resource/Club.php'><img src='../../img/icons/home.png' alt='home' class='logoprincipalsecundario'></a>";
        echo "<a href='../../resource/cursos2.php'><img src='../../img/icons/regresar.png' alt='regresar' class='logoprincipalsecundario'></a>";
      }?>
      
      <div class="titulo">
        <h1 class="h11">Cursos</h1>
      </div>
    </div>
    <div id="d2"></div>
  </header>
  <nav id="navegacion">
    <div id="d3">
      <p id="ncurso"><?php echo"$nombre";?></p>
    </div>
  </nav>
  <main id="principal">
      <section id="izquierda">
        <div class="izq" id="izq-inicial">
          <h1>Lecciones del curso</h1>
        </div>
        <?php 
        if ($rol == "docente"){ 
        echo "<div class='izq' id='izq-inicial' onclick= \"agregarLeccion('$nombre')\">
          <p class='pizq' id='titleizq'><h1>Agregar Leccion</h1></p>
        </div>";
        }?>
        <nav class="nav-bar" id="nav-bar">
          <button id="cerrar-nav"><img src="../../img/icons/cerrar.png" height="20px"></button>
          <?php
          $nivel = 3;
          $select = "SELECT * FROM contenido_curso Where curso_nombre ='$nombre'";
          $resultado = mysqli_query($conn, $select);
            while ($arreglo_select = mysqli_fetch_array($resultado)) {
              $nombre_contenido = $arreglo_select['nombre_contenido'];
              $dir = "../../videos/$nombre/$nombre_contenido/";
              echo "<section class='izq-hijo' onclick=\"expandirSeccion($nivel)\">
              <div class='izq1' id='izq1'>
                <p class='pizq'>$nombre_contenido</p>
              </div>
              <div class='izq$nivel' id='izq$nivel'></div>";
              $videos = scandir($dir);
              foreach ($videos as $archivo) {
                if(pathinfo($archivo, PATHINFO_EXTENSION) === 'mp4' ){
                echo"<div class='izq$nivel' id='izq$nivel' onclick=\"mostrarVideo('$nombre','$nombre_contenido','$archivo')\">
                <p class='pizq'><img src='../../img/icons/video.png' width='50px' height='50px' style='float:left'>
                <h1 class='pizq'>$archivo</h1>
                </p>
              </div>";

            }
              }
              $dirinf = "../../docs/$nombre/$nombre_contenido/Infografias/";
              $infografias = scandir($dirinf);
              $conterinf = 1;
              foreach ($infografias as $archivo) {
                if(pathinfo($archivo, PATHINFO_EXTENSION) === 'pdf' ){
                echo"<div class='izq$nivel' id='izq$nivel' onclick=\"mostrarInfografia('$nombre','$nombre_contenido','$archivo')\">
                <p class='pizq'><img src='../../img/icons/infografia.png' width='50px' height='50px'
                    style='float:left; margin-top: 0px; margin-right: 5px;'>Infografía $conterinf</p>
              </div>";

            }
              }
              $direx = "../../docs/$nombre/$nombre_contenido/Ejemplos/";
              $ejemplos = scandir($direx);
              $conterex = 1;
              foreach ($ejemplos as $archivo) {
                if(pathinfo($archivo, PATHINFO_EXTENSION) === 'pdf' ){
                echo"<div class='izq$nivel' id='izq$nivel' onclick=\"mostrarEjemplo('$nombre','$nombre_contenido','$archivo')\">
                <p class='pizq'><img src='../../img/icons/infografia.png' width='50px' height='50px'
                    style='float:left; margin-top: 0px; margin-right: 5px;'>Ejemplo $conterinf</p>
              </div>";

            }
              }
              $direx="../../docs/$nombre/$nombre_contenido/Actividades/";
              $actividades = scandir($direx);
              $conterex = 1;
              foreach ($actividades as $archivo) {
                if(pathinfo($archivo, PATHINFO_EXTENSION) === 'pdf'){
              echo"<div class='izq$nivel' id='izq$nivel' onclick=\"mostrarActividad('$nombre', '$nombre_contenido','$archivo')\">
                <p class='pizq'><img src='../../img/icons/actividades.png' width='50px' height='50px'
                    style='float:left; margin-top: 0px; margin-right: 5px'>Actividades $conterinf</p>
              </div>";
                }}
              echo"<div class='izq$nivel' id='izq$nivel' onclick=\"verEvaluacion('$nombre','$nombre_contenido')\">
                <p class='pizq'><img src='../../img/icons/evaluacion.png' width='50px' height='50px'
                    style='float:left; margin-top: 0px; margin-right: 5px'>Evaluación</p>
              </div>";
              if ($rol == "docente"){ 
              echo "<div class='izq$nivel' id='izq$nivel' onclick=\"editarLeccion('$nombre','$nombre_contenido')\">
                <p class='pizq'><img src='../../img/icons/editar.png' width='50px' height='50px'
                    style='float:left; margin-top: 0px; margin-right: 5px'>Editar Lección</p>
              </div>
              <div class='izq$nivel' id='izq$nivel' onclick=\"borrarLeccion('$nombre','$nombre_contenido')\">
                <p class='pizq'><img src='../../img/icons/borrar.png' width='50px' height='50px'
                    style='float:left; margin-top: 0px; margin-right: 5px'>Borrar Lección</p>
              </div>
            </section>";
              }
            $nivel = $nivel + 1;
            }
          ?>
        </nav>
      </section>
      <section id="derecha">
        <div id="d6"></div>
      </section>
  </main>

  <footer id="pie">
  </footer>
  <script src="../../JS/main.js"></script>
  <script src="../../JS/curso.js"></script>
</body>
</html>