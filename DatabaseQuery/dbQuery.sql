/*CREATE DATABASE sistema_contable;*/
/*USE sistema_contable */

/*CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);*/

/*CREATE TABLE ingresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    descripcion VARCHAR(255),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);*/

/*CREATE TABLE egresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    descripcion VARCHAR(255),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);*/

/*CREATE TABLE deseos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
); */

/*CREATE TABLE metas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    monto_actual DECIMAL(10, 2) DEFAULT 0,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
); */

/*
ALTER TABLE egresos
ADD categoria ENUM('Comida', 'Servicios básicos', 'Transporte', 'Vestimenta') NOT NULL DEFAULT 'Comida';
*/
/*ALTER TABLE egresos MODIFY categoria VARCHAR(100)*/
/*ALTER TABLE deseos ADD COLUMN monto DECIMAL(10, 2) NOT NULL DEFAULT 0.00;*/


