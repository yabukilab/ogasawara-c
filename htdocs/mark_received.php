<?php
require 'db.php';

if (!isset($_GET['id'])) {
    header("Location: search.php");
    exit;
}

$id = $_GET['id'];

// IDに対応するデータを取得
// ここで keyword と found_place を取得するように変更します
$stmt = $pdo->prepare("SELECT keyword, found_place FROM items WHERE id = ?"); // 修正
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

// エラー処理
if (!$item) {
    exit('対象データが見つかりません');
}

// is_received を 1 に更新
$update = $pdo->prepare("UPDATE items SET is_received = 1 WHERE id = ?");
$update->execute([$id]);

// 完了ページへ遷移（キーワードと見つけた場所をURLパラメータで渡す）
$keyword = urlencode($item['keyword']);
// location パラメータとして found_place を渡します
$location = urlencode($item['found_place']); // 修正
header("Location: search_complete.php?keyword=$keyword&location=$location");
exit;
?>