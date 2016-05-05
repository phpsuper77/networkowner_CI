<?
include '../config.php';
$newconn = new mysqli(SQLHOST, SQLUSER, SQLPASS,SQLDB);

$handle = fopen("GeoLiteCity-Blocks.csv", "r");

$line = fgets($handle);
$line = fgets($handle);
$k = 0;
if ($handle) 
{
    while (($line = fgets($handle)) !== false) 
    {
        // process the line read.
        $row = explode(",", $line);
        $sql = "INSERT INTO geo_block (start_ip, end_ip, loc_id) VALUES ({$row[0]}, {$row[1]}, {$row[2]})";
        mysqli_query($newconn, $sql);
    }
} 
else 
{
    // error opening the file.
} 
fclose($handle);
?>