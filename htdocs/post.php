<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <link rel='stylesheet' href='cit-style.css' />
    <title>データ追加</title>
  </head>
  <body>

  <?php

  session_start();
  $_SESSION['keyword'] = $_POST['kw'];

  # 送信されたデータの取得
  $user = $_POST['name'];        #名前
  $p = $_POST['return'];         #返却予定日
  if (!empty($_POST['chk'])){
    $bookid = $_POST['chk'];     #貸出チェックをした図書
  }
  if (!empty($_POST['ret'])){
    $return =  $_POST['ret'];    #返却チェックをした図書
  }
  $today = date('Y-m-d');
  $num = $_POST['num'];          #検索されたデータ数

  # https://flytech.work/blog/7864/
  # PHPのempty()関数は、変数が空であるかどうかを判定する関数
  # であり、空の場合はtrueをそれ以外の場合はfalseを返すことか
  # ら変数の空チェックを行う際によく使われます。

  # 一つの図書に両方チェックされている場合には戻るようにしたのだが、
  # 一つの図書ではなく、「貸出」と「返却」にチェックが入ると、
  # 戻ってしまうようである（要動作確認）。
  #
  for ($i=0; $i<$num; $i++) {
    if ((!empty($bookid[$i])) && (!empty($return[$i]))) {
      # 両方にチェックされている場合は以後の処理はせずに application.php に戻る
      header('Location: ./application.php');
      //header('Location: ./index.php');
      exit;
    }
  }

  require 'db.php'; # 接続

  for ($i=0; $i<$num; $i++){

    # --------
    # 貸出処理
    # --------
    if (!empty($bookid[$i])) {
      # 氏名か返却日付が設定されていなければ、登録しない
      if (($user == null) || ($p == null)) {
        # DBに登録をしない
      } else {
        $id = $bookid[$i];
        $sql = "UPDATE books SET lending_day = \"$today\", users_name = \"$user\", return_day = \"$p\" where id = \"$id\"";
        $prepare = $db->prepare($sql); # 準備
        $prepare->execute(); # 実行（本当はエラーチェックが必要）
      }
    }

    # --------
    # 返却処理
    # --------
    if (!empty($return[$i])) {
      $id = $return[$i];
      //$sql = "UPDATE books SET lending_day = \"\", users_name = \"\", return_day = \"\" where id = \"$id\"";
      $sql = "UPDATE books SET lending_day = NULL, users_name = \"\", return_day = NULL where id = \"$id\"";
      $prepare = $db->prepare($sql); # 準備
      $prepare->execute(); # 実行（本当はエラーチェックが必要）
    }
  }

  header('Location: ./application.php');
  #header('Location: ./index.php');
  ?>

  </body>
</html>
