document.addEventListener('DOMContentLoaded', () => {
  // Selecciona todos los formularios de eliminación
  document.querySelectorAll('.form-eliminar').forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      // Muestra el confirm; si acepta, envía el form
      if (confirm('¿Seguro que deseas cancelar esta cita?')) {
        form.submit();
      }
    });
  });
});