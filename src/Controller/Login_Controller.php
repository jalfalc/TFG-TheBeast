<?php
// Si hay sesión iniciada redirijo a la página de inicio, si no muestro la vista de 'Login'
if (isset($_SESSION["loged"]) && $_SESSION["loged"] === true) {
    header("Location: index.php");
    exit();
} 
require_once ('View/Login_View.php');
?>