<?php
require_once 'Conexion.php';
require_once __DIR__ . '/../Usuario.php';
class MySqlDAO{
    private $conn;

    public function __construct(){
        $this->conn = Conexion::getConexion();
    }

    public function validarUsuario(Usuario $usuario){
        //Variable que voy a devolver tras realizar mi consulta: true si es usuario válido y false si es inválido.
        $esCorrecto = false;

        //Obtengo el nombre del usuario pasado por parámetro
        $correo = $usuario->getCorreo();

        //Obtengo la contraseña del usuario pasado por parámetro
        $contrasenia = $usuario->getContrasenia();

        //Creo la consulta
        $consulta = "SELECT correo, contrasenia FROM usuarios WHERE correo = ? AND contrasenia = ?";

        //Preparo la consulta
        $consultaPreparada = $this->conn->prepare($consulta);
        
        //Añado los dos parámetros a la consulta
        $consultaPreparada->bindParam(1, $correo);
        $consultaPreparada->bindParam(2, $contrasenia);

        //Ejecuto la consulta
        $consultaPreparada->execute();

        //Si la consulta me da 1 resultado (es que está correcto el usuario) creo la variable de sesión 'loged' 'user'
        if ($consultaPreparada->rowCount() == 1){
            $_SESSION['loged'] = true;
            //$_SESSION['user'] = $usuario->getNombre();

            //Paso a true mi variable booleana de comprobación de usuario
            $esCorrecto = true;

            //Si no obtengo 1 fila en mi consulta (obtengo 0 o más de 1) muestro mensaje de error
        }else{
            
            echo "Usuario inválido, compruebe las credenciales.";
        }

        //Devuelvo mi variable booleana de comprobación de usuario
        return $esCorrecto;

    }
}

?>