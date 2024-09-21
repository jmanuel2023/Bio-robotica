
DROP TABLE IF EXISTS `encabezados`;
CREATE TABLE `encabezados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `encabezados` WRITE;
INSERT INTO `encabezados` VALUES (1,'Club','bienvenido al club de bio-robotica','¡Bienvenidos al Club de Biorrobótica! Aquí encontrarás un espacio vibrante donde la tecnología se fusiona con la inteligencia artificial, abriendo un mundo de posibilidades y descubrimientos. Te invitamos a formar parte de nuestra comunidad, sin importar en qué semestre te encuentres. Tenemos emocionantes proyectos y cursos en camino, diseñados para que explores tus áreas de interés y te sumerjas en el fascinante mundo de la biorrobótica. ¡Únete a nosotros y juntos exploremos nuevos horizontes!'),(2,'Historia','Historia del Club de Bio-Robotica :)','Los atributos de egreso son un conjunto de resultados evaluables individualmente, que conforman los componentes indicativos del potencial de un egresado para adquirir las competencias o capacidades para ejercer la práctica de la ingeniería a un nivel apropiado.\r\n\r\n\r\n \r\n'),(3,'Materiales','Materiales 2','12 Desde hace mucho tiempo, los materiales no sólo se usan para estos propósitos, sino que también juegan un papel muy importante en la economía y la seguridad; se pueden usar como estrategia para el dominio sobre otros países, por la poca disponibilidad de algunos de ellos en el mundo y la alta demanda que se tiene, por lo que esto último obliga a los países consumidores a buscar materiales nuevos para sustituirlos, crear procesos para reciclarlos, buscar la posibilidad de reutilizarlos o encontrar materiales alternativos en caso de que el suministro se interrumpa.');
UNLOCK TABLES;
