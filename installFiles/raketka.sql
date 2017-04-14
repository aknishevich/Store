-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 28 2016 г., 02:47
-- Версия сервера: 5.5.50
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `raketka`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`%` PROCEDURE `proc1`()
    NO SQL
SELECT Products.Name, PTypes.Name_PT
FROM Products INNER JOIN PTypes ON Products.Kod_PT = PTypes.Id
WHERE (Products.Price<(SELECT AVG (Products.Price) FROM Products))$$

CREATE DEFINER=`root`@`%` PROCEDURE `proc2`()
    NO SQL
SELECT Users.Names, Baskets.Kod_Product, Baskets.Count
FROM Users INNER JOIN Baskets
ON Users.ID = Baskets.Kod_User
WHERE (Baskets.Count>(SELECT AVG (Baskets.Count) FROM Baskets)) ORDER BY Baskets.Count DESC$$

CREATE DEFINER=`root`@`%` PROCEDURE `proc3`()
    NO SQL
SELECT Users.Names, Roles.Name_roles, Users.LastActivity
FROM Users INNER JOIN Roles ON Users.Kod_roles = Roles.Kod_roles ORDER BY LastActivity DESC$$

CREATE DEFINER=`root`@`%` PROCEDURE `proc4`()
    NO SQL
SELECT Users.Names, Comments.date, Comments.comments, Blog.Name
FROM Users INNER JOIN (Comments INNER JOIN Blog ON Comments.Kod_Blog = Blog.Id)
ON Users.ID = Comments.Kod_User
WHERE Comments.date = (SELECT CURDATE())$$

CREATE DEFINER=`root`@`%` PROCEDURE `proc5`()
    NO SQL
SELECT Types.Name, Products.Name, PTypes.Name_PT, Products.Price
FROM PTypes INNER JOIN (Products INNER JOIN Types ON Products.Kod_T = Types.Id)
ON PTypes.Id = Products.Kod_PT
WHERE Products.Price > 1500 AND Products.Price <3000$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `Baskets`
--

