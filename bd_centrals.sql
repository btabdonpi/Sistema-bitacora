-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-08-2024 a las 14:54:07
-- Versión del servidor: 10.5.20-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id22230899_bd_centrals`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`id22230899_equipo1`@`%` PROCEDURE `BorrarProyecto` (IN `p_ProyectoID` INT, IN `p_PersonalID` INT)   BEGIN
    DECLARE v_NombreProyecto VARCHAR(100);
    
    -- Obtener el nombre del proyecto antes de borrarlo
    SELECT Nombre INTO v_NombreProyecto FROM proyectos WHERE ProyectoID = p_ProyectoID;
    
    -- Borrar todas las tareas asociadas al proyecto
    DELETE FROM Tareas WHERE ProyectoID = p_ProyectoID;
    
    -- Borrar el proyecto
    DELETE FROM proyectos WHERE ProyectoID = p_ProyectoID;
    
    -- Insertar registro en la tabla bitacora
    INSERT INTO bitacora (PersonalID, RolID, fecha, TareaID, ProyectoID, Actividad)
    VALUES (p_PersonalID, 1, NOW(), 0, 0, CONCAT('Se ha borrado el proyecto ', v_NombreProyecto));
END$$

CREATE DEFINER=`id22230899_equipo1`@`%` PROCEDURE `BorrarTarea` (IN `p_TareaID` INT, IN `p_PersonalID` INT)   BEGIN
    DECLARE v_DescripcionTarea VARCHAR(100);
    DECLARE v_ProyectoID INT;
    
    -- Obtener la descripción de la tarea y el ProyectoID antes de borrarla
    SELECT Descripcion, ProyectoID INTO v_DescripcionTarea, v_ProyectoID FROM Tareas WHERE TareaID = p_TareaID;
    
    -- Borrar la tarea
    DELETE FROM Tareas WHERE TareaID = p_TareaID;
    
    -- Insertar registro en la tabla bitacora
    INSERT INTO bitacora (PersonalID, RolID, fecha, TareaID, ProyectoID, Actividad)
    VALUES (p_PersonalID, 1, NOW(), 0, v_ProyectoID, CONCAT('Se ha borrado una tarea: ', v_DescripcionTarea));
END$$

CREATE DEFINER=`id22230899_equipo1`@`%` PROCEDURE `CrearNuevoProyecto` (IN `p_Nombre` VARCHAR(100), IN `p_Descripcion` TEXT, IN `p_Tipo` VARCHAR(30), IN `p_FechaInicio` DATE, IN `p_FechaFin` DATE, IN `p_EstatusP` VARCHAR(30), IN `p_PersonalID` VARCHAR(5))   BEGIN
    DECLARE v_ProyectoID INT;

    -- Verificar si el nombre del proyecto ya existe
    IF EXISTS (SELECT 1 FROM proyectos WHERE Nombre = p_Nombre) THEN
        SELECT 0 AS 'INSERTADO';  -- El nombre del proyecto ya existe
    ELSE
        -- Insertar nuevo proyecto en la tabla proyectos
        INSERT INTO proyectos (Nombre, Descripcion, Tipo, FechaInicio, FechaFin, EstatusP)
        VALUES (p_Nombre, p_Descripcion, p_Tipo, p_FechaInicio, p_FechaFin, p_EstatusP);
        
        -- Obtener el ID del proyecto recién creado
        SET v_ProyectoID = LAST_INSERT_ID();
        
        if p_PersonalID=1 THEN
        	-- Insertar registro en la tabla bitacora
            INSERT INTO bitacora (PersonalID, RolID, fecha, TareaID, ProyectoID, Actividad)
            VALUES (1, 1, NOW(), 0, 0, 9);
        end if;
        if p_PersonalID=9 THEN
        	-- Insertar registro en la tabla bitacora
            INSERT INTO bitacora (PersonalID, RolID, fecha, TareaID, ProyectoID, Actividad)
            VALUES (9, 1, NOW(), 0, 0, 9);
        end if;
        
        SELECT 2 AS 'INSERTADO';  -- El proyecto se insertó correctamente
    END IF;
END$$

CREATE DEFINER=`id22230899_equipo1`@`%` PROCEDURE `EstatusProyecto` (IN `p_ProyectoID` INT, IN `p_PersonalID` INT)   BEGIN
    DECLARE v_NombreProyecto VARCHAR(255);

    -- Obtener el nombre del proyecto
    SELECT Nombre INTO v_NombreProyecto
    FROM proyectos
    WHERE ProyectoID = p_ProyectoID;

    -- Actualizar el estatus del proyecto
    UPDATE proyectos
    SET EstatusP = 'Terminado'
    WHERE ProyectoID = p_ProyectoID;

    -- Insertar registro en la tabla bitacora
    INSERT INTO bitacora (PersonalID, RolID, fecha, TareaID, ProyectoID, Actividad)
    VALUES (p_PersonalID, 1, NOW(), 0, 0, CONCAT(v_NombreProyecto, ' actualizado a terminado'));
END$$

CREATE DEFINER=`id22230899_equipo1`@`%` PROCEDURE `FiltrarBitacora` (IN `p_TipoFiltro` VARCHAR(50), IN `p_ValorFiltro` VARCHAR(100))   BEGIN
    IF p_TipoFiltro = 'personal' THEN
        SELECT
            b.BitacoraID AS bID,
            (SELECT p.Nombre FROM personal p WHERE p.PersonalID = b.PersonalID) AS personal,
            (SELECT r.Nombre FROM roles r WHERE r.RolID = b.RolID) AS rol,
            b.fecha AS fecha,
            IF(b.TareaID = 0, 'No aplica', (SELECT t.Descripcion FROM Tareas t WHERE t.TareaID = b.TareaID)) AS tarea,
            IF(b.ProyectoID = 0, 'No aplica', (SELECT pr.Nombre FROM proyectos pr WHERE pr.ProyectoID = b.ProyectoID)) AS proyecto,
            (SELECT act.NomAct FROM Actividades act WHERE b.Actividad = act.ActID) AS actividad
        FROM
            bitacora b
        WHERE
            b.PersonalID = p_ValorFiltro
        UNION ALL
        SELECT
            0 AS bID,
            NULL AS personal,
            NULL AS rol,
            NULL AS fecha,
            NULL AS tarea,
            NULL AS proyecto,
            NULL AS actividad
        WHERE
            NOT EXISTS (
                SELECT 1
                FROM bitacora b
                WHERE b.PersonalID = p_ValorFiltro
            );

    ELSEIF p_TipoFiltro = 'fecha' THEN
        SELECT
            b.BitacoraID AS bID,
            (SELECT p.Nombre FROM personal p WHERE p.PersonalID = b.PersonalID) AS personal,
            (SELECT r.Nombre FROM roles r WHERE r.RolID = b.RolID) AS rol,
            b.fecha AS fecha,
            IF(b.TareaID = 0, 'No aplica', (SELECT t.Descripcion FROM Tareas t WHERE t.TareaID = b.TareaID)) AS tarea,
            IF(b.ProyectoID = 0, 'No aplica', (SELECT pr.Nombre FROM proyectos pr WHERE pr.ProyectoID = b.ProyectoID)) AS proyecto,
            (SELECT act.NomAct FROM Actividades act WHERE b.Actividad = act.ActID) AS actividad
        FROM
            bitacora b
        WHERE
            b.fecha = p_ValorFiltro
        UNION ALL
        SELECT
            0 AS bID,
            NULL AS personal,
            NULL AS rol,
            NULL AS fecha,
            NULL AS tarea,
            NULL AS proyecto,
            NULL AS actividad
        WHERE
            NOT EXISTS (
                SELECT 1
                FROM bitacora b
                WHERE b.fecha = p_ValorFiltro
            );

    ELSEIF p_TipoFiltro = 'tarea' THEN
        SELECT
            b.BitacoraID AS bID,
            (SELECT p.Nombre FROM personal p WHERE p.PersonalID = b.PersonalID) AS personal,
            (SELECT r.Nombre FROM roles r WHERE r.RolID = b.RolID) AS rol,
            b.fecha AS fecha,
            IF(b.TareaID = 0, 'No aplica', (SELECT t.Descripcion FROM Tareas t WHERE t.TareaID = b.TareaID)) AS tarea,
            IF(b.ProyectoID = 0, 'No aplica', (SELECT pr.Nombre FROM proyectos pr WHERE pr.ProyectoID = b.ProyectoID)) AS proyecto,
            (SELECT act.NomAct FROM Actividades act WHERE b.Actividad = act.ActID) AS actividad
        FROM
            bitacora b
        WHERE
            b.TareaID = p_ValorFiltro
        UNION ALL
        SELECT
            0 AS bID,
            NULL AS personal,
            NULL AS rol,
            NULL AS fecha,
            NULL AS tarea,
            NULL AS proyecto,
            NULL AS actividad
        WHERE
            NOT EXISTS (
                SELECT 1
                FROM bitacora b
                WHERE b.TareaID = p_ValorFiltro
            );

    ELSEIF p_TipoFiltro = 'actividad' THEN
        SELECT
            b.BitacoraID AS bID,
            (SELECT p.Nombre FROM personal p WHERE p.PersonalID = b.PersonalID) AS personal,
            (SELECT r.Nombre FROM roles r WHERE r.RolID = b.RolID) AS rol,
            b.fecha AS fecha,
            IF(b.TareaID = 0, 'No aplica', (SELECT t.Descripcion FROM Tareas t WHERE t.TareaID = b.TareaID)) AS tarea,
            IF(b.ProyectoID = 0, 'No aplica', (SELECT pr.Nombre FROM proyectos pr WHERE pr.ProyectoID = b.ProyectoID)) AS proyecto,
            (SELECT act.NomAct FROM Actividades act WHERE b.Actividad = act.ActID) AS actividad
        FROM
            bitacora b
        WHERE
            b.Actividad = p_ValorFiltro
        UNION ALL
        SELECT
            0 AS bID,
            NULL AS personal,
            NULL AS rol,
            NULL AS fecha,
            NULL AS tarea,
            NULL AS proyecto,
            NULL AS actividad
        WHERE
            NOT EXISTS (
                SELECT 1
                FROM bitacora b
                WHERE b.Actividad = p_ValorFiltro
            );

    ELSEIF p_TipoFiltro = 'proyecto' THEN
        SELECT
            b.BitacoraID AS bID,
            (SELECT p.Nombre FROM personal p WHERE p.PersonalID = b.PersonalID) AS personal,
            (SELECT r.Nombre FROM roles r WHERE r.RolID = b.RolID) AS rol,
            b.fecha AS fecha,
            IF(b.TareaID = 0, 'No aplica', (SELECT t.Descripcion FROM Tareas t WHERE t.TareaID = b.TareaID)) AS tarea,
            IF(b.ProyectoID = 0, 'No aplica', (SELECT pr.Nombre FROM proyectos pr WHERE pr.ProyectoID = b.ProyectoID)) AS proyecto,
            (SELECT act.NomAct FROM Actividades act WHERE b.Actividad = act.ActID) AS actividad
        FROM
            bitacora b
        WHERE
            b.ProyectoID = p_ValorFiltro
        UNION ALL
        SELECT
            0 AS bID,
            NULL AS personal,
            NULL AS rol,
            NULL AS fecha,
            NULL AS tarea,
            NULL AS proyecto,
            NULL AS actividad
        WHERE
            NOT EXISTS (
                SELECT 1
                FROM bitacora b
                WHERE b.ProyectoID = p_ValorFiltro
            );

    ELSEIF p_TipoFiltro = 'proceso' THEN
        SELECT
            b.BitacoraID AS bID,
            (SELECT p.Nombre FROM personal p WHERE p.PersonalID = b.PersonalID) AS personal,
            (SELECT r.Nombre FROM roles r WHERE r.RolID = b.RolID) AS rol,
            b.fecha AS fecha,
            IF(b.TareaID = 0, 'No aplica', (SELECT t.Descripcion FROM Tareas t WHERE t.TareaID = b.TareaID)) AS tarea,
            IF(b.ProyectoID = 0, 'No aplica', (SELECT pr.Nombre FROM proyectos pr WHERE pr.ProyectoID = b.ProyectoID)) AS proyecto,
            (SELECT act.NomAct FROM Actividades act WHERE b.Actividad = act.ActID) AS actividad
        FROM
            bitacora b
        WHERE
            b.ProcesoID = p_ValorFiltro
        UNION ALL
        SELECT
            0 AS bID,
            NULL AS personal,
            NULL AS rol,
            NULL AS fecha,
            NULL AS tarea,
            NULL AS proyecto,
            NULL AS actividad
        WHERE
            NOT EXISTS (
                SELECT 1
                FROM bitacora b
                WHERE b.ProcesoID = p_ValorFiltro
            );

    ELSEIF p_TipoFiltro = 'rol' THEN
        SELECT
            b.BitacoraID AS bID,
            (SELECT p.Nombre FROM personal p WHERE p.PersonalID = b.PersonalID) AS personal,
            (SELECT r.Nombre FROM roles r WHERE r.RolID = b.RolID) AS rol,
            b.fecha AS fecha,
            IF(b.TareaID = 0, 'No aplica', (SELECT t.Descripcion FROM Tareas t WHERE t.TareaID = b.TareaID)) AS tarea,
            IF(b.ProyectoID = 0, 'No aplica', (SELECT pr.Nombre FROM proyectos pr WHERE pr.ProyectoID = b.ProyectoID)) AS proyecto,
            (SELECT act.NomAct FROM Actividades act WHERE b.Actividad = act.ActID) AS actividad
        FROM
            bitacora b
        WHERE
            b.RolID = p_ValorFiltro
        UNION ALL
        SELECT
            0 AS bID,
            NULL AS personal,
            NULL AS rol,
            NULL AS fecha,
            NULL AS tarea,
            NULL AS proyecto,
            NULL AS actividad
        WHERE
            NOT EXISTS (
                SELECT 1
                FROM bitacora b
                WHERE b.RolID = p_ValorFiltro
            );

    ELSEIF p_TipoFiltro = 'todos' THEN
        SELECT
            b.BitacoraID AS bID,
            (SELECT p.Nombre FROM personal p WHERE p.PersonalID = b.PersonalID) AS personal,
            (SELECT r.Nombre FROM roles r WHERE r.RolID = b.RolID) AS rol,
            b.fecha AS fecha,
            IF(b.TareaID = 0, 'No aplica', (SELECT t.Descripcion FROM Tareas t WHERE t.TareaID = b.TareaID)) AS tarea,
            IF(b.ProyectoID = 0, 'No aplica', (SELECT pr.Nombre FROM proyectos pr WHERE pr.ProyectoID = b.ProyectoID)) AS proyecto,
            (SELECT act.NomAct FROM Actividades act WHERE b.Actividad = act.ActID) AS actividad
        FROM
            bitacora b
        UNION ALL
        SELECT
            0 AS bID,
            NULL AS personal,
            NULL AS rol,
            NULL AS fecha,
            NULL AS tarea,
            NULL AS proyecto,
            NULL AS actividad
        WHERE
            NOT EXISTS (
                SELECT 1
                FROM bitacora b
            );
    END IF;
END$$

CREATE DEFINER=`id22230899_equipo1`@`%` PROCEDURE `MostrarBitacora` ()   BEGIN
    SELECT
        b.BitacoraID AS bID,
        (SELECT p.Nombre FROM personal p WHERE p.PersonalID = b.PersonalID) AS personal,
        (SELECT r.Nombre FROM roles r WHERE r.RolID = b.RolID) AS rol,
        b.fecha AS fecha,
        
        IF(b.TareaID = 0, 'No aplica', (SELECT t.Descripcion FROM Tareas t WHERE t.TareaID = b.TareaID)) AS tarea,
        IF(b.ProyectoID = 0, 'No aplica', (SELECT pr.Nombre FROM proyectos pr WHERE pr.ProyectoID = b.ProyectoID)) AS proyecto,
        (select act.NomAct from Actividades act WHERE b.Actividad=act.ActID ) as actividad
        
    FROM
        bitacora b;
END$$

CREATE DEFINER=`id22230899_equipo1`@`%` PROCEDURE `RegistrarActividad` (IN `p_ActividadID` INT, IN `p_PersonalID` INT)   BEGIN
    DECLARE v_TareaID INT;
    DECLARE v_ProyectoID INT;
    DECLARE v_Actividad VARCHAR(255);
    DECLARE v_RolID INT;
    
    -- Obtener el ID de la tarea y el proyecto asociado al personal
    SELECT TareaID, ProyectoID INTO v_TareaID, v_ProyectoID 
    FROM Tareas 
    WHERE PersonalID = p_PersonalID
    LIMIT 1;  -- Asumimos que un personal está asociado con una única tarea para simplificar
    
    -- Obtener el RolID del personal
    SELECT RolID INTO v_RolID
    FROM personal
    WHERE PersonalID = p_PersonalID;
    
    -- Determinar el texto a concatenar basado en el número identificador de actividad
    CASE p_ActividadID
        WHEN 1 THEN SET v_Actividad = 1;
        WHEN 2 THEN SET v_Actividad = 2;
        WHEN 3 THEN SET v_Actividad = 3;
        WHEN 4 THEN SET v_Actividad = 4;
        WHEN 5 THEN SET v_Actividad = 5;
        WHEN 6 THEN SET v_Actividad = 6;
        WHEN 7 THEN SET v_Actividad = 7;
        WHEN 8 THEN SET v_Actividad = 8;
        WHEN 9 THEN SET v_Actividad = 9;
        WHEN 10 THEN SET v_Actividad = 10;
        WHEN 11 THEN SET v_Actividad = 11;
        WHEN 12 THEN SET v_Actividad = 12;
        WHEN 13 THEN SET v_Actividad = 13;
        WHEN 14 THEN SET v_Actividad = 14;
        WHEN 15 THEN SET v_Actividad = 15;
        WHEN 16 THEN SET v_Actividad = 16;
        ELSE SET v_Actividad = 17;
    END CASE;
    IF p_PersonalID = 1 or p_PersonalID = 9 THEN
    -- Insertar registro en la tabla bitacora
    INSERT INTO bitacora (PersonalID, RolID, fecha, TareaID, ProyectoID, Actividad)
    VALUES (p_PersonalID, v_RolID, NOW(), 'No Aplica', 'No Aplica', v_Actividad);
    ELSE
    INSERT INTO bitacora (PersonalID, RolID, fecha, TareaID, ProyectoID, Actividad)
    VALUES (p_PersonalID, v_RolID, NOW(), v_TareaID, v_ProyectoID, v_Actividad);
    END IF;
END$$

CREATE DEFINER=`id22230899_equipo1`@`%` PROCEDURE `RegistrarNuevaTarea` (IN `p_ProyectoID` INT, IN `p_RecursoID` INT, IN `p_PersonalID` INT, IN `p_Descripcion` VARCHAR(100), IN `p_PersonalIDAccion` INT, IN `p_RolIDAccion` INT)   BEGIN
    DECLARE v_TareaID INT;
    DECLARE v_NombreProyecto VARCHAR(100);
    DECLARE v_Estatus INT;

    SELECT Estatus INTO v_Estatus FROM personal WHERE PersonalID = p_PersonalID;
    
    IF v_Estatus != 0 THEN
        SELECT Nombre INTO v_NombreProyecto FROM proyectos WHERE ProyectoID = p_ProyectoID;
        
        INSERT INTO Tareas (ProyectoID, RecursoID, PersonalID, Descripcion)
        VALUES (p_ProyectoID, p_RecursoID, p_PersonalID, p_Descripcion);
        
        SET v_TareaID = LAST_INSERT_ID();
        
        UPDATE personal SET Estatus = 0 WHERE PersonalID = p_PersonalID;
        
        INSERT INTO bitacora (PersonalID, RolID, fecha, TareaID, ProyectoID, Actividad)
        VALUES (p_PersonalIDAccion, p_RolIDAccion, NOW(), v_TareaID, p_ProyectoID, CONCAT('Creacion de tarea para: ', v_NombreProyecto));
        
        SELECT 1 AS resultado;
    ELSE
        SELECT 0 AS resultado;
    END IF;
END$$

CREATE DEFINER=`id22230899_equipo1`@`%` PROCEDURE `spInBitacora` (IN `usuario` INT, IN `fecha` DATE, IN `tarea` INT, IN `proyecto` INT, IN `actividad` VARCHAR(250))   BEGIN
    IF EXISTS (SELECT p.PersonalID FROM personal p WHERE p.PersonalID = usuario) THEN
        IF EXISTS (SELECT t.TareaID FROM Tareas t WHERE t.TareaID = tarea AND t.PersonalID = usuario) THEN
            IF EXISTS (SELECT pro.ProyectoID FROM proyectos pro WHERE pro.ProyectoID = proyecto) THEN
                IF EXISTS (SELECT ac.ActID FROM Actividades ac WHERE ac.ActID = actividad) THEN
                    BEGIN
                        INSERT INTO bitacora VALUES (NULL, usuario, (SELECT personal.RolID FROM personal WHERE personal.PersonalID = usuario), fecha, tarea, proyecto, actividad);
                        SELECT 2 AS 'INSERTADO';
                    END;
                ELSE
                    SELECT 1 AS 'INSERTADO';
                END IF;
            ELSE
                SELECT 0 AS 'INSERTADO';
            END IF;
        ELSE
            SELECT 0 AS 'INSERTADO';
        END IF;
    ELSE
        SELECT 0 AS 'INSERTADO';
    END IF;
END$$

CREATE DEFINER=`id22230899_equipo1`@`%` PROCEDURE `spValidarAcceso` (IN `usuario` VARCHAR(50), IN `contra` VARCHAR(25))   BEGIN
IF EXISTS (SELECT UsuarioID FROM usuarios WHERE Email=usuario AND Contra=contra AND Es=1) THEN
BEGIN
SELECT A.UsuarioID AS CLAVE, CONCAT(A.Nombre, ' ', A.ApellidoPaterno, ' ', A.ApellidoMaterno) AS USUARIO, B.Nombre AS ROL
        FROM usuarios A, roles B
        WHERE A.Email=usuario
        AND A.Contra=contra
        AND A.RolID=B.RolID;
        INSERT INTO bitacora (PersonalID, RolID, fecha, TareaID, ProyectoID, Actividad)
    	VALUES ((SELECT A.UsuarioID from usuarios A, roles B WHERE A.Email=usuario and A.Contra=contra and A.RolID=B.RolID), 1, NOW(), 0, 0, 25);
END;
ELSE
	SELECT 0 AS CLAVE;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Actividades`
