// =========================================================
// header.js
// Controla la apertura y cierre del panel de navegación móvil
// =========================================================

document.addEventListener('DOMContentLoaded', () => {
  // 1. Referencias a elementos del DOM
  const botonHamburguesa = document.querySelector('.boton-hamburguesa');
  const panelNavegacion  = document.getElementById('panel-navegacion');
  const botonCerrarPanel = document.getElementById('boton-cerrar-panel');

  // 2. Al hacer click en la hamburguesa, abrir el panel
  botonHamburguesa.addEventListener('click', () => {
    panelNavegacion.classList.add('open');
  });

  // 3. Al hacer click en la X, cerrar el panel
  botonCerrarPanel.addEventListener('click', () => {
    panelNavegacion.classList.remove('open');
  });

  // 4. Si se hace click fuera del contenido del panel, cerrarlo
  panelNavegacion.addEventListener('click', event => {
    if (event.target === panelNavegacion) {
      panelNavegacion.classList.remove('open');
    }
  });
});
