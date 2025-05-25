-- Create the database
CREATE DATABASE TheBeastBarber;

-- Create the admin user
CREATE USER 'admin'@'%' IDENTIFIED BY 'admin';

-- Grant all privileges on the database to the admin user
GRANT ALL PRIVILEGES ON TheBeastBarber.* TO 'admin'@'%';
FLUSH PRIVILEGES;

-- Switch to the new database
USE TheBeastBarber;

-- Create the Usuarios table
CREATE TABLE usuarios (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(20) NOT NULL,
  apellidos VARCHAR(30) NOT NULL,
  telefono BIGINT,
  correo VARCHAR(50) NOT NULL,
  contrasenia VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY unique_correo (correo)
) ENGINE=InnoDB
  AUTO_INCREMENT=1
  DEFAULT CHARSET=utf8mb4;

-- Solo guardamos las reservas confirmadas
CREATE TABLE citas_reservadas (
  id INT NOT NULL AUTO_INCREMENT,
  usuario_id INT       NOT NULL,
  servicio   VARCHAR(50) NOT NULL,
  fecha      DATE      NOT NULL,
  hora       TIME      NOT NULL,
  creado_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_reserva (fecha, hora),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);