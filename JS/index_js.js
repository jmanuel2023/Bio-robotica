function mostrarObjetivos(nombre){
    var documento = "<embed class='doc' src='../docs/"+nombre+"/programa_sintetico.pdf' type='application/pdf' navpanes=0 toolbar=0/>";
    document.getElementById('d6').innerHTML = documento;
  }
function mostrarRecursos(nombre, doc){
    var documento = "<embed class='doc' src='../docs/"+nombre+"/Recursos_adicionales/"+doc+"' type='application/pdf' navpanes=0 toolbar=0/>";
    document.getElementById('d6').innerHTML = documento;
  }
function mostrarDuracion(teoria, practica){
  var documento = "<div id='d6-container'>"+
  "<h2 class='in_der'>Duración Teórica</h2>"+
  "<p class='in_der'>"+teoria+" horas</p>"+
  "<h2 class='in_der'>Duración Práctica</h2>"+
  "<p class='in_der'>"+practica+" horas</p>"
"</div>";
  document.getElementById('d6').innerHTML = documento;
}
  function redireccionar(nombre){
    window.location.href = "../database/Curso/materia.php?nombre="+nombre;
  }
  function agregarCurso() {
    var documento = "<div id='d6-container'><form method='post' action='../database/Curso/agregar_curso.php'>"+
    "<h1 class='titulo-formulario'>Nombre del Curso:</h1>"+
    "<input type='text' id='nombre_curso' name='nombre_curso'>"+
    "<h1 class='titulo-formulario'>Duracion Teorica:</h1>"+
    "<input type='text' id='duraciont' name='duraciont'>"+
    "<h1 class='titulo-formulario'>Duración Práctica:</h1>"+
    "<input type='text' id='duracionp' name='duracionp'>"+
    "<input type='submit' name='submit' value='Agregar'>"+
  "</form></div>";
  document.getElementById('d6').innerHTML = documento;
  }
  function editarCurso(nombre) {
    var documento = "<div id='d6-container'><h1 class='titulo-formulario'>Editar Curso</h1>"+
    "<h1 class='titulo-formulario'>Subir Programa Sintético</h2>"+
        "<form action='../database/Curso/subir_archivo.php' method='post' enctype='multipart/form-data'>"+
        "<input type='file' id='programa_pdf' name='programa_pdf' accept='.pdf'>"+
        "<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>"+
        "<input type='submit' value='Subir Programa' name='submit_programa'>"+
    "</form>"+
    "<section id='metodologia'><h2 class='titulo-formulario'>Metodología de Enseñanza</h2>"+
        "<form>"+
        "<label><input type='checkbox' id='checkbox1' name='opcion1' value='inductivo' />Inductivo</label><br>"+
        "<label><input type='checkbox' id='checkbox2' name='opcion2' value='deductivo' />Deductivo</label><br>"+
        "<label><input type='checkbox' id='checkbox3' name='opcion3' value='analogico' />Analogico</label><br>"+
        "<label><input type='checkbox' id='checkbox4' name='opcion4' value='heuristico' />Heuristico</label><br>"+
        "<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>"+
        "<input type='submit' value='Guardar Metodología' name='submit' onclick=\"enviarMetodologia(event)\">"+
    "</form></section>"+
    "<h1 class='titulo-formulario'>Subir Recurso Adicional</h2>"+
    "<form action='../database/Curso/subir_archivo.php' method='post' enctype='multipart/form-data'>"+
        "<input type='file' id='recad_pdf' name='recad_pdf' accept='.pdf'>"+
        "<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>"+
        "<input type='submit' value='Subir Recurso' name='submit_recad'>"+
    "</form>"+
    "<section id='soporte'><h2 class='titulo-formulario'>Soporte</h2>"+
    "<h1 class='titulo-formulario'>Agrega aqui a los profesores que imparten la materia de  "+nombre+"</h3>"+
        "<form>"+
        "<label for='name_prof'>Nombre del profesor:</label>"+
        "<input type='text' id='name_prof' name='name_prof'>"+
        "<label for='horario'>Horario de atencion</label>"+
        "<span> DE </span>"+
        "<select id='hora1'>"+
          "<option value='07:00'>07:00 AM</option>"+
          "<option value='08:30'>08:30 AM</option>"+
          "<option value='10:00'>10:00 AM</option>"+
          "<option value='10:30'>10:30 AM</option>"+
          "<option value='12:00'>12:00 PM</option>"+
          "<option value='13:30'>01:30 PM</option>"+
          "<option value='15:00'>03:00 PM</option>"+
          "<option value='16:30'>04:30 PM</option>"+
          "<option value='18:00'>06:00 PM</option>"+
          "<option value='18:30'>06:30 PM</option>"+
          "<option value='20:00'>08:00 PM</option>"+
       "</select>"+
       "<span> A </span>"+
       "<select id='hora2'>"+
          "<option value='08:30'>08:30 AM</option>"+
          "<option value='10:00'>10:00 AM</option>"+
          "<option value='10:30'>10:30 AM</option>"+
          "<option value='12:00'>12:00 PM</option>"+
          "<option value='13:30'>01:30 PM</option>"+
          "<option value='15:00'>03:00 PM</option>"+
          "<option value='16:30'>04:30 PM</option>"+
          "<option value='18:00'>06:00 PM</option>"+
          "<option value='18:30'>06:30 PM</option>"+
          "<option value='20:00'>08:00 PM</option>"+
          "<option value='21:30'>09:30 PM</option>"+
       "</select>"+
        "<label for='email'>Correo:</label>"+
        "<input type='email' id='email' name='email'>"+ 
        "<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>"+
        "<input type='submit' value='Guardar Profesor' name='submit' onclick=\"enviarSoporte(event)\">"+
    "</form></section></div>";
    document.getElementById('d6').innerHTML = documento;
  }

  function llamarFunciones(nombre){
    editarCurso(nombre);
    verificarExistenciaCurso();
  }

  function verificarExistenciaCurso() {
    var curso= document.getElementById('nombre_curso').value;
    fetch('../database/Metodologia/verificarMetodo.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'  
      },
      body: JSON.stringify({ nombre_curso: curso })
    })
    .then(response => response.json())
    .then(data => {
      if (data == "1") {
        document.getElementById('metodologia').style.display = 'none';
      } else {
        document.getElementById('metodologia').style.display = 'block';
      }
    })
    .catch(error => {
      console.error('Error al verificar el curso:', error);
    });
  }
  function enviarMetodologia(event){
    event.preventDefault();

    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var opcionesSeleccionadas = {
      inductivo: "0",
      deductivo: "0",
      analogico: "0",
      heuristico: "0"
    };
  
    checkboxes.forEach(function(checkbox) {
      if (checkbox.checked) {
        opcionesSeleccionadas[checkbox.value] = "1";
      }
    });
    var curso= document.getElementById('nombre_curso').value;
    fetch('../database/Metodologia/agregarMetodologia.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'  
      },
      body: JSON.stringify({opciones: opcionesSeleccionadas,
      curso_nombre: curso})
    })
    .then(response => response.text())
    .then(datos => {
      alert(datos);
      window.location.href= "./cursos2.php";
    })
    .catch(error => {
      alert("Error al enviar los datos"+ error);
    });
  }


  function mostrarMetodologia(nombreCurso) {
    fetch('../database/Metodologia/obtenerMetodologia.php?curso_nombre=' + encodeURIComponent(nombreCurso))
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud al PHP.');
            }
            return response.text(); 
        })
        .then(data => {
            document.getElementById("d6").innerHTML = data;
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
        });
}

  function mostrarSoporte (nombre){
  fetch('../database/Soporte/obtenerSoporte.php?curso_nombre=' + encodeURIComponent(nombre))
  .then(response => {
    if (!response.ok) {
      throw new Error('Ocurrió un error al obtener los datos');
    }
    return response.json();
  })
  .then(data => {
    console.log(data);
    var soporte = "<div id='d6-container'>"; 
      soporte += "<h1>Aqui encontraras el contacto y horarios de atencion de los profesores que imparten el curso</h1>";
      soporte += "<table>\
      <tr>\
      <th>Nombre del Profesor</th> \
      <th>Horarios de atención</th> \
      <th>Correo electronico institucional</th> \
      </tr>";

      data.forEach(fila => {
        soporte += `<tr><td>${fila.profesor}</td><td>${fila.horario}</td><td>${fila.correo}</td></tr>`;
      });
      soporte += "</table></div>";

      document.getElementById('d6').innerHTML = soporte;
  })
  .catch(error => {
    console.error('Error al obtener los datos:', error);
  });

  }

  function enviarSoporte(event){
    event.preventDefault();
    var curso= document.getElementById('nombre_curso').value;
    var prof = document.getElementById('name_prof').value;
    var hora1= document.getElementById('hora1').value;
    var hora2= document.getElementById('hora2').value;
    var horaTotal = hora1+"-"+hora2+" horas";
    var email = document.getElementById('email').value;
    fetch('../database/Soporte/agregarSoporte.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'  
      },
      body: JSON.stringify({curso_nombre: curso,
        profesor: prof, 
        horario: horaTotal,
        correo: email})
    })
    .then(response => response.text())
    .then(datos => {
      alert(datos);
      window.location.href= "./cursos2.php";
    })
    .catch(error => {
      alert("Error al enviar los datos"+ error);
    });
  }

  function interactividad(nombre) {
    var formularioHTML = "<div id='d6-container'>";
      formularioHTML += "<h1 class='titulo-formulario'>Si tienes alguna duda o pregunta, comunicate via correo con el profesor de tu preferencia.</h1>";
      formularioHTML += "<form>";
        formularioHTML += "<label for='nombre'>Nombre:</label>";
        formularioHTML += "<input type='text' id='nombre' name='nombre'>";
        formularioHTML += "<label for='email'>Correo electrónico:</label>";
        formularioHTML += "<input type='email' id='email' name='email'>";
        formularioHTML += "<label for='mensaje'>Mensaje:</label>";
        formularioHTML += "<textarea id='mensaje' name='mensaje'></textarea>";
        formularioHTML += "<input type='submit' value='Enviar' onclick='enviarCorreo(event)'>";
        formularioHTML += "<input type='hidden' id='nombre_curso' name='nombre_curso' value='"+nombre+"'>"
        formularioHTML += "</form>";
        formularioHTML += "</div>";
        document.getElementById('d6').innerHTML= formularioHTML;
  }

  function enviarCorreo(event){
    event.preventDefault();
    var nombre = document.getElementById('nombre').value;
    var correo = document.getElementById('email').value;
    var mensaje = document.getElementById('mensaje').value;
    var curso = document.getElementById('nombre_curso').value;

    fetch('../database/PHPMailer/mandarCorreo.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'  
      },
      body: JSON.stringify({ nombre_curso: curso,
       name: nombre,
       message: mensaje,   
       email: correo   
      })
    })
    .then(response => response.text())
    .then(data => {
      alert(data);
      window.location.href="./cursos2.php";
    })
    .catch(error => {
      console.error('Error al mandar el correo:', error);
    });
  }

  function eliminarCurso (nombre){
    fetch('../database/Curso/eliminarCurso.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'  
      },
      body: JSON.stringify({ nombre_curso: nombre })
    })
    .then(response => response.text())
    .then(data => {
      alert(data)
      window.location.href="./cursos2.php";
    })
    .catch(error => {
      console.error('Error al verificar el curso:', error);
    });
  }

  