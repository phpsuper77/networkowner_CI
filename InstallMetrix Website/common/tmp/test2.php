<?

include '../config.php';


$sqltt = "
 SELECT COUNT( id ) as cc , pd . * 
FROM  `projects_downloads1` pd
WHERE webbrowser_id =0
GROUP BY hash_agent
ORDER BY COUNT( id ) DESC 
LIMIT 0, 20
";
$qtt = mysql_query($sqltt);
while($rowtt=mysql_fetch_assoc($qtt))
{
$idtt = $rowtt[id];                           
    
$sql = "SELECT hash_agent FROM projects_downloads1 WHERE id={$idtt}";
$q = mysql_query($sql);                                                                      
$row = mysql_fetch_assoc($q);
$agent = $row[hash_agent];
//var_dump($agent);exit;

$sql1 = "SELECT id FROM webbrowser WHERE hash_agent='{$agent}'";
 
$q1 = mysql_query($sql1);
$cc = mysql_numrows($q1);
if($cc==0) continue;

$row1 = mysql_fetch_assoc($q1);

$id = $row1[id];
//var_dump($id);exit;
$sql2 = "UPDATE projects_downloads1 SET webbrowser_id={$id} WHERE hash_agent='{$agent}' ";
mysql_query($sql2);

echo $idtt; echo ",";
}        
?>
yes
