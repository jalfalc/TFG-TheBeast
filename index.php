<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$controlador = "Principal";

if(!empty($_GET['controlador'])){
    $controlador = $_GET['controlador'];

}

if (file_exists("Controlador/" . $controlador . "_Controlador.php")){
    require_once ("Controlador/" . $controlador . "_Controlador.php");
}else{
    echo "Error, el controlador requerido no existe o no se encuentra";
}
?>