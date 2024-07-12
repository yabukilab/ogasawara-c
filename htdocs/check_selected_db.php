<?php
require 'db.php';

$sql='SELECT select_id,menu_id FROM selected_menus WHERE 1';
$stmt=$db->prepare($sql);
$stmt->execute();

$rec=$stmt->fetchall(PDO::FETCH_ASSOC);
foreach ($rec AS $r){
    echo $r['select_id'];
    echo $r['menu_id'];
    echo "<br>";
}
?>