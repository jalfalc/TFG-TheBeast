<?php
// View/EditarReserva_View.php
// Variables disponibles: $reserva = ['id','servicio','fecha','hora']
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

        <div class="form-group">
          <label for="servicio">Servicio:</label>
          <select id="servicio" name="servicio" required>
            <?php foreach (['Corte clásico','Degradado','Barba'] as $s): ?>
              <option value="<?= $s ?>"
                <?= $s === $reserva['servicio'] ? 'selected' : '' ?>><?= $s ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="fecha">Fecha:</label>
          <input type="text" id="fecha" name="fecha"
                 value="<?= htmlspecialchars($reserva['fecha']) ?>"
                 required readonly>
        </div>

        <div class="form-group">
          <label>Horas disponibles:</label>
          <div id="horas-disponibles" class="horas-grid"></div>
        </div>

        <input type="hidden" name="hora" id="hora-seleccionada" 
               value="<?= htmlspecialchars(substr($reserva['hora'],0,5)) ?>"/>

        <button type="submit" class="btn">Guardar cambios</button>
        <a href="index.php?controlador=MisReservas" class="btn btn-cancel">Cancelar</a>
      </form>
    </div>
  </div>

  <?php include 'Footer/Footer_View.php'; ?>
  <script src="js/header.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="js/reservas/cargarHoras.js"></script>
  <script>
    // Ajuste: al cargar usar la fecha y hora existentes
    document.addEventListener('DOMContentLoaded', () => {
      const fechaInput = document.getElementById('fecha');
      // Inicializa flatpickr
      flatpickr(fechaInput, {
        inline: true,
        dateFormat: "Y-m-d",
        defaultDate: fechaInput.value,
        onChange: () => recargarHoras()
      });
      // Forzar carga inmediata
      recargarHoras();
      // Pre-seleccionar la hora actual
      const horaSel = document.getElementById('hora-seleccionada').value;
      window._horaAnterior = horaSel;
    });
  </script>
</body>
</html>
