<?php
$host = 'localhost';
$dbname = 'lost_and_found';
$user = 'root';
$pass = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
  echo 'DB接続エラー: ' . $e->getMessage();
  exit;
}
?>