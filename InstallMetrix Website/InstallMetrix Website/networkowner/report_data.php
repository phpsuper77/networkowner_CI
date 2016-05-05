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
SELECT u1.id as user_id, u1.subid, CONCAT(u1.user_first_name, ' ', u1.user_last_name) as user_name, 
             u2.id as manager_id, CONCAT(u2.user_first_name, ' ', u2.user_last_name) as manager_name, o.id as offer_id, o.offer_name, 
             ct.cat_id, ct.name as cat_name, cr.offer_shown, cr.install_accepted, cr.install_started, cr.install_completed, cr.adjust_install, 
             pr.price as total, pr.am_commission, pr.network_revenue 
FROM 
        offers o
";
if ($campign!=-1) 
    $sql .= "INNER JOIN";
else
    $sql .= "LEFT JOIN";
 
$sql .= "
        (SELECT offer_id, sum(offer_shown) as offer_shown, sum(install_accepted) as install_accepted, 
        sum(install_started) as install_started, sum(install_completed) as install_completed ,sum(install_completed*adjust_rate/100) as adjust_install 
        FROM install_offers 
        WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range1-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range1-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
        ";
        if ($campign!=-1) $sql .= "AND proj_id={$campign}";
        $sql .= "
        GROUP BY offer_id) cr 
ON o.id=cr.offer_id
LEFT JOIN 
        (SELECT offer_id, sum(price*adjust_rate/100) as price, sum(price*adjust_rate/100*am_revenue) as am_commission, 
                sum(price*adjust_rate/100*(100-am_revenue-pub_revenue-pm_revenue)/100) as network_revenue 
        FROM install_offers 
        WHERE   install_completed=1 AND  
                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range1-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range1-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                ";
                if ($campign!=-1) $sql .= "AND proj_id={$campign}";
        $sql .= "
        GROUP BY offer_id) pr 
ON o.id=pr.offer_id
LEFT JOIN 
        users u1 
ON o.assigned_user_id=u1.id 
LEFT JOIN 
        users u2 
ON u1.user_manager=u2.id 
LEFT JOIN 
        (SELECT oc.offer_id, cat.name, cat.id as cat_id FROM offer_categories oc LEFT JOIN categories cat ON oc.category_id=cat.id WHERE oc.isgroup=0) ct 
ON o.id=ct.offer_id

WHERE 
(   
    o.offer_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u1.user_first_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u1.user_last_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u2.user_first_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u2.user_last_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u1.subid = {$tmp_id}
) 
";
 if ($cat!=-1) $sql .= " AND ct.cat_id={$cat}"; 
