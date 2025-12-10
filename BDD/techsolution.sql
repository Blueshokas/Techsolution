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
  `marque` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `components`
--

LOCK TABLES `components` WRITE;
/*!40000 ALTER TABLE `components` DISABLE KEYS */;
INSERT INTO `components` VALUES (1,'Aerocool CS-106 (Noir)','boitier',49.99,NULL),(2,'Intel Core i3-12100','cpu',129.99,NULL),(3,'Intel Core i5-12400F','cpu',199.99,NULL),(4,'Intel Core i7-13700K','cpu',399.99,NULL),(5,'AMD Ryzen 5 5600X','cpu',229.99,NULL),(6,'AMD Ryzen 7 5800X','cpu',349.99,NULL),(7,'AMD Ryzen 9 5900X','cpu',499.99,NULL),(8,'Ventirad be quiet! Pure Rock 2','ventirad',39.99,NULL),(9,'Ventirad Noctua NH-U12S Redux','ventirad',49.99,NULL),(10,'Ventirad be quiet! Dark Rock Pro 4','ventirad',89.99,NULL),(11,'Ventirad Corsair H100i RGB ELITE','ventirad',139.99,NULL),(12,'NVIDIA RTX 3060 MSI Gaming X','gpu',329.99,NULL),(13,'NVIDIA RTX 4060 ASUS Dual','gpu',399.99,NULL),(14,'NVIDIA RTX 4080 ASUS TUF Gaming','gpu',1199.99,NULL),(15,'ASUS Prime B660M-A WiFi D4','carte_mere',89.99,NULL),(16,'MSI MAG B550 Tomahawk','carte_mere',149.99,NULL),(17,'ASUS ROG Strix Z690-E Gaming WiFi','carte_mere',399.99,NULL),(18,'MSI PRO B660M-A WiFi DDR4','carte_mere',79.99,NULL),(19,'Corsair Vengeance LPX 8GB DDR4','ram',39.99,NULL),(20,'Corsair Vengeance LPX 16GB DDR4','ram',79.99,NULL),(21,'Corsair Vengeance LPX 32GB DDR4','ram',159.99,NULL),(22,'G.Skill Trident Z Neo 64GB DDR4','ram',319.99,NULL),(23,'Samsung 980 SSD NVMe 250GB','stockage',49.99,NULL),(24,'Samsung 980 SSD NVMe 500GB','stockage',79.99,NULL),(25,'Samsung 980 Pro SSD NVMe 1TB','stockage',129.99,NULL),(26,'Samsung 980 Pro SSD NVMe 2TB','stockage',259.99,NULL),(27,'Intel Core i7-13700K (16C/24T, 3.4-5.4 GHz)','CPU',NULL,NULL),(28,'MSI PRO Z790-P WIFI DDR5','Carte Mère',NULL,NULL),(29,'Kingston FURY Beast DDR5 64 Go','RAM',NULL,NULL),(30,'Samsung 990 PRO 2 To','SSD',NULL,NULL),(31,'Western Digital Red Plus 4 To','HDD',NULL,NULL),(32,'PNY NVIDIA Quadro P620','GPU',NULL,NULL),(36,'AMD Ryzen 9 7900X (12C/24T, 4.7-5.4 GHz)','CPU',NULL,NULL),(37,'ASUS ROG STRIX B650E-F GAMING WIFI','Carte Mère',NULL,NULL),(38,'G.Skill Trident Z5 RGB DDR5 64 Go','RAM',NULL,NULL),(39,'NVIDIA GeForce RTX 4070 12 Go','GPU',NULL,NULL),(41,'Wacom Intuos Pro Large','Tablette',NULL,NULL),(43,'Intel Core i5-13400 (10C/16T, 2.5-4.6 GHz)','CPU',NULL,NULL),(44,'MSI PRO B660M-A WIFI DDR4','Carte Mère',NULL,NULL),(45,'Corsair Vengeance LPX DDR4 16 Go','RAM',NULL,NULL),(46,'Crucial P3 500 Go','SSD',NULL,NULL),(47,'Seagate BarraCuda 1 To','HDD',NULL,NULL),(48,'Intel UHD Graphics 730','GPU',NULL,NULL),(52,'Jabra Evolve 40 UC','Casque',NULL,NULL),(53,'AMD Ryzen 5 5600G (6C/12T, 3.5-4.4 GHz)','CPU',NULL,NULL),(54,'ASRock B550M Pro4 Micro-ATX','Carte Mère',NULL,NULL),(55,'Kingston FURY Beast DDR4 16 Go','RAM',NULL,NULL),(56,'Kingston NV2 500 Go','SSD',NULL,NULL),(57,'AMD Radeon Vega 7 Graphics','GPU',NULL,NULL),(61,'Plantronics Blackwire 3220 USB','Casque',NULL,NULL),(62,'Intel Core i7-12700 (2.1 GHz / 4.9 GHz)','CPU',NULL,NULL),(63,'Gigabyte H610M S2H V3 DDR4','Carte Mère',NULL,NULL),(64,'G.Skill Aegis 32 Go (2 x 16 Go) DDR4 3200 MHz CL16','RAM',NULL,NULL),(65,'Samsung SSD 980 M.2 PCIe NVMe 1 To','SSD',NULL,NULL),(66,'MSI GeForce RTX 3050 LP 6G OC','GPU',NULL,NULL),(67,'Noctua NH-U12A Chromax Black','Refroidissement',NULL,NULL),(68,'be quiet! Pure Wings 3 120mm PWM','Ventilation',NULL,NULL),(69,'Corsair RM850e (2025)','Alimentation',NULL,NULL),(70,'ASUS PRIME B660M-A D4','Carte Mère',NULL,NULL),(71,'Crucial DDR4 16 Go','RAM',NULL,NULL),(72,'Samsung 970 EVO Plus 500 Go','SSD',NULL,NULL),(73,'Western Digital Blue 1 To','HDD',NULL,NULL),(78,'Intel Core i9-13900K (24C/32T, 3.0-5.8 GHz)','CPU',NULL,NULL),(79,'ASUS ROG MAXIMUS Z790 HERO','Carte Mère',NULL,NULL),(80,'Corsair Dominator Platinum RGB DDR5 64 Go','RAM',NULL,NULL),(81,'NVIDIA GeForce RTX 4060 Ti 8 Go','GPU',NULL,NULL),(84,'CalDigit TS4 Thunderbolt 4 Dock','Station',NULL,NULL),(85,'be quiet! Pure Wings 3 120mm PWM','Ventilateur',NULL,'be quiet!'),(86,'Intel Core i7-13700F (2.1 GHz / 5.2 GHz)','CPU',NULL,'Intel'),(87,'G.Skill Aegis 32 Go (2×16 Go) DDR4 3200 MHz CL16','RAM',NULL,'G.Skill'),(88,'Samsung SSD 980 NVMe M.2 1 To','SSD',NULL,'Samsung'),(89,'Corsair RM850e (2025) – 850W','Alimentation',NULL,'Corsair'),(94,'MSI PRO Z790-P WIFI','Carte Mère',NULL,'MSI'),(95,'Kingston FURY Beast DDR5 64 Go (2×32 Go) 5600 MHz','RAM',NULL,'Kingston'),(96,'Samsung 990 PRO NVMe M.2 – 2 To','SSD',NULL,'Samsung'),(97,'Western Digital Red Plus – 4 To','HDD',NULL,'Western Digital'),(98,'NVIDIA Quadro P620 – 2 Go','GPU',NULL,'NVIDIA'),(99,'Corsair 4000D Airflow','Boîtier',NULL,'Corsair'),(100,'Seasonic FOCUS GX-850 – 850W 80+ Gold','Alimentation',NULL,'Seasonic'),(101,'Noctua NH-D15','Refroidissement',NULL,'Noctua'),(105,'AMD Ryzen 9 7900X (4.7 GHz / 5.4 GHz)','CPU',NULL,'AMD'),(106,'G.Skill Trident Z5 RGB DDR5 64 Go (2x32 Go) 6000 MHz','RAM',NULL,'G.Skill'),(107,'Samsung 990 PRO 2 To M.2 NVMe PCIe 4.0','SSD',NULL,'Samsung'),(108,'Samsung 870 EVO 4 To','SSD',NULL,'Samsung'),(109,'Gigabyte GeForce RTX 5070 EAGLE OC SFF 12G','GPU',NULL,'Gigabyte'),(110,'NZXT H7 Flow RGB Noir (2024)','Boîtier',NULL,'NZXT'),(111,'be quiet! Power Zone 2 1000W 80PLUS Platinum','Alimentation',NULL,'be quiet!'),(112,'NZXT Kraken X63 280mm AIO RGB','Refroidissement',NULL,'NZXT'),(117,'Intel Core i5-12600K (3.7 GHz / 4.9 GHz)','CPU',NULL,'Intel'),(118,'MSI PRO B760M-P DDR4','Carte Mère',NULL,'MSI'),(119,'Corsair Vengeance LPX Series Low Profile 16 Go (2x 8 Go) DDR4 3200 MHz CL16','RAM',NULL,'Corsair'),(120,'Kingston SSD NV3 500 Go','SSD',NULL,'Kingston'),(121,'Seagate BarraCuda 1 To 7200 RPM 3.5\"','HDD',NULL,'Seagate'),(122,'Cooler Master MasterBox Q300L','Boîtier',NULL,'Cooler Master'),(123,'Corsair CX550 80PLUS Bronze (2023)','Alimentation',NULL,'Corsair'),(124,'Cooler Master Hyper 212 Black Edition','Refroidissement',NULL,'Cooler Master'),(131,'AMD Ryzen 5 5600GT Wraith Stealth (3.6 GHz / 4.6 GHz)','CPU',NULL,'AMD'),(132,'Gigabyte B550M DS3H AC R2','Carte Mère',NULL,'Gigabyte'),(133,'Kingston FURY Beast DDR4 16 Go (2x8 Go) 3200 MHz','RAM',NULL,'Kingston'),(134,'Kingston NV2 500 Go M.2 NVMe PCIe 4.0','SSD',NULL,'Kingston'),(135,'Thermaltake View 270 TG ARGB (blanc)','Boîtier',NULL,'Thermaltake'),(136,'Corsair CV550 450W 80+ Bronze','Alimentation',NULL,'Corsair'),(137,'be quiet! Pure Rock Pro 3','Refroidissement',NULL,'be quiet!'),(141,'Intel Core i5-14600K (3.5 GHz / 5.3 GHz)','CPU',NULL,'Intel'),(142,'ASUS PRIME Z790-P WIFI','Carte Mère',NULL,'ASUS'),(143,'Corsair Vengeance DDR5 32 Go (2 x 16 Go) 4800 MHz CL40','RAM',NULL,'Corsair'),(144,'Samsung 980 PRO 1 To M.2 NVMe PCIe 4.0','SSD',NULL,'Samsung'),(145,'Fractal Design Define 7 Compact','Boîtier',NULL,'Fractal Design'),(146,'Seasonic FOCUS GX-750 650W 80+ Gold Modulaire','Alimentation',NULL,'Seasonic'),(147,'be quiet! Pure Rock 3','Refroidissement',NULL,'be quiet!'),(150,'ASUS PRIME B760M-A WIFI D4','Carte Mère',NULL,'ASUS'),(151,'Textorm 16 Go (2x 8 Go) DDR4 3200 MHz','RAM',NULL,'Textorm'),(152,'Samsung SSD 870 EVO 500 Go','SSD',NULL,'Samsung'),(153,'Western Digital WD Red Pro 2 To','HDD',NULL,'Western Digital'),(154,'Antec P10C','Boîtier',NULL,'Antec'),(155,'Corsair CX550 80+ Bronze','Alimentation',NULL,'Corsair'),(159,'Intel Core i9-13900KS (3.2 GHz / 6 GHz)','CPU',NULL,'Intel'),(160,'ASUS TUF GAMING Z790-PLUS WIFI','Carte Mère',NULL,'ASUS'),(161,'Corsair Dominator Titanium DDR5 RGB 64 Go (2 x 32 Go) 6000 MHz','RAM',NULL,'Corsair'),(162,'Samsung SSD 990 PRO M.2 PCIe NVMe 2 To','SSD',NULL,'Samsung'),(163,'Gainward GeForce RTX 4060 Ti Pegasus 8GB','GPU',NULL,'Gainward'),(164,'Lian Li O11 Dynamic EVO XL','Boîtier',NULL,'Lian Li'),(165,'Corsair HX1000i 80PLUS Platinum ATX 3.1','Alimentation',NULL,'Corsair'),(166,'Corsair Nautilus 360 RS ARGB (Noir)','Refroidissement',NULL,'Corsair'),(172,'HP ZBook Ultra G1a 14 pouces (A3ZU9ET)','Ordinateur Portable',NULL,'HP'),(173,'Targus CityGear 3 Sleeve 14\" Noir','Sacoche',NULL,'Targus'),(174,'APC Back-UPS PRO BR 900VA','Onduleur',NULL,'APC');
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
) ENGINE=InnoDB AUTO_INCREMENT=746 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pc_components`
--

LOCK TABLES `pc_components` WRITE;
/*!40000 ALTER TABLE `pc_components` DISABLE KEYS */;
INSERT INTO `pc_components` VALUES (689,66,85),(690,66,63),(691,66,66),(692,66,67),(693,66,87),(694,66,88),(695,66,89),(696,67,4),(697,67,94),(698,67,95),(699,67,96),(700,67,97),(701,67,98),(702,67,99),(703,67,100),(704,67,101),(705,68,37),(706,68,106),(707,68,107),(708,68,108),(709,68,109),(710,68,110),(711,68,111),(712,68,112),(713,69,118),(714,69,119),(715,69,120),(716,69,121),(717,69,122),(718,69,123),(719,69,124),(720,70,132),(721,70,133),(722,70,134),(723,70,135),(724,70,136),(725,70,137),(726,71,142),(727,71,143),(728,71,144),(729,71,145),(730,71,146),(731,71,147),(732,72,150),(733,72,151),(734,72,152),(735,72,153),(736,72,154),(737,72,155),(738,72,124),(739,73,160),(740,73,161),(741,73,162),(742,73,163),(743,73,164),(744,73,165),(745,73,166);
/*!40000 ALTER TABLE `pc_components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pc_peripheriques`
--

DROP TABLE IF EXISTS `pc_peripheriques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pc_peripheriques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_id` int(11) NOT NULL,
  `peripherique_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_pc_peripherique` (`pc_id`,`peripherique_id`),
  KEY `peripherique_id` (`peripherique_id`),
  CONSTRAINT `pc_peripheriques_ibfk_1` FOREIGN KEY (`pc_id`) REFERENCES `pcs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pc_peripheriques_ibfk_2` FOREIGN KEY (`peripherique_id`) REFERENCES `peripheriques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pc_peripheriques`
--

LOCK TABLES `pc_peripheriques` WRITE;
/*!40000 ALTER TABLE `pc_peripheriques` DISABLE KEYS */;
INSERT INTO `pc_peripheriques` VALUES (132,66,49),(129,66,50),(131,66,51),(130,66,86),(134,67,15),(133,67,54),(135,67,87),(139,68,15),(138,68,50),(136,68,56),(137,68,88),(140,68,89),(141,68,90),(144,69,21),(146,69,41),(142,69,60),(143,69,61),(145,69,91),(147,69,92),(149,70,26),(152,70,41),(148,70,64),(150,70,65),(151,70,91),(154,71,33),(153,71,66),(155,71,91),(160,72,41),(157,72,50),(158,72,51),(156,72,67),(162,72,92),(159,72,93),(161,72,94),(163,73,70),(164,73,71),(166,73,73),(165,73,95),(167,73,96);
/*!40000 ALTER TABLE `pc_peripheriques` ENABLE KEYS */;
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
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `actif` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pcs`
--

