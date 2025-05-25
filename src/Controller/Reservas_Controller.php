<?php
// Controller/Reservas_Controller.php
require_once 'Model/DAO/MySqlDAO.php';

class Reservas_Controller {
  private $dao;
  public function __construct(){
    if (empty($_SESSION['loged'])) {
      header('Location: index.php?controlador=Login&action=Login');
      exit();
    }
    $this->dao = new MySqlDAO();
  }

  // /?controlador=Reservas → muestra la vista
  public function Mostrar(){
    $mensaje = $_SESSION['success_reserva'] ?? '';
    $error   = $_SESSION['error_reserva']   ?? '';
    unset($_SESSION['success_reserva'], $_SESSION['error_reserva']);
    require_once 'View/Reservas_View.php';
  }

  // /?action=Horas devuelve JSON con huecos libres
  public function Horas(){
    header('Content-Type: application/json');
    $fecha    = $_GET['fecha']    ?? '';
    $servicio = $_GET['servicio'] ?? '';
    if (!$fecha || !$servicio) {
      echo json_encode(['horas'=>[]]);
      exit();
    }
    // 1) sacamos horas ya reservadas
    $ocupadas = $this->dao->getHorasReservadas($fecha);

    // 2) generamos franjas segun horario real
    $wd = (new DateTime($fecha))->format('N'); // 1=lunes…7=domingo
    $franjas = [];
    if ($wd>=2 && $wd<=5) {
      $franjas = [['09','15'], ['17','21']];
    } elseif ($wd==6||$wd==7) {
      $franjas = [['09','14'], ['15','18']];
    } // lunes nada
    $horasLibres = [];
    foreach($franjas as $f){
      list($h0,$h1) = $f;
      $t = new DateTime("$fecha $h0:00");
      $end = new DateTime("$fecha $h1:00");
      while($t < $end){
        $h = $t->format('H:i');
        if (!in_array($h, $ocupadas, true)) {
          $horasLibres[] = $h;
        }
        $t->add(new DateInterval('PT30M'));
      }
    }
    echo json_encode(['horas'=>$horasLibres]);
    exit();
  }

  // /?action=Confirmar procesa el POST
  public function Confirmar(){
    $uid = $_SESSION['usuario_id'];
    $servicio = $_POST['servicio'] ?? '';
    $fecha    = $_POST['fecha']    ?? '';
    $hora     = $_POST['hora']     ?? '';
    if (!$servicio||!$fecha||!$hora) {
      $_SESSION['error_reserva'] = 'Falta elegir servicio, fecha u hora.';
      header('Location: index.php?controlador=Reservas&action=Mostrar');
      exit();
    }
    if ($this->dao->reservarCita($uid,$servicio,$fecha,$hora)) {
      $_SESSION['success_reserva'] = "Cita para $fecha a las $hora confirmada.";
    } else {
      $_SESSION['error_reserva'] = 'Lo siento, esa hora ya no está disponible.';
    }
    header('Location: index.php?controlador=Reservas&action=Mostrar');
    exit();
  }
}

// router interno
$accion = $_GET['action'] ?? 'Mostrar';
$ctrl   = new Reservas_Controller();
if (!method_exists($ctrl, $accion)) $accion = 'Mostrar';
$ctrl->{$accion}();
