<?php
session_start();
unset($_SESSION['keyword']);
?>

<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="UTF-8">
        <title>研究室書籍管理システム検索画面</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        </head>
    <body>

    <form action="application.php" method="post" class="search">
        <div class="header zentai">
                <p>研究室書籍管理システム</p>
        </div>
		<div class="kensaku">
            <label class="ef">
            <input type="text" name="book_name" size="25" placeholder="search books!">
            <input type="submit" value="&#xf002">
            </label>
        </div>
    </form>
    <div class="purchase">
        <a href="kounyu.php" class="btn">購入希望書籍申請画面へ</a>
    </div>

        <div class="copy">
            &copy;2022 小笠原研究室A班
        </div>
    
    </body>
</html>