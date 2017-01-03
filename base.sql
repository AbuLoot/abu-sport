-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 25 2016 г., 11:04
-- Версия сервера: 5.7.15-0ubuntu0.16.04.1
-- Версия PHP: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `abusport`
--

-- --------------------------------------------------------

--
-- Структура таблицы `areas`
--

CREATE TABLE `areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `sport_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `images` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phones` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emails` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `areas`
--

INSERT INTO `areas` (`id`, `sort_id`, `sport_id`, `org_id`, `city_id`, `district_id`, `slug`, `title`, `image`, `images`, `phones`, `emails`, `address`, `description`, `latitude`, `longitude`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 0, 'area-1', 'Area 1', 'preview-image-jJZCZOGjth.jpg', '', '', '', 'Сатпаев 22', '', '43.237065', '76.931344', '', 1, '2016-09-15 06:54:48', '2016-09-23 16:16:12');

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `sort_id`, `country_id`, `slug`, `title`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'almaty', 'Алматы', 'ru', 1, NULL, NULL),
(2, 2, 1, 'astana', 'Астана', 'ru', 1, NULL, NULL),
(3, 3, 1, 'aktau', 'Актау', 'ru', 1, NULL, NULL),
(4, 4, 1, 'aktobe', 'Актобе', 'ru', 1, NULL, NULL),
(5, 5, 1, 'atyrau', 'Атырау', 'ru', 1, NULL, NULL),
(6, 6, 1, 'zhezkazgan', 'Жезказган', 'ru', 1, NULL, NULL),
(7, 7, 1, 'karaganda', 'Караганда', 'ru', 1, NULL, NULL),
(8, 8, 1, 'kokshetau', 'Кокшетау', 'ru', 1, NULL, NULL),
(9, 9, 1, 'kostanay', 'Костанай', 'ru', 1, NULL, NULL),
(10, 10, 1, 'kyzylorda', 'Кызылорда', 'ru', 1, NULL, NULL),
(11, 11, 1, 'pavlodar', 'Павлодар', 'ru', 1, NULL, NULL),
(12, 12, 1, 'petropavlovsk', 'Петропавловск', 'ru', 1, NULL, NULL),
(13, 13, 1, 'semey', 'Семей', 'ru', 1, NULL, NULL),
(14, 14, 1, 'taldykorgan', 'Талдыкорган', 'ru', 1, NULL, NULL),
(15, 15, 1, 'taraz', 'Тараз', 'ru', 1, NULL, NULL),
(16, 16, 1, 'temirtau', 'Темиртау', 'ru', 1, NULL, NULL),
(17, 17, 1, 'uralsk', 'Уральск', 'ru', 1, NULL, NULL),
(18, 18, 1, 'ust-kamenogorsk', 'Усть-Каменогорск', 'ru', 1, NULL, NULL),
(19, 19, 1, 'shymkent', 'Шымкент', 'ru', 1, NULL, NULL),
(20, 20, 1, 'ekibastuz', 'Экибастуз', 'ru', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `sort_id`, `slug`, `title`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'kazakhstan', 'Казахстан', 'ru', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `districts`
--

CREATE TABLE `districts` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `districts`
--

INSERT INTO `districts` (`id`, `sort_id`, `city_id`, `slug`, `title`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'alatauskij', 'Алатауский район', 'ru', 1, NULL, NULL),
(2, 2, 1, 'almalinskij', 'Алмалинский район', 'ru', 1, NULL, NULL),
(3, 3, 1, 'aujezovskij', 'Ауэзовский район', 'ru', 1, NULL, NULL),
(4, 4, 1, 'bostandykskij', 'Бостандыкский район', 'ru', 1, NULL, NULL),
(5, 5, 1, 'zhetysuskij', 'Жетысуский район', 'ru', 1, NULL, NULL),
(6, 6, 1, 'medeuskij', 'Медеуский район', 'ru', 1, NULL, NULL),
(7, 7, 1, 'nauryzbajskiy', 'Наурызбайский район', 'ru', 1, NULL, NULL),
(8, 8, 1, 'turksibskij', 'Турксибский район', 'ru', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `fields`
--

CREATE TABLE `fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `area_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `fields`
--

INSERT INTO `fields` (`id`, `sort_id`, `area_id`, `title`, `size`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Filed 1', '20x20', '', 1, '2016-09-15 06:55:08', '2016-09-19 15:15:18');

-- --------------------------------------------------------

--
-- Структура таблицы `field_option`
--

CREATE TABLE `field_option` (
  `field_id` int(10) UNSIGNED NOT NULL,
  `option_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `field_option`
--

INSERT INTO `field_option` (`field_id`, `option_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

CREATE TABLE `friends` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `accepted` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `accepted`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 0, NULL, NULL),
(2, 1, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `matches`
--

CREATE TABLE `matches` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `start_time` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `end_time` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `match_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `game_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number_of_players` int(11) NOT NULL,
  `game_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `matches`
--

INSERT INTO `matches` (`id`, `sort_id`, `user_id`, `field_id`, `start_time`, `end_time`, `date`, `match_type`, `game_type`, `number_of_players`, `game_format`, `price`, `description`, `status`, `created_at`, `updated_at`) VALUES
(4, NULL, 1, 1, '06:00', '07:00', '2016-09-22', 'on', '', 10, '', 0, '', 1, '2016-09-21 19:44:46', '2016-09-21 19:44:46'),
(5, NULL, 1, 1, '10:00', '11:00', '2016-09-22', 'on', '', 10, '', 0, '', 1, '2016-09-21 19:45:14', '2016-09-21 19:45:14'),
(6, NULL, 1, 1, '15:00', '18:00', '2016-09-22', 'on', '', 10, '', 0, '', 1, '2016-09-21 19:49:06', '2016-09-21 19:49:06'),
(7, NULL, 1, 1, '22:00', '22:00', '2016-09-22', 'on', '', 10, '', 0, '', 1, '2016-09-22 09:07:53', '2016-09-22 09:07:53'),
(9, NULL, 1, 1, '16:00', '17:00', '2016-09-23', 'on', '', 10, '', 0, '', 1, '2016-09-23 06:51:41', '2016-09-23 06:51:41'),
(10, NULL, 1, 1, '20:00', '21:00', '2016-09-23', 'on', '', 10, '', 0, '', 1, '2016-09-23 06:51:51', '2016-09-23 06:51:51'),
(11, NULL, 1, 1, '07:00', '09:00', '2016-09-23', 'on', '', 10, '', 0, '', 1, '2016-09-23 07:06:56', '2016-09-23 07:06:56'),
(13, NULL, 1, 1, '21:00', '22:00', '2016-09-24', 'on', '', 10, '', 0, '', 1, '2016-09-24 12:12:20', '2016-09-24 12:12:20'),
(14, NULL, 1, 1, '18:00', '21:00', '2016-09-25', 'on', '', 10, '', 0, '', 1, '2016-09-24 12:24:40', '2016-09-24 12:24:40'),
(15, NULL, 1, 1, '17:00', '19:00', '2016-09-26', 'on', '', 10, '', 0, '', 1, '2016-09-24 13:57:40', '2016-09-24 13:57:40'),
(16, NULL, 1, 1, '23:00', '23:00', '2016-09-24', 'on', '', 10, '', 0, '', 1, '2016-09-24 16:12:13', '2016-09-24 16:12:13'),
(17, NULL, 1, 1, '22:00', '23:00', '2016-09-25', 'on', '', 10, '', 0, '', 1, '2016-09-24 16:23:48', '2016-09-24 16:23:48');

-- --------------------------------------------------------

--
-- Структура таблицы `match_user`
--

CREATE TABLE `match_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_08_13_120910_create_countries_table', 1),
('2016_08_13_120920_create_cities_table', 1),
('2016_08_13_120933_create_districts_table', 1),
('2016_08_13_121014_create_profiles_table', 1),
('2016_08_13_121033_create_pages_table', 1),
('2016_08_13_121051_create_organizations_table', 1),
('2016_08_13_132136_create_sports_table', 1),
('2016_08_13_132145_create_areas_table', 1),
('2016_08_13_132333_create_matches_table', 1),
('2016_08_13_132553_create_match_user_table', 1),
('2016_08_19_104747_create_fields_table', 1),
('2016_08_19_115321_create_schedules_table', 1),
('2016_08_22_051426_create_roles_table', 1),
('2016_08_31_093121_create_sms_table', 1),
('2016_09_14_104701_create_friends_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `options`
--

CREATE TABLE `options` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `options`
--

INSERT INTO `options` (`id`, `sort_id`, `slug`, `title`, `lang`, `created_at`, `updated_at`) VALUES
(1, 1, 'option-1', 'Option 1', '', '2016-09-15 06:52:41', '2016-09-15 06:52:41'),
(2, 2, 'option-2', 'Option 2', '', '2016-09-15 06:52:48', '2016-09-15 06:52:48'),
(3, 3, 'option-3', 'Option 3', '', '2016-09-19 05:45:06', '2016-09-19 05:45:06'),
(4, 4, 'option-4', 'Option 4', '', '2016-09-19 05:45:12', '2016-09-19 05:45:12'),
(5, 5, 'option-5', 'Option 5', '', '2016-09-19 05:45:18', '2016-09-19 05:45:18');

-- --------------------------------------------------------

--
-- Структура таблицы `organizations`
--

CREATE TABLE `organizations` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `org_type_id` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phones` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emails` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `organizations`
--

INSERT INTO `organizations` (`id`, `sort_id`, `country_id`, `city_id`, `district_id`, `org_type_id`, `slug`, `title`, `logo`, `phones`, `website`, `emails`, `address`, `latitude`, `longitude`, `balance`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 1, 'company', 'Company', 'dFdTmjN.jpg', '', '', '', '', '43.238286', '76.945456', '0', '', 1, '2016-09-15 06:54:23', '2016-09-15 06:54:23');

-- --------------------------------------------------------

--
-- Структура таблицы `org_types`
--

CREATE TABLE `org_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `org_types`
--

INSERT INTO `org_types` (`id`, `sort_id`, `slug`, `title`, `short_title`, `lang`, `created_at`, `updated_at`) VALUES
(1, NULL, 'tovarishchestvo-s-ogranichennoy-otvetstvennostyu', 'Товарищество с ограниченной ответственностью', 'ТОО', NULL, NULL, NULL),
(2, NULL, 'individualnoe-predprinimatelstvo', 'Индивидуальное предпринимательство', 'ИП', NULL, NULL, NULL),
(3, NULL, 'tovarishchestvo-s-dopolnitelnoy-otvetstvennostyu', 'Товарищество с дополнительной ответственностью', 'ТДО', NULL, NULL, NULL),
(4, NULL, 'gos-predpriyatie', 'Гос предприятие', 'ГП', NULL, NULL, NULL),
(5, NULL, 'gos-predpriyatie-na-prave-khozyaystvennogo-vedeniya', 'Гос предприятие на праве хозяйственного ведения', 'ГПНПХВ', NULL, NULL, NULL),
(6, NULL, 'gos-predpriyatie-na-prave-operativnogo-upravleniya', 'Гос предприятие на праве оперативного управления', 'ГПНПОУ', NULL, NULL, NULL),
(7, NULL, 'khozyaystvennoe-tovarishchestvo', 'Хозяйственное товарищество', 'ХТ', NULL, NULL, NULL),
(8, NULL, 'polnoe-tovarishchestvo', 'Полное товарищество', 'ПТ', NULL, NULL, NULL),
(9, NULL, 'kommanditnoe-tovarishchestvo', 'Коммандитное товарищество', 'КТ', NULL, NULL, NULL),
(10, NULL, 'aktsionernoe-obshchestvo', 'Акционерное общество', 'АО', NULL, NULL, NULL),
(11, NULL, 'drugaya-organizatsionno-pravovye-forma', 'Другая организационно-правовые форма', 'ДОПФ', NULL, NULL, NULL),
(12, NULL, 'proizvodstvennyy-kooperativ', 'Производственный кооператив', 'ПК', NULL, NULL, NULL),
(13, NULL, 'uchrezhdenie', 'Учреждение', 'У', NULL, NULL, NULL),
(14, NULL, 'obshchestvennoe-obedinenie', 'Общественное объединение', 'ОУ', NULL, NULL, NULL),
(15, NULL, 'potrebitelskiy-kooperativ', 'Потребительский кооператив', 'ПК', NULL, NULL, NULL),
(16, NULL, 'fond', 'Фонд', 'Ф', NULL, NULL, NULL),
(17, NULL, 'religioznoe-obedinenie', 'Религиозное объединение', 'РО', NULL, NULL, NULL),
(18, NULL, 'obedinenie-yuridicheskikh-lits-v-forme-assotsiatsii', 'Объединение юридических лиц в форме ассоциации', 'ОЮЛВФА', NULL, NULL, NULL),
(19, NULL, 'selskokhozyaystvennoe-tovarishchestvo', 'Сельскохозяйственное товарищество', 'СТ', NULL, NULL, NULL),
(20, NULL, 'lichnoe-predprinimatelstvo', 'Личное предпринимательство', 'ЛП', NULL, NULL, NULL),
(21, NULL, 'individualnoe-pr-vo-na-osnove-sovmestnogo-pr-va', 'Индивидуальное пр-во на основе совместного пр-ва', 'ИПНОСП', NULL, NULL, NULL),
(22, NULL, 'prostoe-tovarishchestvo', 'Простое товарищество', 'ПП', NULL, NULL, NULL),
(23, NULL, 'predprinimatelstvo-suprugov', 'Предпринимательство супругов', 'ПС', NULL, NULL, NULL),
(24, NULL, 'semeynoe-predprinimatelstvo', 'Семейное предпринимательство', 'СП', NULL, NULL, NULL),
(25, NULL, 'inaya-forma-nekommercheskoy-organizatsii', 'Иная форма некоммерческой организации', 'ИОПФНО', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `org_user`
--

CREATE TABLE `org_user` (
  `org_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `profiles`
--

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `growth` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `sex` enum('man','woman') COLLATE utf8_unicode_ci NOT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `profiles`
--

INSERT INTO `profiles` (`id`, `sort_id`, `user_id`, `city_id`, `avatar`, `phone`, `birthday`, `growth`, `weight`, `sex`, `about`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '', '77078875631', '0000-00-00', 0, 0, 'man', '', 1, '2016-09-15 05:42:14', '2016-09-16 03:53:18'),
(2, 2, 2, 1, '', '77078875632', '0000-00-00', 0, 0, 'man', '', 1, '2016-09-15 06:31:12', '2016-09-16 00:16:55');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'root', 'Root Administrator', '2016-09-15 05:50:57', '2016-09-15 05:50:57'),
(2, 'admin', 'App Administrator', '2016-09-15 05:53:04', '2016-09-15 05:53:04'),
(3, 'user', 'User Application', '2016-09-15 05:53:41', '2016-09-15 05:53:41'),
(4, 'quest', 'Quest Application', '2016-09-15 05:53:55', '2016-09-15 05:53:55'),
(5, 'area-admin', 'Area Administrator', '2016-09-15 05:54:55', '2016-09-15 05:54:55');

-- --------------------------------------------------------

--
-- Структура таблицы `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`) VALUES
(1, 1),
(2, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `schedules`
--

CREATE TABLE `schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `field_id` int(10) UNSIGNED NOT NULL,
  `start_time` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `end_time` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `week` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `schedules`
--

INSERT INTO `schedules` (`id`, `sort_id`, `field_id`, `start_time`, `end_time`, `date`, `week`, `price`, `status`, `created_at`, `updated_at`) VALUES
(8, 1, 1, '00:00', '05:00', '0000-00-00', 1, 3000, 1, '2016-09-19 15:55:25', '2016-09-20 13:26:17'),
(9, 2, 1, '06:00', '17:00', '0000-00-00', 1, 4000, 1, '2016-09-19 15:55:46', '2016-09-20 13:25:00'),
(10, 3, 1, '18:00', '23:00', '0000-00-00', 1, 5000, 1, '2016-09-19 15:56:19', '2016-09-20 13:25:08'),
(12, 5, 1, '00:00', '05:00', '0000-00-00', 2, 2000, 1, '2016-09-20 14:10:45', '2016-09-20 15:07:39'),
(13, 6, 1, '06:00', '17:00', '0000-00-00', 2, 4000, 1, '2016-09-20 14:11:00', '2016-09-20 14:41:33'),
(14, 7, 1, '18:00', '23:00', '0000-00-00', 2, 5000, 1, '2016-09-20 14:11:19', '2016-09-20 14:11:19'),
(15, 8, 1, '00:00', '23:00', '0000-00-00', 3, 4000, 1, '2016-09-21 08:43:00', '2016-09-21 08:43:00'),
(16, 9, 1, '00:00', '12:00', '0000-00-00', 4, 3000, 1, '2016-09-21 18:48:16', '2016-09-21 18:48:16'),
(17, 10, 1, '13:00', '23:00', '0000-00-00', 4, 5000, 1, '2016-09-21 18:48:31', '2016-09-21 18:48:31'),
(18, 10, 1, '00:00', '23:00', '0000-00-00', 5, 5000, 1, '2016-09-22 09:24:26', '2016-09-22 09:24:26'),
(19, 11, 1, '00:00', '23:00', '0000-00-00', 6, 6000, 1, '2016-09-22 09:24:45', '2016-09-22 09:24:45'),
(20, 12, 1, '00:00', '23:00', '0000-00-00', 0, 7000, 1, '2016-09-22 09:24:57', '2016-09-22 09:24:57');

-- --------------------------------------------------------

--
-- Структура таблицы `sms`
--

CREATE TABLE `sms` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `sms`
--

INSERT INTO `sms` (`id`, `user_id`, `phone`, `code`, `created_at`, `updated_at`) VALUES
(1, 1, '77078875631', 34359, '2016-09-15 05:42:14', '2016-09-15 05:42:14'),
(2, 2, '77078875632', 47672, '2016-09-15 06:31:12', '2016-09-15 06:31:12');

-- --------------------------------------------------------

--
-- Структура таблицы `sports`
--

CREATE TABLE `sports` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `rules` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `sports`
--

INSERT INTO `sports` (`id`, `sort_id`, `slug`, `title`, `image`, `title_description`, `meta_description`, `description`, `content`, `rules`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'football', 'Футбол', 'football.jpg', '', '', '', '', '', '', 1, '2016-09-15 06:53:43', '2016-09-16 00:18:06'),
(2, 2, 'basketbol', 'Баскетбол', 'basketball.jpg', '', '', '', '', '', '', 1, '2016-09-16 00:17:59', '2016-09-16 00:17:59'),
(3, 3, 'volleybol', 'Волейбол', 'volleyball.jpg', '', '', '', '', '', '', 1, '2016-09-16 00:54:33', '2016-09-16 00:54:52'),
(4, 4, 'paintball', 'Пэйнтбол', 'paintball.jpg', '', '', '', '', '', '', 1, '2016-09-16 00:59:27', '2016-09-16 00:59:27'),
(5, 5, 'hockey', 'Хоккей', 'hockey.jpg', '', '', '', '', '', '', 1, '2016-09-16 01:02:45', '2016-09-16 01:02:45'),
(6, 6, 'tennis', 'Теннис', 'tennis.jpg', '', '', '', '', '', '', 1, '2016-09-16 03:02:26', '2016-09-20 16:50:26'),
(7, 7, 'table-tennis', 'Настольный теннис', 'pingpong.jpg', '', '', '', '', '', '', 1, '2016-09-16 03:07:08', '2016-09-16 03:07:08'),
(8, 8, 'golf', 'Гольф', 'golf.jpg', '', '', '', '', '', '', 1, '2016-09-16 03:10:37', '2016-09-16 03:10:37');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `sort_id`, `surname`, `name`, `phone`, `email`, `password`, `ip`, `location`, `balance`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 3, 'Issayev', 'Adilet', '77078875631', 'is.adilet@mail.ru', '$2y$10$yR.J7tm0mr0P6sDGy5pzaudG4yaw3FrQpDqJtu3gS4LR46yOe6.1C', '127.0.0.1', 'a:1:{i:0;s:9:"127.0.0.1";}', '', 1, 'TXLfMJE2nio5qc9hpZYbv6pyCtz0pOjQPciruDwrCB9aWkArBJwCV39YGSJB', '2016-09-15 05:42:14', '2016-09-15 10:47:36'),
(2, 3, 'Qanai', 'Batyr', '77078875632', 'qanai@batyr.kz', '$2y$10$W7T8BGxC3P12/SAAIeHm0.W8GcRUonnaR9gTwFu/FSQyWa8xtUFWq', '127.0.0.1', 'a:1:{i:0;s:9:"127.0.0.1";}', '', 1, 'rDeOUOaTNp2SEeTZkVer0dI4GIw0vOQV5IFHXRokmH3dGjI0VpgAsEAsMzjd', '2016-09-15 06:31:12', '2016-09-16 00:16:30');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_city_id_foreign` (`city_id`);

--
-- Индексы таблицы `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fields_area_id_foreign` (`area_id`);

--
-- Индексы таблицы `field_option`
--
ALTER TABLE `field_option`
  ADD PRIMARY KEY (`field_id`,`option_id`),
  ADD KEY `field_option_option_id_foreign` (`option_id`);

--
-- Индексы таблицы `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `match_user`
--
ALTER TABLE `match_user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `org_types`
--
ALTER TABLE `org_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `org_user`
--
ALTER TABLE `org_user`
  ADD PRIMARY KEY (`org_id`,`user_id`),
  ADD KEY `org_user_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Индексы таблицы `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Индексы таблицы `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_field_id_foreign` (`field_id`);

--
-- Индексы таблицы `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблицы `match_user`
--
ALTER TABLE `match_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `options`
--
ALTER TABLE `options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `org_types`
--
ALTER TABLE `org_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT для таблицы `sms`
--
ALTER TABLE `sms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `sports`
--
ALTER TABLE `sports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Ограничения внешнего ключа таблицы `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Ограничения внешнего ключа таблицы `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `field_option`
--
ALTER TABLE `field_option`
  ADD CONSTRAINT `field_option_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `fields` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `field_option_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `org_user`
--
ALTER TABLE `org_user`
  ADD CONSTRAINT `org_user_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `org_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `fields` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
