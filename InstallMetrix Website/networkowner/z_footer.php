
<!-- END PAGE -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div id="footer">
    2013 &copy; Installmetrix.
    <div class="span pull-right">
        <span class="go-top"><i class="icon-arrow-up"></i></span>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS -->
<!-- Load javascripts at bottom, this will reduce page load time -->
<script type="text/javascript" src="../common/assets/jQuery-slimScroll/slimScroll.min.js"></script>
<script type="text/javascript" src="../common/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="../common/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../common/assets/js/jquery.blockui.js"></script>
<script type="text/javascript" src="../common/assets/js/jquery.cookie.js"></script>
<!-- ie8 fixes -->
<!--[if lt IE 9]>
<script src="assets/js/excanvas.js"></script>
<script src="assets/js/respond.js"></script>
<![endif]-->
<script type="text/javascript" src="../common/assets/jqvmap/jqvmap/jquery.vmap.js" ></script>
<script type="text/javascript" src="../common/assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js"></script>
<script type="text/javascript" src="../common/assets/jqvmap/jqvmap/maps/jquery.vmap.world.js"></script>
<script type="text/javascript" src="../common/assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js"></script>
<script type="text/javascript" src="../common/assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js"></script>
<script type="text/javascript" src="../common/assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js"></script>
<script type="text/javascript" src="../common/assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"></script>
<script type="text/javascript" src="../common/assets/jquery-knob/js/jquery.knob.js"></script>
<script type="text/javascript" src="../common/assets/flot/jquery.flot.js"></script>
<script type="text/javascript" src="../common/assets/flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="../common/assets/js/jquery.peity.min.js"></script>
<script type="text/javascript" src="../common/assets/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="../common/assets/uniform/jquery.uniform.min.js"></script>
<script type="text/javascript" src="../common/assets/js/jquery.pulsate.min.js"></script>
<script type="text/javascript" src="../common/assets/bootstrap-daterangepicker/date.js"></script>
<script type="text/javascript" src="../common/assets/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../common/assets/fancybox/source/jquery.fancybox.pack.js"></script>

<script type="text/javascript" src="../common/assets/bootstrap/js/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="../common/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="../common/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="../common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="../common/assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
<script type="text/javascript" src="../common/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../common/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="../common/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<script type="text/javascript" src="../common/assets/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="../common/assets/data-tables/DT_bootstrap.js"></script>
       
<script type="text/javascript" src="../common/assets/js/elrte.full.js" charset="utf-8"></script>
<link rel="stylesheet" href="../common/assets/css/elrte.min.css" type="text/css" media="screen" charset="utf-8">

<!-- elRTE translation messages -->
<script type="text/javascript" src="../common/assets/js/i18n/elrte.en.js" charset="utf-8"></script>


<?
if (strpos($_SERVER['REQUEST_URI'], 'dashboard.php') == true) {
    $sql = "SELECT DISTINCT(day(`install_datetime`)) as install_day, count(id) as install_count, sum(install_price) install_price FROM install_offers WHERE date_format(install_datetime, '%Y%m') = date_format(now(), '%Y%m') AND `network_id`='{$_SESSION[network_id]}' GROUP BY day(`install_datetime`)";
    $q = mysql_query($sql);
    while ($row = mysql_fetch_assoc($q)) {
        $graph_array[$row[install_day]] = '[' . $row[install_day] . ', ' . $row[install_price] . ']';
    }

    for ($i = 1; $i <= date("t"); $i++) {
        if (!isset($graph_array[$i]))
            $graph_array[$i] = '[' . $i . ', 0]';
    }

    ksort($graph_array);

    $ready_graph_array = implode(',', $graph_array);
    ?>
    
     <? } else { ?>
    <script>
        jQuery(document).ready(function() {
            App.init();

            var opts = {
                cssClass: 'el-rte',
                // lang     : 'ru',
                height: 250,
                width: 700,
                toolbar: 'complete',
                cssfiles: ['assets/css/elrte-inner.css']
            }
            $('.editor').elrte(opts);
        });
    </script>
<? } ?>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>