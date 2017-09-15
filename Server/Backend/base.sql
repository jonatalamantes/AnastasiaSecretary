-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: AnastasiaDB
-- ------------------------------------------------------
-- Server version 	5.7.19-0ubuntu0.16.04.1
-- Date: Thu, 14 Sep 2017 20:38:03 -0500

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `anastasiadb_eventos`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anastasiadb_eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(40) DEFAULT NULL,
  `minutos_duracion` int(11) DEFAULT '-1',
  `descripcion` varchar(255) DEFAULT '',
  `fecha_activacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` enum('creado','delegado','terminado') DEFAULT NULL,
  `tipo_alerta` enum('vibrar','timbrar') DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `idEventoPrevio` int(11) DEFAULT '-1',
  `idEventoAnterior` int(11) DEFAULT '-1',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` enum('S','N') DEFAULT 'S',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anastasiadb_eventos`
--

--
-- Table structure for table `anastasiadb_log`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anastasiadb_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(40) DEFAULT '',
  `idSesiones` int(11) DEFAULT NULL,
  `tipo` enum('A','E','M') DEFAULT NULL,
  `consulta` text,
  `activo` enum('S','N') NOT NULL DEFAULT 'S',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `anastasiadb_sesiones`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anastasiadb_sesiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(40) DEFAULT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '''''',
  `host` varchar(50) NOT NULL DEFAULT '''''',
  `ultimo_acceso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `activo` enum('S','N') DEFAULT 'S',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anastasiadb_sesiones`
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Thu, 14 Sep 2017 20:38:03 -0500
