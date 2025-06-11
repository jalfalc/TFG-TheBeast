<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$controlador = "Principal";

if(!empty($_GET['controlador'])){
    $controlador = $_GET['controlador'];

}

if (file_exists("Controller/" . $controlador . "_Controller.php")){
    require_once ("Controller/" . $controlador . "_Controller.php");
}else{
    echo "Error, el controlador requerido no existe o no se encuentra" . "<a href='index.php' style='color:red;'>Volver</a>" ;
}
?>