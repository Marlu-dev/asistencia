#  Creado con Kata Kuntur - Modelador de Datos
#  Versión: 2.5.4
#  Sitio Web: http://katakuntur.jeanmazuelos.com/
#  Si usted encuentra algún error le agradeceriamos lo reporte en:
#  http://pm.jeanmazuelos.com/katakuntur/issues/new

#  Administrador de Base de Datos: MySQL/MariaDB
#  Diagrama: asistencia
#  Autor: lcadi
#  Fecha y hora: 19/01/2024 13:00:30

# GENERANDO TABLAS
create database asistencia;
use asistencia;
CREATE TABLE `Usuario` (
	`idUsuario` INTEGER NOT NULL,
	`nombre` VARCHAR(50) NOT NULL,
	PRIMARY KEY(`idUsuario`)
) ENGINE=INNODB;
CREATE TABLE `Ingreso` (
	`idIngreso` INTEGER NOT NULL,
	`fecha` DATE NOT NULL,
	`hora` TIME NOT NULL,
	`Usuario_idUsuario` INTEGER NOT NULL,
	KEY(`Usuario_idUsuario`),
	PRIMARY KEY(`idIngreso`)
) ENGINE=INNODB;
CREATE TABLE `Salida` (
	`idSalida` INTEGER NOT NULL,
	`fecha` DATE NOT NULL,
	`hora` TIME NOT NULL,
	`Usuario_idUsuario` INTEGER NOT NULL,
	KEY(`Usuario_idUsuario`),
	PRIMARY KEY(`idSalida`)
) ENGINE=INNODB;

# GENERANDO RELACIONES
ALTER TABLE `Ingreso` ADD CONSTRAINT `ingreso_usuario_usuario_idusuario` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `Usuario`(`idUsuario`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `Salida` ADD CONSTRAINT `salida_usuario_usuario_idusuario` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `Usuario`(`idUsuario`) ON DELETE NO ACTION ON UPDATE CASCADE;