LOCK TABLES `pcs` WRITE;
/*!40000 ALTER TABLE `pcs` DISABLE KEYS */;
INSERT INTO `pcs` VALUES (66,'PC Développement',2500.00,0,1),(67,'PC Infrastructure',3500.00,0,1),(68,'PC Design UX/UI',4500.00,0,1),(69,'PC Marketing',1500.00,0,1),(70,'PC Support Client',1200.00,0,1),(71,'PC Support Handicap',2000.00,0,1),(72,'PC RH Administration',1800.00,0,1),(73,'PC Direction',5500.00,0,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peripheriques`
--

LOCK TABLES `peripheriques` WRITE;
/*!40000 ALTER TABLE `peripheriques` DISABLE KEYS */;
INSERT INTO `peripheriques` VALUES (1,'2x Dell UltraSharp U2723DE 27\" QHD','Écran','Développement',15,'2025-11-21 09:42:20'),(2,'Logitech MX Keys Advanced Wireless','Clavier','Développement',15,'2025-11-21 09:42:20'),(3,'Logitech MX Master 3S','Souris','Développement',15,'2025-11-21 09:42:20'),(4,'Jabra Evolve2 65 Bluetooth ANC','Casque','Développement',15,'2025-11-21 09:42:20'),(5,'Logitech Brio 4K','Webcam','Développement',15,'2025-11-21 09:42:20'),(6,'Tapis SteelSeries QcK Heavy XXL','Spéciaux','Développement',15,'2025-11-21 09:42:20'),(7,'3x LG 27UP850-W 27\" 4K','Écran','Infrastructures',5,'2025-11-21 09:42:20'),(8,'Das Keyboard 4 Professional Mécanique','Clavier','Infrastructures',5,'2025-11-21 09:42:20'),(9,'Logitech MX Master 3S','Souris','Infrastructures',5,'2025-11-21 09:42:20'),(10,'Sennheiser SC 165 USB','Casque','Infrastructures',5,'2025-11-21 09:42:20'),(11,'Logitech C920 HD Pro','Webcam','Infrastructures',5,'2025-11-21 09:42:20'),(12,'Hub Anker PowerExpand 13-en-1 + Tapis SteelSeries XXL','Spéciaux','Infrastructures',5,'2025-11-21 09:42:20'),(13,'2x BenQ SW272U 27\" 4K Pro','Écran','Design UX/UI',5,'2025-11-21 09:42:20'),(14,'Apple Magic Keyboard Pavé Numérique','Clavier','Design UX/UI',5,'2025-11-21 09:42:20'),(15,'Logitech MX Master 3S','Souris','Design UX/UI',5,'2025-11-21 09:42:20'),(16,'Sony WH-1000XM5 Bluetooth ANC','Casque','Design UX/UI',5,'2025-11-21 09:42:20'),(17,'Logitech Brio 4K','Webcam','Design UX/UI',5,'2025-11-21 09:42:20'),(18,'Wacom Intuos Pro Large PTH-860 + Colorimètre X-Rite i1Display Pro + Tapis Razer Strider XXL','Spéciaux','Design UX/UI',5,'2025-11-21 09:42:20'),(19,'1x ASUS VA24EHE 24\" Full HD','Écran','Marketing',10,'2025-11-21 09:42:20'),(20,'Logitech K270 Wireless','Clavier','Marketing',10,'2025-11-21 09:42:20'),(21,'Logitech M330 Silent Plus Wireless','Souris','Marketing',10,'2025-11-21 09:42:20'),(22,'Jabra Evolve 40 UC Stereo USB','Casque','Marketing',10,'2025-11-21 09:42:20'),(23,'Logitech C270 HD 720p','Webcam','Marketing',10,'2025-11-21 09:42:20'),(24,'Tapis basique LDLC','Spéciaux','Marketing',10,'2025-11-21 09:42:20'),(25,'1x Dell P2422H 24\" Full HD','Écran','Support Standard',4,'2025-11-21 09:42:20'),(26,'Logitech K120 USB Filaire','Clavier','Support Standard',4,'2025-11-21 09:42:20'),(27,'Logitech B100 USB','Souris','Support Standard',4,'2025-11-21 09:42:20'),(28,'Plantronics Blackwire 3220 USB','Casque','Support Standard',4,'2025-11-21 09:42:20'),(29,'Logitech C270 HD 720p','Webcam','Support Standard',4,'2025-11-21 09:42:20'),(30,'Aucun','Spéciaux','Support Standard',4,'2025-11-21 09:42:20'),(31,'1x Dell UltraSharp U2723DE 27\" QHD','Écran','Support Adapté',1,'2025-11-21 09:42:20'),(32,'Clevy grandes touches contrastées','Clavier','Support Adapté',1,'2025-11-21 09:42:20'),(33,'Contour RollerMouse Red Plus','Souris','Support Adapté',1,'2025-11-21 09:42:20'),(34,'Beyerdynamic DT 770 PRO 80 Ohm','Casque','Support Adapté',1,'2025-11-21 09:42:20'),(35,'Aucune','Webcam','Support Adapté',1,'2025-11-21 09:42:20'),(36,'Plage Braille Focus 40 Blue + Lampe LED TaoTronics + Pavé numérique USB tactile','Spéciaux','Support Adapté',1,'2025-11-21 09:42:20'),(37,'1x HP E24 G5 24\" Full HD','Écran','RH & Admin',5,'2025-11-21 09:42:20'),(38,'Microsoft Wired Keyboard 600 USB','Clavier','RH & Admin',5,'2025-11-21 09:42:20'),(39,'Microsoft Basic Optical Mouse USB','Souris','RH & Admin',5,'2025-11-21 09:42:20'),(40,'Logitech H390 USB','Casque','RH & Admin',5,'2025-11-21 09:42:20'),(41,'Logitech C270 HD 720p','Webcam','RH & Admin',5,'2025-11-21 09:42:20'),(42,'Tapis basique LDLC','Spéciaux','RH & Admin',5,'2025-11-21 09:42:20'),(43,'2x Dell UltraSharp U3223QE 32\" 4K','Écran','Direction',5,'2025-11-21 09:42:20'),(44,'Logitech MX Keys S for Business','Clavier','Direction',5,'2025-11-21 09:42:20'),(45,'Logitech MX Master 3S for Business','Souris','Direction',5,'2025-11-21 09:42:20'),(46,'Bose 700 UC Bluetooth ANC','Casque','Direction',5,'2025-11-21 09:42:20'),(47,'Logitech BRIO 4K Stream Edition','Webcam','Direction',5,'2025-11-21 09:42:20'),(48,'CalDigit TS4 Thunderbolt 4 Dock + Tapis Razer Pro Glide XXL','Spéciaux','Direction',5,'2025-11-21 09:42:20'),(49,'iiyama 27\" LED – G-Master GB2745QSU-B2 Black Hawk','Écran','',1,'2025-12-05 10:43:00'),(50,'Logitech K120 for Business','Clavier','',1,'2025-12-05 10:43:00'),(51,'INOVU EG200V','Souris','',1,'2025-12-05 10:43:00'),(52,'Altyk Tapis de souris Taille M','','',1,'2025-12-05 10:43:00'),(53,'LG 27UP850-W – 27\" 4K','Écran','',1,'2025-12-05 10:43:00'),(54,'Logitech K280e Pro','Clavier','',1,'2025-12-05 10:43:00'),(55,'SteelSeries QcK Heavy XXL','','',1,'2025-12-05 10:43:00'),(56,'BenQ SW272U 27\" 4K IPS Professionnel','Écran','',1,'2025-12-05 10:43:00'),(57,'Wacom Intuos Pro Large PTH-860','','',1,'2025-12-05 10:43:00'),(58,'Calibrite Display Pro HL','','',1,'2025-12-05 10:43:00'),(59,'Razer Strider XXL Hybrid','','',1,'2025-12-05 10:43:00'),(60,'ASUS VA24EHF 24\" Full HD IPS','Écran','',1,'2025-12-05 10:43:00'),(61,'Logitech K270 Wireless Keyboard','Clavier','',1,'2025-12-05 10:43:00'),(62,'Logitech USB Headset H390','Casque','',1,'2025-12-05 10:43:00'),(63,'Fox Spirit S-Pad','','',1,'2025-12-05 10:43:00'),(64,'Dell P2422H 24\" Full HD IPS','Écran','',1,'2025-12-05 10:43:00'),(65,'Logitech B100 USB Optique','Souris','',1,'2025-12-05 10:43:00'),(66,'Clavier rétroéclairé à gros caractères pour PC','Clavier','',1,'2025-12-05 10:43:00'),(67,'iiyama 23.8\" LED - ProLite XUB2491H-B1','Écran','',1,'2025-12-05 10:43:00'),(68,'Logitech H390 USB','Casque','',1,'2025-12-05 10:43:00'),(69,'Epson WorkForce ES-50','','',1,'2025-12-05 10:43:00'),(70,'iiyama 31.5\" LED - ProLite XUB3293UHSN-B5','Écran','',1,'2025-12-05 10:43:00'),(71,'Logitech MX Keys S Combo','Clavier','',1,'2025-12-05 10:43:00'),(72,'SteelSeries Arctis Nova Pro','','',1,'2025-12-05 10:43:00'),(73,'Logitech BRIO 4K B2C','Webcam','',1,'2025-12-05 10:43:00'),(74,'Razer Pro Glide XXL','','',1,'2025-12-05 10:43:00'),(75,'Dell UltraSharp U2723DE 27\"','Écran','',1,'2025-12-05 10:48:52'),(76,'Dell P2423DE 24\"','Écran','',1,'2025-12-05 10:48:52'),(77,'BenQ SW272U 27\"','Écran','',1,'2025-12-05 10:48:52'),(78,'Logitech MX Keys','Clavier','',1,'2025-12-05 10:48:52'),(79,'Logitech K270','Clavier','',1,'2025-12-05 10:48:52'),(80,'Logitech M185','Souris','',1,'2025-12-05 10:48:52'),(81,'Logitech Zone Vibe 100','','',1,'2025-12-05 10:48:52'),(82,'Logitech H390','Casque','',1,'2025-12-05 10:48:52'),(83,'Wacom Intuos Pro M','','',1,'2025-12-05 10:48:52'),(84,'X-Rite i1Display Pro','','',1,'2025-12-05 10:48:52'),(85,'Epson WorkForce DS-530','','',1,'2025-12-05 10:48:52'),(86,'Altyk Tapis de souris Taille M','','',1,'2025-12-05 10:51:53'),(87,'SteelSeries QcK Heavy XXL','','',1,'2025-12-05 10:51:53'),(88,'Wacom Intuos Pro Large PTH-860','','',1,'2025-12-05 10:51:53'),(89,'Calibrite Display Pro HL','','',1,'2025-12-05 10:51:53'),(90,'Razer Strider XXL Hybrid','','',1,'2025-12-05 10:51:53'),(91,'Logitech USB Headset H390','Casque','',1,'2025-12-05 10:51:53'),(92,'Fox Spirit S-Pad','','',1,'2025-12-05 10:51:53'),(93,'Logitech H390 USB','Casque','',1,'2025-12-05 10:51:53'),(94,'Epson WorkForce ES-50','','',1,'2025-12-05 10:51:53'),(95,'SteelSeries Arctis Nova Pro','','',1,'2025-12-05 10:51:53'),(96,'Razer Pro Glide XXL','','',1,'2025-12-05 10:51:53');
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
INSERT INTO `users` VALUES (1,'admin','$2y$10$hWLno5/t6PsUZld8sdK4wOslY23DegcSLOZfGeYB6tBDZunjwqW..','2025-11-12 08:16:38');
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

-- Dump completed on 2025-12-10  9:18:40
