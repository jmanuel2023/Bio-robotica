drop database if exists biorobotica;

create database biorobotica;
use biorobotica;

DROP TABLE IF EXISTS `antecedentes`;
CREATE TABLE `antecedentes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `informacion` text,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `antecedentes` VALUES (14,'Hola prueba','wertyuiopñlkjhgfdfvbn','draft-6043459.jpg'),(15,'Lizbeth 123','jkkkkkkkkkkkk','hqdefault.jpg');

DROP TABLE IF EXISTS `biblioteca`;
CREATE TABLE `biblioteca` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `biblioteca` VALUES (5,'6626fcb92db51_ReporteInforme.pdf','6626fcb92db56_hqdefault.jpg');

DROP TABLE IF EXISTS `carrusel`;
CREATE TABLE `carrusel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(255) NOT NULL,
  `nombre_imagen` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `carrusel` VALUES (2,'Materiales','draft-6043459.jpg','prueba laflalalalla 111111111'),(5,'Materiales','TRABAJO EN CLASE.  IDENTIFICACIÓN DE MI PERSONALIDAD DE ACUERDO A OCEAN.png','prueba 111'),(33,'Club','Fondo anim2.jpg',NULL),(34,'Club','Fondo anime.jpg',NULL),(35,'Club','fondo bloqueo.jpg',NULL),(37,'Materiales','662538651eab4_TRABAJO EN CLASE.  IDENTIFICACIÓN DE MI PERSONALIDAD DE ACUERDO A OCEAN.png','Orueba 123455678');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cursos` VALUES (1,'Introducción a la Programación','Curso introductorio sobre los conceptos básicos de programación','2024-05-01','2024-06-30','icono_programacion.png','Introducción a la programación','leccion1_intro_programacion.pdf','Variables y tipos de datos','leccion2_intro_programacion.pdf','Resolución de problemas con algoritmos','nota1_intro_programacion.txt','Introducción a los bucles','nota2_intro_programacion.txt','Ejercicios prácticos sobre algoritmos','actividades_intro_programacion.pdf','Examen final','examen_intro_programacion.pdf'),(2,'Diseño Gráfico Avanzado','Curso avanzado sobre técnicas de diseño gráfico','2024-06-15','2024-08-15','icono_diseno.png','Teoría del color','leccion1_diseno.pdf','Composición y disposición','leccion2_diseno.pdf','Principios de diseño visual','nota1_diseno.txt','Diseño de logotipos','nota2_diseno.txt','Proyecto final de diseño','proyecto_final_diseno.pdf','Evaluación del portafolio','evaluacion_diseno.pdf'),(3,'Introducción a la Inteligencia Artificial','Curso introductorio sobre los conceptos básicos de Inteligencia Artificial','2024-07-01','2024-08-31','icono_IA.png','Historia y fundamentos de la IA','leccion1_IA.pdf','Algoritmos de búsqueda','leccion2_IA.pdf','Redes Neuronales Artificiales','nota1_IA.txt','Aplicaciones de la IA en la vida cotidiana','nota2_IA.txt','Proyecto final de IA','proyecto_final_IA.pdf','Evaluación del conocimiento adquirido','evaluacion_IA.pdf');

DROP TABLE IF EXISTS `docentes`;
CREATE TABLE `docentes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `informacion` text,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `docentes` VALUES (20,'López Ruiz Gabriela de Jesús','M en C. López Ruiz Gabriela de Jesús. - Maestra en Ciencias de la Computación egresada del Centro de Investigación en Computación del IPN, Profesora de la Escuela Superior de Cómputo del Instituto Politécnico Nacional, adscrita al departamento de Ingeniería en Sistemas Computacionales, ex coordinadora del club de Mini Robótica de ESCOM, actualmente coordinadora del club de Bio-Robótica de ESCOM - IPN. Áreas de interés: Educación, TICs, Inteligencia Artificial, Sistemas Expertos, Redes Neuronales Artificiales, Algoritmos Genéticos, Robótica, Mecatrónica, Biónica, Electrónica, Tecnologías para la Web, Ext. 52032 correos electrónicos glopezru@ipn.mx y gabydlib.tts.escom.ipn@gmail.com, cel. 5583353440.','Docente1.png'),(27,'Cecilia Albortante','en C. López Ruiz Gabriela de Jesús. - Maestra en Ciencias de la Computación egresada del Centro de Investigación en Computación del IPN, Profesora de la Escuela Superior de Cómputo del Instituto Politécnico Nacional, adscrita al departamento de Ingeniería en Sistemas Computacionales, ex coordinadora del club de Mini Robótica de ESCOM, actualmente coordinadora del club de Bio-Robótica de ESCOM - IPN. Áreas de interés: Educación, TICs, Inteligencia Artificial, Sistemas Expertos, Redes Neuronales Artificiales, Algoritmos Genéticos, Robótica, Mecatrónica, Biónica, Electrónica, Tecnologías para la Web, Ext. 52032 correos electrónicos glopezru@ipn.mx y gabydlib.tts.escom.ipn@gmail.com, cel. 5583353440.','fondo bloqueo.jpg');

