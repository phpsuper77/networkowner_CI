<?
	include '../common/config.php';
/*
    $arr_timezone = array(
    -12,-11,-10,-9,-8,-7,-7,-7,-6,-6,-6,-6,-5,-5,-5,-4,-4,-4,-3,-3,-3,-3,-2,-1,-1,-0,-0,1,1,1,1,1,2,2,2,2,2,2,3,3,3,3,3,4,4,4,5,5,5,5,6,6,6,6,7,7,8,8,8,8,8,9,9,9,9,9,10,10,10,10,10,11,12,12,13
    );

    //var_dump($_REQUEST);exit;   
    
    if($_REQUEST[timezone] == NULL) $_REQUEST[timezone] = 4;
    $timezone = $arr_timezone[$_REQUEST[timezone]];
    $default_timezone = -8;
    $diff_timezone = $timezone - $default_timezone;  
*/    
    

	if ($_REQUEST['type']=='advertising')
	{
	    $campign = $_REQUEST['searchCampaign'];
        
	    $_REQUEST['form-date-range1-startdate'] = $_REQUEST['startDate'];
	    $_REQUEST['form-date-range1-enddate'] = $_REQUEST['endDate'];
        
        $date = substr($_REQUEST['startDate'], 0, 10) . "  ~  " . substr($_REQUEST['endDate'], 0, 10);
        
	    $cat = $_REQUEST['searchCatagory'];
	    $i = 0;  
	    $_REQUEST[search_string_1] = $_REQUEST['searchString'];
		$tmp_id = 0;   

$sql = "
SELECT  o.id as offer_id, o.offer_name, 
        cr.offer_shown, cr.install_accepted, cr.install_started, cr.install_completed, 
        cr.price as total 
FROM 
        offers o
LEFT JOIN
        (SELECT offer_id, sum(offer_shown) as offer_shown, sum(install_accepted) as install_accepted, 
        sum(install_started) as install_started, sum(install_completed) as install_completed ,
        sum(install_completed*price*adjust_rate/100) as price
        FROM install_offers 
        WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range1-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range1-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
        GROUP BY offer_id) cr 
ON o.id=cr.offer_id
WHERE 
    o.assigned_user_id={$user_id} AND
    o.offer_name LIKE '%{$_REQUEST[search_string_1]}%'
ORDER BY cr.price DESC"; 
	
        //echo("<textarea>" . $sql . "</textarea>");exit;
       

		$q = mysqli_query($newconn,$sql);
	    
		header('Content-Type: application/octet-stream');
	    header("Content-Transfer-Encoding: Binary"); 
	    header("Content-disposition: attachment; filename=\"advertisers.csv\""); 
		$outstream = fopen("php://output", 'w');
	     
	    $titleLine = array();
        array_push($titleLine,"Date");
	    array_push($titleLine,"Offer");
	    array_push($titleLine,"Offer Screens");
	    array_push($titleLine,"Install Accepted");
	    array_push($titleLine,"Install Started");
	    array_push($titleLine,"Install Successed");
        array_push($titleLine,"Advertiser Revenue");
	    fputcsv	($outstream,$titleLine,',','"');
	  
	    
	    
	    while ($row =  mysqli_fetch_assoc($q))
		{
			$workrow = array();
            array_push($workrow,$date);
            array_push($workrow,$row['offer_name']);
			if (strlen(trim($row['offer_shown']))>0)	{array_push($workrow,$row['offer_shown']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_accepted']))>0)	{array_push($workrow,$row['install_accepted']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_started']))>0)	{array_push($workrow,$row['install_started']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,$row['install_completed']);}	else{array_push($workrow,'0');}
            if (strlen(trim($row['adjust_install']))>0)    {array_push($workrow,(int)$row['adjust_install']);}    else{array_push($workrow,'0');}
			if (strlen(trim($row['total']))>0)	{array_push($workrow,number_format($row[total],2));}	else{array_push($workrow,'0');}
			
			fputcsv	($outstream,$workrow,',','"');
		}
}
	else if ($_REQUEST['type']=='geo')
	{
		$_REQUEST['form-date-range6-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range6-enddate'] = $_REQUEST['endDate'];
        $date = substr($_REQUEST['startDate'], 0, 10) . "  ~  " . substr($_REQUEST['endDate'], 0, 10);
        $_REQUEST['search_string_6'] = $_REQUEST['searchString'];
        
$arr_res_tmp = array();
   $sql = "
SELECT 
    pd.location_id, 
    l.country, 
    sum(io.install_completed*io.price*io.adjust_rate/100) as total,
    sum(io.offer_shown) as offer_shown, sum(io.install_accepted) as install_accepted, 
    sum(io.install_started) as install_started, sum(io.install_completed) as install_completed
FROM 
(
    SELECT * FROM install_offers 
    WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
            install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND
            user_id={$user_id}
) io
INNER JOIN projects_downloads pd ON io.download_id=pd.id  
LEFT JOIN geo_location l ON l.id=pd.location_id
WHERE
    (
        l.country LIKE '%{$_REQUEST[search_string_6]}%' OR 
        l.city LIKE '%{$_REQUEST[search_string_6]}%'
    )    
GROUP BY l.country
ORDER BY sum(install_completed*io.price*io.adjust_rate) DESC
    ";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn,$sql);

		        
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"geo.csv\"");

        $outstream = fopen("php://output", 'w');

        $titleLine = array();
        array_push($titleLine,"Date");
        array_push($titleLine,"Country");
        array_push($titleLine,"Offer Shown");
        array_push($titleLine,"Installs Accepted");
        array_push($titleLine,"Installs Started");
        array_push($titleLine,"Installs Completed");
        array_push($titleLine,"Revenue");
        array_push($titleLine,"RPI");
        fputcsv	($outstream,$titleLine,',','"');
	    
	    while ($row = mysqli_fetch_assoc($q)) 
		{
			$workrow = array();
            array_push($workrow,$date);
			array_push($workrow,$row['country']);
			if (strlen(trim($row['offer_shown']))>0)		{array_push($workrow,$row['offer_shown']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_accepted']))>0)	{array_push($workrow,$row['install_accepted']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_started']))>0)	{array_push($workrow,$row['install_started']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,$row['install_completed']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['total']))>0)				{array_push($workrow,number_format($row[total], 2, ".", ","));} else{array_push($workrow,'0');}
			if (strlen(trim($row['total']/$row['install_completed']))>0)	{array_push($workrow,number_format($row[total]/$row[install_completed], 2, ".", ","));}	else{array_push($workrow,'0');}
			fputcsv	($outstream,$workrow,',','"');
		}
	}
    else if ($_REQUEST['type']=='day')
    {
        $_REQUEST['form-date-range8-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range8-enddate'] = $_REQUEST['endDate'];
        
        $country = $_REQUEST['searchCountry'];
        $offer = $_REQUEST['searchOffer']; 
        
                     $sql = "    
                        SELECT
                            io.install_datetime, hour(io.install_datetime) as hour,           
                            sum(io.offer_shown) as offer_shown,
                            sum(io.install_accepted) as install_accepted,
                            sum(io.install_started) as install_started,
                            sum(io.install_completed) as install_completed,
                            sum(io.install_completed * io.adjust_rate/100) as adjust_install,
                            sum(io.price * io.adjust_rate/100 * io.install_completed) as revenue
                        FROM 
                            ( 
                                SELECT * FROM install_offers 
                                WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                        install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND
                                        user_id={$user_id}                                        
                            )io                        
                        LEFT JOIN offers ON io.offer_id = offers.id                        
                        LEFT JOIN projects_downloads pd ON pd.id=io.download_id
                        LEFT JOIN geo_location gl ON gl.id=pd.location_id
                        WHERE                            
                            offers.offer_name LIKE '%{$offer}%' AND 
                            (
                                gl.country LIKE '%{$country}%' OR 
                                gl.city LIKE '%{$country}%'
                            )                                                                        
                        GROUP BY hour(io.install_datetime)
                        ORDER BY install_datetime
                    ";
                    //var_dump($sql); exit;                                
                          
        $time_arr = array("midnight-1AM", "1AM-2AM", "2AM-3AM", "3AM-4AM", "4AM-5AM", "5AM-6AM", "6AM-7AM", "7AM-8AM", "8AM-9AM", "9AM-10AM", "10AM-11AM", "11AM-12PM",
                            "12PM-1PM", "1PM-2PM", "2PM-3PM", "3PM-4PM", "4PM-5PM", "5PM-6PM", "6PM-7PM", "7PM-8PM", "8PM-9PM", "9PM-10PM", "10PM-11PM", "11PM-midnight" ) ;

        
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"day.csv\""); 
       
        $outstream = fopen("php://output", 'w');
        
        $titleLine = array();
        array_push($titleLine,"Time");
        
        array_push($titleLine,"Offer Shown");
        array_push($titleLine,"Installs Accepted");
        array_push($titleLine,"Installs Started");
        array_push($titleLine,"Installs Completed");
        array_push($titleLine,"Revenue");
        array_push($titleLine,"RPI");
        fputcsv    ($outstream,$titleLine,',','"');
        
        
        
        $q = mysqli_query($newconn,$sql);
        
        $pre_hour = 0;
        while($row=mysqli_fetch_assoc($q))
        {    
            $hour = ($row[hour] + $diff_timezone) % 24;
            if($hour<0) $hour = $hour + 24;
                                              
            for($xx=$pre_hour;$xx<$hour-1;$xx++)              
            {
                $workrow1 = array();    
                array_push($workrow1,$time_arr[$xx]);
                array_push($workrow1,0);
                array_push($workrow1,0);
                array_push($workrow1,0);                
                array_push($workrow1,0);                
                array_push($workrow1,0.00);
                array_push($workrow1,0.00);
                fputcsv    ($outstream,$workrow1,',','"');                                
            }
            
            $workrow = array();    
            array_push($workrow,$time_arr[$hour]);
            
            $offer_shown = $row[offer_shown];
            $install_accepted = $row[install_accepted];
            $install_started = $row[install_started];
            $install_completed = $row[install_completed];
            $revenue = $row[revenue];
            
            if (strlen(trim($offer_shown))                >0)        {array_push($workrow,$offer_shown);} else{array_push($workrow,'0');}
            if (strlen(trim($install_accepted))        >0)        {array_push($workrow,$install_accepted);}                else{array_push($workrow,'0');}
            if (strlen(trim($install_started))        >0)        {array_push($workrow,$install_started);}                else{array_push($workrow,'0');}
            if (strlen(trim($install_completed))    >0)        {array_push($workrow,$install_completed);}                else{array_push($workrow,'0');}
            if (strlen(trim($revenue))                >0)        {array_push($workrow,number_format($revenue,2));}        else{array_push($workrow,'0');}
            if (strlen(trim($revenue/$install_completed))>0)        {array_push($workrow,number_format($revenue/$install_completed,2));}        else{array_push($workrow,'0');}
            
            fputcsv    ($outstream,$workrow,',','"');    
            $pre_hour = $hour;                                                                     

        }
        for($xx=$hour+1;$xx<24;$xx++)
        {
                $workrow1 = array();    
                array_push($workrow1,$time_arr[$xx]);
                array_push($workrow1,0);
                array_push($workrow1,0);
                array_push($workrow1,0);                
                array_push($workrow1,0);                
                array_push($workrow1,0.00);
                array_push($workrow1,0.00);
                fputcsv    ($outstream,$workrow1,',','"');                                
        }
    }
    else if ($_REQUEST['type']=='daily')
    {
        $_REQUEST['form-date-range9-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range9-enddate'] = $_REQUEST['endDate'];        
        
        $_REQUEST[geo_9] = $_REQUEST['searchCountry'];         
        $_REQUEST[offer_9] = $_REQUEST['searchOffer'];
        $country = $_REQUEST[geo_9];
        $offer = $_REQUEST[offer_9];
        
        $sql = "
        SELECT  DATE_FORMAT(io.install_datetime, '%Y-%m-%d') as date,
                sum(io.offer_shown) as offer_shown,
                sum(io.install_accepted) as install_accepted, sum(io.install_started) as install_started, 
                sum(install_completed) as install_completed, sum(io.install_completed * io.adjust_rate / 100) as adjust_install,
                sum(io.install_completed*io.price*io.adjust_rate/100) as total 
        FROM 
        (
            SELECT * FROM install_offers 
            WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND                
                    install_datetime <= DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND
                    user_id={$user_id}
        ) io
        LEFT JOIN projects_downloads pd ON pd.id=io.download_id
        LEFT JOIN geo_location gl ON gl.id=pd.location_id
        LEFT JOIN offers o ON io.offer_id=o.id                 
        WHERE                   
                o.offer_name LIKE '%{$offer}%' AND
                (
                    gl.country LIKE '%{$country}%' OR 
                    gl.city LIKE '%{$country}%'
                )                                                                        
        GROUP BY DATE_FORMAT(io.install_datetime, '%Y-%m-%d')
        ";
        
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"dailyBreakdown.csv\""); 
       
        $outstream = fopen("php://output", 'w');
        
        $titleLine = array();
        array_push($titleLine,"Date");        
        array_push($titleLine,"Offer Shown");
        array_push($titleLine,"Installs Accepted");
        array_push($titleLine,"Installs Started");
        array_push($titleLine,"Installs Completed");                                                            
        array_push($titleLine,"Revenue");
        
        fputcsv    ($outstream,$titleLine,',','"');
        
        
        
        $q = mysqli_query($newconn,$sql);
        
        $pre_hour = 0;
        while($row=mysqli_fetch_assoc($q))
        {
            $workrow = array();
            array_push($workrow,$row['date']);
            if (strlen(trim($row['offer_shown']))>0)                {array_push($workrow,$row['offer_shown']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['install_accepted']))>0)                {array_push($workrow,$row['install_accepted']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['install_started']))>0)                {array_push($workrow,$row['install_started']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['install_completed']))>0)                {array_push($workrow,$row['install_completed']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['total']))>0)                {array_push($workrow,number_format($row[total],2));}    else{array_push($workrow,'0');}
            
            fputcsv    ($outstream,$workrow,',','"');                                                   
        }   
            
    }

?>
