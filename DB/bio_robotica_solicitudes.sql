DROP TABLE IF EXISTS `solicitudes`;
CREATE TABLE `solicitudes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `boleta` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `telefono_emer` varchar(20) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `verifica_contrasena` varchar(100) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre_imss` varchar(255) DEFAULT NULL,
  `nombre_ine` varchar(255) DEFAULT NULL,
  `nombre_credencial` varchar(255) DEFAULT NULL,
  `nombre_domicilio` varchar(255) DEFAULT NULL,
  `nombre_horario` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `solicitudes` WRITE;
UNLOCK TABLES;
