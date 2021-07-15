<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />

<title>グラフ</title>
</head>
<body>
<?php
require 'db.php';
$sql = 'SELECT * FROM itemtable where userid = 1942001';
$prepare = $db->prepare($sql);
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

$jobs=0;$subject=0;$shop=0;$play=0;$spare=0;
foreach ($result as $r) {
    if ($r['カテゴリ'] == "仕事") { ++$jobs;
    }
if ($r['カテゴリ'] == "課題") { ++$subject;
    }
if ($r['カテゴリ'] == "買い物") { ++$shop;
    }
if ($r['カテゴリ'] == "遊び") { ++$play;
    }
if ($r['カテゴリ'] == "その他") { ++$spare;
    }
}
echo $jobs,$subject,$shop,$play,$spare




?>

</body>
</html>