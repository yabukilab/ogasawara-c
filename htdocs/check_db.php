<?php
require 'db.php';

$sql='SELECT user_id,user_name,user_pass,user_gender FROM users WHERE 1';
$stmt=$db->prepare($sql);
$stmt->execute();

$rec=$stmt->fetchall(PDO::FETCH_ASSOC);
foreach ($rec AS $r){
    echo $r['user_id'];
    echo $r['user_name'];
    echo $r['user_pass'];
    echo $r['user_gender'];
    echo "<br>";
}
?>