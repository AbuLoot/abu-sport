
INSERT INTO `countries` (`id`, `sort_id`, `slug`, `title`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'kazakhstan', 'Казахстан', 'ru', 1, NULL, NULL);

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

INSERT INTO `districts` (`id`, `sort_id`, `city_id`, `slug`, `title`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'alatauskij', 'Алатауский район', 'ru', 1, NULL, NULL),
(2, 2, 1, 'almalinskij', 'Алмалинский район', 'ru', 1, NULL, NULL),
(3, 3, 1, 'aujezovskij', 'Ауэзовский район', 'ru', 1, NULL, NULL),
(4, 4, 1, 'bostandykskij', 'Бостандыкский район', 'ru', 1, NULL, NULL),
(5, 5, 1, 'zhetysuskij', 'Жетысуский район', 'ru', 1, NULL, NULL),
(6, 6, 1, 'medeuskij', 'Медеуский район', 'ru', 1, NULL, NULL),
(7, 7, 1, 'nauryzbajskiy', 'Наурызбайский район', 'ru', 1, NULL, NULL),
(8, 8, 1, 'turksibskij', 'Турксибский район', 'ru', 1, NULL, NULL);

------------------

INSERT INTO `users` (`id`, `sort_id`, `surname`, `name`, `phone`, `email`, `password`, `ip`, `location`, `balance`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 3, 'Issayev', 'Adilet', '77078875631', 'is.adilet@mail.ru', '$2y$10$yR.J7tm0mr0P6sDGy5pzaudG4yaw3FrQpDqJtu3gS4LR46yOe6.1C', '127.0.0.1', 'a:1:{i:0;s:9:"127.0.0.1";}', '', 1, 'TXLfMJE2nio5qc9hpZYbv6pyCtz0pOjQPciruDwrCB9aWkArBJwCV39YGSJB', '2016-09-15 05:42:14', '2016-09-15 10:47:36'),
(2, 3, 'Qanai', 'Batyr', '77078875632', 'qanai@batyr.kz', '$2y$10$W7T8BGxC3P12/SAAIeHm0.W8GcRUonnaR9gTwFu/FSQyWa8xtUFWq', '127.0.0.1', 'a:1:{i:0;s:9:"127.0.0.1";}', '', 1, 'rDeOUOaTNp2SEeTZkVer0dI4GIw0vOQV5IFHXRokmH3dGjI0VpgAsEAsMzjd', '2016-09-15 06:31:12', '2016-09-16 00:16:30');

INSERT INTO `profiles` (`id`, `sort_id`, `user_id`, `city_id`, `avatar`, `phone`, `birthday`, `growth`, `weight`, `sex`, `about`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '', '77078875631', '2016-09-16', 0, 0, 'man', '', 1, '2016-09-15 05:42:14', '2016-09-16 03:53:18'),
(2, 2, 2, 1, '', '77078875632', '2016-09-16', 0, 0, 'man', '', 1, '2016-09-15 06:31:12', '2016-09-16 00:16:55');

INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'root', 'Root Administrator', '2016-09-15 05:50:57', '2016-09-15 05:50:57'),
(2, 'admin', 'App Administrator', '2016-09-15 05:53:04', '2016-09-15 05:53:04'),
(3, 'user', 'User Application', '2016-09-15 05:53:41', '2016-09-15 05:53:41'),
(4, 'quest', 'Quest Application', '2016-09-15 05:53:55', '2016-09-15 05:53:55'),
(5, 'area-admin', 'Area Administrator', '2016-09-15 05:54:55', '2016-09-15 05:54:55');

INSERT INTO `role_user` (`role_id`, `user_id`) VALUES
(1, 1),
(2, 1),
(3, 2);

INSERT INTO `sms` (`id`, `user_id`, `phone`, `code`, `created_at`, `updated_at`) VALUES
(1, 1, '77078875631', 34359, '2016-09-15 05:42:14', '2016-09-15 05:42:14'),
(2, 2, '77078875632', 47672, '2016-09-15 06:31:12', '2016-09-15 06:31:12');

------------------

