-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-01-2025 a las 12:57:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_abogados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Causas`
--

CREATE TABLE `Causas` (
  `ID` int(11) NOT NULL,
  `Numero_Expediente` varchar(255) NOT NULL,
  `Cliente_DNI` varchar(20) NOT NULL,
  `Juzgado_ID` int(11) NOT NULL,
  `Objeto_ID` int(11) NOT NULL,
  `Perito_ID` int(11) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `Fecha_Alta` date NOT NULL,
  `Usuario_DNI` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Causas`
--

INSERT INTO `Causas` (`ID`, `Numero_Expediente`, `Cliente_DNI`, `Juzgado_ID`, `Objeto_ID`, `Perito_ID`, `Descripcion`, `Fecha_Alta`, `Usuario_DNI`) VALUES
(1, '123456/25', '35836278', 1, 1, 1, 'Sarasa / sarasa', '2025-01-15', NULL),
(2, '8765432/25', '87612323', 3, 1, 1, 'Test 1', '2024-12-03', NULL),
(3, '281245/52', '25688532', 1, 1, 1, 'wweqweqwe', '2025-01-14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clientes`
--

CREATE TABLE `Clientes` (
  `DNI` varchar(20) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Contacto` varchar(255) DEFAULT NULL,
  `Otros_Datos` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Clientes`
--

INSERT INTO `Clientes` (`DNI`, `Nombre`, `Contacto`, `Otros_Datos`) VALUES
('123123123123', 'waldo alberto ', '123123123', ''),
('1263871263871263', 'juan perez', '123123123', 'sarasaaaaa'),
('23388707', 'Cecilia', 'fsdfsdfsdfsd', 'sfdsfdsdf'),
('25688532', 'GABRIEL GUSTAVO', '3487534614', 'zarate'),
('35836278', 'Ariel', '123123123123', 'zarate'),
('76512365', 'pablo', 'capoleche', 'calvo'),
('87612323', 'pedro el escamoso', '123123123123', 'actor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Estados`
--

CREATE TABLE `Estados` (
  `ID` int(11) NOT NULL,
  `Descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Estados`
--

INSERT INTO `Estados` (`ID`, `Descripcion`) VALUES
(1, 'A Despacho'),
(2, 'En Letra'),
(3, 'TERMINADO'),
(4, 'Archivado'),
(5, 'Paralizado'),
(6, 'Pre Paralizado'),
(7, 'Fuera del Organismo'),
(8, 'CM'),
(9, 'En Borrador'),
(10, 'Extrajudicial'),
(11, 'Cambio de Patrocinio'),
(12, 'Consulta en Estudio'),
(13, 'Escrito'),
(14, 'Aviso al cliente'),
(15, 'Esperando Respuesta'),
(16, 'Elevado a Cámara'),
(17, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Juzgados`
--

CREATE TABLE `Juzgados` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Domicilio` varchar(50) DEFAULT NULL,
  `Fuero` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Juzgados`
--

INSERT INTO `Juzgados` (`ID`, `Nombre`, `Domicilio`, `Fuero`) VALUES
(1, 'Tribunal de Trabajo n° 1 Campana', 'Guemes 780 - Campana', 'Laboral'),
(2, 'Tribunal de Trabajo n° 2 Zárate', 'Gral. Paz. 1784 - Zárate', 'Laboral'),
(3, 'Tribunal de Trabajo n° 3 Campana', 'Guemes 875 - Campana', 'Laboral'),
(4, 'Juzgado Civil y Comercial n° 1', 'Guemes 1112 - Campana', 'CyC'),
(5, 'Juzgado Civil y Comercial n° 2', 'Mitre 755 - Zárate', 'CyC'),
(6, 'Juzgado Civil y Comercial n° 3', 'Guemes 1112 - Campana', 'CyC'),
(7, 'Juzgado Civil y Comercial n° 4', 'Mitre 755 - Zárate', 'CyC'),
(8, 'Comisión Médica SRT', 'Romulo Noya 1049 - Zárate', 'Laboral'),
(9, 'Contencioso Administrativo n° 1 Zárate - Campana', 'Guemes 1056 - Campana', 'Contencioso'),
(10, 'Camara de Apelacion en lo Civil y Comercial - Zárate Campana', 'Avenida Intendente Jorge R. Varela Nro: 552', 'CyC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Objeto`
--

CREATE TABLE `Objeto` (
  `ID` int(11) NOT NULL,
  `Descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Objeto`
--

INSERT INTO `Objeto` (`ID`, `Descripcion`) VALUES
(1, 'DESPIDO'),
(2, 'ENFERMEDAD PROFESIONAL'),
(3, 'COMISIÓN MÉDICA'),
(4, 'CONSIGNACION'),
(5, 'ACCIDENTE DE TRABAJO - ACCION ESPECIAL'),
(6, 'DAÑOS Y PERJ. AUTOM'),
(7, 'PRETENSION ANULATORIA'),
(8, 'QUIEBRA'),
(9, 'COBRO EJECUTIVO DE ALQUILERES'),
(10, 'DESALOJO'),
(11, 'DESPIDO POR EMBARAZADO'),
(12, 'USUCAPION'),
(13, 'SUCESION AB INTESTATO'),
(14, 'INCAPACIDAD ABSOLUTA (ART. 212 L.C.T.)'),
(15, 'PRETENSION RESTABLECIMIENTO O RECONOC. DE DERECHOS'),
(16, 'HOMOLOGACION DE CONVENIO'),
(17, 'DAÑOS Y PERJ. INCUMP. CONTRACTUAL'),
(18, 'BENEFICIO DE LITIGAR SIN GASTOS '),
(19, 'COBRO EJECUTIVO '),
(20, 'INTERDICTO DE RECOBRAR '),
(21, 'ESCRITURACION '),
(22, 'CONCURSO PREVENTIVO(PEQUEÑO) '),
(23, 'PRESCRIPCION ADQUISITIVA LARGA'),
(24, 'AMPARO POR MORA'),
(25, 'APREMIO PROVINCIAL -'),
(26, 'MEDIDA CAUTELAR AUTONOMA O ANTICIPADA -'),
(27, 'PRETENSIÓN RESTABLECIMIENTO O RECONOC. DE DERECHOS - EMPLEO PÚBLICO -'),
(28, 'HOMOLOGACION MEDIACION LEY 13.951'),
(29, 'AMPARO '),
(30, 'DILIGENCIA PRELIMINAR -'),
(31, 'DIVORCIO POR PRESENTACION CONJUNTA'),
(32, 'DAÑOS Y PERJUICIOS -'),
(33, 'ACCIDENTE IN-ITINERE -'),
(34, 'APELACION DE RESOLUCION ADMINISTRATIVA -'),
(35, 'MATERIA A CATEGORIZAR - EMPL.PÚBLICO'),
(36, 'ALIMENTOS'),
(37, 'MULTA TRANSITO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Peritos`
--

CREATE TABLE `Peritos` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Especialidad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Peritos`
--

INSERT INTO `Peritos` (`ID`, `Nombre`, `Especialidad`) VALUES
(1, 'moreno', 'perito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Seguimiento`
--

CREATE TABLE `Seguimiento` (
  `ID` int(11) NOT NULL,
  `Causa_ID` int(11) NOT NULL,
  `Detalle` text NOT NULL,
  `Estado_ID` int(11) NOT NULL,
  `Fecha_Movimiento` date DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Seguimiento`
--

INSERT INTO `Seguimiento` (`ID`, `Causa_ID`, `Detalle`, `Estado_ID`, `Fecha_Movimiento`, `Timestamp`) VALUES
(1, 1, 'prueba 01', 1, '2025-01-01', '2025-01-14 12:03:42'),
(2, 1, 'prueba 02 ', 2, '2025-01-02', '2025-01-14 12:03:56'),
(3, 1, 'prueba 03 - prueba ', 13, '2025-01-06', '2025-01-14 12:05:04'),
(4, 1, 'llamamos al cliente para decirle que es un marmota', 2, '2025-01-07', '2025-01-14 12:05:27'),
(5, 1, 'Hola como estas', 1, '2025-01-15', '2025-01-14 15:08:44'),
(6, 1, 'Prueba 4', 3, '2025-01-14', '2025-01-14 15:09:12'),
(7, 1, 'Prueba 05', 1, '2025-01-14', '2025-01-14 15:25:12'),
(8, 1, 'Test 01', 2, '2025-01-08', '2025-01-14 15:26:23'),
(9, 2, 'Prueba de hora del server', 12, '2025-01-11', '2025-01-14 15:29:41'),
(10, 3, 'lo vio el juez', 1, '2025-01-14', '2025-01-14 18:28:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `DNI` varchar(20) NOT NULL,
  `Nombre_Usuario` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Rol` enum('Administrador','Abogado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Causas`
--
ALTER TABLE `Causas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Cliente_DNI` (`Cliente_DNI`),
  ADD KEY `Juzgado_ID` (`Juzgado_ID`),
  ADD KEY `Objeto_ID` (`Objeto_ID`),
  ADD KEY `Perito_ID` (`Perito_ID`),
  ADD KEY `Usuario_DNI` (`Usuario_DNI`);

--
-- Indices de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  ADD PRIMARY KEY (`DNI`);

--
-- Indices de la tabla `Estados`
--
ALTER TABLE `Estados`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Juzgados`
--
ALTER TABLE `Juzgados`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Objeto`
--
ALTER TABLE `Objeto`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Peritos`
--
ALTER TABLE `Peritos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Seguimiento`
--
ALTER TABLE `Seguimiento`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Causa_ID` (`Causa_ID`),
  ADD KEY `Estado_ID` (`Estado_ID`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`DNI`),
  ADD UNIQUE KEY `Nombre_Usuario` (`Nombre_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Causas`
--
ALTER TABLE `Causas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Estados`
--
ALTER TABLE `Estados`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `Juzgados`
--
ALTER TABLE `Juzgados`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `Objeto`
--
ALTER TABLE `Objeto`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `Peritos`
--
ALTER TABLE `Peritos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `Seguimiento`
--
ALTER TABLE `Seguimiento`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Causas`
--
ALTER TABLE `Causas`
  ADD CONSTRAINT `Causas_ibfk_1` FOREIGN KEY (`Cliente_DNI`) REFERENCES `Clientes` (`DNI`),
  ADD CONSTRAINT `Causas_ibfk_2` FOREIGN KEY (`Juzgado_ID`) REFERENCES `Juzgados` (`ID`),
  ADD CONSTRAINT `Causas_ibfk_3` FOREIGN KEY (`Objeto_ID`) REFERENCES `Objeto` (`ID`),
  ADD CONSTRAINT `Causas_ibfk_4` FOREIGN KEY (`Perito_ID`) REFERENCES `Peritos` (`ID`),
  ADD CONSTRAINT `Causas_ibfk_5` FOREIGN KEY (`Usuario_DNI`) REFERENCES `Usuarios` (`DNI`);

--
-- Filtros para la tabla `Seguimiento`
--
ALTER TABLE `Seguimiento`
  ADD CONSTRAINT `Seguimiento_ibfk_1` FOREIGN KEY (`Causa_ID`) REFERENCES `Causas` (`ID`),
  ADD CONSTRAINT `Seguimiento_ibfk_2` FOREIGN KEY (`Estado_ID`) REFERENCES `Estados` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
