-- MySQL dump 10.13  Distrib 5.5.27, for Win32 (x86)
--
-- Host: localhost    Database: vokuro
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Table structure for table `email_confirmations`
--

DROP TABLE IF EXISTS `email_confirmations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_confirmations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usersId` int(10) unsigned NOT NULL,
  `code` char(32) NOT NULL,
  `createdAt` int(10) unsigned NOT NULL,
  `modifiedAt` int(10) unsigned DEFAULT NULL,
  `confirmed` char(1) DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_confirmations`
--

LOCK TABLES `email_confirmations` WRITE;
/*!40000 ALTER TABLE `email_confirmations` DISABLE KEYS */;
INSERT INTO `email_confirmations` VALUES (1,14,'FK9AlsO6RRsiqmux0PI9EKfzHoFRR2a7',1366990529,1366992523,'Y'),(2,15,'nOLpYKwCFqPYm8fXZ6osjkKUKNaVahp',1367473328,1367505447,'Y'),(3,16,'xMb8ZxTpJv2E3FPKod6OYJ7kDbw9hOLJ',1367509740,1367509761,'Y');
/*!40000 ALTER TABLE `email_confirmations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_logins`
--

DROP TABLE IF EXISTS `failed_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_logins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usersId` int(10) unsigned DEFAULT NULL,
  `ipAddress` char(15) NOT NULL,
  `attempted` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usersId` (`usersId`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_logins`
--

LOCK TABLES `failed_logins` WRITE;
/*!40000 ALTER TABLE `failed_logins` DISABLE KEYS */;
INSERT INTO `failed_logins` VALUES (1,2,'::1',1366995290),(2,2,'::1',1366995304),(3,2,'::1',1366995309),(4,0,'::1',1366995331),(5,2,'::1',1366995342),(6,14,'::1',1366995687),(7,14,'::1',1366995825),(8,14,'::1',1366996310),(9,2,'::1',1366996324),(10,2,'127.0.0.1',1367000208),(11,14,'127.0.0.1',1367012708),(12,2,'::1',1367014700),(13,14,'::1',1367014714),(14,14,'::1',1367014724),(15,14,'::1',1367014830),(16,14,'::1',1367014843),(17,2,'::1',1367014916),(18,2,'::1',1367014926),(19,2,'::1',1367015303),(20,14,'::1',1367015786),(21,2,'127.0.0.1',1367099996);
/*!40000 ALTER TABLE `failed_logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_changes`
--

DROP TABLE IF EXISTS `password_changes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_changes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usersId` int(10) unsigned NOT NULL,
  `ipAddress` char(15) NOT NULL,
  `userAgent` varchar(48) NOT NULL,
  `createdAt` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_changes`
--

LOCK TABLES `password_changes` WRITE;
/*!40000 ALTER TABLE `password_changes` DISABLE KEYS */;
INSERT INTO `password_changes` VALUES (1,2,'::1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 ',1367014804),(2,2,'::1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 ',1367014986),(3,15,'::1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 ',1367505457),(4,2,'::1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 ',1367511911);
/*!40000 ALTER TABLE `password_changes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profilesId` int(10) unsigned NOT NULL,
  `resource` varchar(16) NOT NULL,
  `action` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usersId` (`profilesId`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (90,3,'users','index'),(91,3,'users','search'),(92,3,'profiles','index'),(93,3,'profiles','search'),(105,1,'users','index'),(106,1,'users','search'),(107,1,'users','edit'),(108,1,'users','create'),(109,1,'users','delete'),(110,1,'users','changePassword'),(111,1,'profiles','index'),(112,1,'profiles','search'),(113,1,'profiles','edit'),(114,1,'profiles','create'),(115,1,'profiles','delete'),(116,1,'permissions','index'),(117,2,'users','index'),(118,2,'users','search'),(119,2,'users','edit'),(120,2,'users','create'),(121,2,'profiles','index'),(122,2,'profiles','search');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `active` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,'Administrators','Y'),(2,'Users','Y'),(3,'Read-Only','Y');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `remember_tokens`
--

DROP TABLE IF EXISTS `remember_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `remember_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usersId` int(10) unsigned NOT NULL,
  `token` char(32) NOT NULL,
  `userAgent` varchar(120) NOT NULL,
  `createdAt` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remember_tokens`
--

LOCK TABLES `remember_tokens` WRITE;
/*!40000 ALTER TABLE `remember_tokens` DISABLE KEYS */;
INSERT INTO `remember_tokens` VALUES (1,2,'af4e9eeb963b78bcb14f9311e024180e','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.32 (KHTML, like Gecko) Chrome/27.0.1418.0 Safari/537.32',1367286980),(2,2,'af4e9eeb963b78bcb14f9311e024180e','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.32 (KHTML, like Gecko) Chrome/27.0.1418.0 Safari/537.32',1367287035),(3,2,'af4e9eeb963b78bcb14f9311e024180e','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.32 (KHTML, like Gecko) Chrome/27.0.1418.0 Safari/537.32',1367469635);
/*!40000 ALTER TABLE `remember_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_passwords`
--

DROP TABLE IF EXISTS `reset_passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reset_passwords` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usersId` int(10) unsigned NOT NULL,
  `code` varchar(48) NOT NULL,
  `createdAt` int(10) unsigned NOT NULL,
  `modifiedAt` int(10) unsigned DEFAULT NULL,
  `reset` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usersId` (`usersId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_passwords`
--

LOCK TABLES `reset_passwords` WRITE;
/*!40000 ALTER TABLE `reset_passwords` DISABLE KEYS */;
INSERT INTO `reset_passwords` VALUES (1,14,'6GNAd4EdOjeieWmM7qHzVkzRKMGqio',1367004843,1367005241,'N'),(2,2,'k2NKSEPUglk0evZcnkj6ySJTOQGLp',1367005353,1367005412,'N'),(3,2,'G8aR8g3N59oqzya1PcgfZppR0BwTrftK',1367005359,NULL,'N'),(4,2,'0BWiJtoBlU8KrCL8D8znAPlfpL0R',1367012735,1367012764,'N'),(5,2,'GAZnwnNiwagQDgko0JGyOLhckEaoVX',1367014760,1367014968,'Y');
/*!40000 ALTER TABLE `reset_passwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `success_logins`
--

DROP TABLE IF EXISTS `success_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `success_logins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usersId` int(10) unsigned NOT NULL,
  `ipAddress` char(15) NOT NULL,
  `userAgent` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usersId` (`usersId`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `success_logins`
--

LOCK TABLES `success_logins` WRITE;
/*!40000 ALTER TABLE `success_logins` DISABLE KEYS */;
INSERT INTO `success_logins` VALUES (48,2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.32 (KHTML, like Gecko) Chrome/27.0.1418.0 Safari/537.32'),(49,2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.32 (KHTML, like Gecko) Chrome/27.0.1418.0 Safari/537.32'),(50,2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.32 (KHTML, like Gecko) Chrome/27.0.1418.0 Safari/537.32'),(51,2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.32 (KHTML, like Gecko) Chrome/27.0.1418.0 Safari/537.32'),(52,2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.32 (KHTML, like Gecko) Chrome/27.0.1418.0 Safari/537.32'),(53,2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.32 (KHTML, like Gecko) Chrome/27.0.1418.0 Safari/537.32'),(54,2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.32 (KHTML, like Gecko) Chrome/27.0.1418.0 Safari/537.32'),(55,2,'::1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31'),(56,15,'::1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31'),(57,16,'::1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31'),(58,2,'::1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31'),(59,2,'::1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31');
/*!40000 ALTER TABLE `success_logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `email` varchar(48) NOT NULL,
  `password` char(60) NOT NULL,
  `mustChangePassword` char(1) DEFAULT NULL,
  `profilesId` int(10) unsigned NOT NULL,
  `banned` char(1) NOT NULL,
  `suspended` char(1) NOT NULL,
  `active` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profilesId` (`profilesId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Bob Burnquist','bob@phalconphp.com','$2a$08$Lx1577KNhPa9lzFYKssadetmbhaveRtCoVaOnoXXxUIhrqlCJYWCW','N',1,'N','N','Y'),(14,'Erik','erik@phalconphp.com','$2a$08$f4llgFQQnhPKzpGmY1sOuuu23nYfXYM/EVOpnjjvAmbxxDxG3pbX.','N',1,'Y','Y','Y'),(15,'Veronica','veronica@phalconphp.com','$2a$08$NQjrh9fKdMHSdpzhMj0xcOSwJQwMfpuDMzgtRyA89ADKUbsFZ94C2','N',1,'N','N','Y'),(16,'Yukimi Nagano','yukimi@phalconphp.com','$2a$08$cxxpy4Jvt6Q3xGKgMWIILuf75RQDSroenvoB7L..GlXoGkVEMoSr.','N',2,'N','N','Y');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-02 11:31:16
