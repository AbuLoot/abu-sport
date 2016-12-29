

-- Countries
INSERT INTO `countries` (`sort_id`, `slug`, `title`, `lang`) VALUES
(1, 'kazakhstan', 'Казахстан', 'ru');


-- Cities
INSERT INTO `cities` (`sort_id`, `country_id`, `slug`, `title`, `lang`) VALUES
(1, 1, 'almaty', 'Алматы', 'ru'),
(2, 1, 'astana', 'Астана', 'ru'),
(3, 1, 'aktau', 'Актау', 'ru'),
(4, 1, 'aktobe', 'Актобе', 'ru'),
(5, 1, 'atyrau', 'Атырау', 'ru'),
(6, 1, 'zhezkazgan', 'Жезказган', 'ru'),
(7, 1, 'karaganda', 'Караганда', 'ru'),
(8, 1, 'kokshetau', 'Кокшетау', 'ru'),
(9, 1, 'kostanay', 'Костанай', 'ru'),
(10, 1, 'kyzylorda', 'Кызылорда', 'ru'),
(11, 1, 'pavlodar', 'Павлодар', 'ru'),
(12, 1, 'petropavlovsk', 'Петропавловск', 'ru'),
(13, 1, 'semey', 'Семей', 'ru'),
(14, 1, 'taldykorgan', 'Талдыкорган', 'ru'),
(15, 1, 'taraz', 'Тараз', 'ru'),
(16, 1, 'temirtau', 'Темиртау', 'ru'),
(17, 1, 'uralsk', 'Уральск', 'ru'),
(18, 1, 'ust-kamenogorsk', 'Усть-Каменогорск', 'ru'),
(19, 1, 'shymkent', 'Шымкент', 'ru'),
(20, 1, 'ekibastuz', 'Экибастуз', 'ru');


-- Districts
INSERT INTO `districts` (`sort_id`, `city_id`, `slug`, `title`, `lang`) VALUES
(1, 1, 'alatauskij', 'Алатауский район', 'ru'),
(2, 1, 'almalinskij', 'Алмалинский район', 'ru'),
(3, 1, 'aujezovskij', 'Ауэзовский район', 'ru'),
(4, 1, 'bostandykskij', 'Бостандыкский район', 'ru'),
(5, 1, 'zhetysuskij', 'Жетысуский район', 'ru'),
(6, 1, 'medeuskij', 'Медеуский район', 'ru'),
(7, 1, 'nauryzbajskiy', 'Наурызбайский район', 'ru'),
(8, 1, 'turksibskij', 'Турксибский район', 'ru');



-- Sports
INSERT INTO `sports` (`sort_id`, `slug`, `title`, `image`, `lang`) VALUES
(1, 'football', 'Футбол', 'football.jpg', 'ru'),
(2, 'basketball', 'Баскетбол', 'basketball.jpg', 'ru'),
(3, 'volleyball', 'Волейбол', 'volleyball.jpg', 'ru'),
(4, 'paintball', 'Пейнтбол', 'paintball.jpg', 'ru'),
(5, 'hockey', 'Хоккей', 'hockey.jpg', 'ru'),
(6, 'tennis', 'Теннис', 'tennis.jpg', 'ru'),
(7, 'table-tennis', 'Настольный теннис', 'table-tennis.jpg', 'ru'),
(8, 'golf', 'Гольф', 'golf.jpg', 'ru');


-- Roles
INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'root', 'Root Administrator', '2016-09-15 05:50:57', '2016-09-15 05:50:57'),
(2, 'admin', 'App Administrator', '2016-09-15 05:53:04', '2016-09-15 05:53:04'),
(3, 'user', 'User Application', '2016-09-15 05:53:41', '2016-09-15 05:53:41'),
(4, 'quest', 'Quest Application', '2016-09-15 05:53:55', '2016-09-15 05:53:55'),
(5, 'area-admin', 'Area Administrator', '2016-09-15 05:54:55', '2016-09-15 05:54:55');


