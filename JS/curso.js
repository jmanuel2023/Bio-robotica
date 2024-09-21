function mostrarVideo(nombre, contenido, archivo){
    var documento = "<video src='../../videos/"+nombre+"/"+contenido+"/"+archivo+"' class='vid' controls autoplay></video>";
    document.getElementById('d6').innerHTML = documento;
}
function mostrarInfografia(nombre,contenido,archivo){
    var documento = "<embed class='doc' src='../../docs/"+nombre+"/"+contenido+"/Infografias/"+archivo+"' type='application/pdf' navpanes=0 toolbar=0/>";
    document.getElementById('d6').innerHTML = documento;
  }
  function mostrarEjemplo(nombre,contenido,archivo){
    var documento = "<embed class='doc' src='../../docs/"+nombre+"/"+contenido+"/Ejemplos/"+archivo+"' type='application/pdf' navpanes=0 toolbar=0/>";
    document.getElementById('d6').innerHTML = documento;
  }
  function mostrarActividad(nombre,contenido,archivo){
    var documento = "<embed class='doc' src='../../docs/"+nombre+"/"+contenido+"/Actividades/"+archivo+"' type='application/pdf' navpanes=0 toolbar=0/>";
    document.getElementById('d6').innerHTML = documento;
  }
  function agregarLeccion(nombre) {
    var documento = "<div id='d6-container'><form method='post' action='agregar_leccion.php'>"+
    "<h1 class='titulo-formulario'>Nombre de lección:</h1>"+
    "<input type='text' id='nombre_leccion' name='nombre_leccion'>"+
    "<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>"+
    "<input type='submit' name='submit' value='Agregar'>"+
  "</form></div>";
  document.getElementById('d6').innerHTML = documento;
  }
  function editarLeccion(nombre,contenido) {
    var documento = "<div id='d6-container'><h1 class='titulo-formulario'>Editar Lección</h1>"+
    "<h1 class='titulo-formulario'>Subir video</h2>"+
        "<form action='subir_archivo.php' method='post' enctype='multipart/form-data'>"+
        "<input type='file' name='archivo_mp4' accept='.mp4'>"+
        "<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>"+
        "<input type='hidden' id='nombre_contenido' name='nombre_contenido' value='"+contenido+"'>"+
        "<input type='submit' value='Subir video' name='submit_video'>"+
    "</form>"+
    "<h1 class='titulo-formulario'>Subir Infografía</h2>"+
    "<form action='subir_archivo.php' method='post' enctype='multipart/form-data'>"+
        "<input type='file' id='infografia_pdf' name='infografia_pdf' accept='.pdf'>"+
        "<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>"+
        "<input type='hidden' id='nombre_contenido' name='nombre_contenido' value='"+contenido+"'>"+
        "<input type='submit' value='Subir Infografia' name='submit_info'>"+
    "</form>"+
    "<h1 class='titulo-formulario'>Subir Actividad</h2>"+
    "<form action='subir_archivo.php' method='post' enctype='multipart/form-data'>"+
        "<input type='file' id='actividad_pdf' name='actividad_pdf' accept='.pdf'>"+
        "<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>"+
        "<input type='hidden' id='nombre_contenido' name='nombre_contenido' value='"+contenido+"'>"+
        "<input type='submit' value='Subir Actividad' name='submit_actividad'>"+
    "</form>"+
    "<section id='crearForm'><h2 class='titulo-formulario'>Crear Cuestionario</h2>"+
    "<label for='numPreguntas'>¿Cuantas preguntas va a contener tu cuestionario?</label>"+
    "<input type='number' id='numPreguntas' min='1' required>"+
    "<input type='submit' value='Empezar a crear Cuestionario' name='submit_cuestionario' onclick='crearFormulario()'>"+
    "<form id='formulario_cuestionario' style='display: none;' onsubmit='return enviarCuestionario()'>"+
    "<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>"+
    "<input type='hidden' id='nombre_contenido' name='nombre_contenido' value='"+contenido+"'>"+
    "</form></section></div>";
    document.getElementById('d6').innerHTML = documento;
  }

  function llamarFunciones2 (nombre,contenido){
    editarLeccion(nombre,contenido);
    verificarExistenciaCuestionario(nombre,contenido);
  }
  async function verificarExistenciaCuestionario(nombre, contenido) {
    const urlArchivo = '../../preguntasJSON/'+nombre+'/'+contenido+'/'+contenido+'.json';
    try {
        const response = await fetch(urlArchivo, { method: 'HEAD' });
        if (response.status === 200) {
            ocultarSection();
        } else if (response.status === 404) {
          console.log('El archivo no existe.');
      } else {
          console.log('Error al verificar la existencia del archivo. Código de estado:', response.status);
      }
    } catch (error) {
        console.error('Error al verificar la existencia del archivo:', error);
    }
}
        function ocultarSection() {
            const section = document.getElementById('crearForm');
            if (section) {
                section.style.display = 'none';
            }
        }

  function crearFormulario() {
    const numPreguntas = parseInt(document.getElementById('numPreguntas').value);
            const formulario = document.getElementById('formulario_cuestionario');
            const div=document.getElementById('d6');
            formulario.innerHTML = '';

            for (let i = 0; i < numPreguntas; i++) {
                const preguntaLabel = document.createElement('label');
                preguntaLabel.textContent = `Pregunta ${i + 1}: `;
                const preguntaInput = document.createElement('input');
                preguntaInput.type = 'text';
                preguntaInput.name = `pregunta_${i + 1}`;
                formulario.appendChild(preguntaLabel);
                formulario.appendChild(preguntaInput);
                formulario.appendChild(document.createElement('br'));

                for (let j = 0; j < 4; j++) {
                    const opcionLabel = document.createElement('label');
                    opcionLabel.textContent = `Opción ${j + 1}: `;
                    const opcionInput = document.createElement('input');
                    opcionInput.type = 'text';
                    opcionInput.name = `opcion_${i + 1}_${j + 1}`;
                    formulario.appendChild(opcionLabel);
                    formulario.appendChild(opcionInput);
                    formulario.appendChild(document.createElement('br'));
                }

                const opcionCorrectaLabel = document.createElement('label');
                opcionCorrectaLabel.textContent = 'Opción Correcta (1-4): ';
                const opcionCorrectaInput = document.createElement('input');
                opcionCorrectaInput.type = 'number';
                opcionCorrectaInput.name = `opcion_correcta_${i + 1}`;
                opcionCorrectaInput.min = '1';
                opcionCorrectaInput.max = '4';
                formulario.appendChild(opcionCorrectaLabel);
                formulario.appendChild(opcionCorrectaInput);
                formulario.appendChild(document.createElement('br'));
            }

            const botonEnviar = document.createElement('button');
            botonEnviar.type = 'submit';
            botonEnviar.textContent = 'Enviar Cuestionario';
            formulario.appendChild(botonEnviar);

            formulario.style.display = 'block';
            return false; 
 }

        function enviarCuestionario() {
          const numPreguntas = parseInt(document.getElementById('numPreguntas').value);
          const nombre = document.getElementById('nombre_curso').value;
          const contenido = document.getElementById('nombre_contenido').value;
          const formData = new FormData(document.getElementById('formulario_cuestionario'));
          const data = {};
          for (const [key, value] of formData.entries()) {
            data[key] = value;
          }
          data['numPreguntas']= numPreguntas;
          data['nombre_curso'] = nombre;
          data['nombre_contenido'] = contenido;
          console.log(data);
          var jsonCuestionario = JSON.stringify(data);
          fetch('../Cuestionario/crearCuestionario.php', {
            method: 'POST',
            headers: {
              'Content-Type':'application/json'
            },
            body: jsonCuestionario
          })
          .then(response => response.text())
          .then(data => {
            alert(data);
            window.location.href="materia.php?nombre="+nombre;
          })
          .catch(error => {
            console.error('Error al enviar la solicitud fetch:', error);
          })
          return false; 
        } 
  function verEvaluacion(nombre, contenido){
    var archivoJSON = "../../preguntasJSON/"+nombre+"/"+contenido+"/"+contenido+".json";
      fetch(archivoJSON)
      .then(response => response.json()) 
      .then(cuestionario => {
        var htmlCuestionario = "<div id='d6-container'>"; 
        htmlCuestionario += "<h1>Cuestionario</h1>";

        htmlCuestionario += "<form id='cuestionario'>";
          var id=1;
          htmlCuestionario += "<section class='seccion'>";
        cuestionario.preguntas.forEach(function(pregunta, indice) {
          

            htmlCuestionario += "<h1 class='question'>Pregunta " + (indice + 1) + ": " + pregunta.pregunta + "</h1>";
            pregunta.opciones.forEach(function(opcion, indiceOpcion) {
              htmlCuestionario += "<section id='miSeccion' class='seccion option' onclick=seleccion("+id+");>";
                htmlCuestionario += '<input type="radio" id="radio'+ id+'" name="pregunta' + (indice + 1) + '" value="' + (indiceOpcion + 1) + '"> ' + opcion + '<br>';
                id++;
                htmlCuestionario += "</section>";
            });
            htmlCuestionario += "</section>";
        });
        
        htmlCuestionario +="<br>";
        htmlCuestionario +="<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>";
        htmlCuestionario +="<input type='hidden' id='nombre_contenido' name='nombre_contenido' value='"+contenido+"'>";
        htmlCuestionario +="<input type='submit' value='Verificar Respuestas'>";
        htmlCuestionario +="</form>";
        htmlCuestionario += "</div>";


        document.getElementById('d6').innerHTML = htmlCuestionario;

        
        document.getElementById('cuestionario').addEventListener('submit', function(event) {
          event.preventDefault();
          verificarRespuestasUsuario(event); 
      });
    })
    .catch(error => {
        console.error('Error al cargar el cuestionario:', error);
    });
  }

  
