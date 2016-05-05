<?php

define('SQLHOST_LOCAL', 'localhost');
define('SQLUSER_LOCAL', 'tota89hg_root');
define('SQLPASS_LOCAL', 'f=ew[s4Ddvnn');
define('SQLDB_LOCAL', 'tota89hg_main');
$local_conn = new mysqli(SQLHOST_LOCAL, SQLUSER_LOCAL, SQLPASS_LOCAL,SQLDB_LOCAL); // db of local server

$sql = "SELECT INET_NTOA(ip) AS ip_str, start_datetime FROM `block_iplist` ORDER BY start_datetime DESC";
$q = mysqli_query($local_conn, $sql);
while($row=mysqli_fetch_assoc($q))
{
    $ip = $row[ip_str];
    $datetime = $row[start_datetime];
    echo($ip . "   =================================      " . $datetime);
    echo("<br>");
}
  
?>