// =========================================================
// Controla la apertura y cierre del panel de navegación móvil
// =========================================================
document.addEventListener('DOMContentLoaded', () => {
  // 1. Referencias a elementos del DOM
  const botonHamburguesa = document.querySelector('.boton-hamburguesa');
  const panelNavegacion  = document.getElementById('panel-navegacion');
  const botonCerrarPanel = document.getElementById('boton-cerrar-panel');

  // Si alguno falta, no hacemos nada
  if (!botonHamburguesa || !panelNavegacion || !botonCerrarPanel) return;

  // Funciones de abrir y cerrar
  function abrirPanel() {
    panelNavegacion.classList.add('open');
    document.body.style.overflow = 'hidden'; // evita scroll detrás del panel
  }
  function cerrarPanel() {
    panelNavegacion.classList.remove('open');
    document.body.style.overflow = '';        // restaura scroll
  }

  // 2. Al hacer click en la hamburguesa, abrir el panel
  botonHamburguesa.addEventListener('click', abrirPanel);

  // 3. Al hacer click en la X, cerrar el panel
  botonCerrarPanel.addEventListener('click', cerrarPanel);

  // 4. Si se hace click fuera del contenido, cerrar
  panelNavegacion.addEventListener('click', event => {
    if (event.target === panelNavegacion) {
      cerrarPanel();
    }
  });
});
