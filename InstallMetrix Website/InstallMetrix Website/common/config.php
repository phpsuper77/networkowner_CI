<?PHP

include 'simpleimage.php';

include('additional/FirePHPCore/FirePHP.class.php');
include('additional/FirePHPCore/fb.php');
ob_start();
error_reporting(NULL);
//error_reporting(E_ALL ^ E_NOTICE);
session_start();
/*
define('SQLHOST', 'localhost');
define('SQLUSER', 'tota89hg_root');
define('SQLPASS', 'rootroot');
define('SQLDB', 'tota89hg_main');
 */
 
define('SQLHOST', 'localhost');
define('SQLUSER', 'root');
define('SQLPASS', 'root');
define('SQLDB', 'ints9a3h_new');
//define('SQLDB', 'new2');

define('LONGDATE', 'l, F jS, Y');
define('SHORTDATE', 'd M Y');

define('LONGDATETIME', 'l, F jS, Y. h:i A');
define('SHORTDATETIME', 'm/d/Y h:i A');

define('TOSQLDATE', 'Y-m-d');
define('TOUSDATE', 'm-d-Y');

define('ACP_VERSION', '1.1.0.25');


$my_common_path = $_SERVER["DOCUMENT_ROOT"] . "/network_owner/common/";
$common_path_url = "http://localhost/network_owner/common/"; //david 
$download_url = "http://localhost/network_owner/common/download.php?cid=";

$arr_timezone = array(
-12,-11,-10,-9,-8,-7,-7,-7,-6,-6,-6,-6,-5,-5,-5,-4,-4,-4,-3,-3,-3,-3,-2,-1,-1,-0,-0,1,1,1,1,1,2,2,2,2,2,2,3,3,3,3,3,4,4,4,5,5,5,5,6,6,6,6,7,7,8,8,8,8,8,9,9,9,9,9,10,10,10,10,10,11,12,12,13
);

//var_dump($_REQUEST);exit;   

$user_id = $_SESSION[user_id];

if($_REQUEST[timezone] == NULL) $_REQUEST[timezone] = 4;
$timezone = $arr_timezone[$_REQUEST[timezone]];
$default_timezone = -8;
$diff_timezone = $timezone - $default_timezone;


$newconn = new mysqli(SQLHOST, SQLUSER, SQLPASS,SQLDB);

/*
$conn = mysql_connect(SQLHOST, SQLUSER, SQLPASS);
mysql_select_db(SQLDB);
*/
mysqli_query($newconn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");


unset($system_const);
$sql = "SELECT `id`,`const_value` FROM `system_constants`";
$q = mysqli_query($newconn, $sql);
while ($row = mysqli_fetch_assoc($q)) {
    $system_const[$row[id]] = $row[const_value];
}

function RandomString()
{
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $len = strlen($characters);
    
     
    $randstring = "";
    for ($i = 0; $i < 16; $i++) {
        $randstring .= $characters[rand(0, $len-1)];
    }
    return $randstring;     
}

function CheckRevenues($user_type, $revenue)
{    
    global $newconn;
    if($user_type == 3)//publisher
    {
        $sql = "SELECT field_value FROM network_setting  WHERE field_name='max_revenue_publisher'"; 
        $q = mysqli_query($newconn, $sql);  
        $row = mysqli_fetch_assoc($q);
        $max_val = floatval($row[field_value]);
        $current_cal = floatval($revenue);
        if($current_cal>$max_val)
        {
             return "<li>Maximum Publisher revenue is not able to lager than {$max_val}%, Please check revenue again </li>";
        }        
    }
    else if($user_type == 5)//PM
    {
        $sql = "SELECT field_value FROM network_setting  WHERE field_name='max_revenue_PM'"; 
        $q = mysqli_query($newconn, $sql);  
        $row = mysqli_fetch_assoc($q);
        $max_val = floatval($row[field_value]);
        $current_cal = floatval($revenue);
        
       
        if($current_cal>$max_val)
        {
             return "<li>Maximum Publisher Manager revenue is not able to lager than {$max_val}%, Please check revenue again </li>";
        } 
    }
    else if($user_type == 4)//AM
    {
        $sql = "SELECT field_value FROM network_setting  WHERE field_name='max_revenue_AM'"; 
        $q = mysqli_query($newconn, $sql);  
        $row = mysqli_fetch_assoc($q);
        $max_val = floatval($row[field_value]);
        $current_cal = floatval($revenue);
        if($current_cal>$max_val)
        {
             return "<li>Maximum Advertiser Manager revenue is not able to lager than {$max_val}%, Please check revenue again </li>";
        } 
    }
    return '';  
}

function get_country($ip_addr) {
    $geoplugin = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip_addr));
    $url = 'http://www.geoplugin.net/php.gp?ip=' . $ip_addr;
    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL, $url);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch1);
    $geoplugin = unserialize($result);
    return $geoplugin[geoplugin_countryCode];
}

