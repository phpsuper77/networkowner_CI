<?php

include '../config.php';

/*
input sample : ../installer_gate_offer.php?os_name=Windows 7&os_add=&os_build=7600&offer_id=1027
*/
if ($_REQUEST["offer_id"] != '') 
{
    //insert new recode into install_offer as mode 7 (offer_shown)
    
    $os_name = $_REQUEST["os_name"];
    $os_add = $_REQUEST["os_add"];
    $os_build = $_REQUEST["os_build"];
    $offer_id = $_REQUEST["offer_id"]; 
    $remote_ip = Convert_IPString_To_Int($_SERVER["REMOTE_ADDR"]);
    
    //get os_typeid
    $os_typeid = 0;
    $sql = "SELECT id FROM os_type WHERE os_name='{$os_name}' AND os_additional='{$os_add}' AND os_build='{$os_build}'";
    $q = mysqli_query($newconn, $sql);   
    $count = mysqli_num_rows($q);
    $row = mysqli_fetch_assoc($q);
    if($count>0)
    {
        $os_typeid = $row[id];
    }
    else
    {
        $sql = "INSERT INTO os_type(os_name, os_additional, os_build) VALUES ('{$os_name}', '{$os_add}', '{$os_build}')";
        mysqli_query($newconn, $sql);
        $os_typeid= mysqli_insert_id($newconn);
    }
    
    //if install_offers case, get price, user_id, manager_id, am_revenue
    $sql = "
        SELECT o.id, opc.price as price, o.adjust_rate, u1.id as user_id, u2.id as manager_id, u2.user_revenue as am_revenue 
        FROM offers o 
        LEFT JOIN users u1 ON o.assigned_user_id=u1.id 
        LEFT JOIN users u2 ON u1.user_manager=u2.id
        LEFT JOIN (SELECT * FROM offer_prices_country WHERE country_id=0) opc ON opc.offer_id=o.id
        WHERE o.id={$offer_id} 
    ";
    $q = mysqli_query($newconn, $sql);
    $row = mysqli_fetch_assoc($q);
    $price = $row[price];
    $adjust_rate = $row[adjust_rate];
    $user_id = $row[user_id];
    $manager_id = $row[manager_id];
    $am_revenue = $row[am_revenue];
    
    $pub_revenue = 0;
    $pm_revenue = 0;
    
    $sql = "
        INSERT INTO install_offers (`network_id`, `proj_id`, `offer_id`, `template_id`, `install_datetime`, 
            `os_typeid`, `ip`, `download_id`, `price`, `user_id`, `manager_id` ,`pub_revenue`, `pm_revenue`,
            `am_revenue`, `offer_shown`, `install_accepted`, `install_started`, `install_completed`, `adjust_rate`, `combo_id`) 
            VALUES (-1, 0, {$offer_id}, 0, NOW(), {$os_typeid}, {$remote_ip}, 0, 
            {$price}, {$user_id}, {$manager_id}, {$pub_revenue}, {$pm_revenue}, {$am_revenue}, 1, 1, 1, 0, {$adjust_rate}, 0
            );
    ";
    //var_dump($sql);exit;     
    mysqli_query($newconn, $sql);
    
    $install_id = mysqli_insert_id($newconn);
    
    header("Content-type: text/xml");
    set_time_limit(0);
    ob_implicit_flush();
      
    
    
    $sql = "SELECT * FROM offers WHERE id={$offer_id}";
    $q = mysqli_query($newconn, $sql);
    $row = mysqli_fetch_assoc($q);
    $offer_url = $row[offer_url];
    $offer_param = $row[offer_silent_main];
    
    $xml = "";
    $xml .= "<offer_url>" . $offer_url . "</offer_url>";
    $xml .= "<offer_param>" . $offer_param . "</offer_param>";
    $xml .= "<install_id>" . $install_id . "</install_id>";
    
    echo($xml);
}
  
?>