<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = $_POST['keyword'];
    $currentLocation = $_POST['current_location'];
    $foundPlace = $_POST['found_place'];
    $comment = $_POST['comment'];

    // 画像の処理
    $photoData = null;
    $maxSize = 2 * 1024 * 1024; // 2MB上限

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['photo']['size'] > $maxSize) {
            exit("画像サイズが大きすぎます。2MB以下にしてください。");
        }

        $tmpName = $_FILES['photo']['tmp_name'];

        if (!is_uploaded_file($tmpName)) {
            exit("画像ファイルが正しくアップロードされませんでした。");
        }

        $photoData = file_get_contents($tmpName);
    } else {
        exit("画像のアップロードに失敗しました。（エラーコード: " . $_FILES['photo']['error'] . "）");
    }

    $stmt = $pdo->prepare("INSERT INTO items (photo, keyword, current_location, found_place, comment, is_received) VALUES (?, ?, ?, ?, ?, 0)");
    $stmt->execute([$photoData, $keyword, $currentLocation, $foundPlace, $comment]);
}
?>