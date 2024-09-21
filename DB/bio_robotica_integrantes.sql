DROP TABLE IF EXISTS `integrantes`;
CREATE TABLE `integrantes` (
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
  `rol` varchar(50) DEFAULT NULL,
  `genero` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `integrantes` WRITE;
INSERT INTO `integrantes` VALUES (1,'Juan','Pérez','1234567890','555-1234','555-5678','juan@example.com','contraseña123','contraseña123','2024-03-11 00:28:33',NULL,NULL,NULL,NULL,NULL,'1980-01-01','docente',NULL),(2,'María','González','0987654321','555-4321','555-8765','maria@example.com','password456','password456','2024-03-11 00:28:33',NULL,NULL,NULL,NULL,NULL,'1995-05-15','alumno',NULL),(19,'Luis Miguel','Hernández García','1234567890','5613355248','5613355248','pleititossan@gmail.com','LMHGYLOP','LMHGYLOP','2024-06-08 21:40:33','1234567890_imss_1717882833','1234567890_ine_1717882833','1234567890_ipn_1717882833','1234567890_domicilio_1717882833','1234567890_horario_1717882833','2002-01-01','alumno','Masculino');
UNLOCK TABLES;
