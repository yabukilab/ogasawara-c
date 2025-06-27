<?php
require 'db.php';

if (!isset($_POST['id'])) {
    header("Location: search.php");
    exit;
}

$id = $_POST['id'];
$keyword = $_POST['keyword'] ?? '';
$location = $_POST['location'] ?? '';

// is_received を1に更新
$stmt = $pdo->prepare("UPDATE items SET is_received = 1 WHERE id = ?");
$stmt->execute([$id]);

// 完了画面にリダイレクト
header("Location: search_complete.php?keyword=" . urlencode($keyword) . "&location=" . urlencode($location));
exit;