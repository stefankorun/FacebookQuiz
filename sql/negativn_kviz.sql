-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 09, 2014 at 12:12 PM
-- Server version: 5.5.37-log
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `negativn_kviz`
--

-- --------------------------------------------------------

--
-- Table structure for table `prasanja`
--

DROP TABLE IF EXISTS `prasanja`;
CREATE TABLE IF NOT EXISTS `prasanja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `text` varchar(255) NOT NULL,
  `questions` text NOT NULL,
  `answer` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `prasanja`
--

INSERT INTO `prasanja` (`id`, `description`, `text`, `questions`, `answer`) VALUES
(1, '', 'Од која фирма е софтверот 3ds max?', '{"answers":["Macromedia","Adobe","Autodesk","Microsoft"]}', 3),
(2, '', 'Каква конфигурација е потребна за инсталирање на 3ds max 2015?', '{"answers":["Windows 7, 4gb ram,4.5gb простор на дискот","Windows 8, 8gb ram,2gb простор на дискот","Windows 7, 2gb ram,4.5gb простор на дискот","Windows 7, 1gb ram,1.7gb простор на дискот"]}', 1),
(3, '', 'Што е GPU рендерирање?', '{"answers":["Рендерирање на слика во процесорот","Рендерирање на слика во RAM меморијата","Рендерирање на слика во графичкиот процесор","Рендерирање на слика во тврдиот диск"]}', 3),
(4, '', 'Која фирма го произведува v-ray рендерот?', '{"answers":["Autodesk","Adobe","Microsoft","Chaos Group"]}', 4),
(5, '', 'Што е Acive Shade?', '{"answers":["Active Shade е алатка која се користи за рендерирање на материјали","Active Shade е алатка со која се гледаат промените на светлото и материјалите во реално време","Active Shade е програма за рендерирање","Active Shade служи за моделирање"]}', 2),
(6, '', 'Какви видови на светла постојат во 3ds max?', '{"answers":["Конуни, цилиндрични и сверични","Ласерски, дирекни и омни","Природни и вештачки","Дирекни"]}', 1),
(7, '', 'Колкава резулуција има Full HD слика?', '{"answers":["1336 x 728","1280 x 720","1920 x 1080","1600 x 900"]}', 3),
(8, '', 'Дали 3ds Max може да отвори фајл Кој е изработен во Autocad?', '{"answers":["Само ако е инсталиран plug-in за import","Не","Со помош на посебна програма","Да"]}', 4),
(9, '', 'Што е бит мапа?', '{"answers":["Мапа за нанесување на материјал на моделот","Видливиот дел од моделот","Мапа која помага при рендерирање","Замена за UV мапа"]}', 1),
(10, '', 'Кои се основните алатки за трансформација во 3ds max?', '{"answers":["Поместување и зголемување","Зголемување и ротација","Зголемување/намалување, ротација и поместување","Намалување, ротација и поместување"]}', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `fb_id` varchar(255) NOT NULL,
  `emailFb` varchar(200) NOT NULL,
  `tel` varchar(12) NOT NULL,
  `email` varchar(200) NOT NULL,
  `questionsLeft` int(2) NOT NULL DEFAULT '10',
  `points` int(3) DEFAULT NULL,
  PRIMARY KEY (`fb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `userquestion`
--

DROP TABLE IF EXISTS `userquestion`;
CREATE TABLE IF NOT EXISTS `userquestion` (
  `user_id` varchar(255) NOT NULL,
  `questionId` int(11) NOT NULL,
  `points` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
