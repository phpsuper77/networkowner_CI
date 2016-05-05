<?      //var_dump($_REQUEST);exit;
include 'common/config.php';
  
if($_REQUEST[tryout]==1)
{
       
if ($_SERVER[REMOTE_ADDR] == '46.146.232.230') {
    $ip_addr = '78.80.3.70';
} else {
    $ip_addr = $_SERVER[REMOTE_ADDR]; 
    //$ip_addr = '78.80.3.70';
   
}

//var_dump($_REQUEST);exit;
$country = get_country($ip_addr);    //david
   /* 
$ip_addr = '61.176.96.70';  
$country = "CN";   //david
*/
//var_dump($_REQUEST);exit;

$sql = "SELECT count(id) as cc FROM `users` WHERE LOWER(`user_email`)='" . strtolower($_REQUEST['email']) . "'";
$q = mysqli_query($newconn, $sql);
$row = mysqli_fetch_assoc($q);
$users_count = $row[cc];
//var_dump($users_count );exit;   
if ($users_count != 0) {
    echo 'Email is already existed, please use other email';
    exit;
}
  
$user_status = $_REQUEST[user_type];

$subid = 0;
$sql = "SELECT MAX(u.subid)+1 as subid FROM users u WHERE u.user_status={$user_status}";
$q =  mysqli_query($newconn, $sql);
$ret = mysqli_fetch_assoc($q);
if($ret[subid] == NULL)
{
    $subid = 1000;
}
else
{
    $subid = $ret[subid];
}
        
$sql = "INSERT INTO `users` (
                        subid,
                        user_first_name,
                        user_last_name,
                        user_email,
                        user_name,
                        user_phone,
                        user_company_name,
                        website,
                        user_aim,
                        user_skype,
                        user_pass,
                        network_id,
                        user_status,
                        user_system_status,
                        user_revenue,
                        user_manager
                        ) values (
                        {$subid},
                        '{$_REQUEST[first_name]}',
                        '{$_REQUEST[last_name]}',
                        '{$_REQUEST[email]}',
                        '',
                        '{$_REQUEST[phone]}',
                        '{$_REQUEST[company]}',
                        '{$_REQUEST[company_website]}',
                        '{$_REQUEST[aim]}',
                        '{$_REQUEST[skype]}',
                        md5('{$_REQUEST[pass]}'),
                        '-1',
                        '{$user_status}',
                        '2',
                        '0',
                        '-1'
                        )";

        //echo($sql);exit;                
        $q = mysqli_query($newconn, $sql);
        
        echo("Thank you for signing up with us. Your application is being reviewed and will hear back from us within 48 hours.");
        //break;
}
?>