-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-12-2018 a las 11:05:09
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 8.2.4

-- Zona de creación de la base de datos y comprobaciones previas.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"; -- esto es para que cuando se auto incremente no empiece en cero
SET AUTOCOMMIT =0; -- desactivo el autocommit
START TRANSACTION;
SET time_zone = "+00:00"; -- se establece el huso horario


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */; -- establece una variable de sesion con el valor de la configuración de `@@CHARACTER_SET_CLIENT`
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */; -- Similar al anterior
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */; -- Guarda el valor original de  `@@COLLATION_CONNECTION` en la variable de sesión `@OLD_COLLATION_CONNECTION`
/*!40101 SET NAMES utf8mb4 */; -- establece el juego de caracteres y la configuración de collation para la sesion actual 

DROP DATABASE IF EXISTS `tiendaInformatica`;
CREATE DATABASE `tiendaInformatica` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- DEFAULT CHARACTER SET utf8: 
    /*Establece el conjunto de caracteres predeterminado de la base de datos 
    como "utf8". Esto afecta cómo se almacenan y manejan los caracteres en la base de datos. */
-- COLLATE utf8_unicode_ci:
    /*Establece el orden de clasificación (collation) predeterminado como
    "utf8_unicode_ci". El orden de clasificación afecta cómo se ordenan y comparan los datos de texto 
    en la base de datos. En este caso, "utf8_unicode_ci" es una configuración que usa un orden de clasificación
    insensible a mayúsculas y minúsculas, comúnmente utilizado con caracteres latinos. */

USE `tiendaInformatica`;

-- primero hay que eliminar por orden las que tengan claves foráneas
DROP TABLE IF EXISTS `ventas`;
DROP TABLE IF EXISTS `compras`;
DROP TABLE IF EXISTS `productos`;
DROP TABLE IF EXISTS `categorias`;
DROP TABLE IF EXISTS `proveedores`;
DROP TABLE IF EXISTS `personas`;


-- Zona de creación de tablas (primero hay que crear las que no tengan claves foráneas)

-- tabla personas: PK --> idUsuario  UQ --> telefono - email
CREATE TABLE `personas`
(
    /* Esto sería un error de seguridad el AUTO_INCREMENT, en esta tabla */
	`idPersona` int not null AUTO_INCREMENT, 
    `nombre` varchar (20) not null, 
    `apellidos` varchar (40) not null,
    `direccion` varchar (50),
    `telefono` varchar (20) not null,
    `contrasena` varchar (400) not null,
    `email` varchar (100) not null,
    `fechaNac` date not null,
    `rol` varchar(50) not null DEFAULT 'usuario',
    CONSTRAINT `pk_personas_idUsuario` PRIMARY KEY (`idPersona`)
) DEFAULT CHARSET=utf8, AUTO_INCREMENT=10;-- CHARSET=utf8: Establece el conjunto de caracteres como "latin1". "latin1" es un conjunto de caracteres que cubre una variedad de caracteres europeos, y utiliza un byte por carácter

-- pongo las constraint correspondientes a la tabla personas
ALTER TABLE `personas`
    ADD CONSTRAINT `uq_personas_telefono` UNIQUE (`telefono`),
    ADD CONSTRAINT `uq_personas_email` UNIQUE (`email`);

-- tabla proveedores: PK --> idProveedor UQ --> razonSocial
CREATE TABLE proveedores
(
	`idProveedor` int not null AUTO_INCREMENT,
    `nombre` varchar(50) not null,
    `razonSocial` varchar (100) not null,
    `direccion` varchar(100) not null,
    `telefono` varchar(20) not null,
    `email` varchar(20) not null,
    CONSTRAINT `pk_proveedores_idProveedor` PRIMARY KEY (`idProveedor`)
) DEFAULT CHARSET=utf8;

-- pongo las constraint correspondientes a la tabla proveedores
ALTER TABLE `proveedores`
    ADD CONSTRAINT `uq_proveedores_razonSocial` UNIQUE (`razonSocial`),
    ADD CONSTRAINT `uq_proveedores_telefono` UNIQUE (`telefono`),
    ADD CONSTRAINT `uq_proveedores_email` UNIQUE (`email`);

