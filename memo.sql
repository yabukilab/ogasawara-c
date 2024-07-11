-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-07-05 11:36:07
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `mydb`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(50) DEFAULT NULL,
  `menu_img` mediumblob DEFAULT NULL
  `average_rate` DECIMAL(2,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `rate`
--

DROP TABLE IF EXISTS `rate`;
CREATE TABLE `rate` (
  `rate_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL CHECK (`rate` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- トリガ `rate`
--
DROP TRIGGER IF EXISTS `update_menu_average_rate`;
DELIMITER $$
CREATE TRIGGER `update_menu_average_rate` AFTER INSERT ON `rate` FOR EACH ROW BEGIN
    UPDATE menu m
    SET m.average_rate = (
        SELECT COALESCE(ROUND(AVG(r.rate), 1), 0)
        FROM rate r
        WHERE r.menu_id = NEW.menu_id
    )
    WHERE m.menu_id = NEW.menu_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_pass` varchar(255) DEFAULT NULL,
  `user_gender` enum('male','female','none') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- ビューの作成 `menuwithaveragerate`
--
DROP VIEW IF EXISTS `menuwithaveragerate`;
CREATE ALGORITHM=UNDEFINED 
DEFINER=`testuser`@`127.0.0.1` 
SQL SECURITY DEFINER 
VIEW `menuwithaveragerate` AS 
SELECT 
    m.menu_id AS menu_id, 
    m.menu_name AS menu_name, 
    m.menu_img AS menu_img, 
    COALESCE(ROUND(AVG(r.rate), 1), 0) AS average_rate 
FROM 
    menu m 
    LEFT JOIN rate r ON m.menu_id = r.menu_id 
GROUP BY 
    m.menu_id, 
    m.menu_name, 
    m.menu_img;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- テーブルのインデックス `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`rate_id`),
  ADD UNIQUE KEY `unique_user_menu` (`user_id`,`menu_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- テーブルの AUTO_INCREMENT の設定
--

--
-- テーブルの AUTO_INCREMENT `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `rate`
--
ALTER TABLE `rate`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- トランザクションのコミット
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