INSERT INTO `sports` (`id`, `sort_id`, `slug`, `title`, `image`, `title_description`, `meta_description`, `description`, `content`, `rules`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'football', 'Футбол', 'football.jpg', '', '', '', '', '', '', 1, '2016-09-15 06:53:43', '2016-09-16 00:18:06'),
(2, 2, 'basketbol', 'Баскетбол', 'basketball.jpg', '', '', '', '', '', '', 1, '2016-09-16 00:17:59', '2016-09-16 00:17:59'),
(3, 3, 'volleybol', 'Волейбол', 'volleyball.jpg', '', '', '', '', '', '', 1, '2016-09-16 00:54:33', '2016-09-16 00:54:52'),
(4, 4, 'paintball', 'Пэйнтбол', 'paintball.jpg', '', '', '', '', '', '', 1, '2016-09-16 00:59:27', '2016-09-16 00:59:27'),
(5, 5, 'hockey', 'Хоккей', 'hockey.jpg', '', '', '', '', '', '', 1, '2016-09-16 01:02:45', '2016-09-16 01:02:45'),
(6, 6, 'tennis', 'Теннис', 'tennis.jpg', '', '', '', '', '', '', 1, '2016-09-16 03:02:26', '2016-09-20 16:50:26'),
(7, 7, 'table-tennis', 'Настольный теннис', 'pingpong.jpg', '', '', '', '', '', '', 1, '2016-09-16 03:07:08', '2016-09-16 03:07:08'),
(8, 8, 'golf', 'Гольф', 'golf.jpg', '', '', '', '', '', '', 1, '2016-09-16 03:10:37', '2016-09-16 03:10:37');

INSERT INTO `org_types` (`id`, `sort_id`, `slug`, `title`, `short_title`, `lang`, `created_at`, `updated_at`) VALUES
(1, NULL, 'tovarishchestvo-s-ogranichennoy-otvetstvennostyu', 'Товарищество с ограниченной ответственностью', 'ТОО', 'ru', NULL, NULL),
(2, NULL, 'individualnoe-predprinimatelstvo', 'Индивидуальное предпринимательство', 'ИП', 'ru', NULL, NULL),
(3, NULL, 'tovarishchestvo-s-dopolnitelnoy-otvetstvennostyu', 'Товарищество с дополнительной ответственностью', 'ТДО', 'ru', NULL, NULL),
(4, NULL, 'gos-predpriyatie', 'Гос предприятие', 'ГП', 'ru', NULL, NULL),
(5, NULL, 'gos-predpriyatie-na-prave-khozyaystvennogo-vedeniya', 'Гос предприятие на праве хозяйственного ведения', 'ГПНПХВ', 'ru', NULL, NULL),
(6, NULL, 'gos-predpriyatie-na-prave-operativnogo-upravleniya', 'Гос предприятие на праве оперативного управления', 'ГПНПОУ', 'ru', NULL, NULL),
(7, NULL, 'khozyaystvennoe-tovarishchestvo', 'Хозяйственное товарищество', 'ХТ', 'ru', NULL, NULL),
(8, NULL, 'polnoe-tovarishchestvo', 'Полное товарищество', 'ПТ', 'ru', NULL, NULL),
(9, NULL, 'kommanditnoe-tovarishchestvo', 'Коммандитное товарищество', 'КТ', 'ru', NULL, NULL),
(10, NULL, 'aktsionernoe-obshchestvo', 'Акционерное общество', 'АО', 'ru', NULL, NULL),
(11, NULL, 'drugaya-organizatsionno-pravovye-forma', 'Другая организационно-правовые форма', 'ДОПФ', 'ru', NULL, NULL),
(12, NULL, 'proizvodstvennyy-kooperativ', 'Производственный кооператив', 'ПК', 'ru', NULL, NULL),
(13, NULL, 'uchrezhdenie', 'Учреждение', 'У', 'ru', NULL, NULL),
(14, NULL, 'obshchestvennoe-obedinenie', 'Общественное объединение', 'ОУ', 'ru', NULL, NULL),
(15, NULL, 'potrebitelskiy-kooperativ', 'Потребительский кооператив', 'ПК', 'ru', NULL, NULL),
(16, NULL, 'fond', 'Фонд', 'Ф', 'ru', NULL, NULL),
(17, NULL, 'religioznoe-obedinenie', 'Религиозное объединение', 'РО', 'ru', NULL, NULL),
(18, NULL, 'obedinenie-yuridicheskikh-lits-v-forme-assotsiatsii', 'Объединение юридических лиц в форме ассоциации', 'ОЮЛВФА', 'ru', NULL, NULL),
(19, NULL, 'selskokhozyaystvennoe-tovarishchestvo', 'Сельскохозяйственное товарищество', 'СТ', 'ru', NULL, NULL),
(20, NULL, 'lichnoe-predprinimatelstvo', 'Личное предпринимательство', 'ЛП', 'ru', NULL, NULL),
(21, NULL, 'individualnoe-pr-vo-na-osnove-sovmestnogo-pr-va', 'Индивидуальное пр-во на основе совместного пр-ва', 'ИПНОСП', 'ru', NULL, NULL),
(22, NULL, 'prostoe-tovarishchestvo', 'Простое товарищество', 'ПП', 'ru', NULL, NULL),
(23, NULL, 'predprinimatelstvo-suprugov', 'Предпринимательство супругов', 'ПС', 'ru', NULL, NULL),
(24, NULL, 'semeynoe-predprinimatelstvo', 'Семейное предпринимательство', 'СП', 'ru', NULL, NULL),
(25, NULL, 'inaya-forma-nekommercheskoy-organizatsii', 'Иная форма некоммерческой организации', 'ИОПФНО', 'ru', NULL, NULL);

