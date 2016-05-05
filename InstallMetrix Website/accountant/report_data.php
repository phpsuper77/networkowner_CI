<?
	include '../common/config.php';
    

	if ($_REQUEST['type']=='subid')
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
        array_push($titleLine,"Network Revenue");
        fputcsv    ($outstream,$titleLine,',','"');
        
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
                if (strlen(trim($row['clicks']))>0)                {array_push($workrow,$row['clicks']);}    else{array_push($workrow,'0');}
                if (strlen(trim($row['open_sessions']))>0)        {array_push($workrow,$row['open_sessions']);}    else{array_push($workrow,'0');}
                if (strlen(trim($row['install_accepted']))>0)    {array_push($workrow,$row['install_accepted']);}    else{array_push($workrow,'0');}
                if (strlen(trim($row['install_started']))>0)    {array_push($workrow,$row['install_started']);}    else{array_push($workrow,'0');}
                if (strlen(trim($row['install_completed']))>0)    {array_push($workrow,$row['install_completed']);}    else{array_push($workrow,'0');}
                if (strlen(trim($row['total']))>0)                {array_push($workrow,number_format($row[total], 2, ".", ","));}    else{array_push($workrow,'0');}
                if (strlen(trim($row['install_completed']))>0)    {array_push($workrow,number_format($row[total]/$row[install_completed], 2, ".", ","));}    else{array_push($workrow,'0');}
                if (strlen(trim($row['clicks']))>0)                {array_push($workrow,number_format($row[total]/$row[clicks], 2, ".", ","));}            else{array_push($workrow,'0');}
                if (strlen(trim($row['network_revenue']))>0)    {array_push($workrow,number_format($row[network_revenue], 2, ".", ","));}        else{array_push($workrow,'0');}
                
                fputcsv    ($outstream,$workrow,',','"');
            }
        }
    }
    
?>
