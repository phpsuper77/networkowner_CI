<?

include '../config.php';

error_reporting(E_ALL ^ E_NOTICE);

?>
<html>
  <head>
    
  </head>
  <body>

<?php

$sql = "SELECT id, ip FROM install_offers2 where ip1=0 LIMIT 0, 50000" ;
$q = mysql_query($sql);
$cc = 0;
while($row=mysql_fetch_assoc($q))
{
    if($row[ip]!='')
        $ip = Convert_IPString_To_Int($row[ip]);
    else
        $ip = 0;
    
    $sql1 = "UPDATE install_offers2 SET ip1={$ip} WHERE id={$row[id]}";
    mysql_query($sql1);
    $cc++;
}
echo $cc;
?>

  </body>
</html>
