<header>
  <div class="logo-container">
    <img src="../img/logo.png" alt="Logo The Beast Barber">
  </div>

  <!-- Botón hamburguesa (solo en móvil) -->
  <button class="boton-hamburguesa" aria-label="Abrir menú">
    &#9776;
  </button>

  <!-- Navegación principal (visible en desktop) -->
  <nav class="menu-container">
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="index.php?controlador=Servicios">Servicios</a></li>
      <li><a href="index.php?controlador=Principal#contacto">Contacto</a></li>
      <li><a href="#">Reservar</a></li>
      <?php if (isset($_SESSION["loged"]) && $_SESSION["loged"] === true) { ?>
        <li><a href="index.php?controlador=Citas">Mis citas</a></li>
        <li><a href="index.php?controlador=Logout" id="logout">Cerrar sesión</a></li>
      <?php } else { ?>
        <li><a href="index.php?controlador=Login" id="login">Iniciar sesión</a></li>
      <?php } ?>
    </ul>
  </nav>

  <!-- Panel de navegación (móvil) -->
  <aside id="panel-navegacion" class="panel-navegacion">
    <button id="boton-cerrar-panel" class="boton-cerrar-panel" aria-label="Cerrar menú">
      &times;
    </button>
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="index.php?controlador=Servicios">Servicios</a></li>
      <li><a href="index.php?controlador=Principal#contacto">Contacto</a></li>
      <li><a href="#">Reservar</a></li>
      <?php if (isset($_SESSION["loged"]) && $_SESSION["loged"] === true) { ?>
        <li><a href="index.php?controlador=Citas">Mis citas</a></li>
        <li><a href="index.php?controlador=Logout" id="logout">Cerrar sesión</a></li>
      <?php } else { ?>
        <li><a href="index.php?controlador=Login" id="login">Iniciar sesión</a></li>
      <?php } ?>
    </ul>
  </aside>
</header>
