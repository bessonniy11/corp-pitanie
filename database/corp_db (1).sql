-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 06 2022 г., 15:10
-- Версия сервера: 5.7.33
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `corp_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `companies`
--

CREATE TABLE `companies` (
  `id` int(19) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `img` text,
  `tarif` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `companies`
--

INSERT INTO `companies` (`id`, `name`, `img`, `tarif`) VALUES
(58, 'Сбер', 'sber.png', 'Комфорт (от 350р)'),
(59, 'Копирка', 'copirkapng.png', 'Мини (от 200р)'),
(60, 'Советник', 'sovetnikpng.png', 'Мини (от 200р)'),
(61, 'Би-консталтинг', 'be-consaltpng.png', 'Стандарт (от 250р)'),
(63, 'Техстрой-Сити', 'texstroypng.png', 'Комфорт (от 350р)'),
(70, 'New-Company', 'banner-5.png', 'Комфорт (от 350)р');

-- --------------------------------------------------------

--
-- Структура таблицы `company_admins`
--

CREATE TABLE `company_admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `admin_company` varchar(255) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `admin_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `company_admins`
--

INSERT INTO `company_admins` (`admin_id`, `admin_name`, `admin_company`, `admin_password`, `admin_token`) VALUES
(30, 'Admin', 'Сбер', '$2y$10$hsK/.G.WV0H4bWl2E9vUi.1ZebWapxG0ExXK9qaJ7awnHDuzUahEW', 'Vg1adDUYji9bDQKnpScRNrtXHfiNMsdxQVo3YILNzJdPnLHmC5A5XFLnnWat9dgR'),
(35, 'Kopirka', 'Копирка', '$2y$10$VsMAljzJNeXLDHrMW1rGFuAu11ioBivZ7Zc5qheyXfwBMcPXRPAfm', 'gCYmUDwogZX6PYpZFLkTnBnoqc66hoPSgjc1lKeona1xV6fKUTdMtOA9VjjEGrYz'),
(36, 'Sovetnik', 'Советник', '$2y$10$vfh5EjDJDul4eNDOAOtVO.NjI7KTskyphch0piVVG7ZavRZU.j2Ky', 'J9moKYqqwTnMzLto4OTQfr8t7JhkUDy3MIF7JhXSMvdGj59FK4CD3A5zobbFtL63'),
(48, 'New-Company', 'New-Company', '$2y$10$hw0eWl/MTTt//JVbEpYWRuTVAP7VV2Pa0d1/o6CiUm3Plq1tefV96', '3q70k2ETHEh5PXx5lPUsIXXYQKwhwODpLo9JhJeGM1fEUnI3oXfWo3828kXejake');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_dish1` varchar(255) DEFAULT NULL,
  `order_dish2` text,
  `order_dish3` varchar(255) DEFAULT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `order_name_worker` varchar(255) DEFAULT NULL,
  `order_company` varchar(255) DEFAULT NULL,
  `order_for_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `order_dish1`, `order_dish2`, `order_dish3`, `order_date`, `order_name_worker`, `order_company`, `order_for_date`) VALUES
(92, 'Солянка', 'Капуста квашенная', 'Пюре картофельное', '12/30/2021 14:22:25', 'Иванов Иван', 'Сбер', '2022.01.01'),
(93, 'Лагман', 'Морковь \"по-корейски\"', 'Гречка', '12/30/2021 14:45:45', 'Петров Сергей', 'Копирка', '31.12.2021'),
(94, 'Солянка', 'Морковь \"по-корейски\"', 'Макароны отварные', '01/03/2022 14:49:54', 'Иванов Иван', 'Сбер', '4.1.2022'),
(95, 'Гороховый', 'Морковь \"по-корейски\"', 'Гречка', '01/03/2022 14:49:54', 'Иванов Иван', 'Сбер', '4.1.2022'),
(96, 'Куриный с лапшой', 'Морковь \"по-корейски\"', 'Рис отварной', '01/04/2022 14:24:14', 'Иванов Иван', 'Сбер', '5.1.2022'),
(97, 'Лагман', 'Греческий', 'Белая фасоль с томатами', '01/05/2022 14:20:37', 'Димитриев Николай', 'New-Company', '6.1.2022');

-- --------------------------------------------------------

--
-- Структура таблицы `selected_status`
--

CREATE TABLE `selected_status` (
  `select_id` int(11) NOT NULL,
  `select_company` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `selected_status`
--

INSERT INTO `selected_status` (`select_id`, `select_company`) VALUES
(1, 'Все');

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `worker_id` int(11) NOT NULL,
  `worker_login` varchar(255) DEFAULT NULL,
  `worker_company` varchar(255) DEFAULT NULL,
  `worker_password` varchar(255) DEFAULT NULL,
  `worker_token` varchar(255) DEFAULT NULL,
  `worker_name` text,
  `worker_phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`worker_id`, `worker_login`, `worker_company`, `worker_password`, `worker_token`, `worker_name`, `worker_phone`) VALUES
