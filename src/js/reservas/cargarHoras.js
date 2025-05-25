// js/reservas/cargarHoras.js
// Gestiona la carga y selección de horas disponibles mediante AJAX y Flatpickr.

document.addEventListener('DOMContentLoaded', () => {
  const fechaInput     = document.getElementById('fecha');
  const servicioSelect = document.getElementById('servicio');
  const horasCont      = document.getElementById('horas-disponibles');
  const horaOculta     = document.getElementById('hora-seleccionada');
  const btnConfirmar   = document.getElementById('btn-confirmar');

  let horaSel = null;

  // 1) Inicializar Flatpickr en el input de fecha
  flatpickr(fechaInput, {
    inline: true,
    minDate: "today",
    dateFormat: "Y-m-d",
    onChange: recargarHoras
  });

  // 2) Refrescar cuando cambie el servicio
  servicioSelect.addEventListener('change', recargarHoras);

  /**
   * Recarga la lista de horas libres desde el servidor
   * según la fecha y servicio seleccionados.
   */
  async function recargarHoras() {
    const fecha   = fechaInput.value;
    const servicio = servicioSelect.value;

    // Si falta algún dato, limpiar lista y deshabilitar
    if (!fecha || !servicio) {
      horasCont.innerHTML = "";
      btnConfirmar.disabled = true;
      return;
    }

    // Petición AJAX a la acción Horas de Reservas_Controller
    const res = await fetch(
      `index.php?controlador=Reservas&action=Horas&fecha=${fecha}` +
      `&servicio=${encodeURIComponent(servicio)}`
    );
    if (!res.ok) return;

    const { horas } = await res.json();

    // Limpiar contenedor y reconstruir botones
    horasCont.innerHTML = "";
    horas.forEach(h => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.textContent = h;
      btn.dataset.hora = h;
      btn.addEventListener('click', () => {
        // Marcar selección
        horasCont.querySelector('button.seleccionada')
          ?.classList.remove('seleccionada');
        btn.classList.add('seleccionada');
        horaSel = h;
        horaOculta.value = h;
        btnConfirmar.disabled = false;
      });
      horasCont.appendChild(btn);
    });

    // Reset selección previa
    horaSel = null;
    horaOculta.value = "";
    btnConfirmar.disabled = true;
  }

  // 3) Auto-recarga cada 30 segundos para evitar choques
  setInterval(recargarHoras, 30000);

  // 4) Carga inicial de horas
  recargarHoras();
});
