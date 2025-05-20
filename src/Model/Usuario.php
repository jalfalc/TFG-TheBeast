<?php
class Usuario {
    private $nombre;
    private $apellidos;
    private $telefono;
    private $correo;
    private $contrasenia;
    

    // Constructor para registro
    public function __construct(
        string $nombre,
        string $apellidos,
        string $telefono,
        string $correo,
        string $contrasenia,
        
    ) {
        $this->nombre      = $nombre;
        $this->apellidos   = $apellidos;
        $this->telefono    = $telefono;
        $this->correo      = $correo;
        $this->contrasenia = $contrasenia;
        
    }

    // Getters necesarios:
    public function getNombre(): string    { return $this->nombre; }
    public function getApellidos(): string { return $this->apellidos; }
    public function getTelefono(): string  { return $this->telefono; }
    public function getCorreo(): string    { return $this->correo; }
    public function getContrasenia(): string { return $this->contrasenia; }
    
}
