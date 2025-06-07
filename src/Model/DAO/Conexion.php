<?php
class Conexion {
    // Constructor privado para evitar instancias
    private function __construct() {}

    // Atributos estáticos que llenaremos desde .env vía parse_ini_file()
    private static $host;
    private static $dbname;
    private static $charset;
    private static $user;
    private static $password;

    /**
     * Carga (una vez) las variables desde .env usando parse_ini_file().
     */
    private static function cargarEnv(): void
    {
        // Si ya están cargadas, salimos
        if (self::$host !== null) {
            return;
        }

        // Ruta al .env de la raiz
        $rutaEnv = __DIR__ . '/../../../.env';

        if (!file_exists($rutaEnv)) {
            // Si no existe, podrías lanzar excepción, dejar valores por defecto o terminar
            throw new RuntimeException("No se encontró el archivo .env en $rutaEnv");
        }

        // parse_ini_file nos devuelve un array clave=>valor por cada línea CLAVE=valor
        // usando INI_SCANNER_RAW para que no haga “escapes” automáticos:
        $env = parse_ini_file($rutaEnv, false, INI_SCANNER_RAW);

        // volcamos en cada variable estática
        self::$host     = $env['DB_HOST']    ?? 'localhost';
        self::$dbname   = $env['DB_NAME']    ?? '';
        self::$charset  = $env['DB_CHARSET'] ?? 'utf8mb4';
        self::$user     = $env['DB_USER']    ?? '';
        self::$password = $env['DB_PASSWORD'] ?? '';
    }

    /**
     * Devuelve un PDO configurado con los datos leídos desde .env
     */
    public static function getConexion(): PDO
    {
        // Nos aseguramos de haber leído .env
        self::cargarEnv();

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            self::$host,
            self::$dbname,
            self::$charset
        );

        try {
            $pdo = new PDO($dsn, self::$user, self::$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Ha ocurrido un error en la conexión." . $e->getMessage() . "<a href='index.php' style='color:red;'>Volver</a>");
        }
    }
}
?>