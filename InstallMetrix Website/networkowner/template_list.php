<?
include 'z_header.php';
//var_dump($_SERVER);exit;
?>

<?    
     $act = $_REQUEST["mode"];
     if($act=="del")
     {
         //$sql = "DELETE FROM templates WHERE template_id='{$_REQUEST["tid"]}'";
         $tmpl_name = mysql_result(mysql_query("SELECT name FROM templates WHERE id={$_REQUEST["tid"]}"), 0);
         
         $sql = "UPDATE templates SET status=1 WHERE id={$_REQUEST["tid"]}";
         $q = mysql_query($sql);
         //var_dump($sql);exit;
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
                    Templates List
                    <small>list of HTML templates for Installer Manager interface</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Templates List</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">

            <? if ($usermessage != '') { ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <?= $usermessage ?>
                </div>
            <? } ?>
            <?
            if ($_REQUEST[mode] == 'del') {
                ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    Template <b>"<?= $tmpl_name ?>"</b> has been removed successfully from the list!
                </div>
            <? } ?>
            
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Template List</h4>
                        </div>
                        <div class="widget-body form">
                            <div class="tabbable portlet-tabs">
                                <!-- BEGIN FORM-->
                                <table class="table table-striped table-bordered" id="other_list">
                                    <thead>
                                        <tr>
                                            <th>TID</th>
                                            <th>Template Name</th>                                       
                                            <th>&nbsp</th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $sql = "SELECT * FROM templates WHERE status=0";                                            
                                        $q = mysql_query($sql);
                                        while ($row = mysql_fetch_assoc($q)) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?= $row[id] ?></td>
                                                <td class="highlight"><?= ($row[name])?></td> 
                                                <td class="center">                                                                                                    
                                                    <a href="template_edit.php?tid=<?= $row[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Template"><i class="icon-pencil"></i></a>&nbsp;
                                                    <a href="template_list.php?tid=<?= $row[id]?>&mode=del" onclick="return confirm('Are you sure to remove <?= $row[name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Template"><i class="icon-remove"></i></a>&nbsp;
                                                </td>
                                            </tr>
                                        <? } ?>
                                    </tbody>
                                </table>
                                     
                            </div>
                            <!-- END FORM-->
                            <br>
                            <div class="form-actions" id="buttons_general"  style="<? if ($_REQUEST[tab] == '2') { ?> display: none; <? } ?> padding-left: 15px;">
                                <a href="template_add.php" class="btn btn-success"><i class="icon-plus-sign"></i> Add A New Template</a>
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
