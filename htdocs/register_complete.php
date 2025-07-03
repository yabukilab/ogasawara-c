<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 変数の初期化
    $keyword = $_POST['keyword'] ?? '';
    $currentLocation = $_POST['current_location'] ?? '';
    $foundPlace = $_POST['found_place'] ?? '';
    $comment = $_POST['comment'] ?? '';

    $photoData = null;

    // ファイルが正常にアップロードされたかチェック
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        // 一時保存されたファイルのパスを取得
        $tmpName = $_FILES['photo']['tmp_name'];

        // ファイルの中身をバイナリとして読み込む
        $photoData = file_get_contents($tmpName);
    } else {
        // アップロードエラーの場合のエラーコードを取得
        $uploadError = $_FILES['photo']['error'] ?? 'ファイルが送信されていません';
        exit("ファイルアップロードエラー: エラーコード {$uploadError}");
    }

    // DBに保存
    $stmt = $pdo->prepare("INSERT INTO items (photo, keyword, current_location, found_place, comment, is_received) VALUES (?, ?, ?, ?, ?, 0)");
    $stmt->execute([$photoData, $keyword, $currentLocation, $foundPlace, $comment]);

    // 登録完了画面表示など
    echo "登録完了しました。";
} else {
    exit("不正なアクセスです。");
}
?>