(5, 'Ivan3', 'Сбер', '$2y$10$xacawam05z1lGX9LUHeqfeRThzy.DbV6zBlgiYfSk20FEMvjQ1S/.', 'VRHRuNmeoorNgSqbcIjlo7PFQe9ja3yE5gHbZk6YsdAh703braFLFObwxqgDIn0m', 'Иванов Иван', NULL),
(6, 'art', 'Сбер', '$2y$10$zxdnmR8QSok6SgqYXILBpO0SCq8BG175WnzHbirXSFXTY74L.URKe', '3mR4jeP3idy3oSudJAhenoJX3cdPJvgscK4d9fbvwVWQedaPxMz9oA0Iot6NIYMg', 'Беглов Артём', NULL),
(8, 'ser', 'Копирка', '$2y$10$olUZiMsnA.16OmkyiVse0ORpn9G115lgVg9Xl.VKYb.kCcDDq3GRa', '5TEB9XM8XEizVSL4wL45uyWdwYbtKbCEhJI0gwxqF7wX0r3EI7S6DdRbwwQpQGlT', 'Петров Сергей', NULL),
(10, 'rumkin', 'Сбер', '$2y$10$dOHtKBX.slhlVa..ts9lwuVEhvrYgkh0m9CG9G2nUKOKu/78DMZBW', '3BpZBsoqxNsEPaakwV28j4eA7Z4gGfeMJ9LCAZtpmF0sjNbUv3t9R3H19F5Zee23', 'Роман Рюмкин', '+7 (999) 999-99-99'),
(12, 'Sergey', 'Сбер', '$2y$10$fm9bYNjumi/v76tbQop9SO.rDumhGNLHu2DMgh.q84asPVLpk4TIa', 'MC4uz3E1rmWXxRZQ1DD1pMa4zqI150Sw4f4rFLVif5gx7sE6Rs4zAAEor9bjfELY', 'Петров Сергей', '+7 (999) 999-99-99'),
(17, 'Nikolay', 'New-Company', '$2y$10$n55I3XMoAqhZqpj1zakZGOyNWZfiJQWwhWpGbMBGcdNll5ZwOn4n2', 'm6xLBBSxvAus8oAaDGnM085CE9lbDoxXKacIvg9Q26fluBBBS6sSbHtUJfLPoHbd', 'Димитриев Николай', '+7 (999) 999-99-99');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `company_admins`
--
ALTER TABLE `company_admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_name` (`admin_company`),
  ADD UNIQUE KEY `admin_password` (`admin_password`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `selected_status`
--
ALTER TABLE `selected_status`
  ADD PRIMARY KEY (`select_id`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`worker_id`),
  ADD UNIQUE KEY `worker_login` (`worker_login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT для таблицы `company_admins`
--
ALTER TABLE `company_admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT для таблицы `selected_status`
--
ALTER TABLE `selected_status`
  MODIFY `select_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `worker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
