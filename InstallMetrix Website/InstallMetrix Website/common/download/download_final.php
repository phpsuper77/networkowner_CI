<?

include 'config.php';
                      
                                
$filename = $_REQUEST['file'];
$proj_id = $_REQUEST['cid']; 
   
$ip_addr = $_SERVER[REMOTE_ADDR];
if($ip_addr == "::1")
    $ip_addr = DEFAULT_IP;
   
$main_conn = new mysqli(MAINSQLHOST, MAINSQLUSER, MAINSQLPASS, MAINSQLDB); // db of main server    
                                          
$ip = Convert_IPString_To_Int($ip_addr); 

// get parameters for blocking ip
$sql = "SELECT * FROM network_setting WHERE field_name IN ('ip_monitor_time', 'ip_monitor_limit', 'ip_block_time', 'block_url')";
$q = mysqli_query($main_conn, $sql);
$row = mysqli_fetch_assoc($q);
$ip_monitor_time = $row[field_value];
$row = mysqli_fetch_assoc($q);
$ip_monitor_limit = $row[field_value];
$row = mysqli_fetch_assoc($q);
$ip_block_time = $row[field_value];
$row = mysqli_fetch_assoc($q);
$block_url = $row[field_value];  

/// process blocking ip function

$local_conn = new mysqli(SQLHOST_LOCAL, SQLUSER_LOCAL, SQLPASS_LOCAL,SQLDB_LOCAL); // db of local server

//check the ip is in blocklist
$sql = "SELECT * FROM block_iplist WHERE ip={$ip} AND start_datetime>=DATE_SUB(NOW(), INTERVAL {$ip_block_time} MINUTE)";
//var_dump($sql);exit;
$q = mysqli_query($local_conn, $sql);
$cc = mysqli_num_rows($q);
if($cc > 0)
{
    header("Location: {$block_url}");
    exit;  
}

//get counts of history that has this ip
$sql = "SELECT count(id) as cc FROM download_click_history WHERE ip={$ip} AND click_datetime>=DATE_SUB(NOW(), INTERVAL {$ip_monitor_time} SECOND)";
//var_dump($ip_monitor_limit);exit;
$q = mysqli_query($local_conn, $sql);
$row = mysqli_fetch_assoc($q);
$cc = $row[cc];
if($cc>=(int)$ip_monitor_limit)
{
    // insert the ip into blocking list
    $sql = "INSERT INTO block_iplist(ip) VALUES ({$ip})";
    mysqli_query($local_conn, $sql);
    header("Location: {$block_url}");
    exit;
}

//insert the ip into download_click_history
$sql = "INSERT INTO download_click_history(ip, proj_id) VALUES ({$ip}, {$proj_id})";
mysqli_query($local_conn, $sql);

mysqli_close($local_conn);
/////
 
$browser_ret = user_browser($_SERVER[HTTP_USER_AGENT]);
$browser_ret_arr = explode('|', $browser_ret);     
                
$user_os = user_os($_SERVER[HTTP_USER_AGENT]); 
      
$referer = $_REQUEST['referer'];
 
$sql = "SELECT id, loc_id FROM geo_block force key(idx_geo) WHERE start_ip<={$ip} AND end_ip>{$ip}";
$q = mysqli_query($main_conn, $sql);
$row = mysqli_fetch_assoc($q);
$geo_id = $row[id];

$geo_loc_id = $row[loc_id];
$sql = "SELECT latitude, longitude FROM geo_location WHERE id={$geo_loc_id}";
$q = mysqli_query($main_conn, $sql);
$row = mysqli_fetch_assoc($q);
$latitude = $row[latitude];
$longitude = $row[longitude];


