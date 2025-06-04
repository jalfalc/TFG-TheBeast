// js/reservas/editarReserva.js
document.addEventListener('DOMContentLoaded', () => {
  const calendarioEl = document.getElementById('calendario');
  const fechaInput   = document.getElementById('fecha');
  const servicioSel  = document.getElementById('servicio');
  const horasCont    = document.getElementById('horas-disponibles');
  const horaOculta   = document.getElementById('hora-seleccionada');
  const btnGuardar   = document.querySelector('#form-editar button[type="submit"]');

  // Valores iniciales: nunca habilitado hasta elegir hora
  let fechaActual = '';
  let horaActual  = '';
  btnGuardar.disabled = true;

  // 1) Inicializar calendario Flatpickr INLINE en español
  flatpickr(calendarioEl, {
    inline: true,
    locale: 'es',
    dateFormat: 'Y-m-d',
    minDate: 'today',
    onChange(selectedDates, dateStr) {
      fechaActual = dateStr;
      fechaInput.value = dateStr;
      // refrescar horas, pero NO tocar btnGuardar
      cargarHoras();
    }
  });

  // 2) Cuando cambie servicio, refrescar horas
  servicioSel.addEventListener('change', () => {
    cargarHoras();
  });

  // 3) Carga de horas disponibles
  async function cargarHoras() {
    // limpiar grid y estado de hora/submit
    horasCont.innerHTML = '';
    horaOculta.value = '';
    horaActual = '';
    btnGuardar.disabled = true;

    if (!servicioSel.value || !fechaInput.value) {
      return;
    }

    const res = await fetch(
      `index.php?controlador=Reservas&action=Horas` +
      `&fecha=${encodeURIComponent(fechaInput.value)}` +
      `&servicio=${encodeURIComponent(servicioSel.value)}`
    );
    if (!res.ok) return;
    const { horas } = await res.json();

    horas.forEach(h => {
      const btn = document.createElement('button');
      btn.type         = 'button';
      btn.textContent  = h;
      btn.dataset.hora = h;

      btn.addEventListener('click', () => {
        // desmarcar cualquier otro
        horasCont.querySelector('button.seleccionada')
          ?.classList.remove('seleccionada');
        // marcar este
        btn.classList.add('seleccionada');

        // guardar hora y habilitar submit
        horaOculta.value = h;
        horaActual = h;
        btnGuardar.disabled = false;
      });

      horasCont.appendChild(btn);
    });
  }
});
