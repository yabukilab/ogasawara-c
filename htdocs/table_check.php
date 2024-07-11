<?php
session_start();
require('db.php');

// MySQLデータベースに接続
$conn = new mysqli($dbServer, $dbUser, $dbPass, $dbName);

// 接続をチェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM menu ORDER BY update_at";
$stmt = $conn->prepare($sql);
$stmt -> execute();

?>