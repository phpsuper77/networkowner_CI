<?php
include '../config.php';   

//input : ...&offer_id=25&date=2014-06-01 00:00:00&timezone=-8

$default_timezone = -5;
$timezone = $_REQUEST[timezone];
$diff_timezone = $timezone - $default_timezone;

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

$offer_id = $_REQUEST[offer_id];

$cc = 0;
$sql = "SELECT ip, install_datetime  FROM install_offers 
        WHERE   offer_id={$offer_id} AND 
                install_datetime >= DATE_SUB('{$_REQUEST['date']}', INTERVAL {$diff_timezone} HOUR) AND 
                install_completed=1
        ORDER BY id ASC    
        ";
        //var_dump($sql);exit;
$q = mysqli_query($newconn, $sql);

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"IPlist_offer_{$offer_id}_from_{$_REQUEST[date]}.csv\""); 
$outstream = fopen("php://output", 'w');

$titleLine = array();
array_push($titleLine,"IP");
array_push($titleLine,"Datetime");
fputcsv    ($outstream,$titleLine,',','"');

while($row=mysqli_fetch_assoc($q))
{
    $workrow = array();
     
    $ip = (int)$row[ip];
    $str_ip = Convert_IP_From_Int_To_String($ip);
    
    array_push($workrow,$str_ip);
    array_push($workrow,$row[install_datetime]);
    fputcsv    ($outstream,$workrow,',','"');     
}
                                              
?>