$sql .= " ORDER BY pr.price DESC";    
	
        //echo("<textarea>" . $sql . "</textarea>");exit;
       

		$q = mysqli_query($newconn,$sql);
	    
		header('Content-Type: application/octet-stream');
	    header("Content-Transfer-Encoding: Binary"); 
	    header("Content-disposition: attachment; filename=\"advertisers.csv\""); 
		$outstream = fopen("php://output", 'w');
	     
	    $titleLine = array();
        array_push($titleLine,"Date");
	    array_push($titleLine,"AID");
	    array_push($titleLine,"Advertiser Manager");
	    array_push($titleLine,"Advertiser");
	    array_push($titleLine,"Category");
	    array_push($titleLine,"Offer");
	    array_push($titleLine,"Offer Screens");
	    array_push($titleLine,"Install Accepted");
	    array_push($titleLine,"Install Started");
	    array_push($titleLine,"Install Successed");
        array_push($titleLine,"Adjust Install");
	    array_push($titleLine,"Advertiser Revenue");
	    array_push($titleLine,"AM Commision");
	    array_push($titleLine,"Network Revenue");
		fputcsv	($outstream,$titleLine,',','"');
	  
	    
	    
	    while ($row =  mysqli_fetch_assoc($q))
		{
			$workrow = array();
            array_push($workrow,$date);
            array_push($workrow,$row['subid']);			
			array_push($workrow,$row['manager_name']);
			array_push($workrow,$row['user_name']);
			array_push($workrow,$row['cat_name']);
			array_push($workrow,$row['offer_name']);
			if (strlen(trim($row['offer_shown']))>0)	{array_push($workrow,$row['offer_shown']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_accepted']))>0)	{array_push($workrow,$row['install_accepted']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_started']))>0)	{array_push($workrow,$row['install_started']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,$row['install_completed']);}	else{array_push($workrow,'0');}
            if (strlen(trim($row['adjust_install']))>0)    {array_push($workrow,(int)$row['adjust_install']);}    else{array_push($workrow,'0');}
			if (strlen(trim($row['total']))>0)	{array_push($workrow,number_format($row[total],2));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['am_commission']))>0)		{array_push($workrow,number_format($row[am_commission],2));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['network_revenue']))>0)	{array_push($workrow,number_format($row[network_revenue],2));}	else{array_push($workrow,'0');}
            
			fputcsv	($outstream,$workrow,',','"');
		}
}
	else if ($_REQUEST['type']=='publisher')
	{
        $_REQUEST['form-date-range2-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range2-enddate'] = $_REQUEST['endDate'];
        $date = substr($_REQUEST['startDate'], 0, 10) . "  ~  " . substr($_REQUEST['endDate'], 0, 10);
	    $_REQUEST['search_string_2'] = $_REQUEST['searchString'];
        $tmp_id = (int)$_REQUEST[search_string_2];
	
                            $sql = "
                                SELECT     
                                    user_inf.subid,
                                    user_inf.user_id,
                                    user_inf.user_name,
                                    user_inf.manager_id,
                                    user_inf.manager_name,
                                    sum(proj_click.clicks) AS clicks,
                                    sum(proj_state.open_session) AS open_session, 
                                    sum(proj_state.install_accepted) AS install_accepted, 
                                    sum(proj_state.install_started) AS install_started, 
                                    sum(proj_state.install_completed) AS install_completed,
                                    sum(proj_revenue.pub_revenue) AS pub_revenue,
                                    sum(proj_revenue.pm_revenue) AS pm_revenue,
                                    sum(proj_revenue.net_revenue) AS net_revenue            
                                FROM
                                    ( 
                                        SELECT 
                                            u1.subid,
                                            u1.id AS user_id,
                                            u1.user_manager AS manager_id,
                                            CONCAT(u1.user_first_name, ' ', u1.user_last_name) AS user_name, 
                                            CONCAT(u2.user_first_name, ' ', u2.user_last_name) AS manager_name,
                                            u1.user_status                
                                        FROM users u1
                                        LEFT JOIN users u2 ON u1.user_manager = u2.id                
                                    ) user_inf
                                    LEFT JOIN projects ON user_inf.user_id = projects.assigned_user_id
                                    LEFT JOIN 
                                        (
                                            SELECT 
                                                proj_id, count(id) AS clicks
                                            FROM
                                                projects_downloads
                                            WHERE
                                                download_datetime >= DATE_SUB('{$_REQUEST['form-date-range2-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range2-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                            GROUP BY
                                                proj_id
                                        ) proj_click
                                    ON projects.id = proj_click.proj_id
                                    LEFT JOIN     
                                        (
                                            SELECT 
                                                proj_id, 
                                                sum(open_session) AS open_session, 
                                                sum(install_accepted) AS install_accepted, 
                                                sum(install_started) AS install_started, 
                                                sum(install_completed) AS install_completed
                                            FROM 
                                                install_projects
                                            WHERE
                                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range2-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range2-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                            GROUP BY 
                                                proj_id
                                        ) proj_state
                                    ON projects.id = proj_state.proj_id
                                    LEFT JOIN
                                        (
                                            
                                            SELECT
                                                io.proj_id,
                                                sum(io.price*io.adjust_rate/100) AS total,
                                                sum(io.price*io.adjust_rate/100*io.pub_revenue/100) AS pub_revenue,
                                                sum(io.price*io.adjust_rate/100*io.pm_revenue/100) AS pm_revenue,
                                                sum(io.price*io.adjust_rate/100*(100 - io.am_revenue - io.pub_revenue - io.pm_revenue)/100) AS net_revenue
                                            FROM 
                                                (    
                                                    SELECT 
                                                        *
                                                    FROM 
                                                        install_offers
                                                    WHERE
                                                        install_completed = 1 AND
                                                        install_datetime >= DATE_SUB('{$_REQUEST['form-date-range2-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                        install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range2-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                                ) io
                                            GROUP BY io.proj_id
                                        ) proj_revenue
                                    ON projects.id = proj_revenue.proj_id
                                WHERE
                                    user_inf.user_status = 3 AND
                                    (
                                        user_inf.user_name LIKE '%{$_REQUEST[search_string_2]}%' OR 
                                        user_inf.manager_name LIKE '%{$_REQUEST[search_string_2]}%' OR                                                 
                                        user_inf.subid = {$tmp_id}
                                    )                                        
                                GROUP BY user_id ORDER BY net_revenue DESC";                                
 
				//var_dump($sql);exit;
                $q = mysqli_query($newconn,$sql);
	
		header('Content-Type: application/octet-stream');
	    header("Content-Transfer-Encoding: Binary"); 
	    header("Content-disposition: attachment; filename=\"publishers.csv\""); 

		$outstream = fopen("php://output", 'w');
	    
	    $titleLine = array();
        array_push($titleLine,"Date");
	    array_push($titleLine,"Publisher ID");
	    array_push($titleLine,"Publishing Manager");
	    array_push($titleLine,"Publisher");
	    array_push($titleLine,"Clicks");
	    array_push($titleLine,"Open Sessions");
	    array_push($titleLine,"Install Accepted");
	    array_push($titleLine,"Install Started");
	    array_push($titleLine,"Install Completed");
	    array_push($titleLine,"Publisher Revenue");
	    array_push($titleLine,"PM Commission");
	    array_push($titleLine,"Network Revenue");
		fputcsv	($outstream,$titleLine,',','"');
	    
	    while ($row =  mysqli_fetch_assoc($q))
		{
			$workrow = array();
            array_push($workrow,$date);
			array_push($workrow,$row['subid']);
			array_push($workrow,$row['manager_name']);
			array_push($workrow,$row['user_name']);
			
			if (strlen(trim($row['clicks']))>0)        {array_push($workrow,$row['clicks']);}    else{array_push($workrow,'0');}
			if (strlen(trim($row['open_session']))>0)		{array_push($workrow,$row['open_session']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_accepted']))>0)	{array_push($workrow,$row['install_accepted']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_started']))>0)	{array_push($workrow,$row['install_started']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,$row['install_completed']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['pub_revenue']))>0)		{array_push($workrow,number_format($row[pub_revenue], 2, ".", ","));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['pm_revenue']))>0)			{array_push($workrow,number_format($row[pm_revenue], 2,".",","));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['net_revenue']))>0)	{array_push($workrow,number_format($row[net_revenue], 2,".",","));}	else{array_push($workrow,'0');}

			fputcsv	($outstream,$workrow,',','"');
		}
				
				  
	} 
	else if ($_REQUEST['type']=='refferes')
	{
        $_REQUEST['form-date-range3-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range3-enddate'] = $_REQUEST['endDate'];
        $date = substr($_REQUEST['startDate'], 0, 10) . "  ~  " . substr($_REQUEST['endDate'], 0, 10);
        
        $_REQUEST['search_string_3'] = $_REQUEST['searchString'];
        
                            $sql = "                                    
                                    SELECT
                                        pd.proj_id,
                                        pd.download_datetime,
                                        projects.id,
                                        projects.proj_name,
                                        pd.refer_url_id,
                                        refer_url.refer_url,
                                        users.id AS publisher_id,
                                        CONCAT(users.user_first_name, ' ', users.user_last_name) AS publisher_name
                                    FROM
                                        (
                                            SELECT proj_id, download_datetime, refer_url_id 
                                            FROM projects_downloads 
                                            WHERE   projects_downloads.download_datetime >=DATE_SUB('{$_REQUEST['form-date-range3-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                    projects_downloads.download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range3-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                            GROUP BY proj_id, refer_url_id
                                        ) pd
                                        LEFT JOIN projects ON pd.proj_id = projects.id
                                        LEFT JOIN refer_url ON pd.refer_url_id = refer_url.id
                                        LEFT JOIN users ON projects.assigned_user_id = users.id
                                    WHERE
                                        projects.proj_name IS NOT NULL AND
                                        ( 
                                            projects.proj_name LIKE '%{$_REQUEST[search_string_3]}%' OR 
                                            refer_url.refer_url LIKE '%{$_REQUEST[search_string_3]}%' OR
                                            users.user_first_name LIKE '%{$_REQUEST[search_string_3]}%' OR
                                            users.user_last_name LIKE '%{$_REQUEST[search_string_3]}%' 
                                        )                                    
                                    ORDER BY pd.download_datetime 
                                    ";
		/*							
		$myFile = "reftestFile.txt";
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $sql);
        fclose($fh);
		*/							
									
							$q = mysqli_query($newconn,$sql);
	
		header('Content-Type: application/octet-stream');
	    header("Content-Transfer-Encoding: Binary"); 
	    header("Content-disposition: attachment; filename=\"referrer.csv\""); 

		$outstream = fopen("php://output", 'w');
	    
	    $titleLine = array();
	    array_push($titleLine,"Date");
	    array_push($titleLine,"Publisher");
	    array_push($titleLine,"App Name");
	    array_push($titleLine,"Referrer");

		fputcsv	($outstream,$titleLine,',','"');
	    
	    while ($row =  mysqli_fetch_assoc($q))
		{
			$workrow = array();
            //array_push($workrow,$row['download_datetime']);
			array_push($workrow,$date);
			array_push($workrow,$row['publisher_name']);
			array_push($workrow,$row['proj_name']);
			array_push($workrow,$row['refer_url']);
			fputcsv	($outstream,$workrow,',','"');
		}
	}
	else if ($_REQUEST['type']=='campaign')
	{	
        $_REQUEST['form-date-range4-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range4-enddate'] = $_REQUEST['endDate'];
        $date = substr($_REQUEST['startDate'], 0, 10) . "  ~  " . substr($_REQUEST['endDate'], 0, 10);
        $_REQUEST['search_string_4'] = $_REQUEST['searchString'];
        
                            $sql = "
                                SELECT 
                                    projects.id,
                                    projects.proj_name,
                                    proj_click.clicks,
                                    proj_state.open_session,
                                    proj_state.install_accepted,
                                    proj_state.install_started,
                                    proj_state.install_completed,
                                    proj_revenue.total,
                                    proj_revenue.net_revenue,
                                    user_inf.user_id,
                                    user_inf.user_name,
                                    user_inf.manager_id,    
                                    user_inf.manager_name
                                FROM
                                    projects
                                    LEFT JOIN 
                                        (
                                            SELECT 
                                                proj_id, count(id) AS clicks
                                            FROM
                                                projects_downloads
                                            WHERE
                                                download_datetime >= DATE_SUB('{$_REQUEST['form-date-range4-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range4-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                            GROUP BY
                                                proj_id
                                        ) proj_click
                                    ON projects.id = proj_click.proj_id
                                    LEFT JOIN
                                        (
                                            SELECT 
                                                proj_id, 
                                                sum(open_session) AS open_session, 
                                                sum(install_accepted) AS install_accepted, 
                                                sum(install_started) AS install_started, 
                                                sum(install_completed) AS install_completed
                                            FROM 
                                                install_projects
                                            WHERE
                                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range4-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range4-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                            GROUP BY 
                                                proj_id                        
                                        ) proj_state
                                    ON projects.id = proj_state.proj_id
                                    LEFT JOIN
                                        (
                                            
                                            SELECT
                                                io.proj_id,
                                                sum(io.price*io.adjust_rate/100) AS total,
                                                sum(io.price*io.adjust_rate/100*(100 - io.am_revenue - io.pub_revenue - io.pm_revenue)/100) AS net_revenue
                                            FROM 
                                                (    
                                                    SELECT 
                                                        *
                                                    FROM 
                                                        install_offers
                                                    WHERE
                                                        install_completed = 1 AND
                                                        install_datetime >= DATE_SUB('{$_REQUEST['form-date-range4-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                        install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range4-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                                ) io
                                            GROUP BY io.proj_id
                                        ) proj_revenue
                                    ON projects.id = proj_revenue.proj_id
                                    LEFT JOIN 
                                        ( 
                                            SELECT                 
                                                u1.id AS user_id,
                                                u1.user_manager AS manager_id,
                                                CONCAT(u1.user_first_name, ' ', u1.user_last_name) AS user_name, 
                                                CONCAT(u2.user_first_name, ' ', u2.user_last_name) AS manager_name                
                                            FROM users u1
                                            LEFT JOIN users u2 ON u1.user_manager = u2.id 
                                        ) user_inf
                                    ON projects.assigned_user_id = user_inf.user_id
                                WHERE
                                    (
                                            projects.proj_name LIKE '%{$_REQUEST[search_string_4]}%' OR
                                            user_inf.user_name LIKE '%{$_REQUEST[search_string_4]}%' OR                                            
                                            user_inf.manager_name LIKE '%{$_REQUEST[search_string_4]}%'
                                    )
                                ORDER BY total DESC
                                ";
			
			
			$q = mysqli_query($newconn,$sql);
			/*
			$myFile = "aaatestFile.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			fwrite($fh, $sql);
			fclose($fh);
            */
		
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"campaign.csv\""); 

		$outstream = fopen("php://output", 'w');
	    
	    $titleLine = array();
        array_push($titleLine,"Date");
	    array_push($titleLine,"CID");
	    array_push($titleLine,"Manager");
	    array_push($titleLine,"Publisher");
	    array_push($titleLine,"Campaighn");

	    array_push($titleLine,"Clicks");
	    array_push($titleLine,"Open Sessions");
	    array_push($titleLine,"Installs Accepted");
	    array_push($titleLine,"Installs Started");
	    
	    array_push($titleLine,"Installs Completed");

	    array_push($titleLine,"Revenue");
	    array_push($titleLine,"RPI");
	    array_push($titleLine,"EPC");
	    array_push($titleLine,"Network Revenue");
	    


		fputcsv	($outstream,$titleLine,',','"');
	    
	    while ($row =  mysqli_fetch_assoc($q))
		{
			$workrow = array();
            array_push($workrow,$date);
			array_push($workrow,$row['id']);
			array_push($workrow,$row['manager_name']);
			array_push($workrow,$row['user_name']);
			array_push($workrow,$row['proj_name']);
			if (strlen(trim($row['clicks']))>0)	{array_push($workrow,$row['clicks']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['open_session']))>0)		{array_push($workrow,$row['open_session']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_accepted']))>0)	{array_push($workrow,$row['install_accepted']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_started']))>0)	{array_push($workrow,$row['install_started']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,$row['install_completed']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['total']))>0)				{array_push($workrow,number_format($row[total], 2, ".", ","));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,number_format($row[total]/$row[install_completed], 2, ".", ","));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['clicks']))>0)				{array_push($workrow,number_format($row[total]/$row[clicks], 2, ".", ","));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['net_revenue']))>0)	{array_push($workrow,number_format($row[net_revenue], 2, ".", ","));}	else{array_push($workrow,'0');}
			fputcsv	($outstream,$workrow,',','"');
		}
		
	}
	else if ($_REQUEST['type']=='subid')
	{
		$_REQUEST['form-date-range5-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range5-enddate'] = $_REQUEST['endDate'];
        $date = substr($_REQUEST['startDate'], 0, 10) . "  ~  " . substr($_REQUEST['endDate'], 0, 10);
        
$res_arr = array();   
/////                                                     
                            $sql = " 
                                SELECT
                                    pd_click.proj_id, pd_click.subid_id, pd_click.clicks,                                     
                                    s.subid1, s.subid2, s.subid3, s.subid4, s.subid5,
                                    p.proj_name
                                FROM
                                    (
                                        SELECT 
                                            count(id) as clicks, 
                                            proj_id, 
                                            subid_id 
                                        FROM 
                                            projects_downloads 
                                        WHERE
                                            download_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY proj_id, subid_id
                                    ) pd_click                                
                                LEFT JOIN projects p ON pd_click.proj_id = p.id
                                LEFT JOIN subid s ON pd_click.subid_id=s.id
                                WHERE 
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%' AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%'
                                ";
                                //echo("<textarea>" . $sql . "</textarea>"); exit;
$q = mysqli_query($newconn,$sql);
while($row=mysqli_fetch_assoc($q))
{
    $res_arr[$row[proj_id]][$row[subid_id]][proj_id] = $row[proj_id];
    $res_arr[$row[proj_id]][$row[subid_id]][clicks] = $row[clicks];
    $res_arr[$row[proj_id]][$row[subid_id]][subid1] = $row[subid1];
    $res_arr[$row[proj_id]][$row[subid_id]][subid2] = $row[subid2];
    $res_arr[$row[proj_id]][$row[subid_id]][subid3] = $row[subid3];
    $res_arr[$row[proj_id]][$row[subid_id]][subid4] = $row[subid4];
    $res_arr[$row[proj_id]][$row[subid_id]][subid5] = $row[subid5];
    $res_arr[$row[proj_id]][$row[subid_id]][proj_name] = $row[proj_name];
} 

 /////
                            $sql = " 
                                SELECT
                                    pdip.proj_id, pdip.subid_id, 
                                    pdip.open_sessions, pdip.install_accepted, pdip.install_started, pdip.install_completed,                                    
                                    s.subid1, s.subid2, s.subid3, s.subid4, s.subid5,
                                    p.proj_name
                                FROM
                                    (
                                        SELECT 
                                            pd.proj_id, pd.subid_id, 
                                            sum(ip.open_session) as open_sessions, 
                                            sum(ip.install_accepted) as install_accepted, 
                                            sum(ip.install_started) as install_started, 
                                            sum(ip.install_completed) as install_completed 
                                        FROM 
                                            projects_downloads pd 
                                        INNER JOIN install_projects ip ON pd.id=ip.download_id
                                        WHERE
                                            
                                            ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)  
                                        GROUP BY proj_id, subid_id
                                    ) pdip
                                LEFT JOIN projects p ON pdip.proj_id = p.id
                                LEFT JOIN subid s ON pdip.subid_id=s.id
                                WHERE 
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%' AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%'
                                ";
                                //echo("<textarea>" . $sql . "</textarea>"); exit;
