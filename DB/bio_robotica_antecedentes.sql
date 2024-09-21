
DROP TABLE IF EXISTS `antecedentes`;
CREATE TABLE `antecedentes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `informacion` text,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `antecedentes` WRITE;
INSERT INTO `antecedentes` VALUES (14,'Hola prueba','wertyuiopñlkjhgfdfvbn','draft-6043459.jpg'),(15,'Lizbeth 123','jkkkkkkkkkkkk','hqdefault.jpg');
UNLOCK TABLES;
