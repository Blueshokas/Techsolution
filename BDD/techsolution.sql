-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: techsolution
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actualites`
--

DROP TABLE IF EXISTS `actualites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actualites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) NOT NULL,
  `contenu` text NOT NULL,
  `date_publication` timestamp NOT NULL DEFAULT current_timestamp(),
  `actif` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actualites`
--

LOCK TABLES `actualites` WRITE;
/*!40000 ALTER TABLE `actualites` DISABLE KEYS */;
INSERT INTO `actualites` VALUES (6,'test','test','2025-11-21 10:25:32',1);
/*!40000 ALTER TABLE `actualites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `components`
--

DROP TABLE IF EXISTS `components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `components`
--

LOCK TABLES `components` WRITE;
/*!40000 ALTER TABLE `components` DISABLE KEYS */;
INSERT INTO `components` VALUES (1,'Aerocool CS-106 (Noir)','boitier',49.99),(2,'Intel Core i3-12100','cpu',129.99),(3,'Intel Core i5-12400F','cpu',199.99),(4,'Intel Core i7-13700K','cpu',399.99),(5,'AMD Ryzen 5 5600X','cpu',229.99),(6,'AMD Ryzen 7 5800X','cpu',349.99),(7,'AMD Ryzen 9 5900X','cpu',499.99),(8,'Ventirad be quiet! Pure Rock 2','ventirad',39.99),(9,'Ventirad Noctua NH-U12S Redux','ventirad',49.99),(10,'Ventirad be quiet! Dark Rock Pro 4','ventirad',89.99),(11,'Ventirad Corsair H100i RGB ELITE','ventirad',139.99),(12,'NVIDIA RTX 3060 MSI Gaming X','gpu',329.99),(13,'NVIDIA RTX 4060 ASUS Dual','gpu',399.99),(14,'NVIDIA RTX 4080 ASUS TUF Gaming','gpu',1199.99),(15,'ASUS Prime B660M-A WiFi D4','carte_mere',89.99),(16,'MSI MAG B550 Tomahawk','carte_mere',149.99),(17,'ASUS ROG Strix Z690-E Gaming WiFi','carte_mere',399.99),(18,'MSI PRO B660M-A WiFi DDR4','carte_mere',79.99),(19,'Corsair Vengeance LPX 8GB DDR4','ram',39.99),(20,'Corsair Vengeance LPX 16GB DDR4','ram',79.99),(21,'Corsair Vengeance LPX 32GB DDR4','ram',159.99),(22,'G.Skill Trident Z Neo 64GB DDR4','ram',319.99),(23,'Samsung 980 SSD NVMe 250GB','stockage',49.99),(24,'Samsung 980 SSD NVMe 500GB','stockage',79.99),(25,'Samsung 980 Pro SSD NVMe 1TB','stockage',129.99),(26,'Samsung 980 Pro SSD NVMe 2TB','stockage',259.99),(27,'Intel Core i7-13700K (16C/24T, 3.4-5.4 GHz)','CPU',NULL),(28,'MSI PRO Z790-P WIFI DDR5','Carte Mère',NULL),(29,'Kingston FURY Beast DDR5 64 Go','RAM',NULL),(30,'Samsung 990 PRO 2 To','SSD',NULL),(31,'Western Digital Red Plus 4 To','HDD',NULL),(32,'PNY NVIDIA Quadro P620','GPU',NULL),(33,'3x LG 27UP850-W 27\" 4K','Écran',NULL),(34,'Das Keyboard 4 Professional','Clavier',NULL),(35,'Logitech MX Master 3S','Souris',NULL),(36,'AMD Ryzen 9 7900X (12C/24T, 4.7-5.4 GHz)','CPU',NULL),(37,'ASUS ROG STRIX B650E-F GAMING WIFI','Carte Mère',NULL),(38,'G.Skill Trident Z5 RGB DDR5 64 Go','RAM',NULL),(39,'NVIDIA GeForce RTX 4070 12 Go','GPU',NULL),(40,'2x BenQ SW272U 27\" 4K Pro','Écran',NULL),(41,'Wacom Intuos Pro Large','Tablette',NULL),(42,'Apple Magic Keyboard','Clavier',NULL),(43,'Intel Core i5-13400 (10C/16T, 2.5-4.6 GHz)','CPU',NULL),(44,'MSI PRO B660M-A WIFI DDR4','Carte Mère',NULL),(45,'Corsair Vengeance LPX DDR4 16 Go','RAM',NULL),(46,'Crucial P3 500 Go','SSD',NULL),(47,'Seagate BarraCuda 1 To','HDD',NULL),(48,'Intel UHD Graphics 730','GPU',NULL),(49,'ASUS VA24EHE 24\" Full HD','Écran',NULL),(50,'Logitech K270 Wireless','Clavier',NULL),(51,'Logitech M330 Silent Plus','Souris',NULL),(52,'Jabra Evolve 40 UC','Casque',NULL),(53,'AMD Ryzen 5 5600G (6C/12T, 3.5-4.4 GHz)','CPU',NULL),(54,'ASRock B550M Pro4 Micro-ATX','Carte Mère',NULL),(55,'Kingston FURY Beast DDR4 16 Go','RAM',NULL),(56,'Kingston NV2 500 Go','SSD',NULL),(57,'AMD Radeon Vega 7 Graphics','GPU',NULL),(58,'Dell P2422H 24\" Full HD','Écran',NULL),(59,'Logitech K120 USB','Clavier',NULL),(60,'Logitech B100 USB','Souris',NULL),(61,'Plantronics Blackwire 3220 USB','Casque',NULL),(62,'Intel Core i7-12700 (2.1 GHz / 4.9 GHz)','CPU',NULL),(63,'Gigabyte H610M S2H V3 DDR4','Carte Mère',NULL),(64,'G.Skill Aegis 32 Go (2 x 16 Go) DDR4 3200 MHz CL16','RAM',NULL),(65,'Samsung SSD 980 M.2 PCIe NVMe 1 To','SSD',NULL),(66,'MSI GeForce RTX 3050 LP 6G OC','GPU',NULL),(67,'Noctua NH-U12A Chromax Black','Refroidissement',NULL),(68,'be quiet! Pure Wings 3 120mm PWM','Ventilation',NULL),(69,'Corsair RM850e (2025)','Alimentation',NULL),(70,'ASUS PRIME B660M-A D4','Carte Mère',NULL),(71,'Crucial DDR4 16 Go','RAM',NULL),(72,'Samsung 970 EVO Plus 500 Go','SSD',NULL),(73,'Western Digital Blue 1 To','HDD',NULL),(74,'HP E24 G5 24\" Full HD','Écran',NULL),(75,'Microsoft Wired Keyboard 600','Clavier',NULL),(76,'Microsoft Basic Optical Mouse','Souris',NULL),(77,'Epson WorkForce DS-530 II (partagé)','Scanner',NULL),(78,'Intel Core i9-13900K (24C/32T, 3.0-5.8 GHz)','CPU',NULL),(79,'ASUS ROG MAXIMUS Z790 HERO','Carte Mère',NULL),(80,'Corsair Dominator Platinum RGB DDR5 64 Go','RAM',NULL),(81,'NVIDIA GeForce RTX 4060 Ti 8 Go','GPU',NULL),(82,'2x Dell UltraSharp U3223QE 32\" 4K IPS','Écran',NULL),(83,'Logitech MX Keys S for Business','Clavier',NULL),(84,'CalDigit TS4 Thunderbolt 4 Dock','Station',NULL);
/*!40000 ALTER TABLE `components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `lu` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (3,'Nicolas NOPPE','nicolas.noppe19130@gmail.com','kk','2025-11-21 10:08:05',1);
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pc`
--

DROP TABLE IF EXISTS `pc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `actif` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pc`
--

LOCK TABLES `pc` WRITE;
/*!40000 ALTER TABLE `pc` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pc_components`
--