-- inserto valores en la tabla proveedores
INSERT INTO `proveedores` (`nombre`, `razonSocial`, `direccion`, `telefono`, `email`)
VALUES
('sony', 'SONY S.A', 'Málaga', '900000000', 'sony@gmail.com');

-- tabla categorias: PK --> idCategorías
CREATE TABLE `categorias`
(
    `idCategoria` int not null AUTO_INCREMENT,
    `nombre` varchar(100) not null, 
    `descripcion` varchar(200) not null,
    CONSTRAINT `pk_categorias_idCategoria` PRIMARY KEY (`idCategoria`)
) DEFAULT CHARSET=utf8;

-- inserto valores en la tabla categorias
INSERT INTO `categorias` (`nombre`, `descripcion`) 
VALUES 
("Consolas", "Herramienta para jugar a videojuegos");

-- tabla productos: PK --> idProducto, FK --> categoria
CREATE TABLE `productos`
(
    `idProducto` int not null AUTO_INCREMENT,
    `nombre` varchar(40) not null,
    `descripcion` text not null,
    `categoria` int not null,
    `modelo` varchar(40),
    `precioUnitario` float not null,
    `iva` int not null,
    `stock` int not null,
    CONSTRAINT `pk_productos_idProducto` PRIMARY KEY (`idProducto`)
) DEFAULT CHARSET=utf8;

-- pongo las constraint correspondientes a la tabla productos
ALTER TABLE `productos`
    ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`idCategoria`) ON UPDATE CASCADE ON DELETE CASCADE;


-- inserto valores en la tabla productos
INSERT INTO `productos` (`nombre`, `descripcion`, `categoria`, `modelo`, `precioUnitario`, `iva`, `stock`)
VALUES
("PS5", "Consola creada por Sony para disfrutar un videojuego", 1, "slim", 400.00, 21, 0);

-- tabla compras: PK --> idCompra, FK --> productoId - proveedorId
CREATE TABLE `compras`
(
	`numFacturasCompras` int not null,
    `productoId` int not null,
    `proveedorId` int not null,
    `fechaCompra` TIMESTAMP not null default(NOW()), -- le pongo la fecha actual
    `cantidadComprada` int not null,
    `precioUnitario` float not null,
    `precioTotal` float not null
) DEFAULT CHARSET=utf8;

-- lo he puesto asi porque si ponía estos constraint dentro de la creación de la tabla me daba error
ALTER TABLE `compras`
    ADD  CONSTRAINT `pk_compras_numFacturasCompras` PRIMARY KEY (`numFacturasCompras`),
    ADD CONSTRAINT `fk_compras_productoId` FOREIGN KEY (`productoId`) REFERENCES `productos` (`idProducto`) ON UPDATE CASCADE ON DELETE CASCADE,
    ADD CONSTRAINT `fk_compras_proveedorId` FOREIGN KEY (`proveedorId`) REFERENCES `proveedores` (`idProveedor`) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE `compras`
  MODIFY `numFacturasCompras` int NOT NULL AUTO_INCREMENT;

-- tabla ventas: PK --> idVentas FK --> productoId - personaID
create table `ventas`
(
    `numFacturasVentas` int not null,
    `productoId` int not null,
    `personaId` int not null,
    `enviado` boolean not null DEFAULT (false),
    `fechaVenta` TIMESTAMP not null default(NOW()),
    `cantidadVendida` int not null,
    `precioUnitario` float not null,
    `precioTotal` float not null
) DEFAULT CHARSET=utf8;

ALTER TABLE `ventas`
    ADD CONSTRAINT `pk_ventas_numFacturasVentas` PRIMARY KEY (`numFacturasVentas`),
    ADD CONSTRAINT `fk_ventas_productoId` FOREIGN KEY (`productoId`) references `productos` (`idProducto`) ON UPDATE CASCADE ON DELETE CASCADE,
    ADD CONSTRAINT `fk_ventas_usuarioId` FOREIGN KEY (`personaId`) references `personas` (`idPersona`) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE `ventas`
  MODIFY `numFacturasVentas` int NOT NULL AUTO_INCREMENT;

COMMIT;