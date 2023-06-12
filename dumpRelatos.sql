-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: arqueologia
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `relatosdocs`
--

DROP TABLE IF EXISTS `relatosdocs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `relatosdocs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relatosQId` int(11) NOT NULL,
  `path` varchar(300) DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relatosdocs`
--

LOCK TABLES `relatosdocs` WRITE;
/*!40000 ALTER TABLE `relatosdocs` DISABLE KEYS */;
INSERT INTO `relatosdocs` VALUES (1,3,'\\3\\Exercicio_09_gab.pdf','2023-06-11 21:43:50','2023-06-11 21:43:50');
/*!40000 ALTER TABLE `relatosdocs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relatosquadrilatero`
--

DROP TABLE IF EXISTS `relatosquadrilatero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `relatosquadrilatero` (
  `author` varchar(100) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration` varchar(200) DEFAULT NULL,
  `filePath` varchar(200) DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `title` varchar(100) DEFAULT NULL,
  `legend` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relatosquadrilatero`
--

LOCK TABLES `relatosquadrilatero` WRITE;
/*!40000 ALTER TABLE `relatosquadrilatero` DISABLE KEYS */;
INSERT INTO `relatosquadrilatero` VALUES ('mbaralhou para fazer um livro de modelos de tipos. Lor',1,'dasdasandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu não só a cinco séculos, como também a',NULL,'2023-06-11 20:37:57','2023-06-12 00:13:04','eletrônica, permanecendo essencialmente inalterado.','Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo essencialmente inalterado.'),('sssssssss',2,'ssssssss',NULL,'2023-06-11 20:44:13','2023-06-11 20:44:13','sssss',NULL),('sssssssss',3,'ssssssss',NULL,'2023-06-11 21:34:59','2023-06-11 21:43:53','teste','dasdasdfsfsdfsssd12'),('sssssssss',4,'ssssssss',NULL,'2023-06-11 21:35:10','2023-06-11 21:35:10','sssss12',NULL);
/*!40000 ALTER TABLE `relatosquadrilatero` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-11 22:09:57
