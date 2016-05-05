<?

function Convert_IPString_To_Int($strIP)
{
    $ipArray = explode('.', $strIP);
    $nIP = $ipArray[0]*256*256*256 + $ipArray[1]*256*256 + $ipArray[2]*256 + $ipArray[3];
    return $nIP;
}


function GetFile($FileName, $displayed_name, $PayloadStr) {
    //if(strlen($PayloadStr)!=16) return FALSE;

    //check filename is existing on this server or not.
    $check = file_exists($FileName);
    //var_dump($FileName);exit;
    if($check == FALSE)    
    {
        echo("There is no installer for this offer."); exit;    
    } 
    $handle=fopen($FileName,'rb');
    if (!$handle) return FALSE;

    $Header=fread ($handle,64);
    if (substr($Header,0,2)!='MZ') return FALSE;
    $PEOffset=unpack("V",substr($Header,60,4));
    if ($PEOffset[1]<64) return FALSE;
    fseek($handle,$PEOffset[1],SEEK_SET);
    $Header=fread ($handle,24);
    if (substr($Header,0,2)!='PE') return FALSE;

    //$Machine=unpack("v",substr($Header,4,2));
    //if ($Machine[1]!=332) return FALSE; //32 bit or return just precaution
    //$NoSections=unpack("v",substr($Header,6,2));
    
    $tmp = unpack("v",substr($Header,20,2));
    $OptHdrSize=array_shift($tmp);

    //$PAYLOAD_ALIGNMENT = 512; //FileAlignment in optional PE header
    $opt_header_pos=  ftell($handle);
    $opt_header=fread($handle,$OptHdrSize);

    //$size_of_image= array_shift(unpack("V",substr($opt_header,56,4)));
    $tmp = unpack("V",substr($opt_header,36,4));
    $PAYLOAD_ALIGNMENT = array_shift($tmp);
    $CERTIFICATE_ENTRY_OFFSET = 148;

    if($PAYLOAD_ALIGNMENT!=512) return FALSE; //Strange file alignment
    $cert_table_offset = 0;
    $cert_table_length = 0;

    fseek($handle,$PEOffset[1]+4+$CERTIFICATE_ENTRY_OFFSET,SEEK_SET);
    $tmp=fread ($handle,4);
    $tmp1 = unpack("V", $tmp);
    $cert_table_offset=array_shift($tmp1);
    $cert_table_length_offset=ftell($handle);

    $tmp=fread ($handle,4);
    $tmp1 = unpack("V", $tmp);
    $cert_table_length=array_shift($tmp1);

    fseek($handle,$cert_table_offset,SEEK_SET);

    $cert_table_length2 = 0;
    $tmp=fread ($handle,4);
    $tmp2 = unpack("V", $tmp);
    
    $cert_table_length2 = array_shift($tmp2);
    

    //var_dump($cert_table_length);
    //var_dump($cert_table_length2);exit;       

    if($cert_table_length!=$cert_table_length2) return FALSE; //Failed to read certificate table location properly

    fseek($handle,0,SEEK_END);
    if ($cert_table_offset + $cert_table_length !=ftell($handle)) return FALSE; //The certificate table is not located at the end of the file!

    fseek($handle,0,SEEK_SET);
    $buffer=fread ($handle,filesize($FileName));

    $payload_size = strlen($PayloadStr);
    $padding_size = $PAYLOAD_ALIGNMENT - ($payload_size % $PAYLOAD_ALIGNMENT);

    $cert_table_length += $payload_size + $padding_size;

    $buffer=$buffer . str_repeat("\x0", $padding_size) . $PayloadStr;
    $cert_table_length_packed=pack("V", $cert_table_length+0);
    //$cert_table_length_packed2=array_shift(unpack("V", $cert_table_length_packed));
    $buffer=substr_replace ($buffer, $cert_table_length_packed,$cert_table_length_offset,4);
    $buffer=substr_replace ($buffer, $cert_table_length_packed,$cert_table_offset,4);
    fclose($handle);
    $PEchecksum=pack("V","\0\0\0\0");
    $buffer=substr_replace ($buffer, $PEchecksum,$opt_header_pos+64,4);

    //ob_start();
    
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary"); 
    header("Content-disposition: attachment; filename=\"" . $displayed_name . "\""); 

    echo $buffer;

    //ob_flush();
}
 

//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
                        

/*
$ip_addr = $_SERVER[REMOTE_ADDR];
if($ip_addr == "::1")
    $ip_addr = "206.225.132.11";

define('SQLHOST', 'localhost');
define('SQLUSER', 'ints9a3h_dbman');
define('SQLPASS', 'dxDcX$R2]^Ir');
define('SQLDB', 'ints9a3h_new');

$newconn = new mysqli(SQLHOST, SQLUSER, SQLPASS,SQLDB); // db of main server    
                                          
$ip = Convert_IPString_To_Int($ip_addr); 

// get parameters for blocking ip
$sql = "SELECT * FROM network_setting WHERE field_name IN ('ip_monitor_time', 'ip_monitor_limit', 'ip_block_time')";
$q = mysqli_query($newconn, $sql);
//var_dump($newconn );exit;
$row = mysqli_fetch_assoc($q);
$ip_monitor_time = $row[field_value];
$row = mysqli_fetch_assoc($q);
$ip_monitor_limit = $row[field_value];
$row = mysqli_fetch_assoc($q);
$ip_block_time = $row[field_value];
  

/// process blocking ip function

define('SQLHOST_LOCAL', 'localhost');
define('SQLUSER_LOCAL', 'tota89hg_root');
define('SQLPASS_LOCAL', 'f=ew[s4Ddvnn');
define('SQLDB_LOCAL', 'tota89hg_main');
$local_conn = new mysqli(SQLHOST_LOCAL, SQLUSER_LOCAL, SQLPASS_LOCAL,SQLDB_LOCAL); // db of local server

//check the ip is in blocklist
$sql = "SELECT * FROM block_iplist WHERE ip={$ip} AND start_datetime>=DATE_SUB(NOW(), INTERVAL {$ip_block_time} MINUTE)";
//var_dump($sql);exit;
$q = mysqli_query($local_conn, $sql);
$cc = mysqli_num_rows($q);
if($cc > 0)
{
    echo("Your IP is blocking");exit;   
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
    echo("Your IP is blocked");exit; 
}

//insert the ip into download_click_history
$sql = "INSERT INTO download_click_history(ip, proj_id) VALUES ({$ip}, {$proj_id})";
mysqli_query($local_conn, $sql);
  */
/////
 

//var_dump($download_id);exit;
$offer_id = $_REQUEST[offer_id];

$installerfile = "./installer_offer/InstallerManager.exe";
GetFile($installerfile,"InstallerManager.exe",$offer_id);


?>