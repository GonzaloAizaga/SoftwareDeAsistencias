-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para software_asistencia
CREATE DATABASE IF NOT EXISTS `software_asistencia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `software_asistencia`;

-- Volcando estructura para tabla software_asistencia.alumnos
CREATE TABLE IF NOT EXISTS `alumnos` (
  `ida` int NOT NULL AUTO_INCREMENT,
  `dni` int DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  PRIMARY KEY (`ida`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla software_asistencia.alumnos: ~27 rows (aproximadamente)
INSERT INTO `alumnos` (`ida`, `dni`, `nombre`, `apellido`, `fechaNacimiento`) VALUES
	(1, 42850626, 'Lucas Gabriel', 'Barreiro', '2000-05-08'),
	(2, 45847922, 'Franco', 'Cabrera', '2000-06-06'),
	(3, 43149316, 'Franco Agustin', 'Chappe', '2001-01-27'),
	(4, 43632750, 'Roman', 'Coletti', '2001-08-20'),
	(5, 40790201, 'Esteban', 'Copello', '1998-02-18'),
	(6, 40790201, 'Daian Exequielito', 'Fernandez ', '1998-02-18'),
	(7, 44980999, 'Nicolas Osvaldo', 'Fernandez ', '2003-10-06'),
	(8, 44623314, 'Facundo Geronimo', 'Figun', '2003-08-15'),
	(9, 45623314, 'Lucas jerenias', 'Fioroto', '2004-09-22'),
	(10, 45048325, 'Franco', 'Felipe', '2004-01-27'),
	(11, 43631803, 'Bruno', 'Godoy', '2001-06-25'),
	(12, 42069298, 'Marcos Damian', 'Godoy', '2000-11-10'),
	(13, 45385675, 'Teo', 'Hildt', '2004-04-13'),
	(14, 41872676, 'Facundo Ariel ', 'Janusa', '1999-08-03'),
	(15, 45048950, 'Facundo Martin', 'Jara', '2004-06-13'),
	(16, 45387761, 'Santiago Nicolas', 'Martinez Bender', '2004-12-04'),
	(17, 45741185, 'Pablo Federico', 'Martinez', '2004-03-14'),
	(18, 44980059, 'Federico Jose', 'Martinolich', '2003-08-20'),
	(19, 42070085, 'Maria Pia', 'Melgarejo', '2000-02-01'),
	(20, 43631710, 'Thiago Jeremias', 'Meseguer', '2001-08-12'),
	(21, 44644523, 'Ignacio Agustin', 'Piter', '2003-05-24'),
	(22, 44282007, 'Bianca Ariana', 'Quiroga', '2003-10-09'),
	(23, 40018598, 'Kevin Gustavo', 'Quiroga', '1998-04-08'),
	(24, 38570361, 'Marcos', 'Reynoso', '1996-09-01'),
	(25, 39255959, 'Franco Antonio', 'Robles', '1997-03-12'),
	(26, 43414566, 'Maximiliano', 'Weyler', '2006-06-02'),
	(27, 44980732, 'Gonzalo ', 'Aizaga ', '2003-08-01');

-- Volcando estructura para tabla software_asistencia.asistencias
CREATE TABLE IF NOT EXISTS `asistencias` (
  `cod_asis` int NOT NULL AUTO_INCREMENT,
  `dni` int DEFAULT NULL,
  `asistencia` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_asis`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla software_asistencia.asistencias: ~0 rows (aproximadamente)

-- Volcando estructura para tabla software_asistencia.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `dia_clases` int DEFAULT NULL,
  `paramProm` int DEFAULT NULL,
  `paramReg` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla software_asistencia.parametros: ~1 rows (aproximadamente)
INSERT INTO `parametros` (`dia_clases`, `paramProm`, `paramReg`) VALUES
	(0, 0, 0);

-- Volcando estructura para tabla software_asistencia.profesores
CREATE TABLE IF NOT EXISTS `profesores` (
  `idp` int NOT NULL AUTO_INCREMENT,
  `dni` int DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `fechaNacimientoProf` date NOT NULL,
  PRIMARY KEY (`idp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla software_asistencia.profesores: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
