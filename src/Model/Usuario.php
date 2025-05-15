<?php
class Usuario {
    private $correo;
    private $contrasenia;

    public function __construct($correo, $contrasenia) {
        $this->correo = $correo;
        $this->contrasenia = $contrasenia;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }
    
    public function getContrasenia(){
        return $this->contrasenia;
    }

    //No hago el método "set" de la contraseña porque no lo necesito
}
?>
