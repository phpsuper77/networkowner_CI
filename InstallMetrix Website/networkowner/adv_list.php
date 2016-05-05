<?
include 'z_header.php';

if ($_REQUEST[mode] == 'removed') {
    $user_name = mysql_result(mysql_query("SELECT `user_name` FROM `users` WHERE `id`='{$_REQUEST[id]}' AND `network_id`='{$_SESSION[network_id]}'"), 0);
    //mysql_query("DELETE FROM `users` WHERE `id`={$_REQUEST[id]} AND `network_id`={$_SESSION[network_id]}");
    mysql_query("UPDATE users SET user_system_status=3 WHERE `id`={$_REQUEST[id]} AND `network_id`={$_SESSION[network_id]}");
}
?>


<div id="body">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN STYLE CUSTOMIZER-->
                <!-- END STYLE CUSTOMIZER-->
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Advertisers List
                    <small>list of your network's advertisers</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Advertisers List</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">

            <?
            if ($_REQUEST[mode] == 'added') {
                $user_name = mysql_result(mysql_query("SELECT `user_name` FROM `users` WHERE `id`='{$_REQUEST[id]}' AND `network_id`='{$_SESSION[network_id]}'"), 0);
                ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    New advertiser <b>"<?= $user_name ?>"</b> has been added successfully to your network!
                </div>
            <? } ?>

            <?
            if ($_REQUEST[mode] == 'edited') {
                $user_name = mysql_result(mysql_query("SELECT `user_name` FROM `users` WHERE `id`='{$_REQUEST[id]}' AND `network_id`='{$_SESSION[network_id]}'"), 0);
                ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    Advertiser <b>"<?= $user_name ?>"</b> has been edited successfully!
                </div>
            <? } ?>

            <?
            if ($_REQUEST[mode] == 'removed') {
                ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    Advertiser <b>"<?= $user_name ?>"</b> has been removed successfully from your network!
                </div>
            <? } ?>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Advertisers List</h4>
                        </div>
                        <div class="widget-body form">
                            <div class="tabbable portlet-tabs">
                                <ul class="nav nav-tabs">

                                    <li <? if ($_REQUEST[tab] == '2') { ?>class="active"<? } ?>><a href="#portlet_tab2" data-toggle="tab" id="tab2">Advertiser Managers</a></li>
                                    <li <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '')) { ?>class="active"<? } ?>><a href="#portlet_tab1" data-toggle="tab" id="tab1">Advertisers</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '')) { ?>active<? } ?>" id="portlet_tab1">
                                        <table class="table table-striped table-bordered" id="advertiser_list">
                                            <thead>
                                                <tr>
                                                    <th>AID</th>
                                                    <th>Joined Date/Time</th>
                                                    <th>Manager</th>
                                                    <th>Company Name</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Phone</th>
                                                    <th>Contact Email</th>
                                                    <th>Website</th>                                                     
                                                    <th>AIM</th>                                                     
                                                    <th>Skype</th>                                                     
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i = 0;
                                                $sql = "SELECT `users`.*, u1.user_first_name as manager_first_name, u1.user_last_name as manager_last_name, u1.user_name as manager_name FROM `users`
                                            LEFT JOIN `users` as u1 ON u1.id=users.user_manager
                                            WHERE `users`.`user_status`=2 AND NOT users.user_system_status=3  GROUP BY users.id";
                                                $q = mysql_query($sql);
                                                while ($row = mysql_fetch_assoc($q)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td class="highlight"><div class="success"></div><?= $row[subid] ?></td>
                                                        <td><?= date_format(date_create($row[join_datetime]), SHORTDATETIME) ?></td>
                                                        <td><?
                                                            if ($row[user_manager] == '-1') {
                                                                echo('Not yet assigned');
                                                            } else {
                                                                echo('<a href="adv_edit.php?id=' . $row[user_manager] . '">' . $row[manager_first_name] . ' ' . $row[manager_last_name] . ' </a>');
                                                            }
                                                            ?></td>
                                                        <td><?= $row[user_company_name] ?></td>
                                                        <td><?= $row[user_first_name] . ' ' . $row[user_last_name] ?></td>
                                                        <td><a href='callto:<?= $row[user_phone] ?>'><?= $row[user_phone] ?></a></td>
                                                        <td><a href='mailto:<?= $row[user_email] ?>'><?= $row[user_email] ?></a></td>
                                                        <td><?= $row[website] ?></td>
                                                        <td><?= $row[user_aim] ?></td>
                                                        <td><?= $row[user_skype] ?></td>
                                                        
                                                        <td>
                                                            <?
                                                            switch ($row[user_system_status]) {
                                                                case '0':
                                                                    echo('<span class="label label-important">Suspended</span>');
                                                                    break;
                                                                case '1':
                                                                    echo('<span class="label label-success">Approved</span>');
                                                                    break;
                                                                case '2':
                                                                    echo('<span class="label label-warning">Pending</span>');
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="center">
                                                            <a href="adv_edit.php?id=<?= $row[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Advertiser"><i class="icon-pencil"></i></a>&nbsp;
                                                            <a href="adv_list.php?mode=removed&id=<?= $row[id] ?>" onclick="return confirm('Are you sure to remove <?= $row[user_name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Remove Advertiser From The Network"><i class="icon-remove"></i></a>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <?
                                                    $i++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <script>
                                                                jQuery(document).ready(function() {
                                                                    $("#tab1").html('Advertisers (<?= $i ?>)');
                                                                });
                                        </script>
                                        <br>
                                    </div>

                                    <div class="tab-pane <? if ($_REQUEST[tab] == '2') { ?>active<? } ?>" id="portlet_tab2">
                                        <table class="table table-striped table-bordered" id="other_list">
                                            <thead>
                                                <tr>
                                                    <th>AMID</th>
                                                    <th>Joined Date/Time</th>
                                                    <th>Company Name</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Phone</th>
                                                    <th>Contact Email</th>
                                                    <th>WebSite</th>
                                                    <th>AIM</th>
                                                    <th>Skype</th>
                                                    <th>Revenue</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i = 0;
                                                $sql = "SELECT `users`.*, u1.user_first_name as manager_first_name, u1.user_last_name as manager_last_name, u1.user_name as manager_name FROM `users`
                                            LEFT JOIN `users` as u1 ON u1.id=users.user_manager
                                            WHERE `users`.`user_status`=4 AND NOT users.user_system_status=3 GROUP BY users.id";
                                                $q = mysql_query($sql);
                                                while ($row = mysql_fetch_assoc($q)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td class="highlight"><div class="success"></div><?= $row[subid] ?></td>
                                                        <td><?= date_format(date_create($row[join_datetime]), SHORTDATETIME) ?></td>

                                                        <td><?= $row[user_company_name] ?></td>
                                                        <td><?= $row[user_first_name] . ' ' . $row[user_last_name] ?></td>
                                                        <td><a href='callto:<?= $row[user_phone] ?>'><?= $row[user_phone] ?></a></td>
                                                        <td><a href='mailto:<?= $row[user_email] ?>'><?= $row[user_email] ?></a></td>
                                                        <td><?= $row[website] ?></td>
                                                        <td><?= $row[user_aim] ?></td>
                                                        <td><?= $row[user_skype] ?></td>
                                                        <td><?= $row[user_revenue] ?>%</td>
                                                        <td>
                                                            <?
                                                            switch ($row[user_system_status]) {
                                                                case '0':
                                                                    echo('<span class="label label-important">Suspended</span>');
                                                                    break;
                                                                case '1':
                                                                    echo('<span class="label label-success">Approved</span>');
                                                                    break;
                                                                case '2':
                                                                    echo('<span class="label label-warning">Pending</span>');
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="center">
                                                            <a href="adv_edit.php?id=<?= $row[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Advertiser"><i class="icon-pencil"></i></a>&nbsp;
                                                            <a href="adv_list.php?mode=removed&id=<?= $row[id] ?>" onclick="return confirm('Are you sure to remove <?= $row[user_name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Remove Advertiser From The Network"><i class="icon-remove"></i></a>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <?
                                                    $i++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <script>
                                                                jQuery(document).ready(function() {
                                                                    $("#tab2").html('Advertiser Managers (<?= $i ?>)');
                                                                });
                                        </script>
                                        <br>
                                    </div>

                                </div>
                            </div>

                            <!-- BEGIN FORM-->

                            <!-- END FORM-->
                            <br>
                            <div class="form-actions" id="buttons_general"  style="<? if ($_REQUEST[tab] == '2') { ?> display: none; <? } ?> padding-left: 15px;">
                                <a href="adv_add.php" class="btn btn-success"><i class="icon-plus-sign"></i> Add A New Advertiser</a>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>

        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
</div>

<? include 'z_footer.php'; ?>