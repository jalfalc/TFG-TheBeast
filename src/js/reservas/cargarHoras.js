// js/reservas/cargarHoras.js

/**
 * Este script gestiona la carga y visualización de las horas disponibles
 * al reservar o editar una cita.
 * 
 * - Inicializa Flatpickr para seleccionar la fecha.
 * - Al cambiar fecha o servicio, solicita las horas libres al servidor.
 * - Filtra las horas pasadas si se elige el día actual.
 * - Mantiene seleccionada la hora escogida si sigue disponible tras cada refresco.
 * - Muestra cada hora como un botón clicable; al seleccionar, habilita el botón de confirmar.
 * - Refresca automáticamente cada 3 segundos para evitar solapamientos.
 */

document.addEventListener('DOMContentLoaded', () => {
  // Referencia al input de fecha manejado por Flatpickr
  const inputFecha = document.getElementById('fecha');
  // Referencia al select de servicio
  const selectServicio = document.getElementById('servicio');
  // Contenedor donde se mostrarán los botones de las horas disponibles
  const contenedorHoras = document.getElementById('horas-disponibles');
  // Input oculto que guardará la hora seleccionada para enviar al servidor
  const inputHoraSeleccionada = document.getElementById('hora-seleccionada');
  // Botón "Confirmar cita" que solo se habilita al escoger una hora válida
  const buttonConfirmar = document.getElementById('btn-confirmar');

  // Variable interna para almacenar temporalmente la hora elegida
  let horaSeleccionadaInterna = null;

  // 1) Inicializar el calendario Flatpickr:
  //    - Idioma en español
  //    - Primer día de la semana: lunes
  //    - Despliega mes + año en dropdown
  //    - Modo inline (siempre visible)
  //    - No permite fechas anteriores al día de hoy
  //    - Formato interno de la fecha: "YYYY-MM-DD"
  //    - Al cambiar fecha, se llama a la función recargarHoras()
  flatpickr(inputFecha, {
    locale: 'es',
    firstDayOfWeek: 1,
    monthSelectorType: "dropdown",
    inline: true,
    minDate: "today",
    dateFormat: "Y-m-d",
    onChange: recargarHoras,
  });

  // 2) Cuando cambia el servicio, se recargan las horas disponibles
  selectServicio.addEventListener('change', recargarHoras);

  /**
   * Función que solicita al servidor las horas libres para la fecha y servicio seleccionados,
   * filtra las horas anteriores si la fecha es hoy, y muestra los botones correspondientes.
   * Mantiene la selección previa si sigue disponible tras el refresco.
   */
  async function recargarHoras() {
    // Guardar la hora que estaba seleccionada antes de refrescar (para intentar mantenerla)
    const horaPrevia = horaSeleccionadaInterna;

    // Obtener valores actuales de fecha y servicio
    const fechaSeleccionada = inputFecha.value;
    const servicioElegido   = selectServicio.value;

    // Si falta fecha o servicio, limpiar contenedor y deshabilitar botón
    if (!fechaSeleccionada || !servicioElegido) {
      contenedorHoras.innerHTML = "";
      horaSeleccionadaInterna = null;
      inputHoraSeleccionada.value = "";
      buttonConfirmar.disabled = true;
      return;
    }

    // 3.a) Petición al backend para obtener todas las horas libres en formato JSON
    const respuesta = await fetch(
      `index.php?controlador=Reservas&action=Horas`
      + `&fecha=${encodeURIComponent(fechaSeleccionada)}`
      + `&servicio=${encodeURIComponent(servicioElegido)}`
    );
    if (!respuesta.ok) return;

    // Obtener el array de horas desde la respuesta
    let listaHoras = (await respuesta.json()).horas;

    // 3.b) Si la fecha seleccionada es el día de hoy, filtrar horas pasadas
    const ahora = new Date();
    const año   = ahora.getFullYear();
    const mes   = String(ahora.getMonth() + 1).padStart(2, "0");
    const dia   = String(ahora.getDate()).padStart(2, "0");
    const fechaHoy = `${año}-${mes}-${dia}`; // Formato "YYYY-MM-DD"

    if (fechaSeleccionada === fechaHoy) {
      // Obtener hora y minuto actuales en formato "HH:mm"
      const horaActual = String(ahora.getHours()).padStart(2, "0");
      const minutoActual = String(ahora.getMinutes()).padStart(2, "0");
      const marcaTiempo = `${horaActual}:${minutoActual}`;

      // Filtrar solo las horas posteriores o iguales a la hora actual
      listaHoras = listaHoras.filter(hora => hora >= marcaTiempo);
    }

    // 3.c) Limpiar cualquier hora previa y repintar el contenedor
    contenedorHoras.innerHTML = "";

    // Marcar si la hora previa sigue en la lista
    const sigueDisponible = listaHoras.includes(horaPrevia);

    listaHoras.forEach(hora => {
      // Crear un botón para cada hora disponible
      const botonHora = document.createElement('button');
      botonHora.type = 'button';
      botonHora.textContent = hora;
      botonHora.dataset.hora = hora;

      // Si coincide con la hora previa y esta aún está disponible, marcarlo como seleccionado
      if (hora === horaPrevia) {
        botonHora.classList.add('seleccionada');
        horaSeleccionadaInterna = horaPrevia;
        inputHoraSeleccionada.value = horaPrevia;
      }

      // Al hacer clic en este botón:
      // - Desmarca el botón previamente seleccionado (si existe)
      // - Marca el botón actual como seleccionado
      // - Almacena la hora en la variable interna y en el input oculto
      // - Habilita el botón de confirmar cita
      botonHora.addEventListener('click', () => {
        const previo = contenedorHoras.querySelector('button.seleccionada');
        if (previo) {
          previo.classList.remove('seleccionada');
        }
        botonHora.classList.add('seleccionada');
        horaSeleccionadaInterna = hora;
        inputHoraSeleccionada.value = hora;
        buttonConfirmar.disabled = false;
      });

      // Añadir el botón al contenedor
      contenedorHoras.appendChild(botonHora);
    });

    // 3.d) Si la hora previa ya no está disponible, reiniciar la selección
    if (!sigueDisponible) {
      horaSeleccionadaInterna = null;
      inputHoraSeleccionada.value = "";
      buttonConfirmar.disabled = true;
    } else {
      // Si sigue disponible, mantener el botón “Confirmar” habilitado
      buttonConfirmar.disabled = false;
    }
  }

  // 4) Programar refresco automático cada 3 segundos
  //    para reflejar cambios en horas reservadas desde otros clientes
  setInterval(recargarHoras, 3000);

  // 5) Primera carga de horas (aunque aún no haya fecha/servicio)
  recargarHoras();
});
