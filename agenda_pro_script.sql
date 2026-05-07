CREATE DATABASE agenda_pro;
USE agenda_pro;
CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(90) NOT NULL,
    apellido VARCHAR(90) NOT NULL,
    correo VARCHAR(90) NOT NULL UNIQUE,
    clave VARCHAR(90) NOT NULL,
    fecha_reg DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE cliente (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(90) NOT NULL,
    apellido VARCHAR(90) NOT NULL,
    correo VARCHAR(90) NOT NULL UNIQUE,
    DNI VARCHAR(20) NOT NULL UNIQUE,
    telefono VARCHAR(90) NOT NULL,
    direccion VARCHAR(90) NOT NULL UNIQUE,
    edad VARCHAR(90) NOT NULL,
    fecha_reg DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE cita (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    asunto VARCHAR(90) NOT NULL,
    detalle VARCHAR(90) NOT NULL,
    tipo VARCHAR(90) NOT NULL,
    lugar VARCHAR(90) NOT NULL,
    referencia VARCHAR(90) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado VARCHAR(60) NOT NULL,
    id_cliente INT NOT NULL,
    CONSTRAINT fk_cita_cliente
    FOREIGN KEY (id_cliente)
    REFERENCES cliente(id_cliente)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
INSERT INTO usuario (
    nombre,
    apellido,
    correo,
    clave
)
VALUES
(
    'Admin',
    'Principal',
    'admin@gmail.com',
    '123456'
);
INSERT INTO cliente (
    nombre,
    apellido,
    correo,
    DNI,
    telefono,
    direccion,
    edad
)
VALUES

(
    'Juan',
    'Perez',
    'juan@gmail.com',
    '12345678',
    '999999999',
    'Lima',
    '25'
),
(
    'Maria',
    'Lopez',
    'maria@gmail.com',
    '87654321',
    '988888888',
    'Arequipa',
    '30'
);
INSERT INTO cita (
    asunto,
    detalle,
    tipo,
    lugar,
    referencia,
    fecha,
    hora,
    estado,
    id_cliente
)
VALUES

(
    'Reunion',
    'Reunion importante',
    'Trabajo',
    'Oficina',
    'Frente al parque',
    '2026-05-07',
    '10:00:00',
    'Pendiente',
    1
),

(
    'Consulta',
    'Consulta médica',
    'Salud',
    'Clínica',
    'Segundo piso',
    '2026-05-08',
    '15:30:00',
    'Confirmada',
    2
);