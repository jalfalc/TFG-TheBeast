<?php
// View/MisReservas_View.php
// Variables disponibles tras llamar a MisReservas_Controller::Mostrar():
//   - $reservas: array de reservas formateadas
//   - $_SESSION['success_reserva'] y $_SESSION['error_reserva'] para mensajes flash
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mis Reservas</title>
  <link rel="stylesheet" href="css/header/header.css"/>
  <link rel="stylesheet" href="css/reservas/mis_reservas.css"/>
  <link rel="stylesheet" href="css/footer/footer.css"/>
</head>
<body>
  <?php include 'Header/Header_View.php'; ?>

  <div id="content-reservas">
    <div class="mis-reservas-container">
      <h2>Mis citas</h2>

      <!-- Flash messages -->
      <?php if (!empty($_SESSION['success_reserva'])): ?>
        <div class="reserva-mensaje success">
          <?= htmlspecialchars($_SESSION['success_reserva']) ?>
        </div>
        <?php unset($_SESSION['success_reserva']); ?>
      <?php elseif (!empty($_SESSION['error_reserva'])): ?>
        <div class="reserva-mensaje error">
          <?= htmlspecialchars($_SESSION['error_reserva']) ?>
        </div>
        <?php unset($_SESSION['error_reserva']); ?>
      <?php endif; ?>

      <?php if (!empty($reservas)): ?>
        <table class="tabla-reservas">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Servicio</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reservas as $r): ?>
              <tr>
                <td>
                  <?= htmlspecialchars($r['fecha_formateada']) ?>
                  a las <?= htmlspecialchars($r['hora_corto']) ?>
                </td>
                <td>
                  <?= htmlspecialchars($r['servicio']) ?>
                </td>
                <td class="acciones">
                  <!-- Enlace para modificar -->
                  <a
                    href="index.php?controlador=MisReservas&action=Modificar&id=<?= $r['id'] ?>"
                    class="btn-modificar"
                  >Modificar</a>

                  <!-- Botón para eliminar (confirm en JS) -->
                  <form
                    method="post"
                    action="index.php?controlador=MisReservas&action=Eliminar"
                    class="form-eliminar"
                  >
                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                    <button type="submit" class="btn-eliminar">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p class="mensaje-no-reservas">
          Actualmente no tienes ninguna cita pendiente.
        </p>
        <div class="acciones-sin-reservas">
          <a href="index.php?controlador=Reservas" class="btn-reservar">
            Reservar cita
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <?php include 'Footer/Footer_View.php'; ?>

  <!-- scripts -->
  <script src="js/header.js"></script>
  <script src="js/reservas/eliminarReserva.js"></script>
</body>
</html>
