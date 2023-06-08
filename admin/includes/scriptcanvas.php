<script> //Grafik Users Act In
    var ctxuai = document.getElementById("chartUsersActivityIn");
    var myChartUsersActivityIn = new Chart(ctxuai, {
        type: 'line',
        data: {
            labels: [<?php if(isset($jsonGetIn)){
                        foreach ($jsonGetIn['data_in'] as $inX) {
                          $inX2 = $inX['time_in'];
                          echo '"' . $inX2 . '",';
                        }
                      }
                    ?>],
            datasets: [{
                label: 'Pengguna Masuk',
                pointBorderColor: "rgba(200, 99, 132, .7)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(255, 132, 0, 0.7)",
                pointHoverBorderColor: "rgba(255, 132, 0, 1)",
                pointHoverBorderWidth: 2,
                pointRadius: 5,
                pointHitRadius: 10,
                data: [<?php if(isset($jsonGetIn)){
                          foreach ($jsonGetIn['data_in'] as $inY) {
                            $inY2 = $inY['count'];
                            echo '"' . $inY2 . '",';
                          }
                        }
                        ?>],
                backgroundColor: [
                    'rgba(255, 132, 0, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 132, 0, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "<?php if(isset($jsonGetIn)){ echo $jsonGetIn['label'];} ?>"
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "Jumlah Pengguna Masuk"
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }],
            }
        }
    });
    document.getElementById('btnDownloadChartUAI').addEventListener("click", function(e) {
        splitCanvas('uai');
    });
</script>

<script> //Grafik Users Act Out
    var ctxuao = document.getElementById("chartUsersActivityOut");
    var myChartUsersActivityOut = new Chart(ctxuao, {
        type: 'line',
        data: {
            labels: [<?php if(isset($jsonGetIn)){
                        foreach ($jsonGetIn['data_out'] as $outX) {
                          $outX2 = $outX['time_out'];
                          echo '"' . $outX2 . '",';
                        }
                      }
                    ?>],
            datasets: [{
                label: 'Pengguna Keluar',
                pointBorderColor: "rgba(200, 99, 132, .7)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(0, 144, 255, 0.7)",
                pointHoverBorderColor: "rgba(0, 144, 255, 1)",
                pointHoverBorderWidth: 2,
                pointRadius: 5,
                pointHitRadius: 10,
                data: [<?php if(isset($jsonGetIn)){
                          foreach ($jsonGetIn['data_out'] as $outY) {
                            $outY2 = $outY['count'];
                            echo '"' . $outY2 . '",';
                          }
                        }
                        ?>],
                backgroundColor: [
                    'rgba(0, 144, 255, 0.2)',
                ],
                borderColor: [
                    'rgba(0, 144, 255, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "<?php if(isset($jsonGetIn)){ echo $jsonGetIn['label']; }?>",
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "Jumlah Pengguna Keluar"
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }],
            }
        }
    });
    document.getElementById('btnDownloadChartUAO').addEventListener("click", function(e) {
        splitCanvas('uao');
    });
</script>

<script> //Grafik Jam Sibuk
  var ctxuir = document.getElementById("chartUsersInRoom");
  var myChartUsersInRoom = new Chart(ctxuir, {
    type: 'bar',
    data: {
      labels: [<?php 
      $jsonBusyTime = json_decode(_getDataChart("busy/"), TRUE);
      foreach ($jsonBusyTime['data'] as $valueX) {
        $valX = $valueX['time'];
        echo '"' . $valX . '",';
      }
        ?>],
      datasets: [{
        label: 'Pengguna di Ruangan',
        // pointBorderColor: "rgba(200, 99, 132, .7)",
        // pointBackgroundColor: "#fff",
        // pointBorderWidth: 1,
        // pointHoverRadius: 5,
        // pointHoverBackgroundColor: "rgba(0, 191, 255, 0.7)",
        // pointHoverBorderColor: "rgba(0, 191, 255, 1)",
        // pointHoverBorderWidth: 2,
        // pointRadius: 5,
        // pointHitRadius: 10,
        data: [<?php 
        foreach ($jsonBusyTime['data'] as $valueY) {
          $valY = $valueY['count'];
          echo '"' . $valY . '",';
        }
        ?>],
        backgroundColor: [<?php 
        foreach ($jsonBusyTime['data'] as $valueY) {
          echo "'#00b500',";
        }
        ?>],
        hoverBackgroundColor: [<?php 
        foreach ($jsonBusyTime['data'] as $valueY) {
          echo "'#006000',";
        }
        ?>],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: "Waktu Akses (Pukul)"
          },
          ticks: {
            beginAtZero: true
          }
        }],
        yAxes: [{
          scaleLabel: {
            display: true,
            labelString: "Jumlah Pengguna di Ruangan"
          },
          ticks: {
            beginAtZero: true,
            stepSize: 1
          }
        }],
      }
    }
  });
  document.getElementById('btnDownloadChartUIR').addEventListener("click", function(e) {
    splitCanvas('uir');
  });
</script>

<script> //Grafik Pie Kunjungan Harian
// window.onload = function() {
  $(function() {
    var myChartDailyActivity = $('#chartDailyActivity').get(0).getContext('2d')
    var donutData = {
      labels: [<?php 
        $jsonGetDailyVisitors = json_decode(_getDataChart("dailyvisit/"), TRUE);
        foreach ($jsonGetDailyVisitors['data'] as $valueX) {
          $valX = $valueX['day'];
          echo '"' . $valX . '",';
        }
      
      ?>],
      datasets: [{
        data: [<?php
                foreach ($jsonGetDailyVisitors['data'] as $valueY) {
                  $valY = $valueY['count'];
                  echo '"' . $valY . '",';
                }
                ?>],
        backgroundColor: [
            '#6abb4a', '#f5983a', '#ee4935', '#00c0ef', '#51328d', '#d2d6de', '#733f2a'
        ],
      }]
    }
    var donutOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    new Chart(myChartDailyActivity, {
      type: 'pie',
      data: donutData,
      options: donutOptions
    })
  });
  document.getElementById('btnDownloadPieDaily').addEventListener("click", function(e) {
    splitCanvas('pda');
  });
