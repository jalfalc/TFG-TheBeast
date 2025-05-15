<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <form action="index.php?controlador=Verify" method="post">
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
                <p class="register-link">¿No tienes una cuenta? <a href="register.php">Crear cuenta</a></p>
            </div>
        </div>
    </div>
    <?php include 'Footer/Footer_View.php';?>

    <script src="js/header.js"></script>
</body>
</html>