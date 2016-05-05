<?

include 'config.php';

error_reporting(E_ALL ^ E_NOTICE);

//$gate_url = 'http://publishers.startinstaller.com/gate/installer_gate.php?id=20';
//
//$image_file = $_SERVER['DOCUMENT_ROOT'] . '/installers/startinstaller.exe';
//$new_file = $_SERVER['DOCUMENT_ROOT'] . '/installers/startinstaller_temp.exe';
//$gate_url = "http://" . $_SERVER['SERVER_NAME'] . "/gate/installer_gate.php?id=" . $proj_id;
//$gate_url = str_pad($gate_url, 150, " ");
//copy($image_file, $new_file);
//
//$handle = fopen($new_file, "a+");
//fwrite($handle, $gate_url);
//fclose($handle);
//$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&sensor=false&language=en";

?>
<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Mushrooms', 3],
          ['Onions', 1],
          ['Olives', 1],
          ['Zucchini', 1],
          ['Pepperoni', 2]
        ]);

        // Set chart options
        var options = {'title':'How Much Pizza I Ate Last Night',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>