// }
</script>

<script> 
window.onload = function() {
  var ctxpu = document.getElementById("chartPowerUsage"); //Grafik Pemakaian Daya Harian
  var myChartPowerUsage = new Chart(ctxpu, {
    type: 'line',
    data: {
      labels: [<?php if(isset($id_hw_detail)){
      $jsonPowerUsage = json_decode(_getDataChart("powerconsum/".$id_hw_detail), TRUE);
        foreach ($jsonPowerUsage['daily'] as $valueX) {
          $valX = date("d M", strtotime($valueX['date']));
          echo '"' . $valX . '",';
        }
      }
        ?>],
      datasets: [{
        label: 'Daya (WH)',
        pointBorderColor: "rgba(200, 99, 132, .7)",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(0, 191, 255, 0.7)",
        pointHoverBorderColor: "rgba(0, 191, 255, 1)",
        pointHoverBorderWidth: 2,
        pointRadius: 5,
        pointHitRadius: 10,
        data: [<?php if(isset($jsonPowerUsage)){
          foreach ($jsonPowerUsage['daily'] as $valueY) {
            $valY = $valueY['powerUsage(wH)'];
            echo '"' . $valY . '",';
          }
        }
        ?>],
        backgroundColor: [
          'rgba(0, 191, 255, 0.2)',
        ],
        borderColor: [
          'rgba(0, 191, 255, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: "Tanggal"
          },
          ticks: {
            beginAtZero: true
          }
        }],
        yAxes: [{
          scaleLabel: {
            display: true,
            labelString: "Daya (WH)"
          },
          ticks: {
            beginAtZero: true,
            stepSize: 1
          }
        }],
      }
    }
  });
  document.getElementById('btnDownloadChartPU').addEventListener("click", function(e) {
    splitCanvas('pu');
  });
  
  var ctxpum = document.getElementById("chartPowerUsageMonthly"); //Grafik Pemakaian Daya Bulanan
  var myChartPowerUsageMonthly = new Chart(ctxpum, {
    type: 'line',
    data: {
      labels: [<?php if(isset($id_hw_detail)){
      $jsonPowerUsageM = json_decode(_getDataChart("powerconsum/".$id_hw_detail), TRUE);
        foreach ($jsonPowerUsageM['monthly'] as $valueX) {
          $valX = $valueX['month'];
          echo '"' . $valX . '",';
        }
      }
        ?>],
      datasets: [{
        label: 'Daya (WH)',
        pointBorderColor: "rgba(200, 99, 132, .7)",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(0, 191, 255, 0.7)",
        pointHoverBorderColor: "rgba(0, 191, 255, 1)",
        pointHoverBorderWidth: 2,
        pointRadius: 5,
        pointHitRadius: 10,
        data: [<?php if(isset($jsonPowerUsageM)){
          foreach ($jsonPowerUsageM['monthly'] as $valueY) {
            $valY = $valueY['powerUsage(wH)'];
            echo '"' . $valY . '",';
          }
        }
        ?>],
        backgroundColor: [
          'rgba(0, 191, 255, 0.2)',
        ],
        borderColor: [
          'rgba(0, 191, 255, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: "Bulan"
          },
          ticks: {
            beginAtZero: true
          }
        }],
        yAxes: [{
          scaleLabel: {
            display: true,
            labelString: "Daya (WH)"
          },
          ticks: {
            beginAtZero: true,
            stepSize: 5
          }
        }],
      }
    }
  });
  document.getElementById('btnDownloadChartPUM').addEventListener("click", function(e) {
    splitCanvas('pum');
  });
}
</script>

<script> // Convert canvas to image
    function splitCanvas(periode) {
        var fn = "";
        if (periode == 'uai') {
            fn = "Grafik Pengguna Masuk <?php echo $tPeriode; ?>"
            var canvas = document.querySelector('#chartUsersActivityIn');
        } else if (periode == 'uao') {
            fn = "Grafik Pengguna Keluar <?php echo $tPeriode; ?>"
            var canvas = document.querySelector('#chartUsersActivityOut');
        } else if (periode == 'uir') {
            fn = "Grafik Jam Sibuk <?php echo $dateExport ?>"
            var canvas = document.querySelector('#chartUsersInRoom');
        } else if (periode == 'pda') {
            fn = "Pie Chart Daily Activity - <?php echo $dateExport ?>"
            var canvas = document.querySelector('#chartDailyActivity');
        } else if (periode == 'pu') {
            fn = "Grafik Konsumsi Daya Harian - <?php echo $dateExport ?>"
            var canvas = document.querySelector('#chartPowerUsage');
        } else if (periode == 'pum') {
            fn = "Grafik Konsumsi Daya Bulanan - <?php echo $dateExport ?>"
            var canvas = document.querySelector('#chartPowerUsageMonthly');
        }
        var dataURL = canvas.toDataURL("image/png", 1.0);
        downloadImage(dataURL, fn);
    }

    function downloadImage(data, filename = 'untitled.png') {
        var a = document.createElement('a');
        a.href = data;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
    }
</script>
