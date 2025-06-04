<?php
require_once 'Conexion.php';
require_once __DIR__ . '/../Usuario.php';

/**
 * Class MySqlDAO
 *
 * Acceso a datos para usuarios y reservas en MySQL.
 */
class MySqlDAO {
    /** @var PDO $conn Conexión PDO a la base de datos */
    private $conn;

    /**
     * MySqlDAO constructor.
     * Obtiene la conexión de la clase Conexion.
     */
    public function __construct(){
        $this->conn = Conexion::getConexion();
    }

    /**
     * Valida las credenciales de un usuario usando password_verify()
     * y, si son correctas, inicia la sesión guardando el ID de usuario.
     *
     * @param Usuario $usuario Objeto con correo y contraseña en texto plano.
     * @return bool True si las credenciales son válidas; false en caso contrario.
     */
    public function validarUsuario(Usuario $usuario): bool {
        $sql  = "SELECT id, contrasenia FROM usuarios WHERE correo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $usuario->getCorreo());
        $stmt->execute();

        if ($stmt->rowCount() !== 1) {
            // No existe ese correo
            return false;
        }

        $row       = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashBD    = $row['contrasenia'];
        $idUsuario = (int)$row['id'];

        if (password_verify($usuario->getContrasenia(), $hashBD)) {
            // Credenciales correctas: regenerar sesión y guardar datos
            session_regenerate_id(true);
            $_SESSION['loged']      = true;
            $_SESSION['usuario_id'] = $idUsuario;
            return true;
        }

        // Contraseña incorrecta
        return false;
    }

    /**
     * Registra un nuevo usuario en la base de datos:
     *  - Comprueba que el correo no exista
     *  - Hashea la contraseña
     *  - Inserta el registro
     *  - Inicia sesión guardando el ID del nuevo usuario
     *
     * @param Usuario $u Objeto con datos de registro.
     * @return bool True si el registro y la sesión fueron exitosos; false en caso contrario.
     */
    public function registrarUsuario(Usuario $u): bool {
        // 1) Verificar correo único
        $sqlCheck = "SELECT id FROM usuarios WHERE correo = ?";
        $stmt     = $this->conn->prepare($sqlCheck);
        $stmt->bindParam(1, $u->getCorreo());
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return false;
        }

        // 2) Hashear contraseña
        $hash = password_hash($u->getContrasenia(), PASSWORD_DEFAULT);

        // 3) Insertar nuevo usuario
        $sqlInsert = "
            INSERT INTO usuarios
              (nombre, apellidos, telefono, correo, contrasenia)
            VALUES
              (?, ?, ?, ?, ?)
        ";
        $stmt = $this->conn->prepare($sqlInsert);
        $stmt->bindParam(1, $u->getNombre());
        $stmt->bindParam(2, $u->getApellidos());
        $stmt->bindParam(3, $u->getTelefono());
        $stmt->bindParam(4, $u->getCorreo());
        $stmt->bindParam(5, $hash);

        if ($stmt->execute()) {
            // Marcar sesión iniciada y guardar nuevo ID
            session_regenerate_id(true);
            $_SESSION['loged']      = true;
            $_SESSION['usuario_id'] = (int)$this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    /**
     * Devuelve un array de horas reservadas para una fecha dada.
     *
     * @param string $fecha Fecha en formato YYYY-MM-DD.
     * @return string[] Lista de horas en HH:MM.
     */
    public function getHorasReservadas(string $fecha): array {
    // Con TIME_FORMAT devolvemos solo hora y minutos
    $sql  = "SELECT TIME_FORMAT(hora, '%H:%i') AS hora 
             FROM citas_reservadas 
             WHERE fecha = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(1, $fecha);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

    /**
     * Inserta una nueva cita reservada.
     *
     * @param int    $usuarioId ID de usuario.
     * @param string $servicio  Nombre del servicio.
     * @param string $fecha     Fecha YYYY-MM-DD.
     * @param string $hora      Hora HH:MM.
     * @return bool True si se insertó correctamente.
     */
    public function reservarCita(int $usuarioId, string $servicio, string $fecha, string $hora): bool {
        $sql = "
            INSERT INTO citas_reservadas
              (usuario_id, servicio, fecha, hora)
            VALUES
              (?, ?, ?, ?)
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $usuarioId);
        $stmt->bindParam(2, $servicio);
        $stmt->bindParam(3, $fecha);
        $stmt->bindParam(4, $hora);
        return $stmt->execute();
    }

     /**
     * Devuelve un array con las reservas del usuario dado.
     * Cada elemento incluye:
     *  - id        (ID de la reserva)
     *  - nombre
     *  - apellidos
     *  - servicio
     *  - fecha      (YYYY-MM-DD)
     *  - hora       (HH:MM:SS)
     *
     * @param int $usuarioId
     * @return array
     */
    public function obtenerReservasUsuario(int $usuarioId): array {
        $sql = "
        SELECT
          cr.id        AS id,         -- ID de la reserva
          u.nombre, u.apellidos,
          cr.servicio, cr.fecha, cr.hora
        FROM citas_reservadas AS cr
        JOIN usuarios AS u
          ON cr.usuario_id = u.id
        WHERE cr.usuario_id = ?
        ORDER BY cr.fecha, cr.hora
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Devuelve los datos de una sola reserva por su ID,
 * valida que pertenezca al usuario activo,
 * y trae también el nombre y apellidos del cliente.
 *
 * @param int $reservaId
 * @return array{ id:int, usuario_id:int, servicio:string, fecha:string, hora:string, nombre:string, apellidos:string }|null
 */
public function getReservaPorId(int $reservaId): ?array {
    $sql = "
      SELECT
        cr.id,
        cr.usuario_id,
        cr.servicio,
        cr.fecha,
        cr.hora,
        u.nombre,
        u.apellidos
      FROM citas_reservadas AS cr
      JOIN usuarios AS u
        ON cr.usuario_id = u.id
      WHERE cr.id = ?
        AND cr.usuario_id = ?
      LIMIT 1
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(1, $reservaId, PDO::PARAM_INT);
    $stmt->bindParam(2, $_SESSION['usuario_id'], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

    /**
     * Actualiza los datos de una reserva existente.
     *
     * @param int    $reservaId ID de la reserva.
     * @param string $servicio  Nuevo servicio.
     * @param string $fecha     Nueva fecha YYYY-MM-DD.
     * @param string $hora      Nueva hora HH:MM.
     * @return bool True si la actualización fue exitosa.
     */
    public function actualizarCita(int $reservaId, string $servicio, string $fecha, string $hora): bool {
        $sql = "
            UPDATE citas_reservadas
            SET servicio = ?, fecha = ?, hora = ?
            WHERE id = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $servicio);
        $stmt->bindParam(2, $fecha);
        $stmt->bindParam(3, $hora);
        $stmt->bindParam(4, $reservaId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Elimina (cancela) una reserva por su ID.
     *
     * @param int $reservaId ID de la reserva.
     * @return bool True si la eliminación fue exitosa.
     */
    public function eliminarCita(int $reservaId): bool {
        $sql = "DELETE FROM citas_reservadas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $reservaId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
