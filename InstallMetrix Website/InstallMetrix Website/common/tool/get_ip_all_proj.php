<?php
include '../config.php';   

//input : ...&proj_id=25

function Convert_IP_From_Int_To_String($ip)
{
    $ip1 = $ip % 256;    
    $ip = (int)($ip / 256);
    $ip2 = $ip % 256;
    $ip = (int)($ip / 256);
    $ip3 = $ip % 256;
    $ip4 = (int)($ip / 256);
    
    $str = "";
    
    $str .= $ip1 . "." . $ip2 . "." . $ip3 . "." . $ip4;
    
    return $str;
}

$proj_id = $_REQUEST[proj_id];

$cc = 0;
$sql = "SELECT * FROM projects_downloads 
        WHERE   proj_id={$proj_id} 
        GROUP BY ip";
       // var_dump($sql);exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{
    $ip = (int)$row[ip];
    $str_ip = Convert_IP_From_Int_To_String($ip);
    echo($str_ip);echo("<br>");
    $cc++;
}
  
?>