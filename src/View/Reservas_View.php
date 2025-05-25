<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Reservar Cita</title>
  <link rel="stylesheet" href="css/header/header.css"/>
  <link rel="stylesheet" href="css/reservas/reservas.css"/>
  <link rel="stylesheet" href="css/footer/footer.css"/>
  <!-- Flatpickr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>
</head>
<body>
  <?php include 'Header/Header_View.php'; ?>

  <div id="content-reservas">
    <div class="reservas-container">
      <h2>Reservar Cita</h2>

      <?php if(!empty($mensaje)): ?>
        <div class="reserva-mensaje success"><?= htmlspecialchars($mensaje) ?></div>
      <?php elseif(!empty($error)): ?>
        <div class="reserva-mensaje error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form id="form-reserva" action="index.php?controlador=Reservas&action=Confirmar" method="post" novalidate>
        <div class="form-group">
          <label for="servicio">Servicio:</label>
          <select id="servicio" name="servicio" required>
            <option value="">-- Elige un servicio --</option>
            <option value="Corte clásico">Corte clásico</option>
            <option value="Degradado">Degradado</option>
            <option value="Barba">Barba</option>
          </select>
        </div>

        <div class="form-group">
          <label for="fecha">Fecha:</label>
          <input type="text" id="fecha" name="fecha" placeholder="Selecciona fecha" required readonly>
        </div>

        <div class="form-group">
          <label>Horas disponibles:</label>
          <div id="horas-disponibles" class="horas-grid"></div>
        </div>

        <input type="hidden" name="hora" id="hora-seleccionada"/>
        <button type="submit" id="btn-confirmar" class="btn" disabled>Confirmar cita</button>
      </form>
    </div>
  </div>

  <?php include 'Footer/Footer_View.php'; ?>
  <script src="js/header.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="js/reservas/cargarHoras.js"></script>
</body>
</html>
