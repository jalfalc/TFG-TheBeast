<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Reservar Cita</title>

  <!-- header y footer comunes -->
  <link rel="stylesheet" href="css/header/header.css"/>
  <link rel="stylesheet" href="css/footer/footer.css"/>

  <!-- estilos propios de Reservas -->
  <link rel="stylesheet" href="css/reservas/reservas.css"/>

  <!-- Flatpickr: núcleo + traducción al español -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>
</head>
<body>
  <?php include 'Header/Header_View.php'; ?>

  <!-- contenido principal, este div flex:1 empuja el footer abajo -->
  <div id="content-reservas">
    <div class="reservas-container">
      <h2>Reservar Cita</h2>

      <!-- mensajes de éxito o error desde el controlador -->
      <?php if(!empty($mensaje)): ?>
        <div class="reserva-mensaje success"><?= htmlspecialchars($mensaje) ?></div>
      <?php elseif(!empty($error)): ?>
        <div class="reserva-mensaje error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form id="form-reserva" action="index.php?controlador=Reservas&action=Confirmar" method="post" novalidate>
        <!-- Selector de servicio -->
        <div class="form-group">
          <label for="servicio">Servicio:</label>
          <select id="servicio" name="servicio" required>
            <option value="">-- Elige un servicio --</option>
            <option value="Corte clásico">Corte clásico</option>
            <option value="Degradado">Degradado</option>
            <option value="Barba">Barba</option>
          </select>
        </div>

        <!-- Wrapper que centra el calendario -->
        <div class="form-group calendario-wrapper">
          <!-- Input “técnico” para Flatpickr: oculto luego con CSS -->
          <input
            type="text"
            id="fecha"
            name="fecha"
            class="flatpickr-input oculto"
            required
            readonly
          />
        </div>

        <!-- Horas que carga AJAX tras elegir fecha y servicio -->
        <div class="form-group">
          <label>Horas disponibles:</label>
          <div id="horas-disponibles" class="horas-grid"></div>
        </div>

        <!-- Valor real de la hora elegida, oculto en el formulario -->
        <input type="hidden" name="hora" id="hora-seleccionada"/>

        <!-- Botón de envío, se activa al elegir hora -->
        <button type="submit" id="btn-confirmar" class="btn" disabled>
          Confirmar cita
        </button>
      </form>
    </div>
  </div>

  <?php include 'Footer/Footer_View.php'; ?>

  <!-- scripts -->
  <script src="js/header.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <!-- idioma español y lunes como primer día en el calendario -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
  <!-- nuestro loader de horas -->
  <script src="js/reservas/cargarHoras.js"></script>
</body>
</html>
