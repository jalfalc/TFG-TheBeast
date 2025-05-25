<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Beast Barber - Inicio</title>
  <link rel="stylesheet" href="css/header/header.css">
  <link rel="stylesheet" href="css/principal/principal.css">
  <link rel="stylesheet" href="css/footer/footer.css">
</head>
<body>
  <?php include 'Header/Header_View.php';?>

  <!-- Carousel principal de imágenes en fondo -->
  <section id="carousel">
    <!-- Capa que mostrará la imagen actual del carrusel -->
    <div class="carousel-slides"></div>

    <!-- Contenido superpuesto al carrusel -->
    <div id="carousel-contenido">
      <h1>The Beast Barber</h1>
      <p>Tu barbería de confianza</p>
      <button>
        <!-- Enlace a la sección de reservas -->
        <a href="index.php?controlador=Reservas">Reservar cita</a>
      </button>
    </div>


    <!-- Puntos indicadores de posición en el carrusel -->
    <div class="carousel-dots"></div>
  </section>

  <!-- Sección de servicios destacados -->
  <section id="servicios">
    <img
      src="../img/principal/servicios.jpg"
      alt="Servicios"
      class="imagen-servicios"
    >
    <div class="contenido-servicios">
      <h1>Descubre los servicios que ofrecemos a nuestros clientes</h1>
      <button class="boton-ver-servicios">
        <a href="index.php?controlador=Servicios">Ver servicios</a>
      </button>
    </div>
  </section>

  <!-- Sección de contacto -->
  <section id="contacto">
    <h1>Contacta con nosotros</h1>
    <div class="contacto-items">
      <div class="item">
        <a href="https://wa.me/34653490196">
          <img src="../img/principal/whatsapp.png" alt="WhatsApp">
        </a>
        <p>653-490-196</p>
      </div>
      <div class="item">
        <a href="https://maps.app.goo.gl/Csqzpr5f7xCwPVyw6">
          <img src="../img/principal/mapa.png" alt="Ubicación">
        </a>
        <p>C. San Antón, 16, 28982 Parla, Madrid</p>
      </div>
      <div class="item">
        <a href="https://www.instagram.com/the._beast._barber/">
          <img src="../img/principal/image.png" alt="Instagram">
        </a>
        <p>The._Beast._Barber</p>
      </div>
    </div>
  </section>

  <!-- Sección de horario de apertura -->
  <section id="horario">
    <h1>Horario de apertura</h1>
    <p>Martes a viernes: 09:00-15:00 | 17:00-21:00</p>
    <p>Sábado y domingo: 09:00-14:00 | 15:00-18:00</p>
    <p>Lunes: Cerrado</p>
  </section>
  
  <?php include 'Footer/Footer_View.php';?>
  
  <script src="js/header.js"></script>
  <script src="js/principal/principal.js"></script>
</body>
</html>
