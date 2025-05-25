<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>The Beast Barber – Servicios</title>
  <!-- Estilos de la cabecera -->
  <link rel="stylesheet" href="css/header/header.css">
  <!-- Estilos de la sección de servicios y testimonios -->
  <link rel="stylesheet" href="css/servicios/servicios.css">
  <!-- Estilos del pie de página -->
  <link rel="stylesheet" href="css/footer/footer.css">
</head>
<body>
  <!-- ============================
       CABECERA
       ============================ -->
  <?php include 'Header/Header_View.php'; ?>

  <!-- ============================
       SECCIÓN: LLAMADA A LA ACCIÓN
       ============================ -->
  <div class="seccion-introduccion">
    <div class="contenedor-introduccion">
      <!-- Título principal -->
      <h2 class="titulo-introduccion">
        ¿Listo para lucir tu mejor versión?
      </h2>
      <!-- Texto descriptivo -->
      <p class="texto-introduccion">
        Reserva tu cita hoy y dale a tu pelo el estilo que se merece
      </p>
      <!-- Botón de reserva -->
      <a href="reservas.html" class="boton-reservar">
        Reservar cita
      </a>
    </div>
  </div>

  <!-- ============================
       SECCIÓN: SERVICIOS
       ============================ -->
  <div class="seccion-servicios">
    <div class="contenedor-servicios">
      <!-- Aquí se inyectan dinámicamente las tarjetas de servicio -->
      <div class="grid-servicios"></div>
    </div>
  </div>

  <!-- ============================
       SECCIÓN: TESTIMONIOS
       ============================ -->
  <div class="seccion-testimonios">
    <div class="contenedor-testimonios">
      <!-- Título de la sección de testimonios -->
      <h2 class="titulo-testimonios">Nuestros clientes opinan...</h2>
      <!-- Aquí se inyectan dinámicamente las tarjetas de testimonio -->
      <div class="grid-testimonios"></div>
    </div>
  </div>

  <!-- ============================
       PIE DE PÁGINA
       ============================ -->
  <?php include 'Footer/Footer_View.php'; ?>

  <!-- ============================
       MODAL: Información de Servicio
       ============================ -->
  <div id="modal-informacion-servicio" class="modal-informacion" role="dialog">
    <div class="contenido-modal-informacion">
      <!-- Botón para cerrar el modal -->
      <button id="boton-cerrar-modal" class="boton-cerrar-modal" aria-label="Cerrar">
        &times;
      </button>
      <!-- Campos que se rellenan desde JavaScript -->
      <h2 id="titulo-modal"></h2>
      <p id="descripcion-modal"></p>
      <p>
        <strong>Duración:</strong>
        <span id="duracion-modal"></span>
      </p>
      <p>
        <strong>Incluye:</strong>
        <span id="incluye-modal"></span>
      </p>
    </div>
  </div>

  <!-- ============================
       Scripts
       ============================ -->
  <!-- Funcionalidad para generar las tarjetas y gestionar el modal -->
   <script src="js/header.js"></script>
  <script src="js/servicios/servicios.js"></script>
</body>
</html>
