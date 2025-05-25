<?php
require_once 'Model/DAO/MySqlDAO.php';


// 1) Verificar que se envíen ambos campos
if (
    isset($_POST['mail'], $_POST['password'])
    && $_POST['mail'] !== ''
    && $_POST['password'] !== ''
) {
    $correo     = $_POST['mail'];
    $contrasenia= $_POST['password'];
    // El constructor de Usuario: (nombre, apellidos, teléfono, correo, contraseña)
    $usuario    = new Usuario('', '', '', $correo, $contrasenia);
} else {
    // Falta algún campo: volvemos al login sin validar
    header("Location: index.php?controlador=Login&action=Login");
    exit();
}

// 2) Intentar validar en base de datos
$mySqlDAO = new MySqlDAO();
if ($mySqlDAO->validarUsuario($usuario)) {
    // Éxito → principal
    header("Location: index.php?controlador=MisReservas");
    exit();
} else {
    // Fallo → de nuevo login, pasando flag de error
    header("Location: index.php?controlador=Login&action=Login&error=invalid");
    exit();
}
?>