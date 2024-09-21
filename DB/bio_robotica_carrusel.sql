
DROP TABLE IF EXISTS `carrusel`;
CREATE TABLE `carrusel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(255) NOT NULL,
  `nombre_imagen` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `carrusel` WRITE;
INSERT INTO `carrusel` VALUES (2,'Materiales','draft-6043459.jpg','prueba laflalalalla 111111111'),(5,'Materiales','TRABAJO EN CLASE.  IDENTIFICACIÓN DE MI PERSONALIDAD DE ACUERDO A OCEAN.png','prueba 111'),(33,'Club','Fondo anim2.jpg',NULL),(34,'Club','Fondo anime.jpg',NULL),(35,'Club','fondo bloqueo.jpg',NULL),(37,'Materiales','662538651eab4_TRABAJO EN CLASE.  IDENTIFICACIÓN DE MI PERSONALIDAD DE ACUERDO A OCEAN.png','Orueba 123455678');
UNLOCK TABLES;
