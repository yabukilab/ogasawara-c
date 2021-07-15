<?php // content="text/plain; charset=utf-8"

require 'db.php';
require_once 'libs/jpgraph.php';
require_once 'libs/jpgraph_pie.php';
require_once 'libs/jpgraph_pie3d.php';

$sql = 'SELECT * FROM itemtable where userid = 1942001
and status="確認"';
$prepare = $db->prepare($sql);
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

$jobs=0;$subject=0;$shop=0;$play=0;$spare=0;
foreach ($result as $r) {
    if ($r['category'] == "仕事") { ++$jobs;
    }
if ($r['category'] == "課題") { ++$subject;
    }
if ($r['category'] == "買い物") { ++$shop;
    }
if ($r['category'] == "遊び") { ++$play;
    }
if ($r['category'] == "その他") { ++$spare;
    }
}
//echo $jobs,$subject,$shop,$play,$spare;



$title = "グラフ";
 
// データの設定
$data_jobs    = "仕事";
$data_subject = "課題";
$data_shop    = "買い物";
$data_play    = "遊び";
$data_spare   = "その他";
$data_legends = array($data_jobs, $data_subject, $data_shop, $data_play, $data_spare);
$data         = array($jobs, $subject, $shop, $play, $spare);
// グラフオブジェクトの生成
$graph = new PieGraph(600,500,"auto");
 
$graph->title->Set($title);
$graph->title->SetFont(FF_GOTHIC, FS_NORMAL, 16);
$graph->legend->Pos(0.05, 0.95, "right", "bottom");
$graph->legend->SetFont(FF_GOTHIC, FS_NORMAL);
 
$pie = new PiePlot3D($data);
$pie->SetSize(0.4);
$pie->SetCenter(0.5,0.5);
$pie->SetLegends($data_legends);
$graph->Add($pie);
 
// イメージフォーマット
$graph->img->SetImgFormat('gif');
 
// グラフの表示
$graph->Stroke();


?>
