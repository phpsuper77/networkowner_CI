<?php
include '../config.php';   

$sql = "SELECT id, offer_price FROM offers";
$q = mysqli_query($newconn, $sql);

$sql1 = "INSERT INTO offer_prices_country(offer_id, country_id, price) VALUES ";
while($row=mysqli_fetch_assoc($q))
{
    $sql1 .= "({$row[id]}, 0, {$row[offer_price]}),"; 
    $sql1 .= "({$row[id]}, 17, {$row[offer_price]}),"; 
    $sql1 .= "({$row[id]}, 39, {$row[offer_price]}),";
    $sql1 .= "({$row[id]}, 57, {$row[offer_price]}),";
    $sql1 .= "({$row[id]}, 75, {$row[offer_price]}),";
    $sql1 .= "({$row[id]}, 77, {$row[offer_price]}),";
    $sql1 .= "({$row[id]}, 223, {$row[offer_price]}),";
}

$str_tmp = substr($sql1,0,-1);
//var_dump($str_tmp);exit;
mysqli_query($newconn, $str_tmp);
  
?>