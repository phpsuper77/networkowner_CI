<?      
include 'common/config.php';

if ($_REQUEST['tryout'] == '1') 
{
           
    $sql = "SELECT user_email, user_pass FROM `users` WHERE LOWER(`user_email`)='" . strtolower($_REQUEST['user_email']) . "'";   
    //var_dump($sql);exit; 
    $q = mysqli_query($newconn, $sql);
    
    $cc = mysqli_num_rows($q);
    //var_dump($row);exit;   
    if($cc == 0)
    {
        //no email
        echo('<script language="JavaScript">window.location.href = "index.php?mode=forget&error=noemail"</script>');
        break;
    } 
    $row = mysqli_fetch_assoc($q); 
    $new_pass = RandomString();
    $sql = "UPDATE users SET user_pass='" . md5($new_pass) . "' WHERE user_email='" . strtolower($_REQUEST['user_email']) . "'"; 
    //var_dump($sql);exit; 
    mysqli_query($newconn, $sql);

    
    $to = $row[user_email];                                               
    $subject = 'Your password of Installmetrix.com';

    // message
    $message = "
    <html>
    <head>
      <title>Installmetrix</title>
    </head>
    <body>
      <p>Here is your password on Installmetrix.com</p>
      <span>{$new_pass}</span>
      <br><br>
      <span>Security manager recommends you to change your password asap after login.</span>
    </body>
    </html>
    ";

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Additional headers    
    $headers .= 'From: Installmetrix <supports@installmetrix.com>' . "\r\n";
    
    // Mail it
    mail($to, $subject, $message, $headers);
    
    echo('<script language="JavaScript">window.location.href = "index.php?mode=forget&error=success"</script>');

} 
else 
{   
    echo('<script language="JavaScript">window.location.href = "index.php"</script>');   
}
?>
