<?php
require_once 'Model/DAO/MySqlDAO.php';

/**
 * Controller encargado de mostrar, modificar y eliminar las reservas
 * del usuario actualmente logueado.
 */
class MisReservas_Controller {
    /** @var MySqlDAO DAO para operaciones de reserva */
    private $dao;
    /** @var int ID del usuario en sesión */
    private $usuarioId;

    /**
     * Inicializa el controlador. Verifica sesión y prepara el DAO.
     */
    public function __construct() {
        if (empty($_SESSION['loged']) || $_SESSION['loged'] !== true) {
            header('Location: index.php?controlador=Login&action=Login');
            exit();
        }
        $this->usuarioId = $_SESSION['usuario_id'];
        $this->dao       = new MySqlDAO();
    }

    /**
     * Acción por defecto: obtiene y formatea las reservas para la vista.
     */
    public function mostrar() {
        // Recuperar reservas crudas del DAO
        $raw = $this->dao->obtenerReservasUsuario($this->usuarioId);

        // Arrays para nombres de días y meses en español
        $dias   = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        $meses  = [
            1=>'enero',2=>'febrero',3=>'marzo',4=>'abril',
            5=>'mayo',6=>'junio',7=>'julio',8=>'agosto',
            9=>'septiembre',10=>'octubre',11=>'noviembre',12=>'diciembre'
        ];

        // Formatear fecha y hora para cada reserva
        $reservas = array_map(function($r) use($dias,$meses) {
            $dt = new DateTime($r['fecha']);
            $dSemana = $dias[(int)$dt->format('w')];
            $dNumero = $dt->format('j');
            $mNumero = (int)$dt->format('n');
            $anio    = $dt->format('Y');
            $r['fecha_formateada'] = "$dSemana $dNumero de {$meses[$mNumero]} de $anio";
            $r['hora_corto']       = substr($r['hora'], 0, 5);
            return $r;
        }, $raw);

        // Cargar la vista con $reservas disponible
        require_once 'View/MisReservas_View.php';
    }

    /**
     * Muestra el formulario de edición para una reserva específica.
     */
    public function modificar() {
    $id = (int)($_POST['id'] ?? 0);
    if (!$id) {
        $this->redirectMostrar();
    }
    $reserva = $this->dao->getReservaPorId($id);
    if (!$reserva) {
        $this->redirectMostrar();
    }

    // Formatear fecha y hora para mostrar "Fecha de la reserva actual"
    $dias  = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    $meses = [
        1=>'enero',2=>'febrero',3=>'marzo',4=>'abril',
        5=>'mayo',6=>'junio',7=>'julio',8=>'agosto',
        9=>'septiembre',10=>'octubre',11=>'noviembre',12=>'diciembre'
    ];
    $dt = new DateTime($reserva['fecha']);
    $dSemana = $dias[(int)$dt->format('w')];
    $dNumero = $dt->format('j');
    $mNumero = (int)$dt->format('n');
    $anio    = $dt->format('Y');
    $reserva['fecha_formateada'] = "$dSemana $dNumero de {$meses[$mNumero]} de $anio";
    $reserva['hora_corto']       = substr($reserva['hora'], 0, 5);

    require_once 'View/EditarReserva_View.php';
}

    /**
     * Procesa el envío del formulario de edición de reserva.
     */
    public function actualizar() {
    $id       = (int)($_POST['id'] ?? 0);
    $servicio = trim($_POST['servicio'] ?? '');
    $fecha    = trim($_POST['fecha'] ?? '');
    $hora     = trim($_POST['hora'] ?? '');

    // 0) Lista “oficial” de servicios permitidos (idéntica a la de Reservar)
    $serviciosValidos = [
      "Corte de pelo",
      "Corte de Barba",
      "Corte de pelo y barba",
      "Corte de pelo para jubilados",
      "Perfilado de cejas",
      "Limpieza facial con efecto lifting"
    ];

    // 0.a) Validar que el servicio que llegó en POST esté en nuestro array
    if (!in_array($servicio, $serviciosValidos, true)) {
        $_SESSION['error_reserva'] = 'Error: el servicio seleccionado no existe.';
        // volver a mostrar para que vea el mensaje
        header('Location: index.php?controlador=MisReservas&action=mostrar');
        exit();
    }

    // 1) Validación básica de id/servicio/fecha/hora
    if (!$id || !$servicio || !$fecha || !$hora) {
        $_SESSION['error_reserva'] = 'Todos los campos son obligatorios';
        header("Location: index.php?controlador=MisReservas&action=mostrar");
        exit();
    }

    // 2) Intentar actualizar en BD
    if ($this->dao->actualizarCita($id, $servicio, $fecha, $hora)) {
        $_SESSION['success_reserva'] = 'Reserva modificada correctamente';
    } else {
        $_SESSION['error_reserva'] = 'No se pudo modificar la reserva';
    }
    $this->redirectMostrar();
}

    /**
     * Procesa la eliminación (cancelación) de una reserva.
     */
    public function eliminar() {
        $id = (int)($_POST['id'] ?? 0);
        if ($id && $this->dao->eliminarCita($id)) {
            $_SESSION['success_reserva'] = 'Reserva cancelada';
        } else {
            $_SESSION['error_reserva'] = 'No se pudo cancelar la reserva';
        }
        $this->redirectMostrar();
    }

    /**
     * Redirige a la acción Mostrar().
     */
    private function redirectMostrar() {
        header('Location: index.php?controlador=MisReservas&action=mostrar');
        exit();
    }
}

// Enrutamiento interno del controlador
$action = $_GET['action'] ?? 'mostrar';
$ctrl   = new MisReservas_Controller();
if (!method_exists($ctrl, $action)) {
    $action = 'mostrar';
}
$ctrl->{$action}();
?>