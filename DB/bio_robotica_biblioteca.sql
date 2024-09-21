DROP TABLE IF EXISTS `biblioteca`;
CREATE TABLE `biblioteca` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `biblioteca` WRITE;
INSERT INTO `biblioteca` VALUES (5,'6626fcb92db51_ReporteInforme.pdf','6626fcb92db56_hqdefault.jpg');
UNLOCK TABLES;
