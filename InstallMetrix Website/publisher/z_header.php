<?     
include '../common/config1.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
}

foreach ($_REQUEST as $key => $value) {
    $_REQUEST[$key] = stripslashes($_REQUEST[$key]);
    $_REQUEST[$key] = mysql_real_escape_string($_REQUEST[$key]);
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if IE 10]> <html lang="en" class="ie10"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Installmetrix</title>     
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link href="../common/assets/bootstrap/css/bootstrap.css" rel="stylesheet" />
        <link href="../common/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link href="../common/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="../common/assets/css/style.css" rel="stylesheet" />
        <link href="../common/assets/css/style_responsive.css" rel="stylesheet" />
        <link href="../common/assets/css/style_default.css" rel="stylesheet" id="style_color" />
        
        <link href="../common/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="../common/assets/gritter/css/jquery.gritter.css" />
        <link rel="stylesheet" type="text/css" href="../common/assets/uniform/css/uniform.default.css" />
        <link rel="stylesheet" type="text/css" href="../common/assets/bootstrap-daterangepicker/daterangepicker.css" />
        <link href="../common/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
        <link href="../common/assets/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />


        <link href="../common/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
        <link href="../common/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="../common/assets/chosen-bootstrap/chosen/chosen.css" />
        <link rel="stylesheet" type="text/css" href="../common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
        <link rel="stylesheet" type="text/css" href="../common/assets/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="../common/assets/bootstrap-timepicker/compiled/timepicker.css" />
        <link rel="stylesheet" type="text/css" href="../common/assets/bootstrap-colorpicker/css/colorpicker.css" />
        <link rel="stylesheet" href="../common/assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
        <link rel="stylesheet" href="../common/assets/data-tables/DT_bootstrap.css" />



        <link rel="shortcut icon" href="favicon.png">

        <script type="text/javascript" src="../common/assets/js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="../common/assets/jQuery-slimScroll/jquery-ui-1.9.2.custom.min.js"></script>
        
        
        <!--  For graph on Dashboard  -->    
        <script type="text/javascript" src="../common/assets/jqplot/jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="../common/assets/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script> 
        <script type="text/javascript" src="../common/assets/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="../common/assets/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
        <script type="text/javascript" src="../common/assets/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
        <script type="text/javascript" src="../common/assets/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
        <script type="text/javascript" src="../common/assets/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="../common/assets/jqplot/plugins/jqplot.barRenderer.min.js"></script>
        <script type="text/javascript" src="../common/assets/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
        <script type="text/javascript" src="../common/assets/jqplot/plugins/jqplot.highlighter.min.js"></script>
        <script type="text/javascript" src="../common/assets/jqplot/plugins/jqplot.logAxisRenderer.min.js"></script>
        <script type="text/javascript" src="../common/assets/jqplot/nicenum.js"></script>
    
        
        <script type="text/javascript" src="js/app.js"></script>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script>
//            jQuery(document).ready(function() {
//                google.load('visualization', '1.0', {'packages': ['corechart']});
//            });
        </script>
       
    </head>
  
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="fixed-top">
        <!-- BEGIN HEADER -->
        <div id="header" class="navbar navbar-inverse navbar-fixed-top">
            <!-- BEGIN TOP NAVIGATION BAR -->
            <div class="navbar-inner">
                <div class="container-fluid">
                    <!-- BEGIN LOGO -->
                    <a class="brand" href="dashboard.php">
                        <img src="../common/assets/img/logo.png" style="width: 131px; height: 26px;"/>
                    </a>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="arrow"></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <div class="top-nav">

                        <!-- BEGIN TOP NAVIGATION MENU -->
                        <ul class="nav pull-right" id="top_menu">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <li>
                                <a href="#">
                                    <?
                                    $q = mysqli_query($newconn, "SELECT `name` FROM `users_statuses` WHERE `value`={$_SESSION[user_status]}");
                                    $row = mysqli_fetch_assoc($q);
                                    $user_system_status = $row[name];
                                    ?>
                                    <span class="label label-warning"><?= $user_system_status ?></span>
                                </a>
                                
                            </li>
                            <!-- END NOTIFICATION DROPDOWN -->

                            <li class="divider-vertical hidden-phone hidden-tablet"></li>
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-user"></i>
                                    &nbsp;&nbsp;Welcome, <?= $_SESSION[user_first_name] ?>&nbsp;
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="acc_edit.php"><i class="icon-cogs"></i> Settings</a></li>
                                    <li class="divider"></li>
                                    <li><a href="../login.php"><i class="icon-signout"></i> Log Out</a></li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                        </ul>
                        <!-- END TOP NAVIGATION MENU -->
                    </div>
                </div>
            </div>
            <!-- END TOP NAVIGATION BAR -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
        <div id="container" class="row-fluid">
            <!-- BEGIN SIDEBAR -->
            <div id="sidebar" class="nav-collapse collapse">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <div class="navbar-inverse">
                    <form class="navbar-search visible-phone">
                        <input type="text" class="search-query" placeholder="Search" />
                    </form>
                </div>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
                <!-- BEGIN SIDEBAR MENU -->
                <ul>
                    <li class="<? if (strpos($_SERVER['REQUEST_URI'], 'dashboard.php') == true) echo 'active'; ?>">
                        <a href="dashboard.php">
                            <i class="icon-home"></i> Dashboard
                        </a>
                    </li>

    

                    <li class="has-sub <? if (  (strpos($_SERVER['REQUEST_URI'], 'camp_add.php') == true) || (strpos($_SERVER['REQUEST_URI'], 'camp_list.php') == true) || (strpos($_SERVER['REQUEST_URI'], 'camp_edit.php') == true) ) echo 'active'; ?>">
                        <a href="javascript:;" class="">
                            <i class="icon-list-alt"></i> Campaigns
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub">                            
                            <li class="<? if (strpos($_SERVER['REQUEST_URI'], 'camp_list.php') == true) echo 'active'; ?>"><a href="camp_list.php">Campaigns List</a></li>                            
                        </ul>
                    </li>

                    <li class="<? if (strpos($_SERVER['REQUEST_URI'], 'reports.php') == true) echo 'active'; ?>">
                        <a href="reports.php">
                            <i class="icon-bar-chart"></i> Reports
                        </a>
                    </li>
  

                    <li class="<? if (strpos($_SERVER['REQUEST_URI'], 'acc_edit.php') == true) echo 'active'; ?>">
                        <a href="acc_edit.php">
                            <i class="icon-user"></i> My Account
                        </a>
                    </li>

                </ul>
                <!-- END SIDEBAR MENU -->
            </div>