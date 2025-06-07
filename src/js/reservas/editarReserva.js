// js/reservas/editarReserva.js

/**
 * Este script gestiona la carga y visualización de las horas disponibles
 * cuando el usuario edita una cita.
 *
 * - Inicializa Flatpickr en modo inline para escoger fecha.
 * - Al cambiar fecha o servicio, pide al servidor las horas libres.
 * - Si la fecha elegida es hoy, filtra las horas anteriores a la hora actual.
 * - Mantiene seleccionada la hora previa si sigue disponible tras cada recarga.
 * - Muestra cada hora como botón; al hacer clic en uno, habilita “Guardar cambios”.
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1) Referencias al DOM:
  const calendarioEl       = document.getElementById('calendario');
  const fechaInput         = document.getElementById('fecha');
  const servicioSel        = document.getElementById('servicio');
  const horasCont          = document.getElementById('horas-disponibles');
  const horaOculta         = document.getElementById('hora-seleccionada');
  const btnGuardar         = document.querySelector('#form-editar button[type="submit"]');

  // 2) Variable interna que almacena la hora preseleccionada (si hubiese)
  let horaSeleccionadaInterna = null;

  // 3) Al cargar la página, “Guardar cambios” siempre disabled hasta escoger hora:
  btnGuardar.disabled = true;

  // 4) Inicializar Flatpickr en modo inline:
  flatpickr(calendarioEl, {
    inline: true,
    locale: 'es',
    dateFormat: 'Y-m-d',
    minDate: 'today',
    onChange(selectedDates, dateStr) {
      // Cuando cambies la fecha:
      fechaInput.value = dateStr;
      cargarHoras(); // recargar horas disponibles
    }
  });

  // 5) Cuando cambie el select de servicio, recargar horas también:
  servicioSel.addEventListener('change', () => {
    cargarHoras();
  });

  /**
   * Función que solicita al servidor horas libres para la fecha/servicio actual,
   * filtra las horas anteriores si la fecha es hoy y pinta los botones.
   * Además, mantiene seleccionada una hora previa si aún sigue disponible.
   */
  async function cargarHoras() {
    // 5.a) Recordar qué hora estaba marcada antes (para intentar mantenerla)
    const horaPrevia = horaSeleccionadaInterna;

    // 5.b) Resetar contenedor y estado de “Guardar cambios”
    horasCont.innerHTML = '';
    horaOculta.value     = '';
    horaSeleccionadaInterna = null;
    btnGuardar.disabled  = true;

    // 5.c) Leer fecha y servicio elegidos
    const fechaSel   = fechaInput.value;
    const servicio   = servicioSel.value;
    if (!fechaSel || !servicio) {
      // Si falta alguno, no pedimos nada
      return;
    }

    // 5.d) Hacer la petición AJAX al controlador Reservas→Horas
    const respuesta = await fetch(
      `index.php?controlador=Reservas&action=Horas` +
      `&fecha=${encodeURIComponent(fechaSel)}` +
      `&servicio=${encodeURIComponent(servicio)}`
    );
    if (!respuesta.ok) return;

    // 5.e) Extraer el array de horas libres (["09:00", "09:30", ...])
    let listaHoras = (await respuesta.json()).horas;

    // 5.f) Si la fecha seleccionada es hoy, filtrar las horas anteriores a la hora actual:
    const ahora  = new Date();
    const año    = String(ahora.getFullYear());
    const mes    = String(ahora.getMonth() + 1).padStart(2, '0');
    const dia    = String(ahora.getDate()).padStart(2, '0');
    const fechaHoy = `${año}-${mes}-${dia}`; // ej. "2025-06-06"

    if (fechaSel === fechaHoy) {
      const horaActual   = String(ahora.getHours()).padStart(2, '0');
      const minutoActual = String(ahora.getMinutes()).padStart(2, '0');
      const marcaTiempo  = `${horaActual}:${minutoActual}`; // ej. "17:32"
      listaHoras = listaHoras.filter(hora => hora >= marcaTiempo);
    }

    // 5.g) Comprobar si la hora previa sigue disponible
    const sigueDisponible = listaHoras.includes(horaPrevia);

    // 5.h) Pintar un botón por cada hora en listaHoras
    listaHoras.forEach(hora => {
      const botonHora = document.createElement('button');
      botonHora.type         = 'button';
      botonHora.textContent  = hora;
      botonHora.dataset.hora = hora;

      // Si coincide con la hora previa, marcarlo “seleccionada”
      if (hora === horaPrevia) {
        botonHora.classList.add('seleccionada');
        horaSeleccionadaInterna = horaPrevia;
        horaOculta.value = horaPrevia;
      }

      // Al hacer clic en un botón de hora:
      botonHora.addEventListener('click', () => {
        const previoBtn = horasCont.querySelector('button.seleccionada');
        if (previoBtn) {
          previoBtn.classList.remove('seleccionada');
        }
        botonHora.classList.add('seleccionada');
        horaSeleccionadaInterna = hora;
        horaOculta.value        = hora;
        btnGuardar.disabled     = false;
      });

      horasCont.appendChild(botonHora);
    });

    // 5.i) Si la hora previa sigue libre, dejamos “Guardar cambios” habilitado
    if (sigueDisponible) {
      btnGuardar.disabled = false;
    }
    // Si no sigue disponible, ya se quedó disabled arriba
  }
});