CREATE TABLE IF NOT EXISTS `Baskets` (
  `Id` int(11) NOT NULL,
  `Kod_User` int(11) NOT NULL,
  `Kod_Product` int(11) NOT NULL,
  `Count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Baskets`
--

INSERT INTO `Baskets` (`Id`, `Kod_User`, `Kod_Product`, `Count`) VALUES
(5, 1, 6, 1),
(6, 1, 8, 3),
(7, 1, 5, 1),
(8, 1, 9, 1),
(9, 7, 2, 5),
(10, 7, 11, 3),
(11, 7, 17, 2),
(12, 10, 3, 1),
(13, 1, 2, 1),
(14, 1, 3, 1);

--
-- Триггеры `Baskets`
--
DELIMITER $$
CREATE TRIGGER `trigger1` BEFORE INSERT ON `baskets`
 FOR EACH ROW UPDATE Users SET Users.LastActivity = NOW() WHERE (Users.ID = (SELECT Kod_User FROM Baskets ORDER BY id DESC LIMIT 1))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `Blog`
--

CREATE TABLE IF NOT EXISTS `Blog` (
  `Id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Descriptions` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Blog`
--

INSERT INTO `Blog` (`Id`, `Name`, `Descriptions`) VALUES
(1, 'Коментраі щодо дизайну та структури сайту', 'В цій темі блогу обговорюються всі пропозиції, коментарі, побажання, критикування всіх елементів сайту. desc Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'),
(2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n');

-- --------------------------------------------------------

--
-- Структура таблицы `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `Id` int(11) NOT NULL,
  `Kod_User` int(11) NOT NULL,
  `Kod_Blog` int(11) NOT NULL,
  `date` date NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Comments`
--

INSERT INTO `Comments` (`Id`, `Kod_User`, `Kod_Blog`, `date`, `comments`) VALUES
(1, 1, 1, '2016-06-12', 'test comments'),
(2, 1, 2, '2016-12-28', 'Комментарий 2'),
(3, 10, 1, '2016-12-28', 'Хорошая статья'),
(4, 11, 2, '2016-12-28', 'коментувати...'),
(5, 11, 2, '2016-12-28', 'коментувати...');

--
-- Триггеры `Comments`
--
DELIMITER $$
CREATE TRIGGER `trigger2` AFTER INSERT ON `comments`
 FOR EACH ROW UPDATE Users SET Users.LastActivity = NOW() WHERE (Users.ID = (SELECT Kod_User FROM Comments ORDER BY id DESC LIMIT 1))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `Products`
--

CREATE TABLE IF NOT EXISTS `Products` (
  `Id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Kod_T` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `images` varchar(100) NOT NULL,
  `DS` text,
  `Kod_PT` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Products`
--

INSERT INTO `Products` (`Id`, `Name`, `Kod_T`, `Price`, `images`, `DS`, `Kod_PT`) VALUES
(1, 'ракетка 1', 1, 2000, '1.jpg', 'описание ракетки 1', 1),
(2, 'ракетка 2', 1, 3333, '2.jpg', NULL, 1),
(3, 'сумка 1', 2, 2400, '3.jpg', NULL, 4),
(4, 'ракетка 4', 1, 2250, '4.jpg', NULL, 2),
(5, 'ракетка 5', 1, 1999, '5.jpg', 'описание к ракетка №5', 3),
(6, 'мячи 6', 3, 300, '6.jpg', 'описание к мячам 6', 5),
(7, 'тенисные мячи 7', 3, 2405, '7.jpg', 'description 7', 5),
(8, 'ракетка 8', 1, 1800, '8.jpg', NULL, 2),
(9, 'сумка 9', 2, 450, '9.jpg', 'описание сумки 9', 4),
(10, 'теннисные мячи 10 ', 3, 334, '10.jpg', NULL, 5),
(11, 'сумка 11', 2, 655, '11.jpg', 'description 11', 4),
(13, 'ракетка 12', 1, 1600, '12.jpg', 'qew', 1),
(14, 'ракетка 13', 1, 1800, '13.jpg', '', 2),
(15, 'сумка 27', 2, 900, '27.jpg', 'описание к сумке', 6),
(16, 'сумка 29', 1, 890, '29.jpg', '', 2),
(17, 'ракетка 15', 1, 1600, '15.jpg', '', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `PTypes`
--

CREATE TABLE IF NOT EXISTS `PTypes` (
  `Id` int(11) NOT NULL,
  `Kod_T` int(11) NOT NULL,
  `Name_PT` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `PTypes`
--

INSERT INTO `PTypes` (`Id`, `Kod_T`, `Name_PT`) VALUES
(1, 1, 'Babolat'),
(2, 1, 'Head'),
(3, 1, 'Cyber'),
(4, 2, 'Head'),
(5, 3, 'Dunlop'),
(6, 2, 'Fort');

-- --------------------------------------------------------

--
-- Структура таблицы `Roles`
--

CREATE TABLE IF NOT EXISTS `Roles` (
  `Kod_roles` int(10) NOT NULL,
  `Name_roles` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Roles`
--

INSERT INTO `Roles` (`Kod_roles`, `Name_roles`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Структура таблицы `Types`
--

CREATE TABLE IF NOT EXISTS `Types` (
  `Id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `images` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Types`
--

INSERT INTO `Types` (`Id`, `Name`, `images`) VALUES
(1, 'ракетки', '1.jpg'),
(2, 'сумки', '9.jpg'),
(3, 'мячи', '6jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `ID` int(10) NOT NULL,
  `Names` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `Kod_roles` int(10) NOT NULL,
  `status` int(10) DEFAULT NULL,
  `LastActivity` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`ID`, `Names`, `Password`, `Mail`, `Kod_roles`, `status`, `LastActivity`) VALUES
(1, 'admin', '85064efb60a9601805dcea56ec5402f7', 'divinkas@gmail.com', 1, 2, '2016-12-28 01:18:30'),
(5, 'user', '76d80224611fc919a5d54f0ff9fba446', 'oops@gmail.com', 2, 0, '2016-12-27 00:00:00'),
(7, 'Vadim', 'b59c67bf196a4758191e42f76670ceba', 'sadasf@mail.ru', 2, NULL, '2016-12-28 00:00:00'),
(10, 'Robert', 'b59c67bf196a4758191e42f76670ceba', 'robert@mail.ru', 2, NULL, '2016-12-28 00:00:00'),
(11, 'Ceh9', 'dc61cf1fe9aedeed59cc0d1fd2e03c5f', 'aknishevich@mail.ru', 2, NULL, '2016-12-28 01:18:08');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Baskets`
--
ALTER TABLE `Baskets`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `Blog`
--
ALTER TABLE `Blog`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `PTypes`
--
ALTER TABLE `PTypes`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`Kod_roles`),
  ADD UNIQUE KEY `Kod_roles` (`Kod_roles`);

--
-- Индексы таблицы `Types`
--
ALTER TABLE `Types`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Baskets`
--
ALTER TABLE `Baskets`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `Blog`
--
ALTER TABLE `Blog`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `Comments`
--
ALTER TABLE `Comments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `Products`
--
ALTER TABLE `Products`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблицы `PTypes`
--
ALTER TABLE `PTypes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `Roles`
--
ALTER TABLE `Roles`
  MODIFY `Kod_roles` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `Types`
--
ALTER TABLE `Types`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
