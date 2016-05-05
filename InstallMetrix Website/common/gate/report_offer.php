<?php

include '../config.php';

/*
input sample : ../report_offer.php?mode=2&os_name=Windows 7&os_add=&os_build=7600&offer_id=1027&install_id=2123124
mode => 2: offer install try  
        3: offer install success
        5 : offer is accepted 
        7 : it means screen of the offer is shown. it is for "Offer Screens" column of advertiser tab on report page.
*/

$mode = (int)$_REQUEST["mode"];
$os_name = $_REQUEST["os_name"];
$os_add = $_REQUEST["os_add"];
$os_build = $_REQUEST["os_build"];
$offer_id = $_REQUEST["offer_id"]; 
$install_id = $_REQUEST["install_id"];

$remote_ip = Convert_IPString_To_Int($_SERVER["REMOTE_ADDR"]);

   
if($mode == 2)       
{        
    $sql = "UPDATE install_offers SET install_started=1 WHERE id={$install_id}";
    $q = mysqli_query($newconn, $sql);        
}
else if($mode == 3)       
{        
    $sql = "UPDATE install_offers SET install_completed=1, install_datetime=NOW() WHERE id={$install_id}";
    $q = mysqli_query($newconn, $sql);        
}
else if($mode == 5)       
{        
    $sql = "UPDATE install_offers SET install_accepted=1 WHERE id={$install_id}";
    $q = mysqli_query($newconn, $sql);
}
else if($mode == 7)       
{        
    $sql = "UPDATE install_offers SET offer_shown=1 WHERE id={$install_id}";
    $q = mysqli_query($newconn, $sql);
}
  
 
?>