<?php
include '../config.php';   

//get auto optimizer term
$sql_t = "SELECT field_value FROM network_setting WHERE field_name='auto_optimizer_term'";    
$q_t = mysqli_query($newconn, $sql_t);
$row_t = mysqli_fetch_assoc($q_t);
$term = (int)$row_t[field_value];

$arr_res = array();
// get session 
$sql = "
    
    UPDATE combos c 
    LEFT JOIN  
    ( 
        SELECT io.combo_id, count(io.id) as cc, sum(io.price) as revenue 
        FROM 
            (   
                SELECT combo_id, id, sum(install_completed*price*adjust_rate/100) as price 
                FROM install_offers 
                WHERE   install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00'), INTERVAL {$term} DAY) AND 
                        install_datetime < DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00') 
                GROUP BY download_id, combo_id 
            ) io 
        GROUP BY io.combo_id 
    ) io1 
    ON io1.combo_id=c.id 
    SET rpobc=(io1.revenue/io1.cc)              
";

mysqli_query($newconn, $sql); 
mysqli_close($newconn);

?>