//get webbrowser id
$webbrowser_id = 0;
$sql = "SELECT id FROM webbrowser WHERE hash_agent=md5('{$_SERVER[HTTP_USER_AGENT]}')";
$q = mysqli_query($main_conn, $sql);
$count = mysqli_num_rows($q);
$row = mysqli_fetch_assoc($q);
if($count>0)
{
    $webbrowser_id = $row[id];
}
else
{
    $sql = "INSERT INTO webbrowser(useragent, hash_agent, browser, browser_ver) 
            VALUES ('{$_SERVER[HTTP_USER_AGENT]}', md5('{$_SERVER[HTTP_USER_AGENT]}'), '{$browser_ret_arr[0]}', '{$browser_ret_arr[1]}')";
    mysqli_query($main_conn, $sql);
    $webbrowser_id = mysqli_insert_id($main_conn);
}

//get os_typeid
$os_typeid = 0;
$sql = "SELECT id FROM os_type WHERE os_name='{$user_os}' AND os_additional='' AND os_build=''";
$q = mysqli_query($main_conn, $sql);
$count = mysqli_num_rows($q);
$row = mysqli_fetch_assoc($q);
if($count>0)
{
    $os_typeid = $row[id];
}
else
{
    $sql = "INSERT INTO os_type(os_name) VALUES ('{$user_os}')";
    mysqli_query($main_conn, $sql);
    $os_typeid= mysqli_insert_id($main_conn);
}

//get refer_url_id    
$refer_url =  $_SERVER[HTTP_REFERER];
$pos = strrpos($refer_url, "subid");
$pos = strpos($refer_url, "&", $pos);
$refer_url = substr($refer_url, 0, $pos);
//var_dump($refer_url);exit;

$refer_url_id = 0;
$sql = "SELECT id FROM refer_url WHERE refer_url='{$refer_url}'";
$q = mysqli_query($main_conn, $sql);
$count = mysqli_num_rows($q);
$row = mysqli_fetch_assoc($q);
if($count>0)
{
    $refer_url_id = $row[id];
}
else
{
    $sql = "INSERT INTO refer_url(refer_url) VALUES ('{$refer_url}')";
    mysqli_query($main_conn, $sql);
    $refer_url_id= mysqli_insert_id($main_conn);
}

//get subid_id
$subid_id = 0;
$subid_all = $_REQUEST[subid1] . "|" . $_REQUEST[subid2] . "|" . $_REQUEST[subid3] . "|" . $_REQUEST[subid4] . "|" . $_REQUEST[subid5];
$sql = "SELECT id FROM subid WHERE subid_all='{$subid_all}'";
$q = mysqli_query($main_conn, $sql);
$count = mysqli_num_rows($q);
$row = mysqli_fetch_assoc($q);
if($count>0)
{
    $subid_id = $row[id];
}
else
{
    $sql = "INSERT INTO subid(subid1, subid2, subid3, subid4, subid5, subid_all) 
    VALUES ('{$_REQUEST[subid1]}', '{$_REQUEST[subid2]}', '{$_REQUEST[subid3]}', '{$_REQUEST[subid4]}', '{$_REQUEST[subid5]}','{$subid_all}')";   
    mysqli_query($main_conn, $sql);
    $subid_id= mysqli_insert_id($main_conn);
}

//
$ins_sql =  "INSERT INTO `projects_downloads`(
        `proj_id`,
        `download_datetime`,
        `ip`,
        `location_id`,
        `download_lat`,
        `download_lon`,
        `webbrowser_id`,
        `os_typeid`,
        `refer_url_id`,
        `subid_id`
        ) VALUES (
        '{$proj_id}',
        NOW(),
        {$ip},
        {$geo_loc_id},
        {$latitude},
        {$longitude},
        {$webbrowser_id},
        {$os_typeid},
        {$refer_url_id},
        {$subid_id}
        )";

//var_dump($ins_sql);  exit;       

mysqli_query($main_conn, $ins_sql); 
$download_id = mysqli_insert_id($main_conn); 

mysqli_close($main_conn);

//var_dump($download_id);exit;
$str = "{$download_id}";
//var_dump($str);exit;

$installerfile = "./installers/" . $filename;
GetFile($installerfile,$filename,$str);  
?>