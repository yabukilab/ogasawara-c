<?php
//データベース接続設定
$dbServer = '127.0.0.1';
$dbName = 'ogasawarac';
$dsn = "mysql:host={$dbServer};
dbname={$dbName};
charset=utf8";
$dbUser = 'test';
$dbPass = 'pass';
//データベースへの接続
$db = new PDO($dsn, $dbUser, $dbPass);
$sql = 'SELECT * FROM itemtable where userid = 1942001 ORDER BY 期日 LIMIT 1,3';
$prepare = $db->prepare($sql);
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);
echo '<table border="1">';
foreach ($result as $r) {
echo '<tr>';
switch ($r['カテゴリ']) {
    case "仕事":
        echo '  <th><font color=#66CCFF>';
        break;
    case "課題":
        echo '  <th><font color=#00CC66>';
        break;
    case "買い物":
        echo '  <th><font color=#FFCC33>';
        break;
    case "遊び":
        echo '  <th><font color=#CCCC33>';
        break;
    case "その他":
        echo '  <th><font color=#CCCCCC>';
        break;
}
echo '<font size ="4">';
echo $r['カテゴリ'];
echo '  </th>';
echo '  <th>';
echo '<font size ="4">';
echo $r['contents'];
echo '  </th>';
echo '  <th>';
echo '<font size ="4">';
echo $r['期日'];
echo '  </th>';
echo '<tr>';
}
echo '</table>';
?>