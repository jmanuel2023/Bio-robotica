
DROP TABLE IF EXISTS `eventos`;
CREATE TABLE `eventos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text,
  `fecha` datetime NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `enlace` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL DEFAULT '',
  `hora` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `eventos` WRITE;
INSERT INTO `eventos` VALUES (2,'prueba 12KAK','asdfgbhnjmk,lñ{ñlkmjnb','2024-04-04 00:00:00','draft-6043459.jpg','https://as.com/motor/formula_1/resultados-f1-parrilla-de-salida-del-gp-de-china-n/','MEXICO','08:59:00'),(3,'prueba 12KAK','wdmñwmwrlvmrm','2024-04-21 00:00:00','hqdefault.jpg','https://as.com/motor/formula_1/resultados-f1-parrilla-de-salida-del-gp-de-china-n/','dsfghjkhgfd','21:06:00'),(4,'Titulacion','1234567890asdfghjkdcvbn','2024-04-23 00:00:00','draft-6043459.jpg','https://as.com/motor/formula_1/resultados-f1-parrilla-de-salida-del-gp-de-china-n/','MEXICO','16:38:00'),(5,'FIL 2024','Vamos','2024-04-30 00:00:00','IMG_20240419_182730.jpg','https://as.com/motor/formula_1/resultados-f1-parrilla-de-salida-del-gp-de-china-n/','MEXICO','22:31:00'),(6,'Titulacion','lkawmvmrwmw{','2025-12-12 00:00:00','Tablero en blanco.png','https://as.com/motor/formula_1/resultados-f1-parrilla-de-salida-del-gp-de-china-n/','{ñwmñea','22:10:00');
UNLOCK TABLES;
