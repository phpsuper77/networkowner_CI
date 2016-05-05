<?
	include '../common/config.php';
    

	if ($_REQUEST['type']=='campaign')
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
                                    proj_revenue.total
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
                                                sum(io.price*io.adjust_rate/100*io.pub_revenue/100) AS total
                                            FROM                                                 
                                                install_offers io
                                            WHERE
                                                install_completed = 1 AND
                                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range4-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range4-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)                                                 
                                            GROUP BY io.proj_id
                                        ) proj_revenue
                                    ON projects.id = proj_revenue.proj_id
                                WHERE
                                    projects.assigned_user_id={$user_id} AND                                    
                                    projects.proj_name LIKE '%{$_REQUEST[search_string_4]}%'                                   
                                ORDER BY total DESC
                                ";
			
			
			$q = mysqli_query($newconn,$sql);
 		
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"campaign.csv\""); 

		$outstream = fopen("php://output", 'w');
	    
	    $titleLine = array();
        array_push($titleLine,"Date");
	    array_push($titleLine,"CID");
	    array_push($titleLine,"Campaign");
	    array_push($titleLine,"Clicks");
	    array_push($titleLine,"Open Sessions");
	    array_push($titleLine,"Installs Accepted");
	    array_push($titleLine,"Installs Started");	    
	    array_push($titleLine,"Installs Completed");
	    array_push($titleLine,"Revenue");
	    array_push($titleLine,"RPI");
	    array_push($titleLine,"EPC");
 
		fputcsv	($outstream,$titleLine,',','"');
	    
	    while ($row =  mysqli_fetch_assoc($q))
		{
			$workrow = array();
            array_push($workrow,$date);
			array_push($workrow,$row['id']);
			array_push($workrow,$row['proj_name']);
			if (strlen(trim($row['clicks']))>0)	{array_push($workrow,$row['clicks']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['open_session']))>0)		{array_push($workrow,$row['open_session']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_accepted']))>0)	{array_push($workrow,$row['install_accepted']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_started']))>0)	{array_push($workrow,$row['install_started']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,$row['install_completed']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['total']))>0)				{array_push($workrow,number_format($row[total], 2, ".", ","));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,number_format($row[total]/$row[install_completed], 2, ".", ","));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['clicks']))>0)				{array_push($workrow,number_format($row[total]/$row[clicks], 2, ".", ","));}	else{array_push($workrow,'0');}
			fputcsv	($outstream,$workrow,',','"'); 		}
		
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
                                            count(pd.id) as clicks, 
                                            pd.proj_id, 
                                            pd.subid_id                                             
                                        FROM 
                                            projects_downloads pd 
                                        LEFT JOIN geo_location gl ON gl.id=pd.location_id
                                        WHERE
                                            gl.country LIKE '%{$_REQUEST['country_5']}%' AND
                                            pd.download_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            pd.download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY proj_id, subid_id
                                    ) pd_click                                
                                LEFT JOIN projects p ON pd_click.proj_id = p.id
                                LEFT JOIN subid s ON pd_click.subid_id=s.id                 
                                WHERE 
                                     p.assigned_user_id={$user_id} AND
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%' 
                                ";
                            if($_REQUEST[proj_name_5] != "")
                                $sql .= " AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%' ";   
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
                                    pdip.proj_id, pdip.proj_id, pdip.subid_id, 
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
                                        LEFT JOIN geo_location gl ON gl.id=pd.location_id
                                        WHERE
                                            gl.country LIKE '%{$_REQUEST['country_5']}%' AND
                                            ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)  
                                        GROUP BY proj_id, subid_id
                                    ) pdip
                                LEFT JOIN projects p ON pdip.proj_id = p.id
                                LEFT JOIN subid s ON pdip.subid_id=s.id 
                                WHERE
                                     p.assigned_user_id={$user_id} AND 
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%'   
                                ";
                            if($_REQUEST[proj_name_5] != "")
                                $sql .= " AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%' ";   
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
                                    pdio.proj_id, pdio.subid_id, pdio.total,
                                    s.subid1, s.subid2, s.subid3, s.subid4, s.subid5,
                                    p.proj_name
                                FROM 
                                    (
                                        SELECT 
                                            pd.proj_id, pd.subid_id, 
                                            sum(io.price*io.adjust_rate/100*pub_revenue/100) as total
                                        FROM 
                                            projects_downloads pd 
                                        LEFT JOIN geo_location gl ON gl.id=pd.location_id
                                        INNER JOIN 
                                            ( SELECT * FROM install_offers WHERE install_completed=1) io ON pd.id = io.download_id 
                                        WHERE
                                            gl.country LIKE '%{$_REQUEST['country_5']}%' AND
                                            io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY pd.proj_id, pd.subid_id
                                    ) pdio 
                                LEFT JOIN projects p ON pdio.proj_id = p.id
                                LEFT JOIN subid s ON pdio.subid_id=s.id
                                WHERE 
                                     p.assigned_user_id={$user_id} AND
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%'";
                            if($_REQUEST[proj_name_5] != "")
                                $sql .= " AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%' ";   
                            $sql .= "ORDER BY pdio.total DESC ";
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
                            
								
	    
	
		
		header('Content-Type: application/octet-stream');
	    header("Content-Transfer-Encoding: Binary"); 
	    header("Content-disposition: attachment; filename=\"subid.csv\"");

		$outstream = fopen("php://output", 'w');
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
			    
			    fputcsv	($outstream,$workrow,',','"');
		    }
        }
	}
	else if ($_REQUEST['type']=='geo')
	{
		$_REQUEST['form-date-range6-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range6-enddate'] = $_REQUEST['endDate'];
        $date = substr($_REQUEST['startDate'], 0, 10) . "  ~  " . substr($_REQUEST['endDate'], 0, 10);
        
$arr_res_tmp = array();
$sql = "
        SELECT count(pd.id) as clicks, l.country 
        FROM 
        (
            SELECT id, proj_id, location_id, subid_id FROM projects_downloads 
            WHERE   download_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                    download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)            
        ) pd
        LEFT JOIN projects p ON p.id=pd.proj_id 
        LEFT JOIN geo_location l ON pd.location_id=l.id
        LEFT JOIN subid s ON s.id=pd.subid_id
        WHERE
            p.assigned_user_id={$user_id} AND l.country LIKE '%{$_REQUEST[country_6]}%' AND 
            p.proj_name LIKE '%{$_REQUEST[camp_6]}%' AND s.subid_all LIKE '%{$_REQUEST[subid_6]}%'                        
        GROUP BY l.country                                                                            
    ";
    