DROP TABLE IF EXISTS `pc_components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pc_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_id` int(11) DEFAULT NULL,
  `component_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pc_components`
--

LOCK TABLES `pc_components` WRITE;
/*!40000 ALTER TABLE `pc_components` DISABLE KEYS */;
INSERT INTO `pc_components` VALUES (1,15,1),(2,15,4),(3,15,10),(4,15,17),(5,15,21),(6,15,25),(7,16,1),(8,16,6),(9,16,9),(10,16,12),(11,16,16),(12,16,21),(13,16,25),(14,17,1),(15,17,7),(16,17,11),(17,17,14),(18,17,17),(19,17,22),(20,17,26),(21,18,1),(22,18,6),(23,18,9),(24,18,16),(25,18,20),(26,18,25),(27,19,1),(28,19,5),(29,19,8),(30,19,13),(31,19,16),(32,19,20),(33,19,24),(34,20,1),(35,20,2),(36,20,8),(37,20,18),(38,20,19),(39,20,23),(40,21,1),(41,21,3),(42,21,8),(43,21,15),(44,21,20),(45,21,24),(46,43,27),(47,43,28),(48,43,29),(49,43,30),(50,43,31),(51,43,32),(52,43,33),(53,43,34),(54,43,35),(55,44,36),(56,44,37),(57,44,38),(58,44,30),(59,44,39),(60,44,40),(61,44,41),(62,44,42),(63,44,35),(64,45,43),(65,45,44),(66,45,45),(67,45,46),(68,45,47),(69,45,48),(70,45,49),(71,45,50),(72,45,51),(73,45,52),(74,46,53),(75,46,54),(76,46,55),(77,46,56),(78,46,57),(79,46,58),(80,46,59),(81,46,60),(82,46,61),(83,47,62),(84,47,63),(85,47,64),(86,47,65),(87,47,66),(88,47,1),(89,47,67),(90,47,68),(91,47,69),(92,48,43),(93,48,70),(94,48,71),(95,48,72),(96,48,73),(97,48,48),(98,48,74),(99,48,75),(100,48,76),(101,48,77),(102,49,78),(103,49,79),(104,49,80),(105,49,30),(106,49,81),(107,49,82),(108,49,83),(109,49,35),(110,49,84);
/*!40000 ALTER TABLE `pc_components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pcs`
--

DROP TABLE IF EXISTS `pcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `actif` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pcs`
--

LOCK TABLES `pcs` WRITE;
/*!40000 ALTER TABLE `pcs` DISABLE KEYS */;
INSERT INTO `pcs` VALUES (43,'Poste Infrastructures Systèmes (5 postes)','CPU: Intel Core i7-13700K (16C/24T, 3.4-5.4 GHz) | Carte Mère: MSI PRO Z790-P WIFI DDR5 | RAM: Kingston FURY Beast DDR5 64 Go | SSD: Samsung 990 PRO 2 To | HDD: Western Digital Red Plus 4 To | GPU: PNY NVIDIA Quadro P620 | Écrans: 3x LG 27UP850-W 27\" 4K | Clavier: Das Keyboard 4 Professional | Souris: Logitech MX Master 3S',4500.00,5,1),(44,'Poste Design UX/UI (5 postes)','CPU: AMD Ryzen 9 7900X (12C/24T, 4.7-5.4 GHz) | Carte Mère: ASUS ROG STRIX B650E-F GAMING WIFI | RAM: G.Skill Trident Z5 RGB DDR5 64 Go | SSD: Samsung 990 PRO 2 To | GPU: NVIDIA GeForce RTX 4070 12 Go | Écrans: 2x BenQ SW272U 27\" 4K Pro | Tablette: Wacom Intuos Pro Large | Clavier: Apple Magic Keyboard | Souris: Logitech MX Master 3S',5200.00,5,1),(45,'Poste Marketing/Vente (10 postes)','CPU: Intel Core i5-13400 (10C/16T, 2.5-4.6 GHz) | Carte Mère: MSI PRO B660M-A WIFI DDR4 | RAM: Corsair Vengeance LPX DDR4 16 Go | SSD: Crucial P3 500 Go | HDD: Seagate BarraCuda 1 To | GPU: Intel UHD Graphics 730 | Écran: ASUS VA24EHE 24\" Full HD | Clavier: Logitech K270 Wireless | Souris: Logitech M330 Silent Plus | Casque: Jabra Evolve 40 UC',1200.00,10,1),(46,'Poste Support Client Standard (4 postes)','CPU: AMD Ryzen 5 5600G (6C/12T, 3.5-4.4 GHz) | Carte Mère: ASRock B550M Pro4 Micro-ATX | RAM: Kingston FURY Beast DDR4 16 Go | SSD: Kingston NV2 500 Go | GPU: AMD Radeon Vega 7 Graphics | Écran: Dell P2422H 24\" Full HD | Clavier: Logitech K120 USB | Souris: Logitech B100 USB | Casque: Plantronics Blackwire 3220 USB',1000.00,4,1),(47,'Poste Développement Logiciel (15 postes)','CPU: Intel Core i7-12700 (2.1 GHz / 4.9 GHz) | Carte Mère: Gigabyte H610M S2H V3 DDR4 | RAM: G.Skill Aegis 32 Go (2 x 16 Go) DDR4 3200 MHz CL16 | SSD: Samsung SSD 980 M.2 PCIe NVMe 1 To | GPU: MSI GeForce RTX 3050 LP 6G OC | Boîtier: Aerocool CS-106 (Noir) | Refroidissement: Noctua NH-U12A Chromax Black | Ventilation: be quiet! Pure Wings 3 120mm PWM | Alimentation: Corsair RM850e (2025)',2800.00,15,1),(48,'Poste RH/Administration (5 postes)','CPU: Intel Core i5-13400 (10C/16T, 2.5-4.6 GHz) | Carte Mère: ASUS PRIME B660M-A D4 | RAM: Crucial DDR4 16 Go | SSD: Samsung 970 EVO Plus 500 Go | HDD: Western Digital Blue 1 To | GPU: Intel UHD Graphics 730 | Écran: HP E24 G5 24\" Full HD | Clavier: Microsoft Wired Keyboard 600 | Souris: Microsoft Basic Optical Mouse | Scanner: Epson WorkForce DS-530 II (partagé)',1300.00,5,1),(49,'Poste Direction (5 postes)','CPU: Intel Core i9-13900K (24C/32T, 3.0-5.8 GHz) | Carte Mère: ASUS ROG MAXIMUS Z790 HERO | RAM: Corsair Dominator Platinum RGB DDR5 64 Go | SSD: Samsung 990 PRO 2 To | GPU: NVIDIA GeForce RTX 4060 Ti 8 Go | Écrans: 2x Dell UltraSharp U3223QE 32\" 4K IPS | Clavier: Logitech MX Keys S for Business | Souris: Logitech MX Master 3S | Station: CalDigit TS4 Thunderbolt 4 Dock',7500.00,5,1);
/*!40000 ALTER TABLE `pcs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peripheriques`
--

DROP TABLE IF EXISTS `peripheriques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peripheriques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `type` enum('Écran','Clavier','Souris','Casque','Webcam','Spéciaux') NOT NULL,
  `departement` varchar(100) NOT NULL,
  `quantite` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peripheriques`
--

LOCK TABLES `peripheriques` WRITE;
/*!40000 ALTER TABLE `peripheriques` DISABLE KEYS */;
INSERT INTO `peripheriques` VALUES (1,'2x Dell UltraSharp U2723DE 27\" QHD','Écran','Développement',15,'2025-11-21 09:42:20'),(2,'Logitech MX Keys Advanced Wireless','Clavier','Développement',15,'2025-11-21 09:42:20'),(3,'Logitech MX Master 3S','Souris','Développement',15,'2025-11-21 09:42:20'),(4,'Jabra Evolve2 65 Bluetooth ANC','Casque','Développement',15,'2025-11-21 09:42:20'),(5,'Logitech Brio 4K','Webcam','Développement',15,'2025-11-21 09:42:20'),(6,'Tapis SteelSeries QcK Heavy XXL','Spéciaux','Développement',15,'2025-11-21 09:42:20'),(7,'3x LG 27UP850-W 27\" 4K','Écran','Infrastructures',5,'2025-11-21 09:42:20'),(8,'Das Keyboard 4 Professional Mécanique','Clavier','Infrastructures',5,'2025-11-21 09:42:20'),(9,'Logitech MX Master 3S','Souris','Infrastructures',5,'2025-11-21 09:42:20'),(10,'Sennheiser SC 165 USB','Casque','Infrastructures',5,'2025-11-21 09:42:20'),(11,'Logitech C920 HD Pro','Webcam','Infrastructures',5,'2025-11-21 09:42:20'),(12,'Hub Anker PowerExpand 13-en-1 + Tapis SteelSeries XXL','Spéciaux','Infrastructures',5,'2025-11-21 09:42:20'),(13,'2x BenQ SW272U 27\" 4K Pro','Écran','Design UX/UI',5,'2025-11-21 09:42:20'),(14,'Apple Magic Keyboard Pavé Numérique','Clavier','Design UX/UI',5,'2025-11-21 09:42:20'),(15,'Logitech MX Master 3S','Souris','Design UX/UI',5,'2025-11-21 09:42:20'),(16,'Sony WH-1000XM5 Bluetooth ANC','Casque','Design UX/UI',5,'2025-11-21 09:42:20'),(17,'Logitech Brio 4K','Webcam','Design UX/UI',5,'2025-11-21 09:42:20'),(18,'Wacom Intuos Pro Large PTH-860 + Colorimètre X-Rite i1Display Pro + Tapis Razer Strider XXL','Spéciaux','Design UX/UI',5,'2025-11-21 09:42:20'),(19,'1x ASUS VA24EHE 24\" Full HD','Écran','Marketing',10,'2025-11-21 09:42:20'),(20,'Logitech K270 Wireless','Clavier','Marketing',10,'2025-11-21 09:42:20'),(21,'Logitech M330 Silent Plus Wireless','Souris','Marketing',10,'2025-11-21 09:42:20'),(22,'Jabra Evolve 40 UC Stereo USB','Casque','Marketing',10,'2025-11-21 09:42:20'),(23,'Logitech C270 HD 720p','Webcam','Marketing',10,'2025-11-21 09:42:20'),(24,'Tapis basique LDLC','Spéciaux','Marketing',10,'2025-11-21 09:42:20'),(25,'1x Dell P2422H 24\" Full HD','Écran','Support Standard',4,'2025-11-21 09:42:20'),(26,'Logitech K120 USB Filaire','Clavier','Support Standard',4,'2025-11-21 09:42:20'),(27,'Logitech B100 USB','Souris','Support Standard',4,'2025-11-21 09:42:20'),(28,'Plantronics Blackwire 3220 USB','Casque','Support Standard',4,'2025-11-21 09:42:20'),(29,'Logitech C270 HD 720p','Webcam','Support Standard',4,'2025-11-21 09:42:20'),(30,'Aucun','Spéciaux','Support Standard',4,'2025-11-21 09:42:20'),(31,'1x Dell UltraSharp U2723DE 27\" QHD','Écran','Support Adapté',1,'2025-11-21 09:42:20'),(32,'Clevy grandes touches contrastées','Clavier','Support Adapté',1,'2025-11-21 09:42:20'),(33,'Contour RollerMouse Red Plus','Souris','Support Adapté',1,'2025-11-21 09:42:20'),(34,'Beyerdynamic DT 770 PRO 80 Ohm','Casque','Support Adapté',1,'2025-11-21 09:42:20'),(35,'Aucune','Webcam','Support Adapté',1,'2025-11-21 09:42:20'),(36,'Plage Braille Focus 40 Blue + Lampe LED TaoTronics + Pavé numérique USB tactile','Spéciaux','Support Adapté',1,'2025-11-21 09:42:20'),(37,'1x HP E24 G5 24\" Full HD','Écran','RH & Admin',5,'2025-11-21 09:42:20'),(38,'Microsoft Wired Keyboard 600 USB','Clavier','RH & Admin',5,'2025-11-21 09:42:20'),(39,'Microsoft Basic Optical Mouse USB','Souris','RH & Admin',5,'2025-11-21 09:42:20'),(40,'Logitech H390 USB','Casque','RH & Admin',5,'2025-11-21 09:42:20'),(41,'Logitech C270 HD 720p','Webcam','RH & Admin',5,'2025-11-21 09:42:20'),(42,'Tapis basique LDLC','Spéciaux','RH & Admin',5,'2025-11-21 09:42:20'),(43,'2x Dell UltraSharp U3223QE 32\" 4K','Écran','Direction',5,'2025-11-21 09:42:20'),(44,'Logitech MX Keys S for Business','Clavier','Direction',5,'2025-11-21 09:42:20'),(45,'Logitech MX Master 3S for Business','Souris','Direction',5,'2025-11-21 09:42:20'),(46,'Bose 700 UC Bluetooth ANC','Casque','Direction',5,'2025-11-21 09:42:20'),(47,'Logitech BRIO 4K Stream Edition','Webcam','Direction',5,'2025-11-21 09:42:20'),(48,'CalDigit TS4 Thunderbolt 4 Dock + Tapis Razer Pro Glide XXL','Spéciaux','Direction',5,'2025-11-21 09:42:20');
/*!40000 ALTER TABLE `peripheriques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$hWLno5/t6PsUZld8sdK4wOslY23DegcSLOZfGeYB6tBDZunjwqW..','2025-11-12 08:16:38'),(2,'admin2','$2y$10$oF.8KJ4HqAUPxNA1svadJO1jFRlz.NzvgqcpHogFKlagdnuAmeYVu','2025-11-17 15:28:46');
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

-- Dump completed on 2025-11-26 10:25:29
