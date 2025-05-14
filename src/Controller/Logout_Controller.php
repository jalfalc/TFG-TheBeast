<?php
//Si hay sesión iniciada la destruyo y redirijo a la página de inicio
if (isset($_SESSION["loged"]) && $_SESSION["loged"] === true){
    session_destroy();
    header("Location:index.php");
    exit();

    //Si no hay sesión iniciada redirijo a la página de inicio pero sin destruir la sesión
} else {
    header("Location:index.php");
}
?>