//echo("<textarea>" . $sql . "</textarea>"); exit;
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
    SELECT * FROM install_projects 
    WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
            install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
) ip
INNER JOIN projects_downloads pd ON pd.id=ip.download_id 
LEFT JOIN geo_location l ON l.id=pd.location_id
LEFT JOIN projects p ON p.id=ip.proj_id
LEFT JOIN subid s ON s.id=pd.subid_id
WHERE
    p.assigned_user_id={$user_id} AND    
    l.country LIKE '%{$_REQUEST[country_6]}%' AND p.proj_name LIKE '%{$_REQUEST[camp_6]}%' AND s.subid_all LIKE '%{$_REQUEST[subid_6]}%'
GROUP BY l.country
    ";   
//echo("<textarea>" . $sql . "</textarea>"); //exit;
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
    sum(io.price*io.adjust_rate/100*pub_revenue/100) as total
FROM 
(
    SELECT * FROM install_offers 
    WHERE   install_completed=1 AND
            install_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
            install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)    
) io 
INNER JOIN projects_downloads pd ON io.download_id=pd.id  
LEFT JOIN geo_location l ON l.id=pd.location_id
LEFT JOIN projects p ON p.id=pd.proj_id
LEFT JOIN subid s ON s.id=pd.subid_id
WHERE
    p.assigned_user_id={$user_id} AND    
    l.country LIKE '%{$_REQUEST[country_6]}%' AND p.proj_name LIKE '%{$_REQUEST[camp_6]}%' AND s.subid_all LIKE '%{$_REQUEST[subid_6]}%'
