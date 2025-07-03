<?php
require 'db.php';

if (!isset($_GET['id'])) {
    header("Location: search.php");
    exit;
}

$id = $_GET['id'];

// IDに対応するデータを取得
$stmt = $pdo->prepare("SELECT keyword, current_location FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

// エラー処理
if (!$item) {
    exit('対象データが見つかりません');
}

// is_received を 1 に更新
$update = $pdo->prepare("UPDATE items SET is_received = 1 WHERE id = ?");
$update->execute([$id]);

// 完了ページへ遷移（キーワードと現在の場所をURLパラメータで渡す）
$keyword = urlencode($item['keyword']);
$location = urlencode($item['current_location']);
header("Location: search_complete.php?keyword=$keyword&location=$location");
exit;
?>