INSERT INTO `organizations` (`id`, `sort_id`, `country_id`, `city_id`, `district_id`, `org_type_id`, `slug`, `title`, `logo`, `phones`, `website`, `emails`, `address`, `latitude`, `longitude`, `balance`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 1, 'company', 'Company', 'dFdTmjN.jpg', '', '', '', '', '43.238286', '76.945456', '0', '', 1, '2016-09-15 06:54:23', '2016-09-15 06:54:23');

INSERT INTO `areas` (`id`, `sort_id`, `sport_id`, `org_id`, `city_id`, `district_id`, `slug`, `title`, `image`, `images`, `phones`, `emails`, `address`, `description`, `start_time`, `end_time`, `latitude`, `longitude`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 0, 'area-1', 'Area 1', 'preview-image-jJZCZOGjth.jpg', '', '', '', 'Сатпаев 22', '', '05:00', '23:00', '43.237065', '76.931344', '', 1, '2016-09-15 06:54:48', '2016-09-23 16:16:12');

INSERT INTO `fields` (`id`, `sort_id`, `area_id`, `title`, `size`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Filed 1', '20x20', '', 1, '2016-09-15 06:55:08', '2016-09-19 15:15:18');

INSERT INTO `schedules` (`id`, `sort_id`, `field_id`, `start_time`, `end_time`, `date`, `week`, `price`, `status`, `created_at`, `updated_at`) VALUES
(8, 1, 1, '00:00', '05:00', '2016-09-20', 1, 3000, 1, '2016-09-19 15:55:25', '2016-09-20 13:26:17'),
(9, 2, 1, '06:00', '17:00', '2016-09-20', 1, 4000, 1, '2016-09-19 15:55:46', '2016-09-20 13:25:00'),
(10, 3, 1, '18:00', '23:00', '2016-09-20', 1, 5000, 1, '2016-09-19 15:56:19', '2016-09-20 13:25:08'),
(12, 5, 1, '00:00', '05:00', '2016-09-20', 2, 2000, 1, '2016-09-20 14:10:45', '2016-09-20 15:07:39'),
(13, 6, 1, '06:00', '17:00', '2016-09-20', 2, 4000, 1, '2016-09-20 14:11:00', '2016-09-20 14:41:33'),
(14, 7, 1, '18:00', '23:00', '2016-09-20', 2, 5000, 1, '2016-09-20 14:11:19', '2016-09-20 14:11:19'),
(15, 8, 1, '00:00', '23:00', '2016-09-20', 3, 4000, 1, '2016-09-21 08:43:00', '2016-09-21 08:43:00'),
(16, 9, 1, '00:00', '12:00', '2016-09-20', 4, 3000, 1, '2016-09-21 18:48:16', '2016-09-21 18:48:16'),
(17, 10, 1, '13:00', '23:00', '2016-09-20', 4, 5000, 1, '2016-09-21 18:48:31', '2016-09-21 18:48:31'),
(18, 10, 1, '00:00', '23:00', '2016-09-20', 5, 5000, 1, '2016-09-22 09:24:26', '2016-09-22 09:24:26'),
(19, 11, 1, '00:00', '23:00', '2016-09-20', 6, 6000, 1, '2016-09-22 09:24:45', '2016-09-22 09:24:45'),
(20, 12, 1, '00:00', '23:00', '2016-09-20', 0, 7000, 1, '2016-09-22 09:24:57', '2016-09-22 09:24:57');

INSERT INTO `options` (`id`, `sort_id`, `slug`, `title`, `lang`, `created_at`, `updated_at`) VALUES
(1, 1, 'option-1', 'Option 1', '', '2016-09-15 06:52:41', '2016-09-15 06:52:41'),
(2, 2, 'option-2', 'Option 2', '', '2016-09-15 06:52:48', '2016-09-15 06:52:48'),
(3, 3, 'option-3', 'Option 3', '', '2016-09-19 05:45:06', '2016-09-19 05:45:06'),
(4, 4, 'option-4', 'Option 4', '', '2016-09-19 05:45:12', '2016-09-19 05:45:12'),
(5, 5, 'option-5', 'Option 5', '', '2016-09-19 05:45:18', '2016-09-19 05:45:18');

INSERT INTO `field_option` (`field_id`, `option_id`) VALUES
(1, 2);
