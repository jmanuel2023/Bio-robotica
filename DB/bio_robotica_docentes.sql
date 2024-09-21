DROP TABLE IF EXISTS `docentes`;
CREATE TABLE `docentes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `informacion` text,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `docentes` WRITE;
INSERT INTO `docentes` VALUES (20,'López Ruiz Gabriela de Jesús','M en C. López Ruiz Gabriela de Jesús. - Maestra en Ciencias de la Computación egresada del Centro de Investigación en Computación del IPN, Profesora de la Escuela Superior de Cómputo del Instituto Politécnico Nacional, adscrita al departamento de Ingeniería en Sistemas Computacionales, ex coordinadora del club de Mini Robótica de ESCOM, actualmente coordinadora del club de Bio-Robótica de ESCOM - IPN. Áreas de interés: Educación, TICs, Inteligencia Artificial, Sistemas Expertos, Redes Neuronales Artificiales, Algoritmos Genéticos, Robótica, Mecatrónica, Biónica, Electrónica, Tecnologías para la Web, Ext. 52032 correos electrónicos glopezru@ipn.mx y gabydlib.tts.escom.ipn@gmail.com, cel. 5583353440.','Docente1.png'),(27,'Cecilia Albortante','en C. López Ruiz Gabriela de Jesús. - Maestra en Ciencias de la Computación egresada del Centro de Investigación en Computación del IPN, Profesora de la Escuela Superior de Cómputo del Instituto Politécnico Nacional, adscrita al departamento de Ingeniería en Sistemas Computacionales, ex coordinadora del club de Mini Robótica de ESCOM, actualmente coordinadora del club de Bio-Robótica de ESCOM - IPN. Áreas de interés: Educación, TICs, Inteligencia Artificial, Sistemas Expertos, Redes Neuronales Artificiales, Algoritmos Genéticos, Robótica, Mecatrónica, Biónica, Electrónica, Tecnologías para la Web, Ext. 52032 correos electrónicos glopezru@ipn.mx y gabydlib.tts.escom.ipn@gmail.com, cel. 5583353440.','fondo bloqueo.jpg');
UNLOCK TABLES;
