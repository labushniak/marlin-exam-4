-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 06 2021 г., 13:07
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `laravel-db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_01_31_162323_create_users_info_table', 2),
(5, '2021_01_31_162910_create_users_links_table', 2),
(6, '2021_02_03_175020_alter_table_users', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'New User',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_admin`) VALUES
(1, 'Persy Jacson', 'percy37@example.com', '2021-01-25 15:33:26', '$2y$10$rbutudaKYeirnkF5PIAag.yCtHJseVUmPk2yf8JnobX/EjKhfkXrW', 'gOBul9NrWr90aj2EkxCxn01ZGGkc8DMxys8VBl9lvS0ij3lDRjvkocGqMVf1', '2021-01-25 15:33:26', '2021-01-25 15:33:26', 0),
(2, 'Percy Kuphal', 'reichel.royce@example.org', '2021-01-25 15:33:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'iTBWJAQVyQ', '2021-01-25 15:33:26', '2021-01-25 15:33:26', 0),
(3, 'Alek Hane', 'xstrosin@example.com', '2021-01-25 15:33:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '70EQwa4ZDo', '2021-01-25 15:33:26', '2021-01-25 15:33:26', 0),
(4, 'Cloyd Pacocha', 'ena.padberg@example.org', '2021-01-25 15:33:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9qN0JWZlPU', '2021-01-25 15:33:26', '2021-01-25 15:33:26', 0),
(5, 'Susana Harris', 'sshanahan@example.net', '2021-01-25 15:33:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'EIpaYxYM32', '2021-01-25 15:33:26', '2021-01-25 15:33:26', 0),
(6, 'Prof. Nils Beahan PhD', 'ahammes@example.net', '2021-01-25 15:33:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pGR8H35LQ7', '2021-01-25 15:33:26', '2021-01-25 15:33:26', 0),
(7, 'Nyasia Rohan', 'olarkin@example.com', '2021-01-25 15:33:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'xBtch4xdOr', '2021-01-25 15:33:26', '2021-01-25 15:33:26', 0),
(8, 'Doyle Bernhard', 'eschaefer@example.org', '2021-01-25 15:33:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1DVn3pJyve', '2021-01-25 15:33:26', '2021-01-25 15:33:26', 0),
(9, 'Keely Harvey III', 'estell20@example.com', '2021-01-25 15:33:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'IUrRKvgz3e', '2021-01-25 15:33:26', '2021-01-25 15:33:26', 0),
(10, 'Miss Claire Mante', 'ryleigh88@example.net', '2021-01-25 15:33:26', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nF7JooXwVG', '2021-01-25 15:33:26', '2021-01-25 15:33:26', 0),
(22, 'Admin', 'test@mail.ru', NULL, '$2y$10$8pmmDWH3p2yO7FKM5K5ot.wir2JvEO76QrRLrtdGm124r2ruVPWmu', NULL, '2021-01-31 12:13:38', '2021-01-31 12:13:38', 1),
(28, 'New User', 'test2@mail.ru', NULL, '$2y$10$i5M8GELyrkvLOhqHnJaG3OdNb97gLU7NznS/TPgc/Mnj7h4QlK7/S', NULL, '2021-02-04 09:56:20', '2021-02-04 09:56:20', 0),
(29, 'New User', 'test3@mail.ru', NULL, '$2y$10$ZjFWina8yxRlZHR62xPDoeJqv1dWeFO838Ej3jt92aibUVhHI/6jW', NULL, '2021-02-04 09:56:54', '2021-02-04 09:56:54', 0),
(30, 'New User1', 'test4@mail.ru', NULL, '$2y$10$DSE9ZGVjt0uEe.SXRf6gKuwA/oMPTiP.3tRgd2bfo9TUIwbDrAEMe', NULL, '2021-02-04 09:58:14', '2021-02-04 09:58:14', 0),
(33, 'Иван Васильев', 'ivan@mail.ru', NULL, '$2y$10$YTk9edK5VyCD297faIFfue3mrbY0kMiIVfA3Bj35rSw1Zh6HYcFdO', NULL, '2021-02-04 12:06:52', '2021-02-04 12:06:52', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users_info`
--

CREATE TABLE `users_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'online',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'uploads/avatar-b.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users_info`
--

INSERT INTO `users_info` (`id`, `user_id`, `job_title`, `phone`, `address`, `status`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 1, 'Microsoft', '+764546564', '103 New Arlean, Esten Street 12', 'out', 'uploads/FUHoO94PpFsJOdbnWtBoCAUw4GigfDRiFucMpqy3.png', NULL, NULL),
(2, 2, 'IT Director, Gotbootstrap Inc.', '+1 317-456-2564', '15 Charist St, Detroit, MI, 48212, USA', 'online', 'uploads/OIx52zJjfMiCkwOfkRLzOhroIg6vaogFLxcOHKdZ.png', NULL, NULL),
(3, 3, 'Project Manager, Gotbootstrap Inc.', '+1 313-461-1347', '134 Hamtrammac, Detroit, MI, 48314, USA', 'dont_disturb', 'uploads/mwEccYhBsrXTyRV1anw8486y8604dNRTNiAMzJE3.png', NULL, NULL),
(4, 4, 'Project Manager, Gotbootstrap Inc.', '+1 313-461-1347\r\n', '134 Hamtrammac, Detroit, MI, 48314, USA', 'out', 'uploads/UhIEJdogcIMolSQYiTxqzEdmeLVGDNt5Jy4IOMlW.png', NULL, NULL),
(5, 5, 'Human Resources, Gotbootstrap Inc.', '+1 313-779-1347', '55 Smyth Rd, Detroit, MI, 48341, USA', 'out', 'uploads/sBb7XU0XPmHLoYPzzEbJKRq2RBUQLo1smlPDZiWb.png', NULL, NULL),
(6, 6, 'Human Resources, Gotbootstrap Inc.', '+1 313-779-1347', '55 Smyth Rd, Detroit, MI, 48341, USA', 'out', 'uploads/Ye5DsVSQG1ui9ONnFJngRkokkcSc8U3fQRvo9x6u.png', NULL, NULL),
(7, 7, 'Staff Orgnizer, Gotbootstrap Inc.', '+1 313-779-3314', '134 Tasy Rd, Detroit, MI, 48212, USA', 'dont_disturb', 'uploads/TSILloPeBssi2fk0sJONj9blS3BO22cxeO3Tx0UR.png', NULL, NULL),
(8, 8, 'Staff Orgnizer, Gotbootstrap Inc.', '+1 313-779-3314', '134 Tasy Rd, Detroit, MI, 48212, USA', 'dont_disturb', 'uploads/RVsz26jP86aG5FJd8MPjzcJdU6JsokSaF92X7n4p.png', NULL, NULL),
(9, 9, 'Oncologist, Gotbootstrap Inc.', '+1 313-779-8134', '134 Gallery St, Detroit, MI, 46214, USA', 'out', 'uploads/tm9ozKIxGomeN58tm8nRrXn6xeEZTTPO9TY21eFe.png', NULL, NULL),
(10, 10, 'Oncologist, Gotbootstrap Inc.', '+1 313-779-8134', '134 Gallery St, Detroit, MI, 46214, USA', 'out', 'uploads/LGA8chApEmtYYjj819EKjl32RQN9y51Jn9zF7F14.png', NULL, NULL),
(11, 28, '', '', '', 'online', 'uploads/sx6kpRIWbMXBmrY3l89HqDqmOILzNThrcphkUb6R.png', '2021-02-04 09:56:20', '2021-02-04 09:56:20'),
(12, 29, '', '', '', 'online', 'uploads/Cc4RKIlRVgEMvjksinWw3ONFhNnlcF9t0HZXOt9m.png', '2021-02-04 09:56:54', '2021-02-04 09:56:54'),
(13, 30, 'asdasdasd', '+732132132', 'asdasdas', 'online', 'uploads/avatar-b.png', '2021-02-04 09:58:14', '2021-02-04 09:58:14'),
(15, 22, '', '', '', 'online', 'uploads/avatar-b.png', NULL, NULL),
(17, 33, 'Микрософт', '+79654641315', '100500 Екатеринбург, д. 8, стр. 1', 'online', 'uploads/PlFoYpNwdQNPThX4LrMEbQ0BamYrgokLyrcCGrUc.png', '2021-02-04 12:06:52', '2021-02-04 12:06:52');

-- --------------------------------------------------------

--
-- Структура таблицы `users_links`
--

CREATE TABLE `users_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `vk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telegram` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users_links`
--

INSERT INTO `users_links` (`id`, `user_id`, `vk`, `telegram`, `instagram`, `created_at`, `updated_at`) VALUES
(1, 1, 'paceaste', 'paceaste', 'paceaste', NULL, NULL),
(2, 2, 'expolitted', 'expolitted', 'expolitted', NULL, NULL),
(3, 3, 'bluewolf', 'bluewolf', 'bluewolf', NULL, NULL),
(4, 4, 'ludeduraling', 'ludeduraling', 'ludeduraling', NULL, NULL),
(5, 5, 'launsenzibly', 'launsenzibly', 'launsenzibly', NULL, NULL),
(6, 6, 'eccenblim', 'eccenblim', 'eccenblim', NULL, NULL),
(7, 7, 'aplayeard', 'aplayeard', 'aplayeard', NULL, NULL),
(8, 8, 'annecking', 'annecking', 'annecking', NULL, NULL),
(9, 9, 'waratel', 'waratel', 'waratel', NULL, NULL),
(10, 10, 'relatern', 'relatern', 'relatern', NULL, NULL),
(11, 28, '', '', '', '2021-02-04 09:56:20', '2021-02-04 09:56:20'),
(12, 29, '', '', '', '2021-02-04 09:56:54', '2021-02-04 09:56:54'),
(13, 30, '', '', '', '2021-02-04 09:58:14', '2021-02-04 09:58:14'),
(15, 22, '', '', '', NULL, NULL),
(17, 33, 'vasyliev', 'vasyliev', 'vasyliev', '2021-02-04 12:06:52', '2021-02-04 12:06:52');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `users_info`
--
ALTER TABLE `users_info`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_links`
--
ALTER TABLE `users_links`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `users_info`
--
ALTER TABLE `users_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `users_links`
--
ALTER TABLE `users_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
