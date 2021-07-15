-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2021-07-15 07:54:55
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
  `category` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `itemtable`
--

INSERT INTO `itemtable` (`userid`, `itemid`, `contents`, `category`, `date`, `status`) VALUES
(1942001, 1, '授業研修', '仕事', '2021-07-20', '完了'),
(1942001, 2, 'システム構築', '課題', '2021-07-28', '確認'),
(1942001, 3, 'キャリアデザイン', '課題', '2021-07-21', '確認'),
(1942049, 4, '発表', '課題', '2021-07-23', '確認'),
(1942001, 5, 'ニンジンの特売日', '買い物', '2021-07-26', '削除'),
(1942001, 6, '政治と経済', '課題', '2021-07-28', '完了'),
(1942001, 7, '社会技術論', '課題', '2021-07-29', '確認'),
(1942001, 8, '社会技術論', '課題', '2021-07-29', '確認'),
(1942049, 9, '技術経営論', '課題', '2021-08-02', '完了'),
(1942049, 10, 'コラボ商品発売日', '買い物', '2021-08-05', '削除'),
(1942049, 11, '研究開発技法', '課題', '2021-08-08', '確認'),
(1942049, 12, 'プロジェクト評価', '課題', '2021-08-10', '確認'),
(1942001, 13, 'プロジェクトシステム構築', '課題', '2021-08-13', '完了'),
(1942001, 14, '漫画発売', '買い物', '2021-08-15', '完了'),
(1942001, 22, '散髪', 'その他', '2021-07-12', '確認'),
(1942001, 30, 'プログラミング', '課題', '2021-07-16', '確認'),
(1942001, 31, 'プログラミング', '課題', '2021-07-16', '確認'),
(1942001, 32, '散髪', '買い物', '2021-07-30', '確認'),
(1942001, 33, 'プログラミング', '課題', '2021-07-31', '確認'),
(1942001, 34, 'プログラミング', '仕事', '2021-07-23', '確認'),
(1942001, 35, '散髪', '課題', '2021-08-06', '確認'),
(1942001, 36, '参拝', '遊び', '2021-07-21', '確認');

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
  MODIFY `itemid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
