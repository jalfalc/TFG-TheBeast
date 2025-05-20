<?php
require_once 'Conexion.php';
require_once __DIR__ . '/../Usuario.php';

class MySqlDAO {
    private $conn;

    public function __construct(){
        $this->conn = Conexion::getConexion();
    }

    /**
     * Valida las credenciales de un usuario usando password_verify().
     *
     * @param Usuario $usuario
     * @return bool  True si el email existe y la contraseña es correcta
     */
    public function validarUsuario(Usuario $usuario): bool {
        // 1) Obtener el hash de la contraseña para este correo
        $sql  = "SELECT contrasenia FROM usuarios WHERE correo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $usuario->getCorreo());
        $stmt->execute();

        if ($stmt->rowCount() !== 1) {
            // No existe ese correo
            return false;
        }

        $row     = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashBD  = $row['contrasenia'];
        $passPL  = $usuario->getContrasenia();

        // 2) Verificar la contraseña
        if (password_verify($passPL, $hashBD)) {
            $_SESSION['loged'] = true;
            return true;
        }

        return false;
    }

    /**
     * Registra un nuevo usuario:
     *  - Comprueba duplicados por correo
     *  - Hashea la contraseña con password_hash()
     *  - Inserta el registro
     *
     * @param Usuario $u
     * @return bool  True si se insertó correctamente, false si el correo ya existía
     */
    public function registrarUsuario(Usuario $u): bool {
        // 1) ¿Correo ya en uso?
        $sqlCheck = "SELECT id FROM usuarios WHERE correo = ?";
        $stmt     = $this->conn->prepare($sqlCheck);
        $stmt->bindParam(1, $u->getCorreo());
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false;
        }

        // 2) Generar hash seguro
        $hash = password_hash($u->getContrasenia(), PASSWORD_DEFAULT);

        // 3) Insertar nuevo usuario con el hash
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
            $_SESSION['loged'] = true;
            return true;
        }
        return false;
    }
}
