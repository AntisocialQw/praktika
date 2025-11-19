-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 19 2025 г., 01:13
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lumiere_studio`
--

-- --------------------------------------------------------

--
-- Структура таблицы `access_rights`
--

CREATE TABLE `access_rights` (
  `ID_Access_rights` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `access_rights`
--

INSERT INTO `access_rights` (`ID_Access_rights`, `Name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Структура таблицы `booking`
--

CREATE TABLE `booking` (
  `ID_Booking` int(11) NOT NULL,
  `ID_Users` int(11) DEFAULT NULL,
  `ID_Services` int(11) DEFAULT NULL,
  `Booking_date` date DEFAULT NULL,
  `Booking_time` time DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `ID_Category` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`ID_Category`, `Name`) VALUES
(1, 'Портретная съемка'),
(2, 'Семейная фотосессия'),
(3, 'Love Story'),
(4, 'Коммерческая съемка');

-- --------------------------------------------------------

--
-- Структура таблицы `portfolio`
--

CREATE TABLE `portfolio` (
  `ID_Portfolio` int(11) NOT NULL,
  `ID_Services` int(11) DEFAULT NULL,
  `Image_url` varchar(255) DEFAULT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `portfolio`
--

INSERT INTO `portfolio` (`ID_Portfolio`, `ID_Services`, `Image_url`, `Title`, `Description`) VALUES
(1, 1, 'https://img.freepik.com/free-photo/portrait-pretty-blonde-model-sitting-table-white-casual-warm-knitted-sweater-black-hat_273443-2244.jpg', 'Портретная съемка', 'Индивидуальная фотосессия'),
(2, 2, 'https://i.pinimg.com/736x/8f/e6/18/8fe61853ef6e1641dc80d463d9f4af7d.jpg', 'Семейная фотосессия', 'В студии'),
(3, 3, 'https://the-wedding.ru/upload/photo/CompanyPhoto/353/24_07_2013_203_.JPG', 'Love Story', 'Парная съемка в парке'),
(4, 4, 'https://static.tildacdn.com/tild3738-6566-4630-b539-616566393338/491.jpg', 'Коммерческая съемка', 'Для бренда одежды'),
(5, 1, 'https://s2.fotokto.ru/topics/full/10/105099.jpg', 'Портретная съемка', 'Черно-белый портрет'),
(6, 2, 'https://i.wfolio.ru/x/D48ScH1DA6jxU_uSH-Or-C0cJClpP-QP/lEAL128xEMPGM2o_rKw_kMPHKR9vAJ80/OGxn_dwjJrW2hbd39Z4zeJ7lnEFCB1ye/iyjK5TNIdRWdmErJ-O9M8CdQtM9bxLwW/TGNZ97G7EaqT8HEE9EKqDA.jpg', 'Семейная фотосессия', 'На природе'),
(7, 1, './product_images/691cf25f85e42_1763504735.jpg', ' TEST', 'TEST');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `portfolioview`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `portfolioview` (
`ID_Portfolio` int(11)
,`Image_url` varchar(255)
,`Title` varchar(100)
,`Description` text
,`ServiceName` varchar(100)
,`Price` decimal(10,2)
,`CategoryName` varchar(100)
);

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `ID_Services` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`ID_Services`, `Name`, `Description`, `Price`) VALUES
(1, 'Индивидуальная портретная съемка', 'Профессиональная портретная съемка в студии', 3500.00),
(2, 'Семейная фотосессия', 'Теплые семейные фотографии в студии или на природе', 7000.00),
(3, 'Love Story', 'Романтическая фотосессия для пар', 10000.00),
(4, 'Коммерческая съемка', 'Съемка для брендов и бизнеса', 15000.00);

-- --------------------------------------------------------

--
-- Структура таблицы `services_category`
--

