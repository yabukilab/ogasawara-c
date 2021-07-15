-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2021-07-08 11:30:39
-- サーバのバージョン： 10.4.19-MariaDB
-- PHP のバージョン: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `ogasawarac`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `itemtable`
--

CREATE TABLE `itemtable` (
  `userid` int(11) DEFAULT NULL,
  `itemid` int(11) NOT NULL,
  `contents` varchar(40) NOT NULL,
  `カテゴリ` varchar(10) NOT NULL,
  `期日` date NOT NULL,
  `チェック` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `itemtable`
--

INSERT INTO `itemtable` (`userid`, `itemid`, `contents`, `カテゴリ`, `期日`, `チェック`) VALUES
(1942001, 1, '授業研修', '仕事', '2021-07-20', 'ついている'),
(1942001, 2, 'システム構築', '課題', '2021-07-28', 'ついていない'),
(1942001, 3, 'キャリアデザイン', '課題', '2021-07-21', 'ついていない'),
(1942049, 4, '発表', '課題', '2021-07-23', 'ついていない'),
(1942001, 5, 'ニンジンの特売日', '買い物', '2021-07-26', 'ついている'),
(1942001, 6, '政治と経済', '課題', '2021-07-28', 'ついている'),
(1942001, 7, '社会技術論', '課題', '2021-07-29', 'ついていない'),
(1942001, 8, '社会技術論', '課題', '2021-07-29', 'ついていない'),
(1942049, 9, '技術経営論', '課題', '2021-08-02', 'ついている'),
(1942049, 10, 'コラボ商品発売日', '買い物', '2021-08-05', 'ついている'),
(1942049, 11, '研究開発技法', '課題', '2021-08-08', 'ついていない'),
(1942049, 12, 'プロジェクト評価', '課題', '2021-08-10', 'ついていない'),
(1942001, 13, 'プロジェクトシステム構築', '課題', '2021-08-13', 'ついている'),
(1942001, 14, '漫画発売', '買い物', '2021-08-15', 'ついている');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `itemtable`
--
ALTER TABLE `itemtable`
  ADD PRIMARY KEY (`itemid`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `itemtable`
--
ALTER TABLE `itemtable`
  MODIFY `itemid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
