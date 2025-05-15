<?php
class Conexion{
    //Creo el constructor "privado" para que no se puedan crear objetos de esta clase, puesto que solo vamos a llamarlo para pedir conexión a nuestra base de datos
    private function __construct(){

    }
    //Pongo los atributos estáticos porque van a ser usados por un método estático
    private static $servidor  = "mysql:host=localhost;dbname=thebeastbarber;charset=utf8mb4";
    private static $user = "admin";
    private static $password = "admin";

    //Creo método estático para poder ser llamado sin necesidad de crear objetos de tipo "Conexión".
    public static function getConexion(){
        try{
            //Creo la conexión con sus propios atributos estáticos
            $conexion = new PDO(self::$servidor, self::$user, self::$password);
            
            //Esto hace que cualquier error sea lanzado como una excepción
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conexion;
        } catch (PDOException $e){ 
            die("Ha habido un error en la conexión: " . $e->getMessage());
        }
    }
}
?>