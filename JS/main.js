function expandirSeccion(nivel) {
    var elementos = document.querySelectorAll(".izq" + nivel);
    for (var i = 1; i < elementos.length; i++) {
      if (elementos[i].style.display === "block") {
        if(nivel != 1){
          elementos[i].style.display = "none";
        }
      } else {
        elementos[i].style.display = "block";
      }
    }
  }
const nav = document.querySelector("#nav-bar");
const abrir = document.querySelector("#izq-inicial");
const cerrar = document.querySelector("#cerrar-nav");

abrir.addEventListener("click", () =>{
    nav.classList.add("visible");
})
cerrar.addEventListener("click", () =>{
    nav.classList.remove("visible");
})

function seleccion(num){
    var opcion = "radio" + num;
    var radio = document.getElementById(opcion);
   radio.checked = true;
    };

