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

-- Insert initial admin record
INSERT INTO usuarios (nombre, apellidos, telefono, correo, contrasenia)
VALUES ('admin', 'admin apellidos', 123456789, 'admin@admin.com', 'admin');
