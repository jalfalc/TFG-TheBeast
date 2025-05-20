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

    <div id="content-login">
        <div class="background-overlay">
            <div class="login-container">
                <h2>Iniciar Sesión</h2>
                
                <!-- Contenedor único para errores JS o servidor -->
                <div id="login-error" class="form-error">
                    <?php
                    if (isset($_GET['error']) && $_GET['error'] === 'invalid') {
                        echo 'Error: los campos introducidos no son válidos';
                    }
                    ?>
                </div>
                
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
