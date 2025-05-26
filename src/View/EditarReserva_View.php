<?php
// Variables disponibles: $reserva = ['id','servicio','fecha','hora','fecha_formateada','hora_corto']
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Modificar Reserva</title>
  <link rel="stylesheet" href="css/header/header.css"/>
  <link rel="stylesheet" href="css/reservas/reservas.css"/>
  <link rel="stylesheet" href="css/footer/footer.css"/>
  <!-- Flatpickr core + traducción ES -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>
</head>
<body>
  <?php include 'Header/Header_View.php'; ?>

  <div id="content-reservas">
    <div class="reservas-container">
      <h2>Modificar Reserva</h2>

      <?php if(!empty($_SESSION['error_reserva'])): ?>
        <div class="reserva-mensaje error">
          <?= htmlspecialchars($_SESSION['error_reserva']) ?>
        </div>
        <?php unset($_SESSION['error_reserva']); ?>
      <?php endif; ?>

      <form id="form-editar" action="index.php?controlador=MisReservas&action=Actualizar" method="post" novalidate>
        <input type="hidden" name="id" value="<?= $reserva['id'] ?>">

        <!-- 1) Mostrar la fecha actual como texto -->
        <div class="form-group">
          <label>Fecha de la cita actual:</label>
          <p class="fecha-actual">
            <?= htmlspecialchars($reserva['fecha_formateada']) ?>
            a las <?= htmlspecialchars($reserva['hora_corto']) ?>
          </p>
        </div>

        <!-- 2) Selector de servicio -->
        <div class="form-group">
          <label for="servicio">Servicio:</label>
          <select id="servicio" name="servicio" required>
            <?php foreach (['Corte clásico','Degradado','Barba'] as $s): ?>
              <option value="<?= $s ?>"
                <?= $s === $reserva['servicio'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($s) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- 3) Calendario inline (sin preselección) -->
        <div class="form-group calendario-wrapper">
          <div id="calendario"></div>
        </div>

        <!-- 4) Campos ocultos para fecha+hora elegidas -->
        <input type="hidden" id="fecha" name="fecha" value="">
        <div class="form-group">
          <label>Horas disponibles:</label>
          <div id="horas-disponibles" class="horas-grid"></div>
        </div>
        <input type="hidden" id="hora-seleccionada" name="hora" value=""/>

        <!-- 5) Botones alineados -->
        <div class="form-buttons">
          <button type="submit" class="btn">Guardar cambios</button>
          <a href="index.php?controlador=MisReservas" class="btn btn-cancel">Cancelar</a>
        </div>
      </form>
    </div>
  </div>

  <?php include 'Footer/Footer_View.php'; ?>

  <script src="js/header.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
  <script src="js/reservas/editarReserva.js"></script>
</body>
</html>
