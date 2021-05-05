-- MySQL dump 10.13  Distrib 8.0.13, for linux-glibc2.12 (x86_64)
--
-- Host: localhost    Database: westream
-- ------------------------------------------------------
-- Server version	8.0.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES UTF8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20190318034909','2019-03-22 16:30:33'),('20190318152631','2019-03-22 16:30:33'),('20190318163235','2019-03-22 17:34:00'),('20190322230115','2019-03-22 23:57:47'),('20190322234053','2019-03-22 23:57:47'),('20190404235817','2019-04-05 00:24:13'),('20210422004504','2021-04-22 00:46:52'),('20210426175053','2021-04-26 17:51:22');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `streaming_key` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `streaming_server` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `streamingserver` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'jjudge.developer83@gmail.com','Fuckyou666!','James','Judge','Administrator','349895995933996181754002','42251778_10156829037859924_6216672377334398976_o.jpg',NULL,NULL,NULL,NULL),(2,'developer@jamesjudge.info','Fuckyou666!','James','Judge','James Judge',NULL,NULL,NULL,NULL,NULL,NULL),(3,'club@beatdrop.xyz','edrooney007','_______',' _________','ClubEd','062257786956836106756708','301874gangsta.jpg','DJ','Testing bio input/output','xxxxxxxxxxxxx','xxxxxxxxxxxxx'),(4,'Bpc422@gmail.com','beatdrop','B','C','BPC',NULL,NULL,NULL,NULL,NULL,NULL),(5,'Rachelellmore@gmail.com','Riley2219','Rachel','Ellmore','Serenity',NULL,NULL,NULL,NULL,NULL,NULL),(6,'Jennweldon@hotmail.com','HotMess','Ennifer','Lopez','Jenni from the block',NULL,NULL,NULL,NULL,NULL,NULL),(7,'fucker@asshole.com','AssholeFucker','Fucker of','Many Assholes','AssholeFucker',NULL,NULL,NULL,NULL,NULL,NULL),(8,'metaldave08096@yahoo.com','meyers85','David','Meyers','meyers85',NULL,NULL,NULL,NULL,NULL,NULL),(9,'sungoddesssher@gmail.com','slsl1953','Sherry','Stafford-Loibl','Spirit',NULL,NULL,NULL,NULL,NULL,NULL),(10,'Suckit69times','fuck','Base','Base','Suckit69times',NULL,NULL,NULL,NULL,NULL,NULL),(11,'Pieperbetsy@icloud.com','Barker19','Meghan','Pieper','Meghan',NULL,NULL,NULL,NULL,NULL,NULL),(12,'Samanthag184@yahoo.com','Babigurl07','Samantha','Genader','Sammyg89',NULL,NULL,NULL,NULL,NULL,NULL),(13,'Biggst','pssssyty','Base','Face','Fucker',NULL,NULL,NULL,NULL,NULL,NULL),(14,'Robby','robby','Robby','Robby','Fuckin',NULL,NULL,NULL,NULL,NULL,NULL),(15,'Ryan.h215@gmail.com','Nevermore3','Ryan','Henry','Scion6',NULL,NULL,NULL,NULL,NULL,NULL),(16,'Kyle.Mikhailov@gmail.com','314698','Kyle','Mikhailov','Kyle',NULL,NULL,NULL,NULL,NULL,NULL),(17,'tvjudge@gmail.com','Password1!','Tom','Judge','The Video Voyager',NULL,NULL,NULL,NULL,NULL,NULL),(18,'thejamroomonline@gmail.com','J4Mr00m!','Jam','Room','The Jam Room','sk_us-west-2_CV8E2j3eFcUQ_2BrxK9J11G5HGKsGPSNNvURwOoOp7L','575217tjr18.png','Band','The Jam Room is the channel used by the touring video voyager for live streams.',NULL,NULL),(19,'tvjudge@videovoyager.org','Garnet@32!','THomas','Judge','VVadmin',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-05 19:06:12