function square_crop($src_image, $dest_image, $thumb_size = 60, $jpg_quality = 90) {
    $image = getimagesize($src_image);
    if ($image[0] <= 0 || $image[1] <= 0)
        return false;
    $image['format'] = strtolower(preg_replace('/^.*?\//', '', $image['mime']));
    switch ($image['format']) {
        case 'jpg':
        case 'jpeg':
            $image_data = imagecreatefromjpeg($src_image);
            break;
        case 'png':
            $image_data = imagecreatefrompng($src_image);
            break;
        case 'gif':
            $image_data = imagecreatefromgif($src_image);
            break;
        default:
            return false;
            break;
    }
    if ($image_data == false)
        return false;
    if ($image[0] & $image[1]) {
        $x_offset = ($image[0] - $image[1]) / 2;
        $y_offset = 0;
        $square_size = $image[0] - ($x_offset * 2);
    } else {
        $x_offset = 0;
        $y_offset = ($image[1] - $image[0]) / 2;
        $square_size = $image[1] - ($y_offset * 2);
    }
    $canvas = imagecreatetruecolor($thumb_size, $thumb_size);
    if (imagecopyresampled(
                    $canvas, $image_data, 0, 0, $x_offset, $y_offset, $thumb_size, $thumb_size, $square_size, $square_size
    )) {
        switch (strtolower(preg_replace('/^.*\./', '', $dest_image))) {
            case 'jpg':
            case 'jpeg':
                return imagejpeg($canvas, $dest_image, $jpg_quality);
                break;
            case 'png':
                return imagepng($canvas, $dest_image);
                break;
            case 'gif':
                return imagegif($canvas, $dest_image);
                break;
            default:
                return false;
                break;
        }
    } else {
        return false;
    }
}

function custom_crop($scr_image, $dest_image, $result_width, $result_height) {
    $image = imagecreatefromjpeg($scr_image);
    $filename = $dest_image;

    $thumb_width = $result_width;
    $thumb_height = $result_height;

    $width = imagesx($image);
    $height = imagesy($image);

    $original_aspect = $width / $height;
    $thumb_aspect = $thumb_width / $thumb_height;

    if ($original_aspect >= $thumb_aspect) {
        $new_height = $thumb_height;
        $new_width = $width / ($height / $thumb_height);
    } else {
        $new_width = $thumb_width;
        $new_height = $height / ($width / $thumb_width);
    }
    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
    imagecopyresampled($thumb, $image, 0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0, $new_width, $new_height, $width, $height);
    imagejpeg($thumb, $filename, 100);
}

function Convert_IPString_To_Int($strIP)
{
    $ipArray = explode('.', $strIP);
    $nIP = $ipArray[0]*256*256*256 + $ipArray[1]*256*256 + $ipArray[2]*256 + $ipArray[3];
    return $nIP;
}

?>
