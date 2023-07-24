-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: project
-- ------------------------------------------------------
-- Server version	8.0.28

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
-- Table structure for table `driver_inspect`
--

DROP TABLE IF EXISTS `driver_inspect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `driver_inspect` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(45) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `i_reg_no_idx` (`reg_no`),
  CONSTRAINT `i_reg_no` FOREIGN KEY (`reg_no`) REFERENCES `registration` (`reg_no`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `driver_inspect`
--

LOCK TABLES `driver_inspect` WRITE;
/*!40000 ALTER TABLE `driver_inspect` DISABLE KEYS */;
INSERT INTO `driver_inspect` VALUES (24,'5','2023-06-24 13:51:06'),(25,'5','2023-06-24 21:16:42'),(26,NULL,'2023-06-26 00:15:02');
/*!40000 ALTER TABLE `driver_inspect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `driver_penalty`
--

DROP TABLE IF EXISTS `driver_penalty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `driver_penalty` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(45) DEFAULT NULL,
  `penalty_id` int NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `amount` varchar(45) DEFAULT NULL,
  `penalizer` varchar(225) DEFAULT NULL,
  `dof` date DEFAULT NULL,
  `status` varchar(45) DEFAULT 'Pending',
  PRIMARY KEY (`id`,`penalty_id`),
  KEY `reg_no_idx` (`reg_no`),
  KEY `p_id_idx` (`penalty_id`),
  CONSTRAINT `p_id` FOREIGN KEY (`penalty_id`) REFERENCES `penalty` (`id`),
  CONSTRAINT `p_reg_no` FOREIGN KEY (`reg_no`) REFERENCES `registration` (`reg_no`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `driver_penalty`
--

LOCK TABLES `driver_penalty` WRITE;
/*!40000 ALTER TABLE `driver_penalty` DISABLE KEYS */;
INSERT INTO `driver_penalty` VALUES (37,NULL,1,'2023-06-22 23:30:30','12000','21',NULL,'Paid'),(38,NULL,1,'2023-06-22 23:31:43','12000','21',NULL,'Paid'),(40,'54',3,'2023-06-25 23:12:31','2000','2','2023-06-23','Paid'),(41,'48',5,'2023-06-25 23:40:41','1000','3','2023-06-18','Pending'),(42,NULL,1,'2023-07-02 19:55:50','8000','2','2023-07-08','Pending'),(44,'3',5,'2023-07-06 16:43:36','4500','4','2023-07-06','Pending'),(45,'3',3,'2023-07-06 16:45:04','3000 ','','2023-07-06','Pending'),(46,'5',1,'2023-07-06 16:53:43','3000','4','2023-07-06','Pending'),(47,'48',5,'2023-07-06 17:20:47',' 2000','','2023-07-05','Pending');
/*!40000 ALTER TABLE `driver_penalty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspect`
--

DROP TABLE IF EXISTS `inspect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inspect` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_id` int NOT NULL,
  `answer_id` int NOT NULL,
  `reg_no` varchar(3) NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`question_id`,`answer_id`,`reg_no`),
  KEY `q_reg_no_idx` (`reg_no`),
  KEY `q_id_idx` (`question_id`),
  CONSTRAINT `q_id` FOREIGN KEY (`question_id`) REFERENCES `ques_answer_inspect` (`q_id`),
  CONSTRAINT `q_reg_no` FOREIGN KEY (`reg_no`) REFERENCES `registration` (`reg_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspect`
--

LOCK TABLES `inspect` WRITE;
/*!40000 ALTER TABLE `inspect` DISABLE KEYS */;
/*!40000 ALTER TABLE `inspect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `phone_no` varchar(45) NOT NULL,
  `email` varchar(225) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `usertype` varchar(45) DEFAULT 'user',
  PRIMARY KEY (`id`,`phone_no`),
  KEY `idx_phone_no` (`phone_no`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'mbmn','09023456789',NULL,'$2y$10$D9KAiotfejR1vPV42Pjiiub8IG22YPMyl3KQMJ73nTgaWT.6wKaZy',NULL),(2,'Sette','00099988877',NULL,'$2y$10$JOdqrpErbn4F.WKJvttdV.AGa2qPD4O.UvCdiScoafXLaAE8ZCLwq','user'),(3,'Ray','99988833447','raydonovan@gmail.com','$2y$10$goV5Y5b6fDjyKXhvmIrbxuRszMGX8GfAyKCBckT/mrQAQNxNFyZM.','admin'),(4,'ejiro','07021356768','odikpaejiro@gmail.com','$2y$10$T4retfOLsMbLXRq3i0fGseK11lV8pN.oZ.ByFIHMAu4i5OAg1M1e6','user'),(5,'toyinjr','12345678910','toyin@yahoo.com','$2y$10$zeyxxrVfeEe7coa5QcWfzOAISTMPtPAA0c05fkSPeCdOrsUrhNBGy','user'),(7,'New','08765432567','new@gmail.com','$2y$10$XZjAf6CNnp1YJfoNAjRfB.wfEsZyD.ZbIOyId53RyxoBrr9aaESoC','user'),(8,'Try','08124338375','wetry@gmail.com','$2y$10$UAwKSakORoa5Pfd5YiGHZ.d6maTZV.UHs6Lhl/WXQjWYv9O5.mHAy','user'),(9,'Will','00088877765','will@gmail.com','$2y$10$oXReG29o8X5ZbVu79dn6DOvXQZQHIt19p4uZasFmgsRHzKbGOoRo6','user'),(10,'Wale','45676534589','wale@yahoo.com','$2y$10$KbFYh/k.btMmEKkeGNVULuURJSFECU2fjRPsl96uPXwVRVulws5si','user'),(11,'Mishael','54321678908','mitchy@yahoo.com','$2y$10$ZYQEX3tWBxTce.6zRbclMeWB0qUXjwErU3BuGfZiwa3LoV7D/BPXe','user'),(12,'Kay','89876546787','kay@gmail.com','$2y$10$zq/9kRj4qXvi2gTTTfi3vOyP2uLHgq1R4NJ6ro357TiG6ibxYds7a','user'),(13,'Zendaya','12345678909','zendaya@mid.com','$2y$10$wMAV.sW/URyK1x3/ag5dZuhhu4dRKUfWvRijR0k7g0XRjoQJu1/rm','user'),(14,'Care','23456765467','find@find.com','$2y$10$1LKsZ67jjMvviWjclz5Sp.XkQyGX6g7b5JijnptDkmk7iAQ9Uhy/2','user'),(15,'tyjr','12345678901','yt@yahoo.com','$2y$10$MPPaZZxkR6jjEv./ox283uAYbeoGpxSxgVsgBrHvRvobufpXspJ42','user'),(16,'messi','13579087654','messi@yahoo.com','$2y$10$4a3cNTv8ItHqHfRsMcgUbOWMLgF2MjCYuLBt2RjUCXlmgobUa1eSS','user'),(17,'mishiiray','08167406144','mishael@mail.com','$2y$10$aPJL4CZ4of5.IvzohjZzDOCgZjAQsHG6DdJ6pSnQo2NVqnqkHLF2q','user'),(18,'ronaldo','12345678944','ronaldo@gmail.com','$2y$10$hfOJTONrEnjt7zqbbwUybewtUDcovvKt3FoEkl0CbIjiYnb0aT9dG','user'),(19,'Pablo','77788899900','pablo@bad.com','$2y$10$q0yJ1o33khVtdzxhUf9uX.NEs6wKDN6NnB6iGk7LRqwKvsj..53ii','user'),(20,'Kelly','88866655789','kelly@clarkson.tv','$2y$10$SkvOohGt.bDcYFcRWAXcEOWI2gG17Zt03w4gCNI2N/Pacsz5JK3.u','user'),(21,'Extra','23434254676','extra@hotmail.com','$2y$10$iJHtAFC8TDEuR2pVuIuGhuJ2tRQUZZlV8Rs9nllU9KMH0VD9ltLmW','user'),(22,'Trey','43434343434','434@gmail.com','$2y$10$PwoJfqQZSGbeVB0lU/XrxOOdpo0rr2cBqP1/gol.b.yoWJwVH8/Ku','user'),(43,'Temi','08114451983','temiolaiya@gmail.com','$2y$10$OUtIhDh7J0mqSyakHnqZOurIzyF6kjniC8v18uo1fU7la2AsJtO/q','user'),(44,'Yolanda','00987645678','','Snow',NULL),(45,'Jacob','89877777774','risafy@mailinator.com','Franklin','user'),(46,'Kai','99978067654','kai@haverts.com','$2y$10$RTP29B5kKqDoK.duX0AdqOcdNl0LTxVzBcOTP8YQKLmQYeantIJkS','user'),(47,'Bamidele','09076534786','bamidelegeorge@gmail.com','$2y$10$xkF/wWN9L2n5Y3Gl0KyuhekpNoWiG15UF2eO7UwgBfHb3GQ2vGkDC','user'),(48,'Whitney','16291063524','lane@gmail.com','$2y$10$073oa8lCUjfm9/Ut93.rUuEy5KU3AC.yKdDNkiMuKqhQnI4GW832C','user'),(49,'Brenda','+1 (265) 236-2072','qofowub@mailinator.com','$2y$10$b7J8yqarpgxCIjEb959Pt.Qo1mQgjN/fzZFr1RDBllZtWXuC1vOHS','user'),(50,'Rhiannon','+1 (751) 581-7114','lymapuna@mailinator.com','$2y$10$bnVt7isaa5fnLZ.iIO8SJOnkx81b.zP0mQwatGEyZ.IFtQ2SWeMUa','admin');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `reg_no` varchar(45) DEFAULT NULL,
  `message` varchar(225) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `reg_no_idx` (`reg_no`),
  CONSTRAINT `registr_no` FOREIGN KEY (`reg_no`) REFERENCES `registration` (`reg_no`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (1,'Penalty','5','You have been penalized for 4 with the 3500',NULL),(2,'Penalty',NULL,'You have been penalized for Overspeeding with the 12000','2023-06-22 23:31:43'),(3,'Penalty','3','You have been penalized for Reckless Driving with the amount of 5000','2023-06-25 21:53:52'),(4,'Penalty','54','You have been penalized for Assault with the amount of 2,000','2023-06-25 23:12:31'),(5,'Penalty','48','You have been penalized for One-Way Pass with the amount of 1000','2023-06-25 23:40:41'),(6,'Penalty',NULL,'You have been penalized for Overspeeding with the amount of 8000','2023-07-02 19:55:50'),(7,'Penalty','82','You have been penalized for Overspeeding with the amount of 8000','2023-07-04 08:40:13'),(8,'Penalty','3','You have been penalized for One-Way Pass with the amount of 4500','2023-07-06 16:43:36'),(9,'Penalty','3','You have been penalized for Assault with the amount of 2000','2023-07-06 16:45:04'),(10,'Penalty','5','You have been penalized for Overspeeding with the amount of 3000','2023-07-06 16:53:43'),(11,'Penalty','48','You have been penalized for One-Way Pass with the amount of ','2023-07-06 17:20:47');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  `amount` varchar(45) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1,'Annual','25000','2023-06-17 15:13:54');
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_details`
--

DROP TABLE IF EXISTS `payment_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(45) DEFAULT NULL,
  `reference` varchar(225) DEFAULT NULL,
  `full_name` varchar(225) DEFAULT NULL,
  `date_purchased` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_idx` (`email`),
  CONSTRAINT `email` FOREIGN KEY (`email`) REFERENCES `registration` (`email`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_details`
--

LOCK TABLES `payment_details` WRITE;
/*!40000 ALTER TABLE `payment_details` DISABLE KEYS */;
INSERT INTO `payment_details` VALUES (1,'success','887437491',' ','06/19/2023 11:24:26 am','raydonovan@gmail.com'),(2,'success','502984990',' ','06/19/2023 11:25:19 am','odikpaejiro@gmail.com'),(4,'success','995103878',' ','06/23/2023 12:56:19 pm',NULL),(5,'success','723302398',' ','06/23/2023 01:11:57 pm',NULL),(6,'success','723302398',' ','06/23/2023 01:24:16 pm',NULL),(8,'success','159122587',' ','06/29/2023 12:55:56 pm','wale@yahoo.com');
/*!40000 ALTER TABLE `payment_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_status`
--

DROP TABLE IF EXISTS `payment_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `amount` varchar(45) DEFAULT NULL,
  `penalty_id` int DEFAULT NULL,
  `reg_id` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'Not Paid',
  PRIMARY KEY (`id`),
  KEY `fk_reg_no_idx` (`reg_id`),
  KEY `fk_pid_idx` (`penalty_id`),
  CONSTRAINT `fk_pid` FOREIGN KEY (`penalty_id`) REFERENCES `driver_penalty` (`id`),
  CONSTRAINT `fk_reg_no` FOREIGN KEY (`reg_id`) REFERENCES `registration` (`reg_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_status`
--

LOCK TABLES `payment_status` WRITE;
/*!40000 ALTER TABLE `payment_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penalty`
--

DROP TABLE IF EXISTS `penalty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penalty` (
  `id` int NOT NULL AUTO_INCREMENT,
  `offence` varchar(45) DEFAULT NULL,
  `penalty` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penalty`
--

LOCK TABLES `penalty` WRITE;
/*!40000 ALTER TABLE `penalty` DISABLE KEYS */;
INSERT INTO `penalty` VALUES (1,'Overspeeding','10,000'),(2,'Reckless Driving','5,000'),(3,'Assault','2,000'),(4,'Illegal Parking','5,000'),(5,'One-Way Pass','5,000');
/*!40000 ALTER TABLE `penalty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ques_answer_inspect`
--

DROP TABLE IF EXISTS `ques_answer_inspect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ques_answer_inspect` (
  `id` int NOT NULL AUTO_INCREMENT,
  `q_id` int NOT NULL,
  `answer` varchar(225) DEFAULT NULL,
  `inspect_id` int DEFAULT NULL,
  PRIMARY KEY (`id`,`q_id`),
  KEY `question_id_idx` (`q_id`),
  KEY `i_id_idx` (`inspect_id`),
  CONSTRAINT `i_id` FOREIGN KEY (`inspect_id`) REFERENCES `driver_inspect` (`id`),
  CONSTRAINT `question_id` FOREIGN KEY (`q_id`) REFERENCES `question_inspect` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ques_answer_inspect`
--

LOCK TABLES `ques_answer_inspect` WRITE;
/*!40000 ALTER TABLE `ques_answer_inspect` DISABLE KEYS */;
INSERT INTO `ques_answer_inspect` VALUES (52,3,'Good',24),(53,5,'Fair',24),(54,6,'Yes',24),(55,7,'Yes',24),(56,8,'Yes',24),(57,9,'Yes',24),(58,10,'Yes',24),(59,11,'Cleared',24),(60,3,'Fair',24),(61,5,'Bad',24),(62,6,'No',24),(63,7,'No',24),(64,8,'No',24),(65,9,'No',24),(66,10,'No',24),(67,11,'Failed',24),(68,3,'Fair',24),(69,5,'Fair',24),(70,6,'Yes',24),(71,7,'Yes',24),(72,8,'Yes',24),(73,9,'Yes',24),(74,10,'No',24),(75,11,'Repeat',24);
/*!40000 ALTER TABLE `ques_answer_inspect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_inspect`
--

DROP TABLE IF EXISTS `question_inspect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question_inspect` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(225) NOT NULL,
  `type` varchar(225) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `answer1` varchar(45) DEFAULT NULL,
  `answer2` varchar(45) DEFAULT NULL,
  `answer3` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`,`question`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_inspect`
--

LOCK TABLES `question_inspect` WRITE;
/*!40000 ALTER TABLE `question_inspect` DISABLE KEYS */;
INSERT INTO `question_inspect` VALUES (3,'Tyre Status','radio','2023-05-06 11:58:37','Good','Fair','Bad'),(5,'Side Mirror','radio','2023-05-07 19:16:36','Good','Fair','Bad'),(6,'Presence of Safety Tools','radio','2023-05-07 19:16:41','Yes','No',NULL),(7,'Spare Tyre, Jack e.t.c','radio','2023-05-17 15:42:21','Yes','No',NULL),(8,'Valid Vehicle License','radio','2023-06-24 13:45:52','Yes','No',NULL),(9,'Valid 3rd Insurance','radio','2023-06-24 13:45:52','Yes','No',NULL),(10,'Valid Roadworthiness','radio','2023-06-24 13:45:52','Yes','No',NULL),(11,'Report','radio','2023-06-24 13:45:52','Cleared','Repeat','Failed');
/*!40000 ALTER TABLE `question_inspect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `phone_no` varchar(45) NOT NULL,
  `mode` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `lga` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `nok_firstname` varchar(45) DEFAULT NULL,
  `nok_middlename` varchar(45) DEFAULT NULL,
  `nok_lastname` varchar(45) DEFAULT NULL,
  `nok_relationship` varchar(45) DEFAULT NULL,
  `nok_phoneno` varchar(45) DEFAULT NULL,
  `nok_dob` date DEFAULT NULL,
  `nok_address` varchar(225) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(225) DEFAULT NULL,
  `drivers_license` varchar(45) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`,`phone_no`),
  UNIQUE KEY `uc_email` (`email`),
  KEY `reg_no_idx` (`reg_no`),
  KEY `idx_phone_no` (`phone_no`),
  CONSTRAINT `phone_no` FOREIGN KEY (`phone_no`) REFERENCES `login` (`phone_no`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration`
--

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;
INSERT INTO `registration` VALUES (28,'14','Uma','Whilemina Blanchard','Gonzales','99988833447','Shuttle','','2004-03-21','','Et id eiusmod unde ','Voluptates officia c','active','Jessica','Serena Cortez','Knowles','Quibusdam sequi magn','','1989-06-23','Optio nostrum lauda','2023-05-26 17:16:12',NULL,NULL,'raydonovan@gmail.com'),(36,'48','Scarlet','Nero Alexander','Henderson','07021356768','Shuttle','Female','1982-09-20','Et autem quibusdam t','Numquam dolorem sit ','Voluptate in sunt q','active','Lila','Stewart Harris','King','Voluptatem Labore e','+1 (775) 956-7436',NULL,'Optio magni ipsa m','2023-05-30 12:15:18',NULL,NULL,'odikpaejiro@gmail.com'),(40,'3','Carla',NULL,NULL,'08765432567','Shuttle',NULL,NULL,NULL,NULL,NULL,'active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-20 15:29:25',NULL,NULL,'new@gmail.com'),(42,'99','Ashely','Brooke Duncan','Barry','08124338375','Cab','Male','1991-07-27','Labore aut inventore','Voluptatem dolore q','Nisi aliquid earum a','active','Stacy','Acton Weber','Burke','Aut blanditiis sint ','08124338375',NULL,'Et nulla vel ea aute','2023-06-20 15:43:11','','','ashley@yahoo.com'),(45,'54','Germaine','','Hawkins','45676534589','Cab','Male','1979-09-17','Ipsa voluptatem Na','Mollitia id veritat','Aspernatur et volupt','active','Xerxes','','Clayton','Non repellendus Ea ','+1 (683) 918-4189',NULL,'Autem ad soluta iste','2023-06-21 17:50:16','uploads/64932a487651a3.45231578.jpeg','','wale@yahoo.com'),(47,'5','Eliana','Abigail Gaines','Odom','89876546787','Cab','Male','2013-05-06','Architecto itaque et','Dolores et labore vo','Facere nisi culpa au','active','Candace','Steel Macdonald','Sparks','Vel quas expedita ni','+1 (934) 293-2097',NULL,'Elit aliqua Commod','2023-06-21 18:10:58','uploads/64932f2216ab25.49716344.jpeg','','cazi@mailinator.com'),(51,'26','Mariam','Zephr Stark','Taylor','12345678901','Cab','Male','2016-06-05','Quo accusantium non ','Ipsa cupiditate ea ','In pariatur Excepte','active','Yardley','Uta Bauer','Moore','Esse lorem aliquam q','+1 (656) 156-8644',NULL,'Quia ad ut fugiat co','2023-06-21 18:27:41','uploads/6493330d9c9d81.90858057.jpg','','miqafyro@mailinator.com'),(52,'82','Brenden','Joy Luna','Johnston','13579087654','Shuttle','Male','1986-09-25','Nam ea voluptas occa','Nulla rerum accusamu','Nostrum at atque nis','active','Abra','Adam Holman','Clark','Reprehenderit commod','+1 (879) 145-4594',NULL,'Dolores laudantium ','2023-06-21 18:31:22','uploads/649333ea354587.00422729.jpg','','qepoqotupy@mailinator.com'),(59,'97','Temi','Imo','Olaiya','08114451983','Cab','Female','2020-09-15','Enim facere aut eos ','Tenetur sunt reicie','In proident sunt n','active','Tobias','Katelyn Paul','Gay','Nobis voluptatem cum','+1 (132) 955-7022',NULL,'Incididunt aut simil','2023-06-26 09:43:58','uploads/64994fce8033c6.96453017.jpeg','','temiolaiya@gmail.com'),(60,'269','Yolanda','','Snow','00987645678','Shuttle','Female','1979-04-22','Earum nulla Nam dele','Aliqua Aut neque as','Quis hic amet volup','active','Clinton','','Silva','Quam ea irure dolor ','+1 (376) 654-8202',NULL,'Sapiente laboriosam','2023-07-06 22:34:08','uploads/64a7335060ddf2.20239124.jpeg','',''),(61,'18','Jacob','Wesley Hubbard','Franklin','89877777774','Cab','Male','2020-04-26','Omnis nostrud invent','Exercitationem dolor','Et corrupti in veli','active','Rashad','Nelle Holmes','Velazquez','Quis ut repudiandae ','+1 (663) 635-7547',NULL,'Consequatur consect','2023-07-06 22:37:08','uploads/64a734044d2ea3.13113920.jpg','','risafy@mailinator.com'),(62,'188','Kai','Arsenal','Havertz','99978067654','Shuttle','Male','1990-05-06','Voluptas eaque vel n','Non aspernatur repre','Do aut ab in quasi u','active','Aiko','Lionel Gomez','Owens','Exercitationem eiusm','+1 (978) 908-5063',NULL,'Pariatur Enim est s','2023-07-06 23:25:25','uploads/64a73f55764280.94180051.jpg','','kai@haverts.com'),(63,'089','Bamidele','Seyi','George','09076534786','Cab','','1982-01-04','','Ogun','Ijebu','active','Kemi','Mary','George','Wife','08176534786',NULL,'No 1, Ajayi Str, Bariga, Lagos','2023-07-07 17:52:32','uploads/64a842d01a0a62.23526803.jpg','AWS9087234UI','bamidelegeorge@gmail.com'),(64,'229','Whitney','','Lane','16291063524','Shuttle','Male','1974-11-07','Unde aut velit aspe','Distinctio Ullamco ','Velit dolores veniam','active','Gail','','Whitaker','Enim omnis veniam a','16291063524',NULL,'Vel assumenda sed nu','2023-07-07 19:44:37','uploads/64a85d15383639.56024026.jpg','','lane@gmail.com');
/*!40000 ALTER TABLE `registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `staff_no` varchar(45) DEFAULT NULL,
  `phone_no` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `dept` varchar(45) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'Test','Weir','Random','894','09023456784',NULL,NULL,'2023-05-26 17:17:18',NULL),(2,'Random','Will','Admin','678','09876432902',NULL,NULL,'2023-06-10 11:54:14',NULL),(3,'Werl','Main','Sir','435','09023456783',NULL,NULL,'2023-06-10 11:57:39',NULL),(4,'Imelda','Melvin Simon','Lewis','34','+1 (857) 558-6138',NULL,NULL,'2023-06-10 14:02:51',NULL),(5,'Yoshio','Eden Turner','Barr','70','+1 (907) 204-8584',NULL,NULL,'2023-06-10 14:18:41',NULL),(7,'Tana','Aristotle Odom','Cross','34','+1 (699) 864-8158',NULL,NULL,'2023-06-10 14:23:57',NULL),(8,'Lynn','Neil Mcclure','Dominguez','51','+1 (681) 186-8947',NULL,NULL,'2023-06-10 14:34:09',NULL),(9,'Savannah','Portia Ramirez','Briggs','42','+1 (517) 465-9065',NULL,NULL,'2023-06-10 14:35:17',NULL),(10,'Rachel','Alan Knowles','Cooper','6','+1 (567) 782-4309',NULL,NULL,'2023-06-10 14:35:57',NULL),(11,'Francis','Athena Ware','Calderon','13','+1 (889) 216-7225',NULL,NULL,'2023-06-10 14:39:46',NULL),(29,'Kai','Rim','Havertz','078','07082237654',NULL,NULL,'2023-06-25 23:42:36',NULL),(30,'Adrienne','Hamish Potter','Reilly','3','+1 (367) 576-5824',NULL,NULL,'2023-07-04 21:38:13',NULL),(31,'Brenda','Imelda Foley','Guerrero','50','+1 (265) 236-2072',NULL,NULL,'2023-07-11 19:15:21',NULL),(32,'Rhiannon','Diana Whitley','Navarro','90','+1 (751) 581-7114',NULL,NULL,'2023-07-11 19:17:11',NULL);
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_inspect`
--

DROP TABLE IF EXISTS `user_inspect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_inspect` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(225) DEFAULT NULL,
  `reg_no` varchar(45) DEFAULT NULL,
  `start_work` date DEFAULT NULL,
  `drivers_license` varchar(45) DEFAULT NULL,
  `payment_year` int DEFAULT NULL,
  `rrr` varchar(45) DEFAULT NULL,
  `amount` varchar(45) DEFAULT NULL,
  `receipt` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_inspect`
--

LOCK TABLES `user_inspect` WRITE;
/*!40000 ALTER TABLE `user_inspect` DISABLE KEYS */;
INSERT INTO `user_inspect` VALUES (1,'NasimY Farrell','38','2003-11-12','Eos delectus conse',1996,'Ad sit deserunt qui','Aliquip fuga Exerci','Obcaecati vel et iru','2017-11-14'),(2,'NasimY Farrell','38','2023-06-02','456OK6789o0',1996,'090','12000','256','2023-06-28'),(3,'NasimY Farrell','38','2019-01-03','Aut distinctio Amet',2018,'Ut ut qui fuga Moll','Dolorem facere enim ','Tempore aut volupta','2009-09-04');
/*!40000 ALTER TABLE `user_inspect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plate_no` varchar(11) NOT NULL,
  `vehicle_colour` varchar(45) NOT NULL,
  `vehicle_name` varchar(45) DEFAULT NULL,
  `reg_no` varchar(3) DEFAULT NULL,
  `clearance` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reg_no_idx` (`reg_no`),
  CONSTRAINT `reg_no` FOREIGN KEY (`reg_no`) REFERENCES `registration` (`reg_no`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle`
--

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
INSERT INTO `vehicle` VALUES (24,'08124338375','In omnis repellendus','Raya Carson','99',NULL),(25,'45676534589','Laboris obcaecati cu','Marcia Small','54',NULL),(27,'89876546787','Quia quia reprehende','Isabella Cherry','5',NULL),(28,'12343212345','Debitis autem sint d','Xerxes Reynolds T',NULL,NULL),(30,'12345678901','Qui et ducimus cons','Melissa Cole','26',NULL),(31,'13579087654','Ut vel modi obcaecat','Dustin Keith','82',NULL),(36,'08114451983','Magna sed fugiat hic','Tanisha James','97',NULL),(37,'00987645678','Exercitation digniss','Clio Ashley','269',NULL),(38,'89877777774','Ut dolor nisi evenie','Josiah Benton','18',NULL),(39,'99978067654','Qui numquam ut maior','Beck Knapp','188',NULL),(40,'GGE-12342ZY','Grey','Toyota','089',NULL),(41,'16291063','Proident dolores ev','Kitra Cohen','229',NULL);
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-12 18:18:52
