<?php
require 'db.php';

$sql='SELECT rate_id,user_id,menu_id,rate FROM rate WHERE 1';
$stmt=$db->prepare($sql);
$stmt->execute();

$rec=$stmt->fetchall(PDO::FETCH_ASSOC);
foreach ($rec AS $r){
    echo $r['rate_id'];
    echo $r['user_id'];
    echo $r['menu_id'];
    echo $r['rate'];
    echo "<br>";
}
?>