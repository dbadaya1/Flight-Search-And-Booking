<?php
require_once("config.php");


$stmt = $pdo->prepare('SELECT id FROM airline');
$stmt->execute();
$brands = $stmt->fetchAll();


for($i = 0;$i<100;$i++) {
  $bseats = rand(0,50);
  $eseats  =rand(70,150);
  $brand = $brands[rand(0,count($brands) - 1)]['id'];

$stmt = $pdo->prepare("insert into airplane (airline_id) values($brand)");
$stmt->execute();
$airplane_id = $pdo->lastInsertId('id');

$stmt = $pdo->prepare("insert into airplane_capacity values($airplane_id,1,$eseats)");
$stmt->execute();

$stmt = $pdo->prepare("insert into airplane_capacity values($airplane_id,2,$bseats)");
$stmt->execute();
}


$stmt = $pdo->prepare('SELECT id FROM city');
$stmt->execute();
$cities = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT id FROM airplane');
$stmt->execute();
$airplanes = $stmt->fetchAll();
$acount = count($airplanes) - 1;
$ccount = count($cities) - 1;
$sql = array();

for($i = 0;$i<50000;$i++) {
  $dcity = $cities[rand(0,$ccount)]['id'];
  $acity = $cities[rand(0,$ccount)]['id'];
  if($acity == $dcity) 
    continue;
  $airplane = $airplanes[rand(0,$acount)]['id'];
  $fnumber = mt_rand(100,999);
  $minutes_to_add = mt_rand(40,170);
  $price = 75*$minutes_to_add;
$free_meals = mt_rand(0,1);
$refundable = mt_rand(0,1);
$int= mt_rand(strtotime('2016-10-05 11:44:00'),strtotime('2016-12-05 11:44:00'));

$d_date_time = date("Y-m-d H:i:00",$int);
$a_date_time = date("Y-m-d H:i:00",$int + 60*$minutes_to_add);

$sql[]  = "($fnumber,$airplane,$dcity,'$d_date_time',$acity,'$a_date_time',$price,$free_meals,$refundable)";
/*
$sql = "INSERT INTO 
flights (fnumber,airplane_id,d_city,d_date_time,a_city,a_date_time,price,free_meals,refundable) VALUES ($fnumber,$airplane,$dcity,'$d_date_time',$acity,'$a_date_time',$price,$free_meals,$refundable)";
//echo $sql;
$stmt = $pdo->prepare($sql);
$stmt->execute();
*/
}

$sql = "INSERT INTO 
flight (fnumber,airplane_id,d_city,d_date_time,a_city,a_date_time,price,free_meals,refundable) VALUES".implode(',',$sql);
$stmt = $pdo->prepare($sql);
$stmt->execute();
?>

