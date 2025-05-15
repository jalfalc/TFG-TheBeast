<?php
require_once 'Model/DAO/MySqlDAO.php';

//Compruebo que las credenciales han sido enviadas y si lo son creo un objeto 'Usuario' con ellas
if (isset($_POST['mail']) && isset($_POST['password']) && !empty($_POST['mail']) && !empty($_POST['password'])) {
    $correo = $_POST['mail'];
    $contrasenia = $_POST['password'];

    $usuario = new Usuario($correo, $contrasenia);

    //Si no se han enviado ambas credenciales redirijo de nuevo al login
} else {
    header("Location: index.php?controlador=Login");
    exit();
}

//Creo un objeto "Usuario_DB" para comprobar si el objeto "usuario" existe en base de datos
$mySqlDAO = new MySqlDAO ();

//Compruebo que exista, si es true redirijo a "User_Page_Vista" y si no a "Login_Vista" de nuevo
if($mySqlDAO->validarUsuario($usuario)){
    header("Location: index.php?controlador=Principal");
    exit();
} else{
    header("Location: index.php?controlador=Login");
    exit();
}
?>