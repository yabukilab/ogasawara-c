<?php
require 'db.php';

$sql='SELECT menu_id,menu_name,menu_img, FROM menu WHERE 1';
$stmt=$db->prepare($sql);
$stmt->execute();

$rec=$stmt->fetchall(PDO::FETCH_ASSOC);
foreach ($rec AS $r){
    echo $r['menu_id'];
    echo $r['menu_name'];
    echo $r['menu_img'];
    echo "<br>";
}
?>