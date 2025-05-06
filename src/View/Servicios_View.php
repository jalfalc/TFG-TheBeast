<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/header/header.css">
    <link rel="stylesheet" href="css/servicios/servicios.css">
    <link rel="stylesheet" href="css/footer/footer.css">
</head>
<body>
    <?php include 'Header/Header_View.php';?>
    <div class="hero">
        <img src="barbershop-hero.jpg" alt="Barbería" class="hero-image">
        <div class="hero-content">
            <h1 class="hero-title">Nuestros Servicios</h1>
            <a href="reservas.html" class="btn btn-primary">RESERVAS</a>
        </div>
    </div>

    <!-- Tagline -->
    <div class="tagline">
        <h2 class="tagline-text">Experiencia, precisión y estilo en cada corte.</h2>
    </div>

    <!-- Servicios -->
    <div class="container">
        <div class="servicios-grid">
            <!-- Los servicios se generarán con JavaScript -->
        </div>
    </div>

    <!-- Testimonios -->
    <div class="testimonios-section">
        <div class="container">
            <h2 class="section-title">Lo que dicen nuestros clientes</h2>
            <div class="testimonios-grid">
                <!-- Los testimonios se generarán con JavaScript -->
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="cta-section">
        <div class="container">
            <h2 class="cta-title">¿Listo para lucir tu mejor versión?</h2>
            <p class="cta-text">Reserva tu cita hoy y experimenta el servicio premium que mereces.</p>
            <a href="reservas.html" class="btn btn-gold">RESERVAR AHORA</a>
        </div>
    </div>

    <?php include 'Footer/Footer_View.php';?>
</body>
</html>