DROP TABLE IF EXISTS `encabezados`;
CREATE TABLE `encabezados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `encabezados` VALUES (1,'Club','bienvenido al club de bio-robotica','¡Bienvenidos al Club de Biorrobótica! Aquí encontrarás un espacio vibrante donde la tecnología se fusiona con la inteligencia artificial, abriendo un mundo de posibilidades y descubrimientos. Te invitamos a formar parte de nuestra comunidad, sin importar en qué semestre te encuentres. Tenemos emocionantes proyectos y cursos en camino, diseñados para que explores tus áreas de interés y te sumerjas en el fascinante mundo de la biorrobótica. ¡Únete a nosotros y juntos exploremos nuevos horizontes!'),(2,'Historia','Historia del Club de Bio-Robotica :)','Los atributos de egreso son un conjunto de resultados evaluables individualmente, que conforman los componentes indicativos del potencial de un egresado para adquirir las competencias o capacidades para ejercer la práctica de la ingeniería a un nivel apropiado.\r\n\r\n\r\n \r\n'),(3,'Materiales','Materiales 2','12 Desde hace mucho tiempo, los materiales no sólo se usan para estos propósitos, sino que también juegan un papel muy importante en la economía y la seguridad; se pueden usar como estrategia para el dominio sobre otros países, por la poca disponibilidad de algunos de ellos en el mundo y la alta demanda que se tiene, por lo que esto último obliga a los países consumidores a buscar materiales nuevos para sustituirlos, crear procesos para reciclarlos, buscar la posibilidad de reutilizarlos o encontrar materiales alternativos en caso de que el suministro se interrumpa.');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `eventos` VALUES (2,'prueba 12KAK','asdfgbhnjmk,lñ{ñlkmjnb','2024-04-04 00:00:00','draft-6043459.jpg','https://as.com/motor/formula_1/resultados-f1-parrilla-de-salida-del-gp-de-china-n/','MEXICO','08:59:00'),(3,'prueba 12KAK','wdmñwmwrlvmrm','2024-04-21 00:00:00','hqdefault.jpg','https://as.com/motor/formula_1/resultados-f1-parrilla-de-salida-del-gp-de-china-n/','dsfghjkhgfd','21:06:00'),(4,'Titulacion','1234567890asdfghjkdcvbn','2024-04-23 00:00:00','draft-6043459.jpg','https://as.com/motor/formula_1/resultados-f1-parrilla-de-salida-del-gp-de-china-n/','MEXICO','16:38:00'),(5,'FIL 2024','Vamos','2024-04-30 00:00:00','IMG_20240419_182730.jpg','https://as.com/motor/formula_1/resultados-f1-parrilla-de-salida-del-gp-de-china-n/','MEXICO','22:31:00'),(6,'Titulacion','lkawmvmrwmw{','2025-12-12 00:00:00','Tablero en blanco.png','https://as.com/motor/formula_1/resultados-f1-parrilla-de-salida-del-gp-de-china-n/','{ñwmñea','22:10:00');

DROP TABLE IF EXISTS `foros`;
CREATE TABLE `foros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `foros` VALUES (40,'Fondo anim2.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `integrantes` VALUES (1,'Juan','Pérez','1234567890','555-1234','555-5678','juan@example.com','contraseña123','contraseña123','2024-03-11 00:28:33',NULL,NULL,NULL,NULL,NULL,'1980-01-01','docente',NULL),(2,'María','González','0987654321','555-4321','555-8765','maria@example.com','password456','password456','2024-03-11 00:28:33',NULL,NULL,NULL,NULL,NULL,'1995-05-15','alumno',NULL),(19,'Luis Miguel','Hernández García','1234567890','5613355248','5613355248','pleititossan@gmail.com','LMHGYLOP','LMHGYLOP','2024-06-08 21:40:33','1234567890_imss_1717882833','1234567890_ine_1717882833','1234567890_ipn_1717882833','1234567890_domicilio_1717882833','1234567890_horario_1717882833','2002-01-01','alumno','Masculino');

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

create table curso(
	nombre_curso varchar(60) not null,
    duracion_practica decimal(4,2),
    duracion_teorica decimal(4,2),
    primary key(nombre_curso)
);


create table contenido_curso(
	curso_nombre varchar(60) not null,
    nombre_contenido varchar(60) not null,
    primary key(nombre_contenido, curso_nombre),
    foreign key(curso_nombre) references curso(nombre_curso) ON DELETE cascade
);

create table metodo_curso(
	curso_nombre varchar(60) not null, 
    inductivo INT,
    deductivo INT, 
    heuristico INT,
    analogico INT,
    primary key (curso_nombre),
    foreign key (curso_nombre) references curso(nombre_curso) ON DELETE CASCADE
);

create table soporte(
	curso_nombre varchar(60) not null,
    profesor varchar(50) not null,
    horario varchar(20),
    correo varchar(30),
    primary key (curso_nombre, profesor),
    foreign key (curso_nombre) references curso (nombre_curso)  ON DELETE CASCADE 
);



INSERT INTO `curso` (`nombre_curso`, `duracion_practica`, `duracion_teorica`) VALUES ('Metodos Cuantitativos para la Toma de Decisiones', '8', '9');
INSERT INTO `curso` (`nombre_curso`, `duracion_practica`, `duracion_teorica`) VALUES ('Aplicaciones para Comunicaciones en Red', '8', '9');
INSERT INTO `curso` (`nombre_curso`, `duracion_practica`, `duracion_teorica`) VALUES ('Inteligencia Artificial', '8', '9');
INSERT INTO `curso` (`nombre_curso`, `duracion_practica`, `duracion_teorica`) VALUES ('Probabilidad y Estadistica', '8', '9');
INSERT INTO `curso` (`nombre_curso`, `duracion_practica`, `duracion_teorica`) VALUES ('Tecnologías para el Desarrollo de Aplicaciones Web', '8', '9');
INSERT INTO `contenido_curso` (`curso_nombre`, `nombre_contenido`) VALUES ('Aplicaciones para Comunicaciones en Red', 'Sockets No Bloqueantes');
INSERT INTO `contenido_curso` (`curso_nombre`, `nombre_contenido`) VALUES ('Metodos Cuantitativos para la Toma de Decisiones', 'Algoritmo de Recocido Simulado');
INSERT INTO `contenido_curso` (`curso_nombre`, `nombre_contenido`) VALUES ('Probabilidad y Estadistica', 'Analisis Combinatorio');
INSERT INTO `contenido_curso` (`curso_nombre`, `nombre_contenido`) VALUES ('Probabilidad y Estadistica', 'Densidad Conjunta');
INSERT INTO `contenido_curso` (`curso_nombre`, `nombre_contenido`) VALUES ('Probabilidad y Estadistica', 'Densidad Marginal');
INSERT INTO `contenido_curso` (`curso_nombre`, `nombre_contenido`) VALUES ('Probabilidad y Estadistica', 'Distribucion Normal');
INSERT INTO `contenido_curso` (`curso_nombre`, `nombre_contenido`) VALUES ('Probabilidad y Estadistica', 'Permutaciones');
INSERT INTO `contenido_curso` (`curso_nombre`, `nombre_contenido`) VALUES ('Probabilidad y Estadistica', 'Probabilidad Total');
INSERT INTO `contenido_curso` (`curso_nombre`, `nombre_contenido`) VALUES ('Probabilidad y Estadistica', 'Variable Aleatoria Relacionada a X');


