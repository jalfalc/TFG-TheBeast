-- Crear la base de datos
CREATE DATABASE thebeastbarber;

-- Crear usuario 'admin' que puede conectarse en local
CREATE USER IF NOT EXISTS 'admin'@'localhost' IDENTIFIED BY 'admin';

-- Darle solo SELECT, INSERT, UPDATE y DELETE sobre todas las tablas de TheBeastBarber y aplicar privilegios
GRANT
  SELECT,
  INSERT,
  UPDATE,
  DELETE
ON thebeastbarber.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;

-- Acceder a la base de datos
USE thebeastbarber;

-- Tabla usuarios
CREATE TABLE usuarios (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(20) NOT NULL,
  apellidos VARCHAR(30) NOT NULL,
  telefono BIGINT NOT NULL,
  correo VARCHAR(50) NOT NULL,
  contrasenia VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY unique_correo (correo)
) DEFAULT CHARSET=utf8mb4;

-- Tabla citas_reservadas
CREATE TABLE citas_reservadas (
  id INT NOT NULL AUTO_INCREMENT,
  usuario_id INT       NOT NULL,
  servicio   VARCHAR(50) NOT NULL,
  fecha      DATE      NOT NULL,
  hora       TIME      NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_reserva (fecha, hora),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) DEFAULT CHARSET=utf8mb4;