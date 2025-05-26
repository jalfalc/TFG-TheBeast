<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="css/header/header.css">
  <link rel="stylesheet" href="css/login/login.css">
  <link rel="stylesheet" href="css/footer/footer.css">
</head>
<body>
  <?php include 'Header/Header_View.php';?>

  <!--
    Contenedor principal de toda la zona de login.
    Es un flex que ocupa todo el alto disponible
    y centra su único hijo (.background-overlay).
  -->
  <div id="content-login">
    <!--
      Capa intermedia que ahora también es un flex,
      para centrar vertical y horizontalmente el login-box.
    -->
    <div class="background-overlay">

      <!--
        Caja blanca/verde con bordes redondeados:
        ancho fijo (max 400px), altura mínima para que
        no crezca al mostrarse errores.
      -->
      <div class="login-container">
        <h2>Iniciar Sesión</h2>

        <!--
          Aquí se muestra el error de servidor o JS.
          Está siempre reservado el espacio de 1rem arriba
          para no recolocar todo al aparecer.
        -->
        <div id="login-error" class="form-error">
          <?php
          if (isset($_GET['error']) && $_GET['error'] === 'invalid') {
              echo 'Error: los campos introducidos no son válidos';
          }
          ?>
        </div>

        <!--
          Formulario de login. novalidate para que JS maneje
          la validación y no el HTML5 por defecto.
        -->
        <form id="form-login" action="index.php?controlador=Verify" method="post" novalidate>
          <div class="form-group">
            <label for="username">Correo electrónico:</label>
            <input type="text" id="username" name="mail" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
          </div>
          <button type="submit" class="btn">Enviar</button>
        </form>

        <!--
          Enlace para ir a la página de registro si no hay cuenta.
        -->
        <p class="register-link">
          ¿No tienes una cuenta?
          <a href="index.php?controlador=Login&action=Registro">Crear cuenta</a>
        </p>
      </div>
    </div>
  </div>

  <?php include 'Footer/Footer_View.php';?>
  <script src="js/header.js"></script>
  <script src="js/login/validarLogin.js"></script>
</body>
</html>
