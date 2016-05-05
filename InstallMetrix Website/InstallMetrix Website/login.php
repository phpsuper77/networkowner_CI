<?      
include 'common/config.php';

if ($_REQUEST['tryout'] == '1') {
    
    if ($_SERVER[REMOTE_ADDR] == '46.146.232.230') {
        $ip_addr = '78.80.3.70';
    } else {
        $ip_addr = $_SERVER[REMOTE_ADDR]; 
        //$ip_addr = '78.80.3.70';
       
    }
    
    //var_dump($_REQUEST);exit;
    //$country = get_country($ip_addr);    //david
        
    $ip_addr = '61.176.96.70';  
    $country = "CN";   //david

    
       
    $sql = "SELECT * FROM `users` WHERE (LOWER(`user_email`)='" . strtolower($_REQUEST['user_email']) . "' OR LOWER(`user_name`)='" . strtolower($_REQUEST['user_email']) . "') AND `user_pass`='" . strtolower(md5($_REQUEST['user_pass'])) . "'";
    //echo $sql;  exit;
    $q = mysqli_query($newconn, $sql);
       
    $row = mysqli_fetch_array($q);
    //var_dump($row);exit;
                
    if (mysqli_num_rows($q) == 0) {
        $errormsg = 'Wrong user name and/or password!';
        //mysql_query("INSERT INTO `users_log` (`tryout_ip`, `tryout_country`, `tryout_user_email`, `tryout_status`) VALUES ('{$ip_addr}', '{$country}', '$_REQUEST[user_email]', 'UNSUCCESS')");
        
        //echo('<script language="JavaScript"> alert("' . $errormsg . '");</script>');
        echo('<script language="JavaScript">window.location.href = "index.php?mode=login&error=wrong"</script>'); 
        
    } else {      
        if ($row[user_system_status] == '0') 
        {   
            $errormsg = 'Your account is suspended!';
            //echo('<script language="JavaScript"> alert("' . $errormsg . '");</script>');
            echo('<script language="JavaScript">window.location.href = "index.php?mode=login&error=suspend"</script>'); 
        } 
        else if ($row[user_system_status] == '2') 
        {   
            $errormsg = 'Your account is reviewing! it will finish in 48hrs ';
            //echo('<script language="JavaScript"> alert("' . $errormsg . '");</script>');
            echo('<script language="JavaScript">window.location.href = "index.php?mode=login&error=review"</script>'); 
        }
        else 
        {
                           
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['user_email'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_first_name'] = $row['user_first_name'];
            $_SESSION['user_last_name'] = $row['user_last_name'];
            $_SESSION['user_status'] = $row['user_status'];
            $_SESSION['user_system_status'] = $row['user_system_status'];
            $_SESSION['network_id'] = $row['network_id'];
            mysqli_query($newconn, "UPDATE `users` SET `lastvisit_datetime`=NOW(), `lastvisit_ip`='$ip_addr', `lastvisit_country`='{$country}' WHERE LOWER(`user_email`)='" . strtolower($_REQUEST['user_email']) . "'");
            mysql_query($newconn, "INSERT INTO `users_log` (`tryout_ip`, `tryout_country`, `tryout_user_email`, `tryout_status`) VALUES ('{$ip_addr}', '{$country}', '$_REQUEST[user_email]', 'SUCCESS')");

            $user_s = $row[user_status];
            
            //var_dump($user_s);exit;
            
            if($user_s == "0" || $user_s == "1")
            {
                //var_dump($user_s);exit;
                echo('<script language="JavaScript">window.location.href = "networkowner/dashboard.php"</script>');
            } 
            else if($user_s == "2")
            {
                 echo('<script language="JavaScript">window.location.href = "advertiser_manager/dashboard.php"</script>');   
            }  
            else if($user_s == "3")
            {
                 echo('<script language="JavaScript">window.location.href = "publisher/dashboard.php"</script>');
            }
            else if($user_s == "4")
            {
                 echo('<script language="JavaScript">window.location.href = "advertiser_manager/dashboard.php"</script>');
            }
            else if($user_s == "5")
            {
                 echo('<script language="JavaScript">window.location.href = "publisher_manager/dashboard.php"</script>');
            }
            else if($user_s == "6")
            {
                 echo('<script language="JavaScript">window.location.href = "accountant/reports.php"</script>');
            }
            
            break;

        }
    }
} else {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_first_name']);
    unset($_SESSION['user_last_name']);
    unset($_SESSION['user_status']);
    unset($_SESSION['user_system_status']);
    unset($_SESSION['network_id']);
    
    echo('<script language="JavaScript">window.location.href = "index.php"</script>');   
}
?>
