<?php
require_once 'Model/DAO/MySqlDAO.php';
require_once 'Model/Usuario.php';

// 1. Validamos que lleguen todos los campos y no estén vacíos
if (
    isset($_POST['nombre'], $_POST['apellidos'], $_POST['telefono'], $_POST['mail'], $_POST['password'], $_POST['password2'])
    && trim($_POST['nombre']) !== ''
    && trim($_POST['apellidos']) !== ''
    && trim($_POST['telefono']) !== ''
    && trim($_POST['mail']) !== ''
    && trim($_POST['password']) !== ''
    && trim($_POST['password2']) !== ''
) {
    $nombre      = trim($_POST['nombre']);
    $apellidos   = trim($_POST['apellidos']);
    $telefono    = trim($_POST['telefono']);
    $correo      = trim($_POST['mail']);
    $contrasenia = $_POST['password'];
    $pass2       = $_POST['password2'];

    // 1.a Comprobamos que ambas contraseñas coincidan
    if ($contrasenia !== $pass2) {
        $msg = "Error en el registro: las contraseñas no coinciden";
        header("Location: index.php?controlador=Login&action=Registro&error_message=" . urlencode($msg));
        exit();
    }

    // 2. Creamos el objeto Usuario con todos los datos
    $usuario = new Usuario($nombre, $apellidos, $telefono, $correo, $contrasenia);

} else {
    // Falta algún dato
    $msg = "Error en el registro: todos los campos son obligatorios";
    header("Location: index.php?controlador=Login&action=Registro&error_message=" . urlencode($msg));
    exit();
}

// 3. Invocamos al DAO
$mySqlDAO = new MySqlDAO();

// 4. Intentamos registrar
if ($mySqlDAO->registrarUsuario($usuario)) {
    // Éxito → principal (o login si prefieres)
    header("Location: index.php?controlador=Login&action=Login");
    exit();
} else {
    // Fracaso: correo duplicado u otro error en DAO
    // Para distinguir, podrías ampliar registrarUsuario() para lanzar excepciones, pero aquí:
    $msg = "Error en el registro: ese correo ya está registrado";
    header("Location: index.php?controlador=Login&action=Registro&error_message=" . urlencode($msg));
    exit();
}
