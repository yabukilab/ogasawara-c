<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Progate</title>
  <link rel="stylesheet" href="completion.css">
</head>

<body>
  <div class="main">
  <div class="header">
      <h1>購入希望書籍申請が完了しました</h1>
      <p>入力内容</p>
    </div>

<form method="post" action="">
	<div class="element_wrap">
		<label>日付</label>
		<p><?php echo $_POST['birthday']; ?></p>
	</div>
	<div class="element_wrap">
		<label>氏名</label>
		<p><?php echo $_POST['name']; ?></p>
	</div>
    <div class="element_wrap">
		<label>タイトル</label>
		<p><?php echo $_POST['title']; ?></p>
	</div>
    <div class="element_wrap">
		<label>出版社</label>
		<p><?php echo $_POST['publisher']; ?></p>
	</div>
    <div class="element_wrap">
		<label>金額</label>
		<p><?php echo $_POST['price']; ?></p>
	</div>
    <div class="element_wrap">
		<label>URL</label>
		<p><?php echo $_POST['URL']; ?></p>
	</div>

	<div class="purchase">
		<a href="index.php" class="btn">戻る</a>
	</div>
</form>

</body>
</html>