// js/reservas/editarReserva.js
document.addEventListener('DOMContentLoaded', () => {
  const calendarioEl = document.getElementById('calendario');
  const fechaInput   = document.getElementById('fecha');
  const servicioSel  = document.getElementById('servicio');
  const horasCont    = document.getElementById('horas-disponibles');
  const horaOculta   = document.getElementById('hora-seleccionada');
  const btnGuardar   = document.querySelector('#form-editar button[type="submit"]');

  // Valores iniciales en hidden (pueden venir vacíos)
  let fechaActual = fechaInput.value; // "2025-05-27" o ""
  let horaActual  = horaOculta.value; // "13:00" o ""

  // 1) Inicializar Flatpickr INLINE en español
  flatpickr(calendarioEl, {
    inline: true,
    locale: 'es',
    dateFormat: 'Y-m-d',
    // Impide seleccionar fechas anteriores a hoy
    minDate: 'today',
    // Preselecciona la fecha de la reserva si existe
    defaultDate: fechaActual || null,
    onChange(selectedDates, dateStr) {
      // Sólo cuando el usuario elige un día
      if (!dateStr) return;
      fechaActual = dateStr;
      fechaInput.value = fechaActual;
      cargarHoras();
    }
  });

  // 2) Cuando cambie servicio, refrescar horas
  servicioSel.addEventListener('change', cargarHoras);

  // 3) Función para pedir al servidor y pintar horas libres
  async function cargarHoras() {
    // Limpiar estado previo
    horasCont.innerHTML = '';
    horaOculta.value   = '';
    btnGuardar.disabled = true;

    if (!fechaActual || !servicioSel.value) return;

    const res = await fetch(
      `index.php?controlador=Reservas&action=Horas` +
      `&fecha=${fechaActual}` +
      `&servicio=${encodeURIComponent(servicioSel.value)}`
    );
    if (!res.ok) return;

    const { horas } = await res.json();
    horas.forEach(h => {
      const btn = document.createElement('button');
      btn.type        = 'button';
      btn.textContent = h;
      btn.dataset.hora = h;

      // Si coincide con la hora antigua, márcala
      if (h === horaActual) {
        btn.classList.add('seleccionada');
      }

      btn.addEventListener('click', () => {
        horasCont.querySelector('button.seleccionada')
                ?.classList.remove('seleccionada');
        btn.classList.add('seleccionada');
        horaOculta.value = h;
        horaActual      = h;
        btnGuardar.disabled = false;
      });

      horasCont.appendChild(btn);
    });
  }

  // 4) Carga inicial: si ya existía fecha y servicio
  if (fechaActual && servicioSel.value) {
    cargarHoras();
  }
});
