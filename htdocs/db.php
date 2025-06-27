<?php
//$host = '127.0.0.1'; // XAMPPでは通常これ
//$dbname = 'mydb';    // 作ったDB名
//$user = 'root';      // デフォルトユーザー
//$pass = '';          // パスワードは空

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "DB接続成功しました！"; ←公開時はコメントアウトか削除！
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}
?>