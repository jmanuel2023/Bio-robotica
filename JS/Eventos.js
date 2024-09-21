function actualizarTiempoRestante() {
    var tiempoRestanteElemento = document.getElementById("tiempo_restante");
    function actualizar() {
        var ahora = new Date().getTime();
        var diferencia = new Date('<?php echo $fecha_evento->format('Y-m-d H:i:s');?>').getTime() - ahora;
        var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
        var horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
        var segundos = Math.floor((diferencia % (1000 * 60)) / 1000);
        dias = agregarCero(dias);
        horas = agregarCero(horas);
        minutos = agregarCero(minutos);
        segundos = agregarCero(segundos);

        tiempoRestanteElemento.textContent = dias + " : " + horas + " : " + minutos + " : " + segundos;
        if (diferencia <= 0) {
            clearInterval(intervalo);
            tiempoRestanteElemento.textContent = "¡El evento ha comenzado!";
        }
    }
    actualizar();
    var intervalo = setInterval(actualizar, 1000);
}

actualizarTiempoRestante();
    function agregarCero(numero) {
    if (numero < 10) {
        return "0" + numero;
    } else {
        return numero;
    }
}

////////////////mas informacion
function mostrarMasInformacion() {
    var masInformacion = document.getElementById("mas-informacion");
    var btnMasInformacion = document.getElementById("btn_mas");
    var estiloMasInformacion = window.getComputedStyle(masInformacion); // Obtiene el estilo calculado del elemento
    if (estiloMasInformacion.display === "none") {
        masInformacion.style.display = "block";
        btnMasInformacion.textContent = "Ocultar";
    } else {
        masInformacion.style.display = "none";
        btnMasInformacion.textContent = "Saber más";
    }
}