GROUP BY l.country
ORDER BY sum(io.price*io.adjust_rate/100*pub_revenue/100) DESC
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
    $arr_res_tmp[$row[country]][country] = $row[country];
    
    if ($rowcount < 5)
    {
        array_push($topName,$row[country]);
        array_push($topAmount,$row[total]);    
        $rowcount ++;
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
		fputcsv	($outstream,$titleLine,',','"');
	    
	    foreach($arr_res_tmp as $row)         
		{
			$workrow = array();
            array_push($workrow,$date);
			array_push($workrow,$row['country']);
			if (strlen(trim($row['clicks']))>0)				{array_push($workrow,$row['clicks']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['open_sessions']))>0)		{array_push($workrow,$row['open_sessions']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_accepted']))>0)	{array_push($workrow,$row['install_accepted']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_started']))>0)	{array_push($workrow,$row['install_started']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['install_completed']))>0)	{array_push($workrow,$row['install_completed']);}	else{array_push($workrow,'0');}
			if (strlen(trim($row['total']))>0)				{array_push($workrow,number_format($row[total], 2, ".", ","));} else{array_push($workrow,'0');}
			if (strlen(trim($row['total']/$row['install_completed']))>0)	{array_push($workrow,number_format($row[total]/$row[install_completed], 2, ".", ","));}	else{array_push($workrow,'0');}
			if (strlen(trim($row['total']/$row['clicks']))>0)				{array_push($workrow,number_format($row[total]/$row[clicks], 2, ".", ","));} else{array_push($workrow,'0');}			
			fputcsv	($outstream,$workrow,',','"');
		}
	}
    else if ($_REQUEST['type']=='day')
    {
        $_REQUEST['form-date-range8-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range8-enddate'] = $_REQUEST['endDate'];
                 
        $camp = $_REQUEST['searchCampaighn'];
        $subid = $_REQUEST['searchSubid'];
        $country = $_REQUEST['searchCountry'];
                
                             $sql = "
                    SELECT 
                        click.download_datetime, click.hour, click.clicks,
                        state.open_session, state.install_accepted, state.install_started, state.install_completed, 
                        revenue.revenue 
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
                                p.assigned_user_id={$user_id} AND
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
                                p.assigned_user_id={$user_id} AND 
                                p.proj_name LIKE '%{$camp}%' AND l.country LIKE '%{$country}%' AND s.subid_all LIKE '%{$subid}%' AND 
                                ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                            GROUP BY hour(ip.install_datetime)
                        ) state ON click.hour = state.hour
                    LEFT JOIN
                        (
                            SELECT 
                                hour(io.install_datetime) AS hour, 
                                sum(io.price * io.adjust_rate / 100 * io.pub_revenue/100) AS revenue
                            FROM 
                                projects_downloads pd 
                            INNER JOIN ( SELECT * FROM install_offers WHERE install_completed = 1 ) io ON pd.id = io.download_id 
                            LEFT JOIN projects p ON pd.proj_id = p.id
                            LEFT JOIN geo_location l ON pd.location_id = l.id
                            LEFT JOIN subid s ON pd.subid_id = s.id
                            WHERE
                                p.assigned_user_id={$user_id} AND 
                                p.proj_name LIKE '%{$camp}%' AND l.country LIKE '%{$country}%' AND s.subid_all LIKE '%{$subid}%' AND                                             
                                io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                            GROUP BY hour(io.install_datetime)
                        ) revenue 
                    ON click.hour = revenue.hour
                    ORDER BY click.download_datetime
                    ";
                    //echo("<textarea>" . $sql . "</textarea>"); exit;
                          
        $time_arr = array("midnight-1AM", "1AM-2AM", "2AM-3AM", "3AM-4AM", "4AM-5AM", "5AM-6AM", "6AM-7AM", "7AM-8AM", "8AM-9AM", "9AM-10AM", "10AM-11AM", "11AM-12PM",
                            "12PM-1PM", "1PM-2PM", "2PM-3PM", "3PM-4PM", "4PM-5PM", "5PM-6PM", "6PM-7PM", "7PM-8PM", "8PM-9PM", "9PM-10PM", "10PM-11PM", "11PM-midnight" ) ;

        
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"day.csv\""); 
       
        $outstream = fopen("php://output", 'w');
        
        $titleLine = array();
        array_push($titleLine,"Time");
        
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
            $hour = ($row[hour] + $diff_timezone) % 24;
            if($hour<0) $hour = $hour + 24;
                                              
            for($xx=$pre_hour;$xx<$hour-1;$xx++)              
            {
                $workrow1 = array();    
                array_push($workrow1,$time_arr[$xx]);
                array_push($workrow1,"0");
                array_push($workrow1,"0");
                array_push($workrow1,"0");                
                array_push($workrow1,0);
                array_push($workrow1,0);                
                array_push($workrow1,0.00);
                array_push($workrow1,0.00);                     
                array_push($workrow1,0.00);                  
                fputcsv    ($outstream,$workrow1,',','"');                                
            }
            
            $workrow = array();    
            array_push($workrow,$time_arr[$hour]);
            
            $clicks = $row[clicks];
            $open_session = $row[open_session];
            $install_accepted = $row[install_accepted];
            $install_started = $row[install_started];
            $install_completed = $row[install_completed];
            $adjust_install = $row[adjust_install];
            $revenue = $row[revenue];
            $network_revenue = $row[network_revenue];                        
        
            if (strlen(trim($clicks))                >0)        {array_push($workrow,$clicks);    }                        else{array_push($workrow,'0');}
            if (strlen(trim($open_session))        >0)        {array_push($workrow,$open_session);}                else{array_push($workrow,'0');}
            if (strlen(trim($install_accepted))        >0)        {array_push($workrow,$install_accepted);}                else{array_push($workrow,'0');}
            if (strlen(trim($install_started))        >0)        {array_push($workrow,$install_started);}                else{array_push($workrow,'0');}
            if (strlen(trim($install_completed))    >0)        {array_push($workrow,$install_completed);}                else{array_push($workrow,'0');}
            if (strlen(trim($revenue))                >0)        {array_push($workrow,number_format($revenue,2));}        else{array_push($workrow,'0');}
            if (strlen(trim($revenue/$install_completed))>0)        {array_push($workrow,number_format($revenue/$install_completed,2));}        else{array_push($workrow,'0');}
            if (strlen(trim($revenue/$clicks))         >0)        {array_push($workrow,number_format($revenue/$clicks,2));}                else {array_push($workrow,'0');}    
        
            fputcsv    ($outstream,$workrow,',','"');    
            $pre_hour = $hour;                                                                     

        }
        for($xx=$hour+1;$xx<24;$xx++)
        {
                $workrow1 = array();    
                array_push($workrow1,$time_arr[$xx]);
                array_push($workrow1,"0");
                array_push($workrow1,"0");
                array_push($workrow1,0);
                array_push($workrow1,0);
                array_push($workrow1,0.00);
                array_push($workrow1,0.00);
                array_push($workrow1,0.00);
                array_push($workrow1,0.00);   
                fputcsv    ($outstream,$workrow1,',','"');                                
        }
    }
    else if ($_REQUEST['type']=='daily')
    {
        $_REQUEST['form-date-range9-startdate'] = $_REQUEST['startDate'];
        $_REQUEST['form-date-range9-enddate'] = $_REQUEST['endDate'];      
        
        $_REQUEST[campaign_9] = $_REQUEST['searchCampaighn'];
        $_REQUEST[subid_9] = $_REQUEST['searchSubid'];
        $_REQUEST[geo_9] = $_REQUEST['searchCountry'];         
                
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
                    LEFT JOIN subid s ON pd.subid_id=s.id
                    LEFT JOIN geo_location l ON pd.location_id=l.id                                            
                    WHERE  
                        p.assigned_user_id={$user_id} AND                                           
                        download_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                        download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND 
                        p.proj_name LIKE '%{$_REQUEST[campign_9]}%' AND                        
                        l.country LIKE '%{$_REQUEST[geo_9]}%' AND
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
                    LEFT JOIN projects_downloads pd ON pd.id=ip.download_id
                    LEFT JOIN subid s ON pd.subid_id=s.id
                    LEFT JOIN geo_location l ON pd.location_id=l.id                                                                
                    WHERE
                        p.assigned_user_id={$user_id} AND 
                        ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                        ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND 
                        p.proj_name LIKE '%{$_REQUEST[campign_9]}%' AND                        
                        l.country LIKE '%{$_REQUEST[geo_9]}%' AND
                        (   
                            s.subid1 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid2 LIKE '%{$_REQUEST[subid_9]}%' OR 
                            s.subid3 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid4 LIKE '%{$_REQUEST[subid_9]}%' OR 
                            s.subid5 LIKE '%{$_REQUEST[subid_9]}%' 
                        ) 
                    GROUP BY 
                        DATE_FORMAT(DATE_ADD(ip.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d')
                ) proj_state
            ON proj_click.date = proj_state.date
            LEFT JOIN
                (                                             
                    SELECT
                        DATE_FORMAT(DATE_ADD(io.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d') as date,
                        sum(io.price*io.adjust_rate/100*io.pub_revenue/100) AS total
                    FROM 
                        (    
                            SELECT 
                                io1.install_datetime,
                                io1.price, io1.adjust_rate, io1.am_revenue, io1.pub_revenue, io1.pm_revenue
                            FROM 
                                install_offers io1
                            LEFT JOIN projects_downloads pd on io1.download_id=pd.id                                                    
                            LEFT JOIN projects p ON io1.proj_id=p.id                            
                            LEFT JOIN subid s ON pd.subid_id=s.id
                            LEFT JOIN geo_location l ON pd.location_id=l.id                                            
                            WHERE
                                p.assigned_user_id={$user_id} AND 
                                io1.install_completed = 1 AND
                                io1.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                io1.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND
                                p.proj_name LIKE '%{$_REQUEST[campign_9]}%' AND                                
                                l.country LIKE '%{$_REQUEST[geo_9]}%' AND
                                (   
                                    s.subid1 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid2 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                    s.subid3 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid4 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                    s.subid5 LIKE '%{$_REQUEST[subid_9]}%' 
                                ) 
                        ) io
                    GROUP BY DATE_FORMAT(DATE_ADD(io.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d')
                ) proj_revenue
            ON proj_click.date = proj_revenue.date                                    
        ORDER BY proj_click.date
        ";
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
            if (strlen(trim($row['clicks']))>0)                {array_push($workrow,$row['clicks']);}    else{array_push($workrow,'0');}    
            if (strlen(trim($row['open_session']))>0)                {array_push($workrow,$row['open_session']);}    else{array_push($workrow,'0');}            
            if (strlen(trim($row['install_accepted']))>0)                {array_push($workrow,$row['install_accepted']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['install_started']))>0)                {array_push($workrow,$row['install_started']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['install_completed']))>0)                {array_push($workrow,$row['install_completed']);}    else{array_push($workrow,'0');}
            if (strlen(trim($row['total']))>0)                {array_push($workrow,number_format($row[total],2));}    else{array_push($workrow,'0');}
            if (strlen(trim($row['total']/$row['install_completed']))>0)                {array_push($workrow,number_format($row[total],2));}    else{array_push($workrow,'0');}
            if (strlen(trim($row['total']/$row['clickes']))>0)                {array_push($workrow,number_format($row[total],2));}    else{array_push($workrow,'0');}
            
            fputcsv    ($outstream,$workrow,',','"');                                                   
        }   
            
    }
 
    
?>