CREATE TABLE `services_category` (
  `ID_Services_category` int(11) NOT NULL,
  `ID_Services` int(11) DEFAULT NULL,
  `ID_Category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `services_category`
--

INSERT INTO `services_category` (`ID_Services_category`, `ID_Services`, `ID_Category`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `team`
--

CREATE TABLE `team` (
  `ID_Team` int(11) NOT NULL,
  `Full_name` varchar(100) DEFAULT NULL,
  `Position` varchar(100) DEFAULT NULL,
  `Photo_url` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `team`
--

INSERT INTO `team` (`ID_Team`, `Full_name`, `Position`, `Photo_url`, `Description`) VALUES
(1, 'Анна Петрова', 'Фотограф', 'https://express-externat.spb.ru/images/sotrudniki/as_petrova.jpg', 'Опыт работы: 7 лет. Специализация: портретная и семейная съемка.'),
(2, 'Семён Ворошин', 'Фотограф', 'https://24smi.org/public/media/290x360/celebrity/2025/10/02/jgty3m973d5p-tuborosho.jpg', 'Опыт работы: 5 лет. Специализация: коммерческая съемка и Love Story.'),
(3, 'Мария Иванова', 'Визажист-стилист', 'https://modnoe.tv/user/1/images/w480_h525_article_330.jpg', 'Создает неповторимые образы, подчеркивающие индивидуальность клиентов.');

-- --------------------------------------------------------

--
-- Структура таблицы `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `test`
--

INSERT INTO `test` (`id`, `name`, `email`, `phone`, `created_at`) VALUES
(1, 'Иван Иванов', 'ivan@test.ru', '+79161234567', '2025-11-18 23:02:57'),
(2, 'Петр Петров', 'petr@test.ru', '+79162345678', '2025-11-18 23:02:57'),
(3, 'Мария Сидорова', 'maria@test.ru', '+79163456789', '2025-11-18 23:02:57'),
(4, 'Анна Козлова', 'anna@test.ru', '+79164567890', '2025-11-18 23:02:57'),
(5, 'Сергей Смирнов', 'sergey@test.ru', '+79165678901', '2025-11-18 23:02:57');

-- --------------------------------------------------------

--
-- Структура таблицы `testimonials`
--

CREATE TABLE `testimonials` (
  `ID_Testimonials` int(11) NOT NULL,
  `Client_name` varchar(100) DEFAULT NULL,
  `Client_photo` varchar(255) DEFAULT NULL,
  `Text` text DEFAULT NULL,
  `Service_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID_Users` int(11) NOT NULL,
  `ID_Access_rights` int(11) DEFAULT NULL,
  `Phone` varchar(20) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Full_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID_Users`, `ID_Access_rights`, `Phone`, `Password`, `Email`, `Full_name`) VALUES
(1, 2, '(916) 648-25-42', '$2y$10$mMAnFJbnh8uv3MeobxRnXeUd9UpvAKxUQsEbaUwqbrC.2qbB0b5Fu', 'mihailstepachev@gmail.com', 'Михаил Степачев'),
(2, 1, '(916) 270-78-53', '$2y$10$qOFIcnrgDt2OmTHNSH8MKeoZDy0ZNn00wblPWusNHln/Tjl.1IcfO', 'anna1502@list.ru', 'АННА ЭНЮТИНА'),
(3, 1, '(926) 521-74-03', '$2y$10$uCRjZHBGzoKIhbReHnbj5.iTu1YI2OnnXCoYvqkOzKDxAIqNdY1/e', 'mikhailstepachev@gmail.com', 'Admin'),
(6, 2, '(987) 757-45-63', '$2y$10$RWULl9SkXao6oFwRBZ9hMugMxwMOa0z1F113iD76cgX.kzW/BQXjq', 'TEST@gmail.com', 'DROP TABLE test ');

-- --------------------------------------------------------

--
-- Структура для представления `portfolioview`
--
DROP TABLE IF EXISTS `portfolioview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `portfolioview`  AS SELECT `p`.`ID_Portfolio` AS `ID_Portfolio`, `p`.`Image_url` AS `Image_url`, `p`.`Title` AS `Title`, `p`.`Description` AS `Description`, `s`.`Name` AS `ServiceName`, `s`.`Price` AS `Price`, `c`.`Name` AS `CategoryName` FROM (((`portfolio` `p` left join `services` `s` on(`p`.`ID_Services` = `s`.`ID_Services`)) left join `services_category` `sc` on(`s`.`ID_Services` = `sc`.`ID_Services`)) left join `category` `c` on(`sc`.`ID_Category` = `c`.`ID_Category`)) ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `access_rights`
--
ALTER TABLE `access_rights`
  ADD PRIMARY KEY (`ID_Access_rights`);

--
-- Индексы таблицы `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`ID_Booking`),
  ADD KEY `ID_Users` (`ID_Users`),
  ADD KEY `ID_Services` (`ID_Services`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID_Category`);

--
-- Индексы таблицы `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`ID_Portfolio`),
  ADD KEY `ID_Services` (`ID_Services`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ID_Services`);

--
-- Индексы таблицы `services_category`
--
ALTER TABLE `services_category`
  ADD PRIMARY KEY (`ID_Services_category`),
  ADD KEY `ID_Services` (`ID_Services`),
  ADD KEY `ID_Category` (`ID_Category`);

--
-- Индексы таблицы `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`ID_Team`);

--
-- Индексы таблицы `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`ID_Testimonials`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_Users`),
  ADD UNIQUE KEY `Phone` (`Phone`),
  ADD KEY `ID_Access_rights` (`ID_Access_rights`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `access_rights`
--
ALTER TABLE `access_rights`
  MODIFY `ID_Access_rights` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `booking`
--
ALTER TABLE `booking`
  MODIFY `ID_Booking` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `ID_Category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `ID_Portfolio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `ID_Services` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `services_category`
--
ALTER TABLE `services_category`
  MODIFY `ID_Services_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `team`
--
ALTER TABLE `team`
  MODIFY `ID_Team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `ID_Testimonials` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID_Users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`ID_Users`) REFERENCES `users` (`ID_Users`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`ID_Services`) REFERENCES `services` (`ID_Services`);

--
-- Ограничения внешнего ключа таблицы `portfolio`
--
ALTER TABLE `portfolio`
  ADD CONSTRAINT `portfolio_ibfk_1` FOREIGN KEY (`ID_Services`) REFERENCES `services` (`ID_Services`);

--
-- Ограничения внешнего ключа таблицы `services_category`
--
ALTER TABLE `services_category`
  ADD CONSTRAINT `services_category_ibfk_1` FOREIGN KEY (`ID_Services`) REFERENCES `services` (`ID_Services`),
  ADD CONSTRAINT `services_category_ibfk_2` FOREIGN KEY (`ID_Category`) REFERENCES `category` (`ID_Category`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ID_Access_rights`) REFERENCES `access_rights` (`ID_Access_rights`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