function verificarRespuestasUsuario(event) {
  event.preventDefault();
  var curso = document.getElementById('nombre_curso').value;
  var contenido= document.getElementById('nombre_contenido').value;
  var respuestas_usuario = {
    respuestas: [],
    curso: curso,
    contenido: contenido
};
    var radios = document.querySelectorAll('input[type="radio"]:checked');
    
    radios.forEach(function(radio) {
        respuestas_usuario.respuestas.push(radio.value);
    });
    var respuesta = JSON.stringify(respuestas_usuario);
    fetch('../Cuestionario/verificar_respuestas.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: respuesta
  })
  .then(response => response.json())
  .then(data => {
    let alertMessage = `Puntuación: ${data.puntuacion}\nResultados:\n`;
    
    data.resultados.forEach(resultado => {
        alertMessage += `${resultado}\n`;
    });
    
    alert(alertMessage);
    window.location.href='./materia.php?nombre='+curso; 
  })
  .catch(error => {
      console.error('Error al verificar respuestas:', error);
  });
}

function borrarLeccion (curso, leccion){
  fetch('eliminarLeccion.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'  
    },
    body: JSON.stringify({ nombre_curso: curso,
      nombre_leccion: leccion})
  })
  .then(response => response.text())
  .then(data => {
    alert(data)
    window.location.href="./materia.php?nombre="+curso;
  })
  .catch(error => {
    console.error('Error al verificar el curso:', error);
  });
}
