// js/reservas/cargarHoras.js
document.addEventListener('DOMContentLoaded', () => {
  const fechaInput     = document.getElementById('fecha');
  const servicioSelect = document.getElementById('servicio');
  const horasCont      = document.getElementById('horas-disponibles');
  const horaOculta     = document.getElementById('hora-seleccionada');
  const btnConfirmar   = document.getElementById('btn-confirmar');

  let horaSel = null;

  // 1) Inicializar calendario Flatpickr:
  flatpickr(fechaInput, {
    locale: 'es',             // usa traducción al español
    firstDayOfWeek: 1,        // lunes como primer día
    monthSelectorType: "dropdown", // despliega mes + año
    inline: true,             // siempre visible
    minDate: "today",         // no deja fechas pasadas
    dateFormat: "Y-m-d",      // formato interno
    onChange: recargarHoras,  // al cambiar fecha → recargar horas
  });

  // 2) Si cambia el servicio, también recarga horas
  servicioSelect.addEventListener('change', recargarHoras);

  // 3) Función que pide al servidor las horas libres y las pinta:
  async function recargarHoras() {
    const fecha    = fechaInput.value;
    const servicio = servicioSelect.value;
    if (!fecha || !servicio) {
      horasCont.innerHTML = "";
      btnConfirmar.disabled = true;
      return;
    }
    const res = await fetch(
      `index.php?controlador=Reservas&action=Horas`
      + `&fecha=${encodeURIComponent(fecha)}`
      + `&servicio=${encodeURIComponent(servicio)}`
    );
    if (!res.ok) return;
    const { horas } = await res.json();

    horasCont.innerHTML = "";
    horas.forEach(h => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.textContent = h;
      btn.dataset.hora = h;
      btn.addEventListener('click', () => {
        // Desmarcar anterior
        horasCont.querySelector('button.seleccionada')
                 ?.classList.remove('seleccionada');
        btn.classList.add('seleccionada');
        horaSel = h;
        horaOculta.value = h;
        btnConfirmar.disabled = false;
      });
      horasCont.appendChild(btn);
    });

    // Reset selección si recarga desde cero
    horaSel = null;
    horaOculta.value = "";
    btnConfirmar.disabled = true;
  }

  // 4) Auto-refresh cada 3s para mantener horas actualizadas
  setInterval(recargarHoras, 3000);

  // 5) Primera carga de horas (aunque aún no haya fecha/servicio)
  recargarHoras();
});
