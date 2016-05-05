<?
include 'config.php'; 
       
$new_url = "";

//check that this doamin is assigned to the publisher

$main_conn = new mysqli(MAINSQLHOST, MAINSQLUSER, MAINSQLPASS, MAINSQLDB); // db of main server    
$domain_url = DOMAIN_URL;
$cid = $_REQUEST[cid];

$sql = "SELECT dp.id
        FROM domain_publisher dp 
        LEFT JOIN domains d ON d.id=dp.domain_id 
        LEFT JOIN users u ON dp.pub_id=u.id 
        LEFT JOIN projects p ON p.assigned_user_id=u.id
        WHERE d.domain='{$domain_url}' AND p.id={$cid}";
//var_dump($sql);exit;
$q = mysqli_query($main_conn, $sql);
$cc = mysqli_num_rows($q);
mysqli_close($main_conn);
if($cc==0)
{
    //block download;
    exit;
}
else
{

//check browser and redirect request if it is chrome and redirecting option of this domain is "YES".
                                                                                                    
if ((REDIRECTING_OPTION=="YES")&&(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') != false))
{    
    //make randome long paramenter    
    $param1_name = RandomeStringName(rand(3, 5));
    $param1_value = RandomeUpperStringValue(rand(6900, 7100));    
    $new_url =  REDIRECT_URL . "/download_redirected.php?" . $_SERVER['QUERY_STRING'] . "&" . $param1_name . "=" . $param1_value;
}          
else
{
    $new_url =  DOMAIN_URL . "/download_final.php?" . $_SERVER['QUERY_STRING'];
}

header("Location: {$new_url}");
exit;   
}
?>