--

CREATE TABLE `Actividades` (
  `ActID` int(11) NOT NULL,
  `NomAct` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Actividades`
--

INSERT INTO `Actividades` (`ActID`, `NomAct`) VALUES
(1, 'Herramienta en uso: Godot 3.4.4'),
(2, 'Herramienta en uso: Python con Pygame'),
(3, 'Herramienta en uso: Visual Studio Code'),
(4, 'Herramienta en uso: Sublime Text'),
(5, 'Herramienta en uso: Visual Studio .Net'),
(6, 'Herramienta en uso: MySQL Server'),
(7, 'Herramienta en uso: Adobe Premiere'),
(8, 'Herramienta en uso: Adobe Animate'),
(9, 'Creación de Proyecto'),
(10, 'Modificación De Proyecto'),
(11, 'Borrado de Proyecto'),
(12, 'Creación de Tarea'),
(13, 'Modificación de Tarea'),
(14, 'Borrado de Tarea'),
(15, 'Asignación de Recursos'),
(16, 'Asignación de personal'),
(25, 'Inicio de sesión');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `BitacoraID` int(11) NOT NULL,
  `PersonalID` int(11) NOT NULL,
  `RolID` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `TareaID` varchar(200) DEFAULT NULL,
  `ProyectoID` varchar(200) DEFAULT NULL,
  `Actividad` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`BitacoraID`, `PersonalID`, `RolID`, `fecha`, `TareaID`, `ProyectoID`, `Actividad`) VALUES
(163, 3, 2, '2024-07-21', '10', '25', '3'),
(164, 3, 2, '2024-07-21', '10', '25', '7'),
(165, 4, 2, '2024-07-21', '11', '26', '3'),
(166, 4, 2, '2024-07-21', '11', '26', '7'),
(167, 6, 3, '2024-07-21', '13', '27', '3'),
(168, 3, 2, '2024-07-21', '10', '25', '3'),
(169, 6, 3, '2024-07-21', '13', '27', '7'),
(170, 6, 3, '2024-07-21', '13', '27', '8'),
(171, 7, 3, '2024-07-21', '14', '27', '5'),
(174, 5, 2, '2024-07-28', '12', '27', '1'),
(175, 6, 3, '2024-07-28', '13', '27', '1'),
(176, 6, 3, '2024-07-28', '13', '27', '1'),
(186, 3, 2, '2024-07-28', '10', '25', '2'),
(194, 3, 2, '2024-05-06', '14', '25', '4'),
(197, 2, 2, '2024-05-05', '10', '25', '2'),
(198, 3, 2, '2024-05-06', '14', '25', '4'),
(201, 2, 2, '2024-05-05', '10', '25', '2'),
(202, 3, 2, '2024-05-06', '14', '25', '4'),
(205, 2, 2, '2024-05-05', '10', '25', '2'),
(206, 3, 2, '2024-05-06', '14', '25', '4'),
(209, 2, 2, '2024-05-05', '10', '25', '2'),
(210, 3, 2, '2024-05-06', '14', '25', '4'),
(213, 2, 2, '2024-05-05', '10', '25', '2'),
(214, 3, 2, '2024-05-06', '14', '25', '4'),
(217, 2, 2, '2024-05-05', '10', '25', '2'),
(218, 3, 2, '2024-05-06', '14', '25', '4'),
(221, 2, 2, '2024-05-05', '10', '25', '2'),
(222, 3, 2, '2024-05-06', '14', '25', '4'),
(225, 2, 2, '2024-05-05', '10', '25', '2'),
(226, 3, 2, '2024-05-06', '14', '25', '4'),
(229, 2, 2, '2024-05-05', '10', '25', '2'),
(230, 3, 2, '2024-05-06', '14', '25', '4'),
(237, 3, 2, '2024-05-05', '10', '25', '1'),
(239, 3, 2, '2024-05-05', '10', '25', '1'),
(247, 3, 2, '2024-08-01', '10', '25', '5'),
(248, 3, 2, '2024-08-01', '10', '25', '5'),
(249, 3, 2, '2024-08-01', '10', '25', '5'),
(252, 3, 2, '2024-08-01', '10', '25', '5'),
(253, 3, 2, '2024-08-01', '10', '25', '5'),
(254, 3, 2, '2024-08-01', '10', '25', '5'),
(265, 7, 3, '2024-08-03', '14', '27', '7'),
(266, 7, 3, '2024-08-03', '14', '27', '1'),
(268, 2, 2, '2024-05-05', '10', '25', '2'),
(269, 2, 2, '2024-05-05', '10', '25', '2'),
(270, 2, 2, '2024-05-05', '10', '25', '2'),
(271, 2, 2, '2024-05-05', '10', '25', '2'),
(272, 2, 2, '2024-05-05', '10', '25', '2'),
(273, 2, 2, '2024-05-05', '10', '25', '2'),
(274, 2, 2, '2024-05-05', '10', '25', '2'),
(275, 2, 2, '2024-05-05', '10', '25', '2'),
(276, 2, 2, '2024-05-05', '10', '25', '2'),
(277, 2, 2, '2024-05-05', '10', '25', '2'),
(282, 2, 2, '2024-05-05', '10', '25', '2'),
(288, 2, 2, '2024-05-05', '10', '25', '2'),
(291, 8, 2, '2024-08-05', '17', '25', '3'),
(307, 2, 2, '2024-08-05', '10', '25', '1'),
(308, 2, 2, '2024-08-05', '10', '25', '2'),
(309, 2, 2, '2024-08-05', '10', '25', '3'),
(310, 2, 2, '2024-08-05', '10', '25', '4'),
(311, 2, 2, '2024-08-05', '10', '25', '5'),
(312, 2, 2, '2024-08-05', '10', '25', '6'),
(313, 2, 2, '2024-08-05', '10', '25', '7'),
(314, 2, 2, '2024-08-05', '10', '25', '8'),
(315, 6, 3, '2024-08-05', '13', '27', '1'),
(316, 5, 2, '2024-08-05', '12', '26', '2'),
(317, 6, 3, '2024-08-05', '13', '27', '1'),
(318, 6, 3, '2024-08-05', '13', '27', '2'),
(319, 6, 3, '2024-08-05', '13', '27', '3'),
(320, 6, 3, '2024-08-05', '13', '27', '4'),
(321, 6, 3, '2024-08-05', '13', '27', '5'),
(322, 6, 3, '2024-08-05', '13', '27', '6'),
(323, 6, 3, '2024-08-05', '13', '27', '7'),
(324, 6, 3, '2024-08-05', '13', '27', '8'),
(329, 9, 1, '2024-08-05', 'No Aplica', 'No Aplica', '10'),
(353, 9, 1, '2024-08-05', '0', '0', '9'),
(354, 9, 1, '2024-08-05', '0', '0', '9'),
(355, 9, 1, '2024-08-05', '0', '0', '9'),
(356, 9, 1, '2024-08-05', '0', '0', '9'),
(359, 9, 1, '2024-08-05', '0', '0', '9'),
(360, 9, 1, '2024-08-05', '0', '0', '9'),
(361, 2, 2, '2024-05-05', '10', '25', '2'),
(362, 2, 2, '2024-05-05', '10', '25', '2'),
(363, 2, 2, '2024-08-07', '10', '25', '2'),
(364, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '1'),
(365, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '2'),
(366, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '14'),
(367, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '11'),
(368, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '10'),
(369, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '5'),
(370, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '7'),
(371, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '8'),
(372, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '13'),
(373, 9, 1, '2024-08-05', 'No Aplica', 'No Aplica', '14'),
(374, 9, 1, '2024-08-05', 'No Aplica', 'No Aplica', '11'),
(375, 9, 1, '2024-08-05', 'No Aplica', 'No Aplica', '1'),
(376, 9, 1, '2024-08-05', 'No Aplica', 'No Aplica', '2'),
(377, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '1'),
(378, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '1'),
(379, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '2'),
(380, 1, 1, '2024-08-05', 'No Aplica', 'No Aplica', '15'),
(381, 1, 1, '2024-08-06', 'No Aplica', 'No Aplica', '9'),
(382, 2, 2, '2024-08-06', '10', '25', '2'),
(383, 9, 1, '2024-08-06', 'No Aplica', 'No Aplica', '4'),
(384, 2, 2, '2024-08-07', '10', '25', '2'),
(385, 2, 2, '2024-08-07', '10', '25', '2'),
(386, 2, 2, '2024-08-11', '10', '25', '2'),
(387, 2, 2, '2024-08-11', '10', '25', '2'),
(388, 2, 2, '2024-08-11', '10', '25', '2'),
(389, 1, 1, '2024-08-06', 'No Aplica', 'No Aplica', '1'),
(390, 2, 2, '2024-08-06', '10', '25', '8'),
(391, 7, 3, '2024-08-06', '14', '27', '2'),
(392, 2, 2, '2024-08-11', '10', '25', '2'),
(393, 1, 1, '2024-08-06', '0', '0', '9'),
(394, 1, 1, '2024-08-06', '0', '0', '9'),
(395, 1, 1, '2024-08-06', 'No Aplica', 'No Aplica', '1'),
(396, 1, 1, '2024-08-06', 'No Aplica', 'No Aplica', '15'),
(397, 2, 2, '2024-08-06', '10', '25', '8'),
(398, 7, 3, '2024-08-06', '14', '27', '4'),
(399, 2, 2, '2024-08-11', '10', '25', '2'),
(400, 1, 1, '2024-08-06', '0', '0', '9'),
(401, 1, 1, '2024-08-06', '0', '0', '9'),
(402, 1, 1, '2024-08-06', '0', '0', '25'),
(403, 1, 1, '2024-08-06', '0', '0', '25'),
(404, 5, 2, '2024-08-06', '12', '26', '1'),
(405, 2, 2, '2024-08-06', '10', '25', '1'),
(406, 2, 2, '2024-08-06', '10', '25', '1'),
(407, 1, 1, '2024-08-06', 'No Aplica', 'No Aplica', '1'),
(408, 1, 1, '2024-08-06', 'No Aplica', 'No Aplica', '1'),
(409, 1, 1, '2024-08-06', 'No Aplica', 'No Aplica', '1'),
(410, 1, 1, '2024-08-06', 'No Aplica', 'No Aplica', '1'),
(411, 1, 1, '2024-08-06', '0', '0', '25'),
(412, 2, 2, '2024-08-11', '10', '25', '2'),
(413, 1, 1, '2024-08-06', '0', '0', '25'),
(414, 1, 1, '2024-08-06', '0', '0', '25'),
(415, 1, 1, '2024-08-06', '0', '0', '25'),
(416, 1, 1, '2024-08-06', '0', '0', '25'),
(417, 1, 1, '2024-08-06', '0', '0', '25'),
(418, 1, 1, '2024-08-06', '0', '0', '25'),
(419, 1, 1, '2024-08-06', '0', '0', '25'),
(420, 1, 1, '2024-08-06', '0', '0', '25'),
(421, 1, 1, '2024-08-06', '0', '0', '25'),
(422, 1, 1, '2024-08-06', '0', '0', '25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `PersonalID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `RolID` varchar(50) DEFAULT NULL,
  `Estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`PersonalID`, `Nombre`, `Email`, `RolID`, `Estatus`) VALUES
(1, 'Brandon Rubin Hernandez', 'barnddon@gmail.com', '1', 0),
(2, 'yair Garcia Ordoñez', 'yayo@gmail.com', '2', 0),
(3, 'Eduaro Nuñez', 'Yair@gmail', '2', 0),
(4, 'Carlos Juarez', 'carlos@gmal', '2', 0),
(5, 'Jose Juan ', 'juan@gmail', '2', 1),
(6, 'Naydelin Perez', 'nay@gmail.com', '3', 1),
(7, 'Jimena Jimenez', 'jim@gmail', '3', 1),
(8, 'Ignacio De la Cruz Osorio', 'oso@gmail.copm', '2', 1),
(9, 'Yair Ortega Garcia', 'yairortega93@gmail.com', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `ProyectoID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Tipo` varchar(30) DEFAULT NULL,
  `FechaInicio` date DEFAULT NULL,
  `FechaFin` date DEFAULT NULL,
  `EstatusP` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`ProyectoID`, `Nombre`, `Descripcion`, `Tipo`, `FechaInicio`, `FechaFin`, `EstatusP`) VALUES
(25, 'BD para Juego UPMH', 'Desarrolla proceimientos para el videojuego UPMH', 'Entretenimeinto', '2024-08-01', '2024-08-22', 'Activo'),
(26, 'Programacion de entronos', 'Programar las escenas creadas de los videojuegos', 'Transaccional', '2024-07-30', '2024-09-12', 'Activo'),
(27, 'Videojuego UPMH', 'Desarrollo del videojuego UPMH', 'Entretenimiento', '2024-07-10', '2024-07-28', 'Terminado'),
(80, 'proyecto az', 'Descripcion del b', 'Entretenimiento', '2024-05-05', '2024-05-05', 'Activo'),
(81, 'Proyecto A', 'ggg', 'Transaccional', '2024-05-05', '2024-05-05', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `RecursoID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Tipo` varchar(50) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `Estatus` varchar(30) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`RecursoID`, `Nombre`, `Tipo`, `Descripcion`, `Estatus`, `Cantidad`) VALUES
(1, 'Laptop HP', 'Diseñador', 'Diseñador Gráfico', 'Disponible', 1),
(2, 'Laptop Dell', 'Programador', 'Desarrollador Front-End', 'Disponible', 1),
(3, 'Cables de red', 'Programador', 'Desarrollador Back-End', 'Disponible', 1),
(4, 'Ipad', 'Diseñador', 'Diseñador UI/UX', 'Disponible', 1),
(5, 'Recurso Disco SSD', 'Programador', 'Ingeniero de Software', 'Disponible', 1),
(6, 'Stylus', 'Diseñador', 'Diseñador de Interacción', 'Disponible', 1),
(7, 'Licencia NET', 'Programador', 'Desarrollador Móvil', 'Disponible', 1),
(8, 'Servidor NAS', 'Programador', 'Especialista en DevOps', 'Disponible', 1),
(9, 'Adobe Animate', 'Diseñador', 'Ilustrador', 'Disponible', 1),
(10, 'Licencia Excel', 'Programador', 'Analista de Datos', 'Disponible', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso_tareas`
--

CREATE TABLE `recurso_tareas` (
  `idRecurso_tarea` int(11) NOT NULL,
  `RecursoID` int(11) NOT NULL,
  `TareaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `recurso_tareas`
--

INSERT INTO `recurso_tareas` (`idRecurso_tarea`, `RecursoID`, `TareaID`) VALUES
(1, 10, 17),
(2, 1, 11),
(3, 7, 14),
(4, 4, 12),
(5, 5, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `RolID` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`RolID`, `Nombre`) VALUES
(1, 'Administrador'),
(2, 'Programador'),
(3, 'Diseñador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tareas`
--

CREATE TABLE `Tareas` (
  `TareaID` int(11) NOT NULL,
  `ProyectoID` int(11) NOT NULL,
  `RecursoID` int(11) NOT NULL,
  `PersonalID` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Tareas`
--

INSERT INTO `Tareas` (`TareaID`, `ProyectoID`, `RecursoID`, `PersonalID`, `Descripcion`) VALUES
(10, 25, 4, 2, 'Crear SP RegistroVidas\r\n'),
(11, 26, 2, 4, 'Creación Escena Inicio'),
(12, 26, 3, 5, 'Creacion de Nodos Inciales'),
(13, 27, 3, 6, 'Definir requerimientos'),
(14, 27, 3, 7, 'Diseño de logo UPMH'),
(15, 27, 6, 2, 'Conexión base de datos'),
(16, 27, 7, 3, 'Crear SP Acceso \r\n'),
(17, 25, 8, 8, 'Aplicar SP creados en las escenas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `UsuarioID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `ApellidoPaterno` varchar(40) NOT NULL,
  `ApellidoMaterno` varchar(40) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Contra` varchar(256) NOT NULL,
  `RolID` int(11) DEFAULT NULL,
  `Es` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`UsuarioID`, `Nombre`, `ApellidoPaterno`, `ApellidoMaterno`, `Email`, `Contra`, `RolID`, `Es`) VALUES
(1, 'Brandon', 'Mora', 'Hernandez', 'bb@gmail.com', '12345678', 1, 1),
(9, 'Yair', 'Ortega', 'García', 'yairortega93@gmail.com', '123456', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Actividades`
--
ALTER TABLE `Actividades`
  ADD PRIMARY KEY (`ActID`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`BitacoraID`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`PersonalID`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`ProyectoID`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`RecursoID`);

--
-- Indices de la tabla `recurso_tareas`
--
ALTER TABLE `recurso_tareas`
  ADD PRIMARY KEY (`idRecurso_tarea`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RolID`);

--
-- Indices de la tabla `Tareas`
--
ALTER TABLE `Tareas`
  ADD PRIMARY KEY (`TareaID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`UsuarioID`),
  ADD KEY `RolID` (`RolID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Actividades`
--
ALTER TABLE `Actividades`
  MODIFY `ActID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `BitacoraID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=423;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `PersonalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `ProyectoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
  MODIFY `RecursoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `recurso_tareas`
--
ALTER TABLE `recurso_tareas`
  MODIFY `idRecurso_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `RolID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Tareas`
--
ALTER TABLE `Tareas`
  MODIFY `TareaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UsuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