$q = mysqli_query($newconn,$sql);
while($row=mysqli_fetch_assoc($q))
{
    $res_arr[$row[proj_id]][$row[subid_id]][proj_id] = $row[proj_id];
    $res_arr[$row[proj_id]][$row[subid_id]][open_sessions] = $row[open_sessions];   
    $res_arr[$row[proj_id]][$row[subid_id]][install_accepted] = $row[install_accepted];
    $res_arr[$row[proj_id]][$row[subid_id]][install_started] = $row[install_started];
    $res_arr[$row[proj_id]][$row[subid_id]][install_completed] = $row[install_completed];
    $res_arr[$row[proj_id]][$row[subid_id]][subid1] = $row[subid1];
    $res_arr[$row[proj_id]][$row[subid_id]][subid2] = $row[subid2];
    $res_arr[$row[proj_id]][$row[subid_id]][subid3] = $row[subid3];
    $res_arr[$row[proj_id]][$row[subid_id]][subid4] = $row[subid4];
    $res_arr[$row[proj_id]][$row[subid_id]][subid5] = $row[subid5];
    $res_arr[$row[proj_id]][$row[subid_id]][proj_name] = $row[proj_name];
}

/////
                            $sql = " 
                                SELECT
                                    pdio.proj_id, pdio.subid_id, pdio.total, pdio.network_revenue, 
                                    s.subid1, s.subid2, s.subid3, s.subid4, s.subid5,
                                    p.proj_name
                                FROM 
                                    (
                                        SELECT 
                                            pd.proj_id, pd.subid_id, 
                                            sum(io.price*io.adjust_rate/100) as total, 
                                            sum(io.price*io.adjust_rate/100*(100-io.am_revenue-io.pub_revenue-io.pm_revenue)/100) as network_revenue 
                                        FROM 
                                            projects_downloads pd 
                                        INNER JOIN 
                                            ( SELECT * FROM install_offers WHERE install_completed=1) io ON pd.id = io.download_id 
                                        WHERE
                                            
                                            io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY pd.proj_id, pd.subid_id
                                    ) pdio 
                                LEFT JOIN projects p ON pdio.proj_id = p.id
                                LEFT JOIN subid s ON pdio.subid_id=s.id
                                WHERE 
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%' AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%'
                                ORDER BY pdio.total DESC
                                ";
                                //echo("<textarea>" . $sql . "</textarea>"); exit;
$q = mysqli_query($newconn,$sql);


