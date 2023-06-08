<?php
require_once '../../config/config.php';

if (!empty($_GET['var1'])) {
  $id_hw = $_GET['var1'];
  $jsonRealPowerId = json_decode(_getDataCurrentById($id_hw), TRUE);

?>

<canvas id="myChartPower"></canvas>
<script>
  var canvasChartPower = document.getElementById('myChartPower');
  canvasChartPower.height = 100;
  var dataChartPower = {
    labels: [
        // "00:00:38","00:00:40","00:00:42","00:00:44","00:00:47","00:00:49","00:00:51","00:00:53","00:00:55","00:00:57","00:00:59","00:01:01","00:01:03","00:01:05","00:01:07",
        <?php
        foreach ($jsonRealPowerId['data'] as $valueX) {
          $valX = substr($valueX['datetime'], 10);
          echo '"' . $valX . '",';
        }
        ?>
      ],
      datasets: [{
          label: "Daya Listrik (Watt)",
          fill: true,
          backgroundColor: "rgba(109, 148, 182, .2)",
          borderColor: "rgba(0, 160, 0, .5)",
          borderCapStyle: 'butt',
          borderDash: [],
          borderDashOffset: 0.0,
          borderJoinStyle: 'miter',
          pointBorderColor: "rgba(42, 64, 83, .5)",
          pointBackgroundColor: "#fff",
          pointBorderWidth: 1,
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(248, 42, 42, .7)",
          pointHoverBorderColor: "rgba(248, 42, 42, .5)",
          pointHoverBorderWidth: 2,
          pointRadius: 5,
          pointHitRadius: 10,
          data: [
            // 6,4,7,4,4,3,7,4,4,7,6,6,6,5,7,
            <?php
              foreach ($jsonRealPowerId['data'] as $valueY) {
                $valX = round($valueY['power'], 1);
                echo '"' . $valX . '",';
              }
              ?>
            ],
        },

      ]
    };

    var optionChartPower = {
      responsive: true,
      // maintainAspectRatio: false,
      showLines: true,
      animation: {
        duration: 0
      },
      scales: {
        yAxes: [{
          ticks: {
            // beginAtZero: true
          }
        }]
      }
    };

  var myLineChartPower = Chart.Line(canvasChartPower, {
    data: dataChartPower,
    options: optionChartPower
  });
</script>
<?php } ?>