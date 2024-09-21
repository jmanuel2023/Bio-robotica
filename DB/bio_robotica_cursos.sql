
DROP TABLE IF EXISTS `cursos`;
CREATE TABLE `cursos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_curso` varchar(255) NOT NULL,
  `descripcion_curso` text,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `descripcion_leccion1` text,
  `documento_leccion1` varchar(255) DEFAULT NULL,
  `descripcion_leccion2` text,
  `documento_leccion2` varchar(255) DEFAULT NULL,
  `nota1` text,
  `documento_nota1` varchar(255) DEFAULT NULL,
  `nota2` text,
  `documento_nota2` varchar(255) DEFAULT NULL,
  `descripcion_actividades` text,
  `documento_actividades` varchar(255) DEFAULT NULL,
  `evaluacion` text,
  `documento_pdf` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `cursos` WRITE;
INSERT INTO `cursos` VALUES (1,'Introducción a la Programación','Curso introductorio sobre los conceptos básicos de programación','2024-05-01','2024-06-30','icono_programacion.png','Introducción a la programación','leccion1_intro_programacion.pdf','Variables y tipos de datos','leccion2_intro_programacion.pdf','Resolución de problemas con algoritmos','nota1_intro_programacion.txt','Introducción a los bucles','nota2_intro_programacion.txt','Ejercicios prácticos sobre algoritmos','actividades_intro_programacion.pdf','Examen final','examen_intro_programacion.pdf'),(2,'Diseño Gráfico Avanzado','Curso avanzado sobre técnicas de diseño gráfico','2024-06-15','2024-08-15','icono_diseno.png','Teoría del color','leccion1_diseno.pdf','Composición y disposición','leccion2_diseno.pdf','Principios de diseño visual','nota1_diseno.txt','Diseño de logotipos','nota2_diseno.txt','Proyecto final de diseño','proyecto_final_diseno.pdf','Evaluación del portafolio','evaluacion_diseno.pdf'),(3,'Introducción a la Inteligencia Artificial','Curso introductorio sobre los conceptos básicos de Inteligencia Artificial','2024-07-01','2024-08-31','icono_IA.png','Historia y fundamentos de la IA','leccion1_IA.pdf','Algoritmos de búsqueda','leccion2_IA.pdf','Redes Neuronales Artificiales','nota1_IA.txt','Aplicaciones de la IA en la vida cotidiana','nota2_IA.txt','Proyecto final de IA','proyecto_final_IA.pdf','Evaluación del conocimiento adquirido','evaluacion_IA.pdf');
UNLOCK TABLES;