$rowcount = 0;
while($row=mysqli_fetch_assoc($q))
{
    $res_arr[$row[proj_id]][$row[subid_id]][proj_id] = $row[proj_id];
    $res_arr[$row[proj_id]][$row[subid_id]][total] = $row[total];
    $res_arr[$row[proj_id]][$row[subid_id]][network_revenue] = $row[network_revenue];
    $res_arr[$row[proj_id]][$row[subid_id]][subid1] = $row[subid1];
    $res_arr[$row[proj_id]][$row[subid_id]][subid2] = $row[subid2];
    $res_arr[$row[proj_id]][$row[subid_id]][subid3] = $row[subid3];
    $res_arr[$row[proj_id]][$row[subid_id]][subid4] = $row[subid4];
    $res_arr[$row[proj_id]][$row[subid_id]][subid5] = $row[subid5];
    $res_arr[$row[proj_id]][$row[subid_id]][proj_name] = $row[proj_name];  //var_dump($res_arr[$row[proj_id]][$row[subid_id]]); 
    
    if ($rowcount < 5)
    {
        array_push($topName,$row[proj_name]);
        array_push($topAmount,$row[total]);
        $rowcount++;
    }
    
    //echo($row[total]);echo("<br>");
}                                  //exit;
                            
								
	    
	
		/*
		header('Content-Type: application/octet-stream');
	    header("Content-Transfer-Encoding: Binary"); 
	    header("Content-disposition: attachment; filename=\"subid.csv\"");
        */
		//$outstream = fopen("php://output", 'w');
        
        $filename = "./csv/subid_" . time();
        $outstream = fopen($filename, 'w');
	    $titleLine = array();
        array_push($titleLine,"Date");
	    array_push($titleLine,"CID");
	    array_push($titleLine,"Application");
	    array_push($titleLine,"Subid #1");
	    array_push($titleLine,"Subid #2");
	    array_push($titleLine,"Subid #3");
	    array_push($titleLine,"Subid #4");
	    array_push($titleLine,"Subid #5");
	    array_push($titleLine,"Clicks");
	    array_push($titleLine,"Open Session");
	    array_push($titleLine,"Installs Accepted");
	    array_push($titleLine,"Installs Started");
	    array_push($titleLine,"Installs Completed");
	    array_push($titleLine,"Revenue");
	    array_push($titleLine,"RPI");
	    array_push($titleLine,"EPC");
	    array_push($titleLine,"Network Revenue");
		fputcsv	($outstream,$titleLine,',','"');
	    
	    foreach($res_arr as $res_arr_proj)
        {
            foreach($res_arr_proj as $row)
		    {
			    $workrow = array();
                array_push($workrow,$date);
			    array_push($workrow,$row['proj_id']);
			    array_push($workrow,$row['proj_name']);
			    array_push($workrow,$row['subid1']);
			    array_push($workrow,$row['subid2']);
			    array_push($workrow,$row['subid3']);
			    array_push($workrow,$row['subid4']);
			    array_push($workrow,$row['subid5']);
			    if (strlen(trim($row['clicks']))>0)				{array_push($workrow,$row['clicks']);}	else{array_push($workrow,'0');}
			    if (strlen(trim($row['open_sessions']))>0)		{array_push($workrow,$row['open_sessions']);}	else{array_push($workrow,'0');}
			    if (strlen(trim($row['install_accepted']))>0)	{array_push($workrow,$row['install_accepted']);}	else{array_push($workrow,'0');}
			    if (strlen(trim($row['install_started']))>0)	{array_push($workrow,$row['install_started']);}	else{array_push($workrow,'0');}
			    if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,$row['install_completed']);}	else{array_push($workrow,'0');}
			    if (strlen(trim($row['total']))>0)				{array_push($workrow,number_format($row[total], 2, ".", ","));}	else{array_push($workrow,'0');}
			    if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,number_format($row[total]/$row[install_completed], 2, ".", ","));}	else{array_push($workrow,'0');}
			    if (strlen(trim($row['clicks']))>0)				{array_push($workrow,number_format($row[total]/$row[clicks], 2, ".", ","));}			else{array_push($workrow,'0');}
			    if (strlen(trim($row['network_revenue']))>0)	{array_push($workrow,number_format($row[network_revenue], 2, ".", ","));}		else{array_push($workrow,'0');}
			    
			    fputcsv	($outstream,$workrow,',','"');
		    }
        }
        
        $url = '<script language="JavaScript">window.location.href = "' . $filename .'"</script>';
        echo($url);
	}
	else if ($_REQUEST['type']=='geo')
	{
		$_REQUEST['form-date-range6-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range6-enddate'] = $_REQUEST['endDate'];

        $date = substr($_REQUEST['startDate'], 0, 10) . "  ~  " . substr($_REQUEST['endDate'], 0, 10);
        
$arr_res_tmp = array();

$adv = $_REQUEST[adv_6];
$offer = $_REQUEST[offer_6];
$pub = $_REQUEST[pub_6];
$camp = $_REQUEST[camp_6];
$subid = $_REQUEST[subid_6];
$country = $_REQUEST[country_6];

if(($adv != "")||($offer != ""))
{
    $sql = "
        SELECT 
            pd.location_id, 
            l.country, 
            sum(io.install_accepted) as install_accepted,
            sum(io.install_started) as install_started,  
            sum(io.install_completed) as install_completed,          
            sum(revenue) as total, 
            sum(network_revenue) as network_revenue
        FROM 
        (
            SELECT  download_id, user_id, offer_id, install_accepted, install_started, install_completed, 
                    (install_completed*price*adjust_rate/100) as revenue,             
                    (install_completed*price*adjust_rate/100*(100-am_revenue-pub_revenue-pm_revenue)/100) as network_revenue
            FROM install_offers 
            WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                    install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
        ) io 
        INNER JOIN projects_downloads pd ON io.download_id=pd.id  
        LEFT JOIN 
        (
            SELECT id FROM subid 
            WHERE subid_all LIKE '%{$subid}%'
        ) s ON s.id=pd.subid_id
        LEFT JOIN 
        (
            SELECT id, country FROM geo_location 
            WHERE
                country LIKE '%{$country}%'         
        ) l ON l.id=pd.location_id
        LEFT JOIN
        (
            SELECT id FROM users WHERE user_first_name LIKE '%{$adv}%' OR user_last_name LIKE '%{$adv}%'
        ) u ON u.id=io.user_id
        LEFT JOIN 
        (
            SELECT id FROM offers WHERE offer_name LIKE '%{$offer}%'
        ) o ON o.id=io.offer_id
        GROUP BY l.country
        ORDER BY sum(io.revenue) DESC
    ";
    //echo("<textarea>" . $sql . "</textarea>");exit;
    $q = mysqli_query($newconn,$sql);
    while ($row = mysqli_fetch_assoc($q)) {
        if($row[country] == NULL)
        {
            $row[country] = "";
        }
        $arr_res_tmp[$row[country]][country] = $row[country];
        $arr_res_tmp[$row[country]][install_accepted] = $row[install_accepted]; 
        $arr_res_tmp[$row[country]][install_started] = $row[install_started]; 
        $arr_res_tmp[$row[country]][install_completed] = $row[install_completed]; 
        $arr_res_tmp[$row[country]][total] = $row[total]; 
        $arr_res_tmp[$row[country]][network_revenue] = $row[network_revenue];
    }    
}
else
{
    $sql = "
            SELECT count(pd.id) as clicks, l.country 
            FROM 
            (
                SELECT id, location_id, proj_id, subid_id FROM projects_downloads 
                WHERE   download_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                        download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
            ) pd 
            LEFT JOIN 
            (
                SELECT id, country FROM geo_location 
                WHERE   country LIKE '%{$country}%'
            ) l ON pd.location_id=l.id
            LEFT JOIN 
            (
                SELECT id, assigned_user_id FROM projects 
                WHERE   proj_name LIKE '%{$camp}%'
            ) p ON p.id=pd.proj_id
            LEFT JOIN 
            (
                SELECT id FROM users 
                WHERE   user_first_name LIKE '%{$pub}%' OR user_last_name LIKE '%{$pub}%'
            ) u ON p.assigned_user_id=u.id        
            LEFT JOIN 
            (
                SELECT id FROM subid WHERE subid_all LIKE '%{$subid}%' 
            ) s ON s.id=pd.subid_id
            
            GROUP BY l.country
        
        ";
    //echo("<textarea>" . $sql . "</textarea>");exit;
    $q = mysqli_query($newconn,$sql);
    while ($row = mysqli_fetch_assoc($q)) {
        if($row[country] == NULL)
        {
            $row[country] = "";
        }    
        $arr_res_tmp[$row[country]][clicks] = $row[clicks];
        $arr_res_tmp[$row[country]][country] = $row[country];
    }    

    $sql = "
    SELECT 
        pd.location_id,
        l.country, 
        sum(ip.open_session) as open_sessions, 
        sum(ip.install_accepted) as install_accepted, 
        sum(ip.install_started) as install_started, 
        sum(ip.install_completed) as install_completed 
    FROM 
    (
        SELECT proj_id, download_id, open_session, install_accepted, install_started, install_completed 
        FROM install_projects 
        WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
    ) ip
    INNER JOIN projects_downloads pd ON pd.id=ip.download_id 
    LEFT JOIN 
    (
        SELECT id, country FROM geo_location 
        WHERE   country LIKE '%{$country}%'
    ) l ON pd.location_id=l.id
    LEFT JOIN 
    (
        SELECT id, assigned_user_id FROM projects 
        WHERE   proj_name LIKE '%{$camp}%'
    ) p ON p.id=ip.proj_id
    LEFT JOIN 
    (
        SELECT id FROM users 
        WHERE   user_first_name LIKE '%{$pub}%' OR user_last_name LIKE '%{$pub}%'
    ) u ON p.assigned_user_id=u.id        
    LEFT JOIN 
    (
        SELECT id FROM subid WHERE subid_all LIKE '%{$subid}%' 
    ) s ON s.id=pd.subid_id  
    GROUP BY l.country
        ";   
    //echo("<textarea>" . $sql . "</textarea>");exit;
    $q = mysqli_query($newconn,$sql);
    while ($row = mysqli_fetch_assoc($q)) {
        if($row[country] == NULL)
        {
            $row[country] = "";
        }    
        $arr_res_tmp[$row[country]][open_sessions] = $row[open_sessions];
        $arr_res_tmp[$row[country]][install_accepted] = $row[install_accepted];
        $arr_res_tmp[$row[country]][install_started] = $row[install_started];
        $arr_res_tmp[$row[country]][install_completed] = $row[install_completed];
        $arr_res_tmp[$row[country]][country] = $row[country];
    }                                 

    $sql = "
    SELECT 
        pd.location_id, 
        l.country, 
        sum(io.revenue) as total, 
        sum(io.net_revenue) as network_revenue
    FROM 
    (
        SELECT download_id, proj_id, (price*adjust_rate/100) as revenue, (price*adjust_rate/100*(100-am_revenue-pub_revenue-pm_revenue)/100) as net_revenue 
        FROM install_offers 
        WHERE   install_completed=1 AND
                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
    ) io 
    INNER JOIN projects_downloads pd ON io.download_id=pd.id  
    LEFT JOIN 
    (
        SELECT id, country FROM geo_location 
        WHERE   country LIKE '%{$country}%'
    ) l ON pd.location_id=l.id
    LEFT JOIN 
    (
        SELECT id, assigned_user_id FROM projects 
        WHERE   proj_name LIKE '%{$camp}%'
    ) p ON p.id=io.proj_id
    LEFT JOIN 
    (
        SELECT id FROM users 
        WHERE   user_first_name LIKE '%{$pub}%' OR user_last_name LIKE '%{$pub}%'
    ) u ON p.assigned_user_id=u.id        
    LEFT JOIN 
    (
        SELECT id FROM subid WHERE subid_all LIKE '%{$subid}%' 
    ) s ON s.id=pd.subid_id        
    GROUP BY l.country
    ORDER BY sum(io.revenue) DESC
        ";
               //echo("<textarea>" . $sql . "</textarea>");exit;
    $rowcount = 0;
    $q = mysqli_query($newconn,$sql);
    while ($row = mysqli_fetch_assoc($q)) {
        if($row[country] == NULL)
        {
            $row[country] = "";
        }    
        $arr_res_tmp[$row[country]][total] = $row[total];
        $arr_res_tmp[$row[country]][network_revenue] = $row[network_revenue];     
        $arr_res_tmp[$row[country]][country] = $row[country];
        
        if ($rowcount < 5)
        {
            array_push($topName,$row[country]);
            array_push($topAmount,$row[total]);    
            $rowcount ++;
        }        
    }
}		
		header('Content-Type: application/octet-stream');
	    header("Content-Transfer-Encoding: Binary"); 
	    header("Content-disposition: attachment; filename=\"geo.csv\"");

		$outstream = fopen("php://output", 'w');
	    
	    $titleLine = array();
        array_push($titleLine,"Date");
	    array_push($titleLine,"Country");
	    array_push($titleLine,"Clicks");
	    array_push($titleLine,"Open Session");
	    array_push($titleLine,"Installs Accepted");
	    array_push($titleLine,"Installs Started");
	    array_push($titleLine,"Installs Completed");
	    array_push($titleLine,"Revenue");
	    array_push($titleLine,"RPI");
	    array_push($titleLine,"EPC");
	    array_push($titleLine,"Network Revenue");
		fputcsv	($outstream,$titleLine,',','"');
	    
	    foreach($arr_res_tmp as $row)         
		{
			$workrow = array();
            array_push($workrow,$date);
			array_push($workrow,$row['country']);
            if(($adv != "")||($offer != "")) 
            {
                array_push($workrow,"");
                array_push($workrow,"");
            }
            else
            {
			    if (strlen(trim($row['clicks']))>0)				{array_push($workrow,$row['clicks']);}	else{array_push($workrow,'0');}
			    if (strlen(trim($row['open_sessions']))>0)		{array_push($workrow,$row['open_sessions']);}	else{array_push($workrow,'0');}
            }
			if (strlen(trim($row['install_accepted']))>0)	{array_push($workrow,$row['install_accepted']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_started']))>0)	{array_push($workrow,$row['install_started']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,$row['install_completed']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['total']))>0)				{array_push($workrow,number_format($row[total], 2, ".", ","));} else{array_push($workrow,'0');}
			if (strlen(trim($row['total']/$row['install_completed']))>0)	{array_push($workrow,number_format($row[total]/$row[install_completed], 2, ".", ","));}	else{array_push($workrow,'0');}
            if(($adv != "")||($offer != ""))
            {
                array_push($workrow,"");   
            }
            else
            {
			    if (strlen(trim($row['total']/$row['clicks']))>0)				{array_push($workrow,number_format($row[total]/$row[clicks], 2, ".", ","));} else{array_push($workrow,'0');}
            }
			if (strlen(trim($row['network_revenue']))>0)	{array_push($workrow,number_format($row[network_revenue], 2, ".", ","));}else{array_push($workrow,'0');}
			fputcsv	($outstream,$workrow,',','"');
		}
	}
	else if ($_REQUEST['type']=='temp')
	{
        $_REQUEST['form-date-range7-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range7-enddate'] = $_REQUEST['endDate'];
        $date = substr($_REQUEST['startDate'], 0, 10) . "  ~  " . substr($_REQUEST['endDate'], 0, 10);
        $_REQUEST['search_string_7'] = $_REQUEST['searchString'];
        
		$campign = $_REQUEST['searchCampaign'];

                            $sql = "
                                    SELECT 
                                        t.id,
                                        t.name,
                                        template_state.open_sessions,
                                        template_state.install_accepted,
                                        template_state.install_started,
                                        template_state.install_completed,
                                        template_revenue.revenue,
                                        (template_revenue.revenue/template_state.install_completed) as rpi
                                    FROM 
                                        templates t
                                    LEFT JOIN
                                        (
                                            SELECT
                                                template_id,
                                                sum(open_session) AS open_sessions,
                                                sum(install_accepted) AS install_accepted,
                                                sum(install_started) AS install_started,
                                                sum(install_completed) AS install_completed
                                            FROM
                                                install_projects
                                            WHERE
                                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range7-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range7-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                    ";
                            if($campign != -1) $sql .= " AND proj_id = {$campign}";
                            $sql .= "
                                            GROUP BY
                                                template_id
                                        ) template_state
                                    ON t.id = template_state.template_id
                                    LEFT JOIN
                                        (
                                            SELECT
                                                template_id,
                                                sum(price*adjust_rate/100 * install_completed) AS revenue
                                            FROM
                                                install_offers
                                            WHERE
                                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range7-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range7-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                     ";
                             if($campign != -1) $sql .= " AND proj_id = {$campign}";
                             $sql .= "
                                            GROUP BY
                                                template_id
                                        ) template_revenue
                                    ON t.id = template_revenue.template_id
                                    WHERE t.name LIKE '%{$_REQUEST[search_string_7]}%'
                                    ORDER by revenue DESC";
		
        
		$q = mysqli_query($newconn,$sql);
		
		header('Content-Type: application/octet-stream');
	    header("Content-Transfer-Encoding: Binary"); 
	    header("Content-disposition: attachment; filename=\"template.csv\""); 

		$outstream = fopen("php://output", 'w');
	    
	    $titleLine = array();
        array_push($titleLine,"Date");
	    array_push($titleLine,"Template");
	    array_push($titleLine,"Open Session");
	    array_push($titleLine,"Installs Accepted");
	    array_push($titleLine,"Installs Started");
	    array_push($titleLine,"Installs Completed");
	    array_push($titleLine,"Revenue");
	    array_push($titleLine,"RPI");
        array_push($titleLine,"RPOS");    
		fputcsv	($outstream,$titleLine,',','"');
	    
	    while ($row =  mysqli_fetch_assoc($q))
		{
			$workrow = array();
            array_push($workrow,$date);
			array_push($workrow,$row['name']);
			
			if (strlen(trim($row['open_sessions']))>0)				{array_push($workrow,$row['open_sessions']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_accepted']))>0)				{array_push($workrow,$row['install_accepted']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_started']))>0)				{array_push($workrow,$row['install_started']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)				{array_push($workrow,$row['install_completed']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['revenue']))>0)				{array_push($workrow,number_format($row[revenue],2));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['rpi']))>0)				{array_push($workrow,number_format($row[rpi],2));}	else{array_push($workrow,'0');}
            if (strlen(trim($row['revenue']))>0)                {array_push($workrow,number_format($row[revenue]/$row[open_sessions],2));}    else{array_push($workrow,'0');}

			fputcsv	($outstream,$workrow,',','"');                                      			
		}		    
	}
    else if ($_REQUEST['type']=='day')
    {
        $_REQUEST['form-date-range8-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range8-enddate'] = $_REQUEST['endDate'];
        
        $adv = $_REQUEST['searchAdv'];
        $pub = $_REQUEST['searchPub'];
        $camp = $_REQUEST['searchCampaighn'];
        $subid = $_REQUEST['searchSubid'];
        $country = $_REQUEST['searchCountry'];
        $offer = $_REQUEST['searchOffer']; 
        
                    if(($adv != "")||($offer != ""))
                    {
                        // if advertiser filter is used, then get offer install accepted, install started and install completed
                        $sql = "    
                            SELECT
                                install_datetime, hour(install_datetime) as hour,           
                                sum(install_accepted) as install_accepted,
                                sum(install_started) as install_started,
                                sum(install_completed) as install_completed,
                                sum(install_completed * install_offers.adjust_rate/100) as adjust_install,
                                sum(price * install_offers.adjust_rate/100 * install_completed) as revenue,
                                sum(price * install_offers.adjust_rate/100 * install_completed * (100-am_revenue-pub_revenue-pm_revenue)/100) as network_revenue
                            FROM 
                                install_offers
                            LEFT JOIN offers ON install_offers.offer_id = offers.id
                            LEFT JOIN users ON install_offers.user_id = users.id
                            WHERE
                                (users.user_first_name LIKE '%{$adv}%' OR users.user_last_name LIKE '%{$adv}%') AND 
                                offers.offer_name LIKE '%{$offer}%' AND 
                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                            GROUP BY hour(install_datetime)
                            ORDER BY install_datetime
                        ";
                        
                        // var_dump($sql);
                    }                    
                    else if($pub != "")
                    {
                        $sql = "
                            SELECT
                                pub_state.install_datetime,
                                pub_click.download_datetime, pub_click.hour, pub_click.clicks,
                                pub_state.open_session, pub_state.install_accepted, pub_state.install_started, pub_state.install_completed,
                                pub_revenue.revenue, pub_revenue.network_revenue
                            FROM
                                (
                                    SELECT 
                                        download_datetime,                                        
                                        hour(pd.download_datetime) AS hour,
                                        count(pd.id) AS clicks
                                    FROM 
                                        projects_downloads pd
                                    LEFT JOIN projects p ON pd.proj_id = p.id
                                    LEFT JOIN users u ON p.assigned_user_id = u.id
                                    WHERE
                                        (u.user_first_name LIKE '%{$pub}%' OR u.user_last_name LIKE '%{$pub}%') AND
                                        pd.download_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                        pd.download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                    GROUP BY hour(pd.download_datetime)
                                ) pub_click
                            LEFT JOIN
                                (
                                    SELECT 
                                        ip.install_datetime,
                                        hour(ip.install_datetime) AS hour,
                                        sum(ip.open_session) as open_session, 
                                        sum(ip.install_accepted) as install_accepted, 
                                        sum(ip.install_started) as install_started, 
                                        sum(ip.install_completed) as install_completed 
                                    FROM 
                                        install_projects ip
                                    LEFT JOIN projects p ON ip.proj_id = p.id 
                                    LEFT JOIN users u ON p.assigned_user_id = u.id 
                                    WHERE
                                        (u.user_first_name LIKE '%{$pub}%' OR u.user_last_name LIKE '%{$pub}%') AND
                                        ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                        ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                    GROUP BY hour(ip.install_datetime)        
                                ) pub_state ON pub_click.hour = pub_state.hour
                            LEFT JOIN 
                                (    
                                    SELECT 
                                        hour(io.install_datetime) AS hour, 
                                        sum(io.price * io.adjust_rate / 100) AS revenue, 
                                        sum(io.price * io.adjust_rate / 100 * (100-io.am_revenue-io.pub_revenue-io.pm_revenue)/100) as network_revenue 
                                    FROM 
                                        projects_downloads pd 
                                    INNER JOIN ( SELECT * FROM install_offers WHERE install_completed = 1 ) io ON pd.id = io.download_id 
                                    LEFT JOIN projects p ON pd.proj_id = p.id
                                    LEFT JOIN users u ON p.assigned_user_id = u.id
                                    WHERE
                                        (u.user_first_name LIKE '%{$pub}%' OR u.user_last_name LIKE '%{$pub}%') AND                                        
                                        io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                        io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                    GROUP BY hour(io.install_datetime)
                                ) pub_revenue 
                            ON pub_click.hour = pub_revenue.hour
                            ORDER BY pub_state.install_datetime
                            ";
                            
                            // var_dump($sql);
                    }
                    else //for campign, subid, country 
                    {
                            $sql = "
                                SELECT 
                                    click.download_datetime, click.hour, click.clicks,
                                    state.open_session, state.install_accepted, state.install_started, state.install_completed, 
                                    revenue.revenue, revenue.network_revenue 
                                FROM
                                    (
                                        SELECT 
                                            download_datetime,
                                            hour(pd.download_datetime) AS hour,
                                            count(pd.id) AS clicks 
                                        FROM 
                                            projects_downloads pd
                                        LEFT JOIN projects p ON pd.proj_id = p.id
                                        LEFT JOIN geo_location l ON pd.location_id = l.id
                                        LEFT JOIN subid s ON pd.subid_id = s.id
                                        WHERE
                                            p.proj_name LIKE '%{$camp}%' AND l.country LIKE '%{$country}%' AND s.subid_all LIKE '%{$subid}%' AND 
                                            pd.download_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            pd.download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY hour(pd.download_datetime)
                                    ) click
                                LEFT JOIN
                                    (
                                        SELECT 
                                            ip.install_datetime,
                                            hour(ip.install_datetime) AS hour, 
                                            sum(ip.open_session) as open_session, 
                                            sum(ip.install_accepted) as install_accepted, 
                                            sum(ip.install_started) as install_started, 
                                            sum(ip.install_completed) as install_completed 
                                        FROM 
                                            projects_downloads pd 
                                        INNER JOIN install_projects ip ON pd.id = ip.download_id 
                                        LEFT JOIN projects p ON pd.proj_id = p.id
                                        LEFT JOIN geo_location l ON pd.location_id = l.id
                                        LEFT JOIN subid s ON pd.subid_id = s.id
                                        WHERE
                                            p.proj_name LIKE '%{$camp}%' AND l.country LIKE '%{$country}%' AND s.subid_all LIKE '%{$subid}%' AND 
                                            ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY hour(ip.install_datetime)
                                    ) state ON click.hour = state.hour
                                LEFT JOIN
                                    (
                                        SELECT 
                                            hour(io.install_datetime) AS hour, 
                                            sum(io.price * io.adjust_rate / 100) AS revenue, 
                                            sum(io.price * io.adjust_rate / 100 * (100-io.am_revenue-io.pub_revenue-io.pm_revenue)/100) as network_revenue 
                                        FROM 
                                            projects_downloads pd 
                                        INNER JOIN ( SELECT * FROM install_offers WHERE install_completed = 1 ) io ON pd.id = io.download_id 
                                        LEFT JOIN projects p ON pd.proj_id = p.id
                                        LEFT JOIN geo_location l ON pd.location_id = l.id
                                        LEFT JOIN subid s ON pd.subid_id = s.id
                                        WHERE
                                            p.proj_name LIKE '%{$camp}%' AND l.country LIKE '%{$country}%' AND s.subid_all LIKE '%{$subid}%' AND                                             
                                            io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY hour(io.install_datetime)
                                    ) revenue 
                                ON click.hour = revenue.hour
                                ORDER BY click.download_datetime
                                ";
                                
                                 
                    }
                    //var_dump($sql); exit;                                
                          
        $time_arr = array("midnight-1AM", "1AM-2AM", "2AM-3AM", "3AM-4AM", "4AM-5AM", "5AM-6AM", "6AM-7AM", "7AM-8AM", "8AM-9AM", "9AM-10AM", "10AM-11AM", "11AM-12PM",
                            "12PM-1PM", "1PM-2PM", "2PM-3PM", "3PM-4PM", "4PM-5PM", "5PM-6PM", "6PM-7PM", "7PM-8PM", "8PM-9PM", "9PM-10PM", "10PM-11PM", "11PM-midnight" ) ;

        
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"day.csv\""); 
       
        $outstream = fopen("php://output", 'w');
        
        $titleLine = array();
        array_push($titleLine,"Time");
        
        array_push($titleLine,"Clicks");
        array_push($titleLine,"Installs Accepted");
        array_push($titleLine,"Installs Started");
        array_push($titleLine,"Installs Completed");
        
        if(($adv != "")||($offer != "")) 
            array_push($titleLine,"Adjust Install");
            
                                                            
        array_push($titleLine,"Revenue");
        array_push($titleLine,"RPI");
        array_push($titleLine,"EPC");
        array_push($titleLine,"Network Revenue");
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
                if(($adv!="")||($offer!="")) {
                    array_push($workrow1,"");
                    array_push($workrow1,"");
                }
                else
                {
                    array_push($workrow1,"0");
                    array_push($workrow1,"0");
                }
                array_push($workrow1,0);
                array_push($workrow1,0);                
                if(($adv != "")||($offer != ""))
                {
                    array_push($workrow1,0);   
                }
                array_push($workrow1,0.00);
                array_push($workrow1,0.00);
                if($adv!="")
                {
                    array_push($workrow1,"");    
                }
                else
                {                       
                    array_push($workrow1,0.00);
                }
                array_push($workrow1,0.00);   
                fputcsv    ($outstream,$workrow1,',','"');                                
            }
            
            $workrow = array();    
            array_push($workrow,$time_arr[$hour]);
            
            $clicks = $row[clicks];
            $install_accepted = $row[install_accepted];
            $install_started = $row[install_started];
            $install_completed = $row[install_completed];
            $adjust_install = $row[adjust_install];
            $revenue = $row[revenue];
            $network_revenue = $row[network_revenue];                        
        
            if(($adv!="")||($offer!="")) {
                array_push($workrow,"");
                array_push($workrow,"");
            }
            else
            {
                if (strlen(trim($clicks))                >0)        {array_push($workrow,$clicks);    }                        else{array_push($workrow,'0');}
                if (strlen(trim($install_accepted))        >0)        {array_push($workrow,$install_accepted);}                else{array_push($workrow,'0');}
            }
            
            if (strlen(trim($install_started))        >0)        {array_push($workrow,$install_started);}                else{array_push($workrow,'0');}
            if (strlen(trim($install_completed))    >0)        {array_push($workrow,$install_completed);}                else{array_push($workrow,'0');}
            if(($adv != "")||($offer != ""))
            {
                if (strlen(trim($adjust_install))                >0)        {array_push($workrow,number_format($adjust_install,2));}        else{array_push($workrow,'0');}
            }
            if (strlen(trim($revenue))                >0)        {array_push($workrow,number_format($revenue,2));}        else{array_push($workrow,'0');}
            if (strlen(trim($revenue/$install_completed))>0)        {array_push($workrow,number_format($revenue/$install_completed,2));}        else{array_push($workrow,'0');}
            if($adv!="")
            {
                array_push($workrow,"");    
            }
            else
            {
                if (strlen(trim($revenue/$clicks))         >0)        {array_push($workrow,number_format($revenue/$clicks,2));}                else {array_push($workrow,'0');}    
            }
            if (strlen(trim($network_revenue))        >0)        {array_push($workrow,number_format($row[network_revenue],2));}                else{array_push($workrow,'0');}

            fputcsv    ($outstream,$workrow,',','"');    
            $pre_hour = $hour;                                                                     

        }
        for($xx=$hour+1;$xx<24;$xx++)
        {
                $workrow1 = array();    
                array_push($workrow1,$time_arr[$xx]);
                if(($adv!="")||($offer!="")) {
                    array_push($workrow1,"");
                    array_push($workrow1,"");
                }
                else
                {
                    array_push($workrow1,"0");
                    array_push($workrow1,"0");
                }
                array_push($workrow1,0);
                array_push($workrow1,0);
                
                if(($adv != "")||($offer != ""))
                {
                    array_push($workrow1,0);   
                }
                array_push($workrow1,0.00);
                array_push($workrow1,0.00);
                if($adv!="")
                {
                    array_push($workrow1,"");
                }
                else
                {   
                    
                    array_push($workrow1,0.00);
                }
                array_push($workrow1,0.00);   
                fputcsv    ($outstream,$workrow1,',','"');                                
        }
    }
    else if ($_REQUEST['type']=='daily')
    {
        $_REQUEST['form-date-range9-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range9-enddate'] = $_REQUEST['endDate'];        
        
        $_REQUEST[advertiser_9] = $_REQUEST['searchAdv'];
        $_REQUEST[publisher_9] = $_REQUEST['searchPub'];
        $_REQUEST[campaign_9] = $_REQUEST['searchCampaighn'];
        $_REQUEST[subid_9] = $_REQUEST['searchSubid'];
        $_REQUEST[geo_9] = $_REQUEST['searchCountry'];         
        $_REQUEST[template_9] = $_REQUEST['searchTempalte'];
        $_REQUEST[bundle_9] = $_REQUEST['searchBundle'];
        $_REQUEST[offer_9] = $_REQUEST['searchOffer'];
        
        if(($_REQUEST[advertiser_9]!='')||($_REQUEST[bundle_9])||($_REQUEST[offer_9]))
        {
            //advertiser or bundle
            $sql = "
                SELECT  DATE_FORMAT(io.install_datetime, '%Y-%m-%d') as date,
                        sum(io.install_accepted) as install_accepted, sum(io.install_started) as install_started, sum(install_completed) as install_completed,
                        sum(io.price*io.adjust_rate/100) as total 
                FROM install_offers io        
                LEFT JOIN offers o ON io.offer_id=o.id
                LEFT JOIN users u ON o.assigned_user_id=u.id
                WHERE   io.install_completed = 1 AND
                        io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND                
                        io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND
                        CONCAT( u.user_first_name,  ' ', u.user_last_name ) LIKE '%{$_REQUEST[advertiser_9]}%' AND
                        o.offer_name LIKE '%{$_REQUEST[offer_9]}%' 
                GROUP BY DATE_FORMAT(io.install_datetime, '%Y-%m-%d')
            ";    
        }
        else
        {
            //for publisher, campaign, subid, geo, template
                                     $sql = "
                                        SELECT 
                                            proj_click.date,                                
                                            proj_click.clicks,
                                            proj_state.open_session,
                                            proj_state.install_accepted,
                                            proj_state.install_started,
                                            proj_state.install_completed,
                                            proj_revenue.total
                                        FROM 
                                                (
                                                    SELECT 
                                                        DATE_FORMAT(DATE_ADD(pd.download_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d') as date, count(pd.id) AS clicks
                                                    FROM
                                                        projects_downloads pd
                                                    LEFT JOIN projects p ON pd.proj_id=p.id
                                                    LEFT JOIN users u ON p.assigned_user_id=u.id
                                                    LEFT JOIN subid s ON pd.subid_id=s.id
                                                    LEFT JOIN geo_location l ON pd.location_id=l.id                                            
                                                    WHERE                                            
                                                        download_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                        download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND 
                                                        p.proj_name LIKE '%{$_REQUEST[campign_9]}%' AND
                                                        CONCAT( u.user_first_name,  ' ', u.user_last_name ) LIKE '%{$_REQUEST[publisher_9]}%' AND 
                                                        (l.country LIKE '%{$_REQUEST[geo_9]}%' OR l.city LIKE '%{$_REQUEST[geo_9]}%') AND
                                                        (   
                                                            s.subid1 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid2 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                            s.subid3 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid4 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                            s.subid5 LIKE '%{$_REQUEST[subid_9]}%' 
                                                        ) 
                                                    GROUP BY
                                                        DATE_FORMAT(DATE_ADD(download_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d')
                                                ) proj_click
                                            LEFT JOIN
                                                (
                                                    SELECT 
                                                        DATE_FORMAT(DATE_ADD(ip.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d') as date,
                                                        sum(ip.open_session) AS open_session, 
                                                        sum(ip.install_accepted) AS install_accepted, 
                                                        sum(ip.install_started) AS install_started, 
                                                        sum(ip.install_completed) AS install_completed
                                                    FROM 
                                                        install_projects ip
                                                    LEFT JOIN projects p ON ip.proj_id=p.id
                                                    LEFT JOIN users u ON p.assigned_user_id=u.id
                                                    LEFT JOIN projects_downloads pd ON pd.id=ip.download_id
                                                    LEFT JOIN subid s ON pd.subid_id=s.id
                                                    LEFT JOIN geo_location l ON pd.location_id=l.id                                            
                                                    LEFT JOIN templates t ON t.id=ip.template_id
                                                    WHERE
                                                        ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                        ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND 
                                                        p.proj_name LIKE '%{$_REQUEST[campign_9]}%' AND
                                                        CONCAT( u.user_first_name,  ' ', u.user_last_name ) LIKE '%{$_REQUEST[publisher_9]}%' AND                                                 
                                                        (l.country LIKE '%{$_REQUEST[geo_9]}%' OR l.city LIKE '%{$_REQUEST[geo_9]}%') AND
                                                        (   
                                                            s.subid1 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid2 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                            s.subid3 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid4 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                            s.subid5 LIKE '%{$_REQUEST[subid_9]}%' 
                                                        ) AND
                                                        t.name LIKE '%{$_REQUEST[template_9]}%'
                                                    GROUP BY 
                                                        DATE_FORMAT(DATE_ADD(ip.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d')
                                                ) proj_state
                                            ON proj_click.date = proj_state.date
                                            LEFT JOIN
                                                (                                             
                                                    SELECT
                                                        DATE_FORMAT(DATE_ADD(io.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d') as date,
                                                        sum(io.price*io.adjust_rate/100) AS total,
                                                        sum(io.price*io.adjust_rate/100*(100 - io.am_revenue - io.pub_revenue - io.pm_revenue)/100) AS net_revenue
                                                    FROM 
                                                        (    
                                                            SELECT 
                                                                io1.install_datetime,
                                                                io1.price, io1.adjust_rate, io1.am_revenue, io1.pub_revenue, io1.pm_revenue
                                                            FROM 
                                                                install_offers io1
                                                            LEFT JOIN projects_downloads pd on io1.download_id=pd.id                                                    
                                                            LEFT JOIN projects p ON io1.proj_id=p.id
                                                            LEFT JOIN users u ON p.assigned_user_id=u.id                                                    
                                                            LEFT JOIN subid s ON pd.subid_id=s.id
                                                            LEFT JOIN geo_location l ON pd.location_id=l.id                                            
                                                            LEFT JOIN templates t ON t.id=io1.template_id
                                                                
                                                            WHERE
                                                                io1.install_completed = 1 AND
                                                                io1.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                                io1.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND
                                                                p.proj_name LIKE '%{$_REQUEST[campign_9]}%' AND
                                                                CONCAT( u.user_first_name,  ' ', u.user_last_name ) LIKE '%{$_REQUEST[publisher_9]}%' AND 
                                                                (l.country LIKE '%{$_REQUEST[geo_9]}%' OR l.city LIKE '%{$_REQUEST[geo_9]}%') AND
                                                                (   
                                                                    s.subid1 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid2 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                                    s.subid3 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid4 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                                    s.subid5 LIKE '%{$_REQUEST[subid_9]}%' 
                                                                ) AND
                                                                t.name LIKE '%{$_REQUEST[template_9]}%'
                                                                
                                                        ) io
                                                    GROUP BY DATE_FORMAT(DATE_ADD(io.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d')
                                                ) proj_revenue
                                            ON proj_click.date = proj_revenue.date                                    
                                        ORDER BY proj_click.date
                                        ";
        }
                    //echo("<textarea>" . $sql . "</textarea>"); exit;                                
        
        
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"dailyBreakdown.csv\""); 
       
        $outstream = fopen("php://output", 'w');
        
        $titleLine = array();
        array_push($titleLine,"Date");        
        array_push($titleLine,"Clicks");
        array_push($titleLine,"Open Sessions");
        array_push($titleLine,"Installs Accepted");
        array_push($titleLine,"Installs Started");
        array_push($titleLine,"Installs Completed");                                                            
        array_push($titleLine,"Revenue");
        array_push($titleLine,"RPI");
        array_push($titleLine,"EPC");
        
        fputcsv    ($outstream,$titleLine,',','"');
        
        
        
        $q = mysqli_query($newconn,$sql);
        
        $pre_hour = 0;
        while($row=mysqli_fetch_assoc($q))
        {
            $workrow = array();
            array_push($workrow,$row['date']);
            if(($_REQUEST[advertiser_9] != NULL) || ($_REQUEST[bundle_9] != NULL)) 
            {
                array_push($workrow,"");    
                array_push($workrow,"");    
            }
            else
            {
                if (strlen(trim($row['clicks']))>0)                {array_push($workrow,$row['clicks']);}    else{array_push($workrow,'0');}    
                if (strlen(trim($row['open_session']))>0)                {array_push($workrow,$row['open_session']);}    else{array_push($workrow,'0');}
            }
            
            
            if (strlen(trim($row['install_accepted']))>0)                {array_push($workrow,$row['install_accepted']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['install_started']))>0)                {array_push($workrow,$row['install_started']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['install_completed']))>0)                {array_push($workrow,$row['install_completed']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['total']))>0)                {array_push($workrow,number_format($row[total],2));}    else{array_push($workrow,'0');}
            if (strlen(trim($row['total']/$row['install_completed']))>0)                {array_push($workrow,number_format($row[total]/$row['install_completed'],2));}    else{array_push($workrow,'0');}
            if(($_REQUEST[advertiser_9] != NULL) || ($_REQUEST[bundle_9] != NULL)) 
            {
                array_push($workrow,"");   
            }
            else
            {
                if (strlen(trim($row['total']/$row['clicks']))>0)                {array_push($workrow,number_format($row[total]/$row['clicks'],2));}    else{array_push($workrow,'0');}
            }
            fputcsv    ($outstream,$workrow,',','"');                                                   
        }   
            
    }
	
    else if ($_REQUEST['type']=='offerbundle')
    {
        $_REQUEST['form-date-range10-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range10-enddate'] = $_REQUEST['endDate'];
        
        $_REQUEST[bundle_10] = $_REQUEST[bundle];
        $_REQUEST[offer_10] = $_REQUEST[offer];
        
        $arr_offer_id = array();
        if($_REQUEST[offer_10] == "")
        {
            
        } 
        else
        {
            $sql = "SELECT id FROM offers WHERE offer_name LIKE '%{$_REQUEST[offer_10]}%'";
            $q = mysqli_query($newconn, $sql);
            while($row = mysqli_fetch_assoc($q))
            {
                array_push($arr_offer_id, $row[id]);
            }
        }
        
        $sql = "
        SELECT ioc.combo_id, ioc.combo, b.id as bundle_id, b.name as bundle_name, ioc.session, ioc.revenue  
        FROM 
        (                     
            SELECT oc.combo_id, oc.combo, oc.session, o_r.revenue, oc.bundle_id
                  FROM 
                        (
                            SELECT c.id as combo_id, c.combo, io1.cc as session, c.bundle_id 
                            FROM 
                                (   SELECT count(io.id) as cc, io.combo_id 
                                    FROM 
                                        (   SELECT count(id) as id, combo_id 
                                            FROM install_offers
                                            WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range10-startdate']}', INTERVAL {$diff_timezone} HOUR) AND                
                                                    install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range10-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
                                            GROUP BY download_id, combo_id 
                                        ) io 
                                    GROUP BY io.combo_id
                                ) io1 
                            LEFT JOIN combos c 
                            ON io1.combo_id=c.id                     
                        ) oc
                  LEFT JOIN 
                        (
                            SELECT c.id as combo_id, c.combo, io1.revenue, c.bundle_id 
                            FROM 
                                (   
                                    SELECT sum(io.price) as revenue, io.combo_id 
                                    FROM 
                                        (   
                                            SELECT sum(price*adjust_rate/100) as price, combo_id 
                                            FROM install_offers 
                                            WHERE   install_completed=1 AND
                                                    install_datetime >= DATE_SUB('{$_REQUEST['form-date-range10-startdate']}', INTERVAL {$diff_timezone} HOUR) AND                
                                                    install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range10-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
                                            GROUP BY download_id, combo_id 
                                        ) io 
                                    GROUP BY io.combo_id
                                ) io1 
                            LEFT JOIN combos c 
                            ON io1.combo_id=c.id
                        ) o_r
                  ON oc.combo_id=o_r.combo_id 
        ) ioc 
        LEFT JOIN combos c ON c.id=ioc.combo_id
        LEFT JOIN bundles b ON c.bundle_id=b.id 
        WHERE b.name LIKE '%{$_REQUEST[bundle_10]}%'
        ORDER BY b.id 
        ";
        
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"dailyBreakdown.csv\""); 
       
        $outstream = fopen("php://output", 'w');
        
        $titleLine = array();
                
        array_push($titleLine,"Offer Bundle");
        array_push($titleLine,"Combo");
        array_push($titleLine,"Session");        
        array_push($titleLine,"Revenue");
        array_push($titleLine,"RPOBC");
        
        fputcsv    ($outstream,$titleLine,',','"');
        
        
        
        $q = mysqli_query($newconn,$sql);
        
        $pre_hour = 0;
        while($row=mysqli_fetch_assoc($q))
        {
            $i = 0;
            //apply offer filter
            $arr_offer_size = sizeof($arr_offer_id);
            if($arr_offer_size==0)
            {
                //without offer filter
            }
            else
            {
                //with offer filter
                for($i=0;$i<$arr_offer_size;$i++)
                {
                    //echo($row[combo] . "==" . $arr_offer_id[$i] . "<br>");
                    $r1 = strstr($row[combo], $arr_offer_id[$i]);
                    //var_dump($r1);echo("<br>");
                    if(strstr($row[combo], $arr_offer_id[$i])!=false)
                        break;
                }
                if($i==$arr_offer_size)
                    continue;                                                                 
            }
            
            $workrow = array();
            
            array_push($workrow,$row['bundle_name']);
            
            $arr_offer = explode("|", $row[combo]);
            $str_tmp1 = "";
            foreach( $arr_offer as $offer_tmp)
            {
                $sql1 = "SELECT offer_name FROM offers WHERE id={$offer_tmp}";
                $q1 = mysqli_query($newconn, $sql1);
                $row1 = mysqli_fetch_assoc($q1);
                $str_tmp1 .= $row1[offer_name] . "|";
            }
            $str_tmp1 = substr($str_tmp1, 0 ,-1);
            array_push($workrow,$str_tmp1);
            if (strlen(trim($row['session']))>0)                {array_push($workrow,$row['session']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['revenue']))>0)                {array_push($workrow,number_format($row[revenue], 2));}    else{array_push($workrow,'0');}
            array_push($workrow,number_format($row[revenue]/$row[session],2));
                        
            fputcsv    ($outstream,$workrow,',','"');                                                   
        }
    } 
    
?>
