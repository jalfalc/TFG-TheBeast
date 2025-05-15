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
  nombre VARCHAR(20) NOT NULL,
  apellidos VARCHAR(30) NOT NULL,
  correo VARCHAR(50) NOT NULL,
  contrasenia VARCHAR(30) NOT NULL,
  PRIMARY KEY (Correo)
);

-- Insert initial admin record
INSERT INTO usuarios (nombre, apellidos, correo, contrasenia)
VALUES ('admin', 'admin apellidos', 'admin@admin.com', 'admin');
