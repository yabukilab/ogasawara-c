SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- データベースの作成
CREATE DATABASE IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- データベースの選択
USE `mydb`;

-- テーブル `menu` の作成
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) DEFAULT NULL,
  `menu_img` mediumblob DEFAULT NULL,
  `average_rate` DECIMAL(2,1) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- テーブル `rate` の作成
DROP TABLE IF EXISTS `rate`;
CREATE TABLE `rate` (
  `rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL CHECK (`rate` between 1 and 5),
  PRIMARY KEY (`rate_id`),
  UNIQUE KEY `unique_user_menu` (`user_id`,`menu_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `fk_rate_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- テーブル `users` の作成
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT NULL,
  `user_pass` varchar(255) DEFAULT NULL,
  `user_gender` enum('male','female','none') DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- テーブル `menuwithaveragerate_table` の作成
DROP TABLE IF EXISTS `menuwithaveragerate`;
CREATE TABLE `menuwithaveragerate` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(50) DEFAULT NULL,
  `menu_img` mediumblob DEFAULT NULL,
  `average_rate` DECIMAL(2,1) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- データの挿入
INSERT INTO `menuwithaveragerate` (`menu_id`, `menu_name`, `menu_img`, `average_rate`)
SELECT 
    menu_id, 
    menu_name, 
    menu_img, 
    average_rate 
FROM 
    menuwithaveragerate;

-- トリガ `update_menu_average_rate` の作成
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

COMMIT;