-- Organization types
INSERT INTO `org_types` (`slug`, `title`, `short_title`) VALUES
('tovarishchestvo-s-ogranichennoy-otvetstvennostyu', 'Товарищество с ограниченной ответственностью', 'ТОО'),
('individualnoe-predprinimatelstvo', 'Индивидуальное предпринимательство', 'ИП'),
('tovarishchestvo-s-dopolnitelnoy-otvetstvennostyu', 'Товарищество с дополнительной ответственностью', 'ТДО'),
('gos-predpriyatie', 'Гос предприятие', 'ГП'),
('gos-predpriyatie-na-prave-khozyaystvennogo-vedeniya', 'Гос предприятие на праве хозяйственного ведения', 'ГПНПХВ'),
('gos-predpriyatie-na-prave-operativnogo-upravleniya', 'Гос предприятие на праве оперативного управления', 'ГПНПОУ'),
('khozyaystvennoe-tovarishchestvo', 'Хозяйственное товарищество', 'ХТ'),
('polnoe-tovarishchestvo', 'Полное товарищество', 'ПТ'),
('kommanditnoe-tovarishchestvo', 'Коммандитное товарищество', 'КТ'),
('aktsionernoe-obshchestvo', 'Акционерное общество', 'АО'),
('drugaya-organizatsionno-pravovye-forma', 'Другая организационно-правовые форма', 'ДОПФ'),
('proizvodstvennyy-kooperativ', 'Производственный кооператив', 'ПК'),
('uchrezhdenie', 'Учреждение', 'У'),
('obshchestvennoe-obedinenie', 'Общественное объединение', 'ОУ'),
('potrebitelskiy-kooperativ', 'Потребительский кооператив', 'ПК'),
('fond', 'Фонд', 'Ф'),
('religioznoe-obedinenie', 'Религиозное объединение', 'РО'),
('obedinenie-yuridicheskikh-lits-v-forme-assotsiatsii', 'Объединение юридических лиц в форме ассоциации', 'ОЮЛВФА'),
('selskokhozyaystvennoe-tovarishchestvo', 'Сельскохозяйственное товарищество', 'СТ'),
('lichnoe-predprinimatelstvo', 'Личное предпринимательство', 'ЛП'),
('individualnoe-pr-vo-na-osnove-sovmestnogo-pr-va', 'Индивидуальное пр-во на основе совместного пр-ва', 'ИПНОСП'),
('prostoe-tovarishchestvo', 'Простое товарищество', 'ПП'),
('predprinimatelstvo-suprugov', 'Предпринимательство супругов', 'ПС'),
('semeynoe-predprinimatelstvo', 'Семейное предпринимательство', 'СП'),
('inaya-forma-nekommercheskoy-organizatsii', 'Иная форма некоммерческой организации', 'ИОПФНО');


INSERT INTO `organizations` (`id`, `sort_id`, `country_id`, `city_id`, `district_id`, `org_type_id`, `slug`, `title`, `logo`, `phones`, `website`, `emails`, `address`, `latitude`, `longitude`, `balance`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 1, 'company', 'Company', 'dFdTmjN.jpg', '', '', '', '', '43.238286', '76.945456', '0', '', 1, '2016-09-15 06:54:23', '2016-09-15 06:54:23');


INSERT INTO `areas` (`id`, `sort_id`, `sport_id`, `org_id`, `city_id`, `district_id`, `slug`, `title`, `image`, `images`, `phones`, `emails`, `address`, `description`, `latitude`, `longitude`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 0, 'area-1', 'Area 1', 'preview-image-jJZCZOGjth.jpg', '', '', '', 'Сатпаев 22', '', '43.237065', '76.931344', '', 1, '2016-09-15 06:54:48', '2016-09-23 16:16:12');


INSERT INTO `options` (`id`, `sort_id`, `slug`, `title`, `lang`, `created_at`, `updated_at`) VALUES
(1, 1, 'option-1', 'Option 1', '', '2016-09-15 06:52:41', '2016-09-15 06:52:41'),
(2, 2, 'option-2', 'Option 2', '', '2016-09-15 06:52:48', '2016-09-15 06:52:48'),
(3, 3, 'option-3', 'Option 3', '', '2016-09-19 05:45:06', '2016-09-19 05:45:06'),
(4, 4, 'option-4', 'Option 4', '', '2016-09-19 05:45:12', '2016-09-19 05:45:12'),
(5, 5, 'option-5', 'Option 5', '', '2016-09-19 05:45:18', '2016-09-19 05:45:18');


INSERT INTO `fields` (`id`, `sort_id`, `area_id`, `title`, `size`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Filed 1', '20x20', '', 1, '2016-09-15 06:55:08', '2016-09-19 15:15:18');


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
