<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link rel="stylesheet" href="css/header/header.css">
    <link rel="stylesheet" href="css/login/login.css">
    <link rel="stylesheet" href="css/footer/footer.css">
    <style>
        .error {
            color: red;
            font-size: 0.85rem;
            display: block;
            margin-top: 4px;
        }
    </style>
</head>

<body>
    <?php include 'Header/Header_View.php'; ?>

    <div id="content-register">
        <div class="background-overlay">
            <div class="register-container">
                <h2>Crear Cuenta</h2>
                <?php if (isset($_GET['error_message'])): ?>
                    <div class="form-error" style="margin-bottom:1rem; text-align:center;">
                        <?= htmlspecialchars($_GET['error_message']) ?>
                    </div>
                <?php endif; ?>
                <form id="form-register" action="index.php?controlador=Registro" method="post" novalidate>

                    <!-- Nombre -->
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Máximo 20 caracteres">
                        <small id="error-nombre" class="error"></small>
                    </div>

                    <!-- Apellidos -->
                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" placeholder="Máximo 30 caracteres">
                        <small id="error-apellidos" class="error"></small>
                    </div>

                    <!-- Teléfono -->
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono"
                            placeholder="Sin prefijo, 9 dígitos">
                        <small id="error-telefono" class="error"></small>
                    </div>

                    <!-- Correo -->
                    <div class="form-group">
                        <label for="mail">Correo electrónico:</label>
                        <input type="email" id="mail" name="mail" placeholder="Ejemplo: jorge@gmail.com">
                        <small id="error-mail" class="error"></small>
                    </div>

                    <!-- Contraseña -->
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres">
                        <small id="error-password" class="error"></small>
                    </div>

                    <!-- Repetir contraseña -->
                    <div class="form-group">
                        <label for="password2">Repetir contraseña:</label>
                        <input type="password" id="password2" name="password2">
                        <small id="error-password2" class="error"></small>
                    </div>

                    <!-- Botón -->
                    <button type="submit" class="btn">Registrar</button>
                </form>
                <p class="register-link">
                    ¿Ya tienes cuenta? <a href="index.php?controlador=Login&action=Login">Iniciar sesión</a>
                </p>
            </div>
        </div>
    </div>

    <?php include 'Footer/Footer_View.php'; ?>
    <script src="js/header.js"></script>
    <script src="js/registro/validarRegistro.js"></script>
</body>

</html>