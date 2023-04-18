-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2022 at 09:07 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `acry_class_tb`
--

CREATE TABLE `acry_class_tb` (
  `acry_class_id` int(25) NOT NULL,
  `acry_class_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acry_class_tb`
--

INSERT INTO `acry_class_tb` (`acry_class_id`, `acry_class_name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D');

-- --------------------------------------------------------

--
-- Table structure for table `acry_color_tb`
--

CREATE TABLE `acry_color_tb` (
  `acry_color_id` int(250) NOT NULL,
  `acry_color_name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acry_color_tb`
--

INSERT INTO `acry_color_tb` (`acry_color_id`, `acry_color_name`) VALUES
(1, '104'),
(2, '107'),
(3, '116'),
(4, '128'),
(5, '158'),
(6, '202'),
(7, '266'),
(8, '268'),
(9, '303'),
(10, '315'),
(11, '332'),
(12, '335'),
(13, '393'),
(14, '403'),
(15, '407'),
(16, '447'),
(17, '467'),
(18, '473'),
(19, '501'),
(20, '502'),
(21, '505'),
(22, '507'),
(23, '524'),
(24, '527'),
(25, '529'),
(26, '531'),
(27, '535'),
(28, '612'),
(29, '622'),
(30, '627'),
(31, '667'),
(32, '701'),
(33, '737'),
(34, '777'),
(35, '801'),
(36, '802'),
(37, '816'),
(38, '830'),
(39, '881'),
(40, '902'),
(41, '914'),
(42, '1021'),
(43, '4111'),
(44, '4622'),
(45, '6133'),
(46, '6136'),
(47, '7706'),
(48, '7715'),
(49, '7859'),
(50, '7869'),
(51, '10539'),
(52, '11526'),
(53, '12805'),
(54, '13136'),
(55, '13502'),
(56, '13503'),
(57, '13528'),
(58, '14128'),
(59, '14667'),
(60, '14878'),
(61, '17332'),
(62, '17528'),
(63, '19129'),
(64, '19136'),
(65, '78525'),
(66, '79901'),
(67, '80536'),
(68, '83630'),
(69, '87489'),
(70, '87901'),
(71, '88322'),
(72, '88325'),
(73, '88488'),
(74, '88511'),
(75, '88525'),
(76, '88558'),
(77, '88806'),
(78, '88937'),
(79, '88987'),
(80, '90528'),
(81, '91503'),
(82, '93808'),
(83, '13446'),
(84, '13467A'),
(85, '13467B'),
(86, '13467D'),
(87, '13467E'),
(88, '622STN'),
(89, '000'),
(90, 'CR886A'),
(91, 'CR886B'),
(92, 'DC14523A'),
(93, 'DC816'),
(94, 'DC816A'),
(95, 'DC886I'),
(96, 'DC886II'),
(97, 'GREEN1'),
(98, 'IR001'),
(99, 'IR004'),
(100, 'IR005'),
(101, 'IR14004'),
(102, 'IR14004A'),
(103, 'NOVAGLASS'),
(104, 'SUPPLIES'),
(105, 'WSTP'),
(106, 'FABRICATED ITEMS'),
(107, 'RAWMATS'),
(108, 'RT'),
(109, 'MIS'),
(110, 'SERVICES'),
(111, '000 UV'),
(112, 'L'),
(113, 'L Size'),
(114, '3mmT L size'),
(115, '622 UV'),
(116, 'LAYOUT FEE'),
(117, 'PRCG'),
(118, '468'),
(119, '531 UV'),
(120, '88667'),
(121, '881W'),
(122, '881 STN'),
(123, '96632'),
(124, 'TRED'),
(125, 'SILVER'),
(126, 'GOLD'),
(127, '06136'),
(128, 'DC14524'),
(129, 'DC14523'),
(130, 'DC14523-B'),
(131, 'DC568A'),
(132, '04111'),
(133, '19121'),
(134, 'EC:PINK'),
(135, 'ADMIN SUPPLIES'),
(136, 'OFFICE SUPPLIES'),
(137, 'PACKAGING SUPPLIES'),
(138, 'GENERAL SUPPLIES'),
(139, 'FABRICATION SUPPLIES'),
(140, 'TOOLS & EQUIPMENT'),
(141, 'ELECTRICAL SUPPLIES'),
(142, 'BUFFING SUPPLIES'),
(143, 'HARDWARE SUPPLIES'),
(144, 'BEARING'),
(145, 'GEN/PROCESSING'),
(146, 'BOILER'),
(147, 'AUTOMOTIVE'),
(148, 'OIL SEAL'),
(149, 'MACHINE PART/GENSET 1'),
(150, 'MACHINE PART'),
(151, 'TIRE SUPPLIES'),
(152, 'PLUMBING SUPPLIES'),
(153, 'GAUGE/LEVEL/SENSOR'),
(154, 'MACHINE PART/LOADCAR'),
(155, 'ANTI-STATIC'),
(156, 'RAW MATERIAL/ACRYL:OPACIFIER'),
(157, 'ELASTOMER/CHLORINATED POLYETHYLENE'),
(158, 'COLORANT/TiO2-RUTILE'),
(159, 'COLORANT/PEARL ESSENCE'),
(160, 'OPTICAL BRIGHTENER'),
(161, 'COLORANT/DYESTUFF:VLT'),
(162, 'PROCESSING AID/ACRY'),
(163, 'FAB SUPPLIES/AQUASOUND PART'),
(164, 'CRATING SUPPLIES'),
(165, 'LUBRICANT/EXTERNAL-FG'),
(166, 'PROCESSING AID/ACRY-LUBRICANT'),
(167, 'FAB SUPPLIES/WSHLD PART'),
(168, 'COLORANT/PIGMENT:GRN'),
(169, 'BLUING AGENT/ULTRAMARINE BLUE'),
(170, 'LUBRICANT/STEARATE:STEARIC ACID'),
(171, 'COLORANT/PIGMENT:YEL'),
(172, 'LUBRICANT/STEARATE'),
(173, 'COLORANT/PIGMENT:RED'),
(174, 'COLORANT/PIGMENT:MSTER BATCH-BRW'),
(175, 'LUBRICANT'),
(176, 'COLORANT/PIGMENT:CARBON BLACK'),
(177, 'COLORANT/ACRY TONER:WHT'),
(178, 'FILLER/CLAY'),
(179, 'COLORANT/PIGMENT:MSTER BATCH-CRM'),
(180, 'COLORANT/PIGMENT:MSTER BATCH-YEL'),
(181, 'FAB SUPPLIES/COLORANT:RED'),
(182, 'ANTI-OXIDANT'),
(183, 'COLORANT/PIGMENT:MSTER BATCH-BEIGE'),
(184, 'COLORANT/PIGMENT:MSTER BATCH-GRN'),
(185, 'RAW MATERIAL/ACRY-PRESSURE SENSI'),
(186, 'METHYL METHACRYLATE MONOMER'),
(187, 'IMPACT MODIFIER/MBS'),
(188, 'LUBRICANT/STEARATE:CALCIUM'),
(189, 'ELASTOMER/EVA'),
(190, 'RESIN/PVC SUSPENSION:K70-72'),
(191, 'RESIN/PVC SUSPENSION:K57-62'),
(192, 'RESIN/PVC SUSPENSION:K65-68'),
(193, 'CONST/CONCRETE'),
(194, 'RESIN/PSGP'),
(195, 'RESIN/NYLON'),
(196, 'RESIN/POLYVINYL ACETATE COPOLYMER'),
(197, 'OIL SUPPLIES'),
(198, 'PAINT & ACCESSORIES'),
(199, 'GEN/ACRYLIC'),
(200, 'BAND HEATER'),
(201, 'MACHINE/BOILER'),
(202, 'VALVES'),
(203, 'WELDING SUPPLIES'),
(204, 'CUTTING SUPPLIES'),
(205, 'O-RING'),
(206, 'MACHINE PART/CENTRIFUGAL PUMP'),
(207, 'FAB SUPPLIES'),
(208, 'MACHINE PART/EXT65'),
(209, 'V-BELT'),
(210, 'PLSTCZR/POLYMERIC:POLYESTER'),
(211, 'COLORANT/PIGMENT:MSTER BATCH BLK'),
(212, 'BLUING AGENT'),
(213, 'BLUING AGENT/ULTRAMARINE VIOLET'),
(214, 'COLORANT/PIGMENT:ORG'),
(215, 'COLORANT/PIGMENT:BLU'),
(216, 'COLORANT/PIGMENT:VLT'),
(217, 'LUBRICANT/FATTY ACID ESTER COMPLEX'),
(218, 'COUPLING AGENT'),
(219, 'RESIN/PVC PASTE:K-70'),
(220, 'BLOWING AGENT'),
(221, 'FILLER/SILICA'),
(222, 'BLOWING AGENT/KICKER'),
(223, 'HEAT STAB/Ca-Zn1PACK'),
(224, 'PROCESSING AID/PE WAX'),
(225, 'HEAT STAB/TIN:BUTYL'),
(226, 'PLSTCZR/NITRILE BLEND'),
(227, 'FAB SUPP/DYESTUFF:RED'),
(228, 'FAB SUPP/DYESTUFF:BRN'),
(229, 'FAB SUPP/DYESTUFF:VLT'),
(230, 'CSTMR/MTL/BI-SAMPLE'),
(231, 'CSTMR MTL/JUN SOLER:COLORANT'),
(232, 'COLORANT/PIGMENT:LBLU'),
(233, 'COLORANT/PIGMENT:BRN'),
(234, 'COLORANT/PIGMENT:WHT'),
(235, 'COLORANT/PIGMENT:GRY'),
(236, 'COLORANT/PIGMENT:BRONZE'),
(237, 'COLORANT/PIGMENT:GRANITE-BLK'),
(238, 'COLORANT/PIGMENT:GRANITE-BLU'),
(239, 'HEAT STAB/TIN:METHYL'),
(240, 'COLORANT/PIGMENT:MSTER BATCH-ORG'),
(241, 'ESBO'),
(242, 'LUBRICANT/STEARATE:BUTYL'),
(243, 'HEAT STAB/Ba-Zn'),
(244, 'FAB SUPP/CLIPBOARD'),
(245, 'FAB SUPPLIES/COWLING VISOR PART'),
(246, 'WSHLD/COWLING'),
(247, 'CSTMR/MTL/SAMPLE'),
(248, 'FILLER/CaCO3'),
(249, 'FILLER/CaCO3:MASTERBATCH'),
(250, 'HEAT STAB/LEAD'),
(251, 'HEAT STAB/Ca-Zn'),
(252, 'FIRE EXTINGUISHER'),
(253, 'UV STABILIZER'),
(254, 'COLORANT/PIGMENT'),
(255, 'WSTP-CB'),
(256, 'WSTP-CORR'),
(257, 'WSTP-CORR/CB'),
(258, 'WSTP-CORR/PLAIN'),
(259, 'WSTP-PLAIN/CB'),
(260, 'WSTP-PLAIN/DB'),
(261, 'BACK-UP RING'),
(262, 'COLORANT/PIGMENT:MSTER BATCH-WHT'),
(263, 'CSTMR/MTL/JS'),
(264, 'PRCG ITEMS'),
(265, 'LUBRICANT/STEARATE:BARIUM'),
(266, 'LABORATORY SUPPLIES'),
(267, 'COLORANT'),
(268, 'CaCO3'),
(269, 'FOAMING AGENT'),
(270, 'MAGNET'),
(271, 'PVC CMPD'),
(272, 'HEAT STAB'),
(273, 'FILLER'),
(274, 'RESIN/PVC'),
(275, 'COLORANT/TiO2-XTENDR'),
(276, 'COMPUTER ACCESSORIES'),
(277, 'RESIN/PE'),
(278, 'RESIN/SG'),
(279, 'RE-SALE'),
(280, 'JUN SOLER'),
(281, '0132'),
(282, '281'),
(283, '1156'),
(284, '57D STN'),
(285, '284'),
(286, '14446A'),
(287, '14446B'),
(288, '0127'),
(289, '7706'),
(290, 'COLORANT/PIGMENT-BLU'),
(291, 'COLORANT'),
(292, 'CR886-A'),
(293, 'CR886-B'),
(294, '267/PIGMENT'),
(295, '267/PEARL ESSENCE'),
(296, '294:GRANITE-BLK'),
(297, '294:GRANITE-BLU'),
(298, '294:GRY'),
(299, '294:MSTER BATCH-GRN'),
(300, '267/TiO2-XTENDR'),
(301, '294:ORG'),
(302, 'COLORANT'),
(303, '000 STN'),
(304, 'OPAQUE GRAY'),
(305, 'WSTP/PLAIN-CB'),
(306, '522'),
(307, 'CaCA3'),
(308, 'FABRICATON'),
(309, '5041'),
(310, 'G.126'),
(311, 'GPINK'),
(312, 'G.GOLD'),
(313, 'SHOPEE'),
(314, 'METALIC GOLD'),
(315, 'LACE SILVER'),
(316, 'WSHLD PART'),
(317, 'others'),
(318, 'CHRISTMAS GIFT'),
(319, 'METALIC SILVER'),
(320, 'ASSTD COLOR'),
(321, 'G.GRN'),
(322, 'G.BLU'),
(323, 'G.BLK'),
(324, 'PC/SOLID-STD'),
(325, 'PC/SOLID-UV'),
(326, 'PC/SOLID-CLR'),
(327, 'PC/T-BRN'),
(328, 'PRES MATIC'),
(329, '503');

-- --------------------------------------------------------

--
-- Table structure for table `acry_mask_tb`
--

CREATE TABLE `acry_mask_tb` (
  `acry_mask_id` int(25) NOT NULL,
  `acry_mask_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acry_mask_tb`
--

INSERT INTO `acry_mask_tb` (`acry_mask_id`, `acry_mask_name`) VALUES
(1, 'MM'),
(2, 'KK');

-- --------------------------------------------------------

--
-- Table structure for table `acry_tb`
--

CREATE TABLE `acry_tb` (
  `acry_id` int(25) NOT NULL,
  `product_id` int(25) NOT NULL,
  `acry_color_id` int(25) NOT NULL,
  `acry_mask_id` int(25) NOT NULL,
  `acry_thick_id` int(25) NOT NULL,
  `acry_class_id` int(25) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `product_type_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acry_tb`
--

INSERT INTO `acry_tb` (`acry_id`, `product_id`, `acry_color_id`, `acry_mask_id`, `acry_thick_id`, `acry_class_id`, `barcode`, `product_type_id`) VALUES
(1, 1, 1, 1, 18, 0, '100', 0),
(2, 3, 2, 2, 4, 2, 'ad', 0),
(3, 4, 12, 2, 3, 1, '400', 0),
(4, 5, 8, 2, 5, 0, '123', 1),
(5, 6, 2, 1, 2, 1, 'asd', 1),
(6, 7, 17, 2, 5, 0, 'as', 1),
(7, 8, 3, 1, 2, 0, 'q', 1),
(8, 11, 89, 1, 3, 0, '232', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acry_thick_tb`
--

CREATE TABLE `acry_thick_tb` (
  `acry_thick_id` int(25) NOT NULL,
  `thickness` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acry_thick_tb`
--

INSERT INTO `acry_thick_tb` (`acry_thick_id`, `thickness`) VALUES
(1, '1.5mm'),
(2, '2.0mm'),
(3, '2.5mm'),
(4, '3.0mm'),
(5, '4.0mm'),
(6, '4.5mm'),
(7, '5.0mm'),
(8, '6.0mm'),
(9, '8.0mm'),
(10, '9.0mm'),
(11, '10.0mm'),
(12, '12.0mm'),
(13, '15.0mm'),
(14, '18.0mm'),
(15, '20.0mm'),
(16, '25.0mm'),
(17, '30.0mm'),
(18, '50.0mm');

-- --------------------------------------------------------

--
-- Table structure for table `fab_tb`
--

CREATE TABLE `fab_tb` (
  `fab_id` int(25) NOT NULL,
  `product_id` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fab_tb`
--

INSERT INTO `fab_tb` (`fab_id`, `product_id`) VALUES
(1, 2),
(2, 9),
(3, 10);

-- --------------------------------------------------------

--
-- Table structure for table `loc_tb`
--

CREATE TABLE `loc_tb` (
  `loc_id` int(250) NOT NULL,
  `loc_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loc_tb`
--

INSERT INTO `loc_tb` (`loc_id`, `loc_name`) VALUES
(1, 'B2AR1'),
(2, 'B2AR2'),
(3, 'B2AR3'),
(4, 'B2AR4'),
(5, 'B2AR5'),
(6, 'B2AR6'),
(7, 'B2AR7'),
(8, 'B2AR8'),
(9, 'B2AR9'),
(10, 'B2AR10'),
(11, 'B2AR11'),
(12, 'B2AR12'),
(13, 'B2AR13'),
(14, 'B2AR14'),
(15, 'B2AR15'),
(16, 'B2AR16'),
(17, 'B2AR17'),
(18, 'B2AR18'),
(19, 'B2AR19'),
(20, 'B2AR20'),
(21, 'B2AR21'),
(22, 'B2AR22'),
(23, 'B2AR23'),
(24, 'B2AR24'),
(25, 'B2AR25'),
(26, 'B2AR26'),
(27, 'B2AR27'),
(28, 'B2AR28'),
(29, 'B2AR29'),
(30, 'B2AR30'),
(31, 'B2AR31'),
(32, 'B2AR32'),
(33, 'B2AR33'),
(34, 'B2AR34'),
(35, 'B2AR35'),
(36, 'B2AR36'),
(37, 'B2AR37'),
(38, 'B2AR39'),
(39, 'B2AR40'),
(40, 'BDG2'),
(41, 'B2STR1'),
(42, 'B2STR2'),
(43, 'B2STR3'),
(44, 'B2STR4'),
(45, 'B2STR5'),
(46, 'B2STR6'),
(47, 'B2UR1'),
(48, 'B2UR2'),
(49, 'B2UR3'),
(50, 'B2UR4'),
(51, 'B2STR7'),
(52, 'B2UR5'),
(53, 'B2UR6'),
(54, 'B2STR8'),
(55, 'B2UR7'),
(56, 'B2UR8'),
(57, 'B2STR9'),
(58, 'B2UR9'),
(59, 'B2UR10'),
(60, 'B2STR10'),
(61, 'B2STR11'),
(62, 'B2STR12'),
(63, 'B2STR13'),
(64, 'B2STR14'),
(65, 'B2STR15'),
(66, 'B2STR16'),
(67, 'B2STR17'),
(68, 'B2STR18'),
(69, 'B2STR19'),
(70, 'B2STR20'),
(71, 'B2STR21'),
(72, 'B2STR22'),
(73, 'B2STR23'),
(74, 'B2STR24'),
(75, 'B2STR25'),
(76, 'B2STR26'),
(77, 'B2STR27'),
(78, 'B2STR28'),
(79, 'B2STR29'),
(80, 'B2STR30'),
(81, 'B2STR31'),
(82, 'B2STR32'),
(83, 'B2STR33'),
(84, 'B2STR34'),
(85, 'B2STR35'),
(86, 'B2STR36'),
(87, 'B2STR37'),
(88, 'B2STR38'),
(89, 'B2STR39'),
(90, 'B2STR40'),
(91, 'B2STR41'),
(92, 'B2STR42'),
(93, 'B2STR43'),
(94, 'B2STR44'),
(95, 'B2STR45'),
(96, 'B2STR46'),
(97, 'B2STR47'),
(98, 'B2STR48'),
(99, 'B2STR49'),
(100, 'B2STR50'),
(101, 'B2STR51'),
(102, 'B2STR52'),
(103, 'B2STR53'),
(104, 'B2STR54'),
(105, 'B2STR55'),
(106, 'B2STR56'),
(107, 'B2STR57'),
(108, 'B2STR58'),
(109, 'B2STR59'),
(110, 'B2STR60'),
(111, 'B2STR61'),
(112, 'B2STR62'),
(113, 'B2STR63'),
(114, 'B2STR64'),
(115, 'B2STR65'),
(116, 'B2STR66'),
(117, 'B2STR67'),
(118, 'B2STR68'),
(119, 'B2STR69'),
(120, 'B2STR70'),
(121, 'B2STR71'),
(122, 'B2STR72'),
(123, 'B2STR73'),
(124, 'B2STR74'),
(125, 'B2STR75'),
(126, 'B2STR76'),
(127, 'B2STR77'),
(128, 'B2STR78'),
(129, 'B2STR79'),
(130, 'B2STR80'),
(131, 'B2STR81'),
(132, 'B2STR82'),
(133, 'B2STR83'),
(134, 'B2STR84'),
(135, 'B2STR85'),
(136, 'B2STR86'),
(137, 'B2STR87'),
(138, 'B2STR88'),
(139, 'B2STR89'),
(140, 'B2STR90'),
(141, 'B2STR91'),
(142, 'B2STR92'),
(143, 'B2STR93'),
(144, 'B2STR94'),
(145, 'B2STR95'),
(146, 'B2STR96'),
(147, 'B2STR97'),
(148, 'B2STR98'),
(149, 'B2STR99'),
(150, 'B2STR100'),
(151, 'B2STR101'),
(152, 'B2STR102'),
(153, 'B2STR103'),
(154, 'B2STR104'),
(155, 'B2STR105'),
(156, 'B2STR106'),
(157, 'B2STR107'),
(158, 'B2STR108'),
(159, 'B2STR109'),
(160, 'B2STR110'),
(161, 'B2STR111'),
(162, 'B2STR112'),
(163, 'B2STR113'),
(164, 'B2STR114'),
(165, 'B2STR115'),
(166, 'B2STR116'),
(167, 'B2STR117'),
(168, 'B2STR118'),
(169, 'B2STR119'),
(170, 'B2STR120'),
(171, 'B2STR121'),
(172, 'B2STR122'),
(173, 'B2STR123'),
(174, 'B2STR124'),
(175, 'B2STR125'),
(176, 'B2STR126'),
(177, 'B2STR127'),
(178, 'B2STR128'),
(179, 'B2STR129'),
(180, 'B2STR130'),
(181, 'B2STRDOWN'),
(182, 'B2STRUP'),
(183, 'B2STRDOWN/RIGHTSIDE'),
(184, 'B2STRDOWN/LEFTSIDE'),
(185, 'B2STRUP/RIGHTSIDE'),
(186, 'B2STRUP/LEFTSIDE'),
(187, 'LASER'),
(188, 'SCRAP'),
(189, 'B2AR41'),
(190, 'STKRM'),
(191, 'CUTTER'),
(192, 'FABRICATION'),
(193, 'B4AR6'),
(194, 'B2AR42'),
(195, 'BD4/GF'),
(196, 'BD3'),
(197, 'B4AR7'),
(198, 'B4AR8'),
(199, 'B2AR38'),
(200, 'B4UG'),
(201, 'B4AP5'),
(202, 'B4AP7'),
(203, 'B4AP8'),
(204, 'B4AP9'),
(205, 'B2STRDRS'),
(206, 'B4AP6'),
(207, 'B4AP2'),
(208, 'B4AP3'),
(209, 'B4AP4'),
(210, 'B2ST54'),
(211, 'B2STR/UP'),
(212, 'B2STRDLS'),
(213, 'B2STRDC'),
(214, 'BD2'),
(215, 'BD3/WEIGHING AREA'),
(216, 'BD4/2F'),
(217, 'BD3/PRCGLAB'),
(218, 'BD3/MIXER AREA 2'),
(219, 'BD3/ROLL MILL AREA'),
(220, 'BDG4'),
(221, 'BD3/WEIGHINGM AREA'),
(222, 'BD2STR7'),
(223, 'BD4'),
(224, 'BD2B2STR35'),
(225, 'B2STRDOWN/CENTER'),
(226, 'B2STR'),
(227, 'B2STRRC'),
(228, 'BDG1'),
(229, 'B2/2F'),
(230, 'B2/2F'),
(231, 'B4/2F'),
(232, 'B4AR4'),
(233, 'B2UR'),
(234, 'OFFICE'),
(235, 'BDG3'),
(236, 'B4AR1'),
(237, 'SHOPEE ITEM'),
(238, 'B2AR38'),
(239, 'B2AR38');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(25) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `loc_id` int(25) NOT NULL,
  `sup_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `product_type_id` int(25) NOT NULL,
  `price` double NOT NULL,
  `cost` double NOT NULL,
  `pro_remarks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `loc_id`, `sup_id`, `unit_id`, `product_type_id`, `price`, `cost`, `pro_remarks`) VALUES
(1, '1in x 2in', 1, 0, 1, 1, 100, 100, '100'),
(2, 'ACRY 1in x 2in', 2, 0, 1, 2, 200, 200, '200'),
(3, '123123', 3, 0, 2, 1, 123, 123, 'ad'),
(4, 'asdasdasd', 4, 0, 3, 1, 400, 400, '400'),
(5, 'asdasda', 5, 0, 1, 1, 123, 321, '123'),
(6, 'asdasd', 4, 0, 4, 1, 123, 12, 'asd'),
(7, 'fgdgdfgd', 3, 0, 3, 1, 123, 12, 'dasd'),
(8, 'dsaddd', 2, 0, 2, 1, 1213, 321, 'dasdas'),
(9, 'testing', 146, 0, 2, 2, 33333, 3333, 'asdad'),
(10, 'test2', 80, 0, 3, 2, 222, 222, 'adsadad'),
(11, 'acrylictest', 168, 0, 1, 1, 23232, 12323, '23');

-- --------------------------------------------------------

--
-- Table structure for table `product_loc_tb`
--

CREATE TABLE `product_loc_tb` (
  `product_loc_id` int(25) NOT NULL,
  `product_id` int(25) NOT NULL,
  `loc_id` int(25) NOT NULL,
  `qty` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_loc_tb`
--

INSERT INTO `product_loc_tb` (`product_loc_id`, `product_id`, `loc_id`, `qty`) VALUES
(1, 1, 1, 100),
(2, 2, 2, 200),
(3, 3, 3, 123),
(4, 3, 4, 400),
(5, 5, 5, 123),
(6, 6, 4, 123),
(7, 7, 3, 13),
(8, 8, 2, 123),
(9, 9, 146, 999),
(10, 10, 80, 222),
(11, 11, 168, 32323);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `product_type_id` int(250) NOT NULL,
  `product_type_name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`product_type_id`, `product_type_name`) VALUES
(1, 'ACRYLIC'),
(2, 'FABRICATION'),
(3, 'PRCG'),
(4, 'RAWMATS');

-- --------------------------------------------------------

--
-- Table structure for table `unit_tb`
--

CREATE TABLE `unit_tb` (
  `unit_id` int(250) NOT NULL,
  `unit_name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit_tb`
--

INSERT INTO `unit_tb` (`unit_id`, `unit_name`) VALUES
(1, 'pcs'),
(2, 'bgs'),
(3, 'box'),
(4, 'can'),
(5, 'cnt'),
(6, 'drm'),
(7, 'ft'),
(8, 'gal'),
(9, 'grms'),
(10, 'kgs'),
(11, 'ltrs'),
(12, 'lttr'),
(13, 'ltts'),
(14, 'pad'),
(15, 'pr'),
(16, 'prs'),
(17, 'rls'),
(18, 'set'),
(19, 'sht'),
(20, 'mtr'),
(21, 'mtrs'),
(22, 'tank'),
(24, 'ml'),
(25, 'pck'),
(26, 'btl'),
(27, 'cc'),
(28, 'PAIL'),
(29, 'OZ'),
(30, 'lot'),
(31, 'unit');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acry_class_tb`
--
ALTER TABLE `acry_class_tb`
  ADD PRIMARY KEY (`acry_class_id`);

--
-- Indexes for table `acry_color_tb`
--
ALTER TABLE `acry_color_tb`
  ADD PRIMARY KEY (`acry_color_id`);

--
-- Indexes for table `acry_mask_tb`
--
ALTER TABLE `acry_mask_tb`
  ADD PRIMARY KEY (`acry_mask_id`);

--
-- Indexes for table `acry_tb`
--
ALTER TABLE `acry_tb`
  ADD PRIMARY KEY (`acry_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `acry_color_id` (`acry_color_id`),
  ADD KEY `acry_mask_id` (`acry_mask_id`),
  ADD KEY `acry_thick_id` (`acry_thick_id`),
  ADD KEY `acry_class_id` (`acry_class_id`);

--
-- Indexes for table `acry_thick_tb`
--
ALTER TABLE `acry_thick_tb`
  ADD PRIMARY KEY (`acry_thick_id`);

--
-- Indexes for table `fab_tb`
--
ALTER TABLE `fab_tb`
  ADD PRIMARY KEY (`fab_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `loc_tb`
--
ALTER TABLE `loc_tb`
  ADD PRIMARY KEY (`loc_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `sup_id` (`sup_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `loc_id` (`loc_id`),
  ADD KEY `product_type_id` (`product_type_id`);

--
-- Indexes for table `product_loc_tb`
--
ALTER TABLE `product_loc_tb`
  ADD PRIMARY KEY (`product_loc_id`),
  ADD KEY `loc_id` (`loc_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `unit_tb`
--
ALTER TABLE `unit_tb`
  ADD PRIMARY KEY (`unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acry_class_tb`
--
ALTER TABLE `acry_class_tb`
  MODIFY `acry_class_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `acry_color_tb`
--
ALTER TABLE `acry_color_tb`
  MODIFY `acry_color_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=330;

--
-- AUTO_INCREMENT for table `acry_mask_tb`
--
ALTER TABLE `acry_mask_tb`
  MODIFY `acry_mask_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `acry_tb`
--
ALTER TABLE `acry_tb`
  MODIFY `acry_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `acry_thick_tb`
--
ALTER TABLE `acry_thick_tb`
  MODIFY `acry_thick_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `fab_tb`
--
ALTER TABLE `fab_tb`
  MODIFY `fab_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loc_tb`
--
ALTER TABLE `loc_tb`
  MODIFY `loc_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_loc_tb`
--
ALTER TABLE `product_loc_tb`
  MODIFY `product_loc_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `product_type_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `unit_tb`
--
ALTER TABLE `unit_tb`
  MODIFY `unit_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
