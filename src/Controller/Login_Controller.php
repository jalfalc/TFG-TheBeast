<?php
// Si hay sesión iniciada redirijo a la página de inicio, si no muestro la vista de 'Login'
if (isset($_SESSION["loged"]) && $_SESSION["loged"] === true) {
    header("Location: index.php");
    exit();
} else {
    $action = $_GET['action'];

    if ($action == 'Login') {
        require_once('View/Login_View.php');
    } else if ($action == 'Registro') {
        require_once('View/Registro_View.php');
    }
}
