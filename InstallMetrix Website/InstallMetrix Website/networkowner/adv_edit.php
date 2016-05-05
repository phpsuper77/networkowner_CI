<?
include 'z_header.php';


////IS OWNER?
//if ($row[user_id] != $_SESSION[user_id]) {
//    echo('<script language="JavaScript">window.location.href = "dashboard.php"</script>');
//    break;
//}




if ($_REQUEST[tryout] == '1') {

    $errmsg = '';


    if ($_REQUEST[user_first_name] == '') {
        $errmsg.='<li>Field "First Name" should not be empty</li>';
    }

    if ($_REQUEST[user_last_name] == '') {
        $errmsg.='<li>Field "Last Name" should not be empty</li>';
    }

    if ($_REQUEST[user_email] == '') {
        $errmsg.='<li>Field "Last Name" should not be empty</li>';
    }

    if ($_REQUEST[user_pass] != '') {
        if ($_REQUEST[user_pass] != $_REQUEST[user_pass1]) {
            $errmsg.='<li>Entered passwords must be identical</li>';
        }
    }

    if (!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $_REQUEST[user_email])) {
        $errmsg.='<li>Enter a valid email address</li>';
    }

    if ($_REQUEST[user_phone] != '') {
        if (!preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $_REQUEST[user_phone])) {
            $errmsg.='<li>Enter a valid phone number</li>';
        }
    }

    
    if ($_REQUEST[adv_manager] == '1')
    {
        $user_status = '4';
        $errmsg = CheckRevenues($user_status,$_REQUEST[user_revenue]);    
    }
    else
    {
        $user_status = '2';
        $_REQUEST[user_revenue] = 0;
    }    
    
    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
    } else {

        if ($_REQUEST[user_pass] != '') {
            mysql_query("UPDATE `users` SET
                        user_first_name='{$_REQUEST[user_first_name]}',
                        user_last_name='{$_REQUEST[user_last_name]}',
                        user_email='{$_REQUEST[user_email]}',
                        user_phone='{$_REQUEST[user_phone]}',
                        user_company_name='{$_REQUEST[user_company_name]}',
                        website='{$_REQUEST[website]}',
                        user_aim='{$_REQUEST[user_aim]}',
                        user_skype='{$_REQUEST[user_skype]}',
                        user_pass=md5('{$_REQUEST[user_pass]}'),
                        user_status='{$user_status}',
                        user_system_status='{$_REQUEST[user_system_status]}',
                        user_revenue='{$_REQUEST[user_revenue]}',
                        user_manager='{$_REQUEST[user_manager]}'
                        WHERE id={$_REQUEST[id]} AND network_id={$_SESSION[network_id]}");
        } else {
            mysql_query("UPDATE `users` SET
                        user_first_name='{$_REQUEST[user_first_name]}',
                        user_last_name='{$_REQUEST[user_last_name]}',
                        user_email='{$_REQUEST[user_email]}',
                        user_phone='{$_REQUEST[user_phone]}',
                        user_company_name='{$_REQUEST[user_company_name]}',
                        website='{$_REQUEST[website]}',
                        user_aim='{$_REQUEST[user_aim]}',
                        user_skype='{$_REQUEST[user_skype]}',
                        user_status='{$user_status}',
                        user_system_status='{$_REQUEST[user_system_status]}',
                        user_revenue='{$_REQUEST[user_revenue]}',
                        user_manager='{$_REQUEST[user_manager]}'
                        WHERE id={$_REQUEST[id]} AND network_id={$_SESSION[network_id]}");
        }

        echo('<script language="JavaScript">window.location.href = "adv_list.php?mode=edited&id=' . $_REQUEST[id] . '"</script>');
        break;
    }
} else {
    $sql = "SELECT * FROM `users` WHERE `id`='{$_REQUEST[id]}' AND `network_id`={$_SESSION[network_id]}";
    $q = mysql_query($sql);
    $row = mysql_fetch_assoc($q);
    foreach ($row as $key => $value) {
        $_REQUEST[$key] = $value;
    }
    $_REQUEST[user_pass] = '';
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
                    Edit Advertiser
                    <small>edit the existing advertiser</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="adv_list.php">Advertisers List</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Edit Advertiser</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">
            <? if ($usermessage != '') { ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert"></button>
                    <?= $usermessage ?>
                </div>
            <? } ?>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Edit The Existing Advertiser</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <form action="adv_edit.php" class="form-horizontal" method="POST" id="add_form" enctype="multipart/form-data">
                                <input type="hidden" name="tryout" value="1"/>
                                <input type="hidden" name="id" value="<?= $_REQUEST[id] ?>"/>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Email</label>
                                    <div class="controls">
                                        <input type="text" id="user_email" name="user_email" value="<?= $_REQUEST[user_email] ?>" class="span6" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Password</label>
                                    <div class="controls">
                                        <input type="password" id="user_pass" name="user_pass" value="<?= $_REQUEST[user_pass] ?>" class="span6 popovers" data-trigger="hover" data-content='User password that will be used to sign in to the system. Leave this field blank if you want to keep the current password.' data-original-title="Password" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Repeat Password</label>
                                    <div class="controls">
                                        <input type="password" id="user_pass1" name="user_pass1" value="<?= $_REQUEST[user_pass1] ?>" class="span6" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> First Name</label>
                                    <div class="controls">
                                        <input type="text" id="user_first_name" name="user_first_name" value="<?= $_REQUEST[user_first_name] ?>" class="span6" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Last Name</label>
                                    <div class="controls">
                                        <input type="text" id="user_last_name" name="user_last_name" value="<?= $_REQUEST[user_last_name] ?>" class="span6" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3">Company (Firm) Name</label>
                                    <div class="controls">
                                        <input type="text" id="user_company_name" name="user_company_name" value="<?= $_REQUEST[user_company_name] ?>" class="span6" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3"> Website</label>
                                    <div class="controls">
                                        <input type="text" id="website" name="website" value="<?= $_REQUEST[website] ?>" class="span6" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"> AIM</label>
                                    <div class="controls">
                                        <input type="text" id="user_aim" name="user_aim" value="<?= $_REQUEST[user_aim] ?>" class="span6" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3">Skype</label>
                                    <div class="controls">
                                        <input type="text" id="user_skype" name="user_skype" value="<?= $_REQUEST[user_skype] ?>" class="span6" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3">Phone #</label>
                                    <div class="controls">
                                        <input type="text" id="user_phone" name="user_phone" value="<?= $_REQUEST[user_phone] ?>" class="span6 popovers" data-trigger="hover" data-content='Phone number in XXX-XXX-XXXX format' data-original-title="Phone Number" />
                                    </div>
                                </div>

                                <hr>

                                <div class="control-group">
                                    <label class="control-label" for="input3">Revenue Percentage</label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input type="text" id="user_revenue" name="user_revenue" value="<?= $_REQUEST[user_revenue] ?> " <? if($_REQUEST[user_status] == 2) echo 'disabled';?> class="input-large popovers"><span class="add-on">%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Assigned Manager</label>
                                    <div class="controls">
                                        <select class="span6 chosen" name='user_manager'>
                                            <option value="-1" <? if ($_REQUEST[user_manager] == '-1') echo 'SELECTED'; ?>>Not yet assigned</option>
                                            <?
                                            $sql1 = "SELECT id, user_name, user_first_name, user_last_name FROM `users` WHERE `user_status`=4 ORDER BY `id` DESC";
                                            $q1 = mysql_query($sql1);
                                            while ($row1 = mysql_fetch_assoc($q1)) {
                                                ?>
                                                <option value="<?= $row1[id] ?>" <? if ($_REQUEST[user_manager] == $row1[id]) echo 'SELECTED'; ?>><?= $row1[user_first_name] . ' ' . $row1[user_last_name] . ' (' . $row1[user_name] . ')' ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Status</label>
                                    <div class="controls">
                                        <select class="span6 chosen" name='user_system_status'>
                                            <option value="1" <? if ($_REQUEST[user_system_status] == '1') echo 'SELECTED'; ?>>Approved</option>
                                            <option value="2" <? if ($_REQUEST[user_system_status] == '2') echo 'SELECTED'; ?>>Pending</option>
                                            <option value="0" <? if ($_REQUEST[user_system_status] == '0') echo 'SELECTED'; ?>>Suspended</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" >Advertiser Manager</label>
                                    <div class="controls">
                                        <label class="checkbox">
                                            <input type="checkbox" name="adv_manager" id="adv_manager" value="1" <? if (($_REQUEST[adv_manager] == '1') || ($_REQUEST[user_status] == '4')) echo 'CHECKED'; ?>/>
                                        </label>
                                    </div>
                                </div>


                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick="$('#add_form').submit();
                                            return false;"><i class="icon-check"></i> Save Advertiser</a>
                                    <a href="adv_list.php" class="btn">Cancel</a>
                                </div>
                            </form>
                            <!-- END FORM-->
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