CREATE DATABASE Dulcera;
USE Dulcera;
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
USE Dulcera;

CREATE TABLE producto_regional (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(120) NOT NULL,
    categoria VARCHAR(80) NOT NULL,
    region_origen VARCHAR(90) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    descripcion TEXT,
    fecha_reg DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_producto INT NOT NULL,
    fecha_pedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    cantidad INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    estado_pedido ENUM('PENDIENTE','COMPLETADO','CANCELADO') DEFAULT 'PENDIENTE',

    CONSTRAINT fk_pedido_cliente
        FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_pedido_producto
        FOREIGN KEY (id_producto) REFERENCES producto_regional(id_producto)
        ON UPDATE CASCADE
        ON DELETE CASCADE
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
INSERT INTO producto_regional
(nombre_producto, categoria, region_origen, precio, stock, descripcion)
VALUES
('Café regional', 'Bebida', 'Ucayali', 18.50, 40, 'Café natural producido en la región.'),
('Cacao artesanal', 'Dulce', 'San Martín', 12.00, 35, 'Cacao regional para consumo familiar.'),
('Miel de abeja', 'Natural', 'Junín', 20.00, 25, 'Miel pura de producción local.'),
('Textil artesanal', 'Artesanía', 'Cusco', 45.00, 15, 'Producto textil elaborado artesanalmente.');