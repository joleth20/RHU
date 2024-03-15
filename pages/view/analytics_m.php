<?php
$user_type = $_SESSION["user_type"];
$user_id = $_SESSION["user_id"];
$doctor = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
if ($user_type != "1") {
  echo "<script>alert('Action Not Allowed!')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";

}
include 'pages/view/config/dbconfig.php';

// DATE SORTER
function sortFunction( $a, $b ) {
    return strtotime($a["date"]) - strtotime($b["date"]);
}

$sql_rx_pending = "SELECT
    DATE_FORMAT(req_date, '%b %Y') AS req_month,	status,
    COUNT(rx_id) AS count
  FROM medication_refills WHERE status = 'Pending' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
  GROUP BY req_month";

$result_rx_pending = mysqli_query($conn, $sql_rx_pending);
$rx_pending=[];
if($result_rx_pending){
while($row_rx_pending=mysqli_fetch_assoc($result_rx_pending)){
    $rx_pending[] = array("date"=>$row_rx_pending["req_month"],"count"=>$row_rx_pending["count"]);
}}


usort($rx_pending, "sortFunction");

foreach ($rx_pending as $key => $value) {
   $dataPointsBar_rx_pending_label[] =  $value["date"];
   $dataPointsBar_rx_pending_count[] = $value["count"];
}


$sql_rx_completed = "SELECT
    DATE_FORMAT(req_date, '%b %Y') AS req_month,	status,
    COUNT(rx_id) AS count
  FROM medication_refills WHERE status = 'Completed' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
  GROUP BY req_month";

$result_rx_completed = mysqli_query($conn, $sql_rx_completed);
$rx_completed = [];
if($result_rx_completed){
while($row_rx_completed=mysqli_fetch_assoc($result_rx_completed)){
       $rx_completed[]=array("date"=>$row_rx_completed["req_month"],"count"=>$row_rx_completed["count"]);
    }
}

usort($rx_completed, "sortFunction");

foreach ($rx_completed as $key => $value) {
   $dataPointsBar_rx_completed_label[] =  $value["date"];
   $dataPointsBar_rx_completed_count[] = $value["count"];
}


$sql_rx_rejected = "SELECT
    DATE_FORMAT(req_date, '%b %Y') AS req_month,	status,
    COUNT(rx_id) AS count
  FROM medication_refills WHERE status = 'Rejected' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
  GROUP BY req_month";

$result_rx_rejected = mysqli_query($conn, $sql_rx_rejected);
$rx_rejected = [];
if($result_rx_rejected){
    while($row_rx_rejected=mysqli_fetch_assoc($result_rx_rejected)){
        $rx_rejected[]=array("date"=>$row_rx_rejected["req_month"],"count"=>$row_rx_rejected["count"]);
    }
}
usort($rx_rejected, "sortFunction");

foreach ($rx_rejected as $key => $value) {
   $dataPointsBar_rx_rejected_label[] =  $value["date"];
   $dataPointsBar_rx_rejected_count[] = $value["count"];
}

$sql_rx_totalrx = "SELECT
    DATE_FORMAT(req_date, '%b %Y') AS req_month,
    COUNT(rx_id) AS count
  FROM medication_refills WHERE req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
  GROUP BY req_month";

$result_rx_totalrx = mysqli_query($conn, $sql_rx_totalrx);
$rx_totalrx=[];
if($result_rx_totalrx){
    while($row_rx_totalrx=mysqli_fetch_assoc($result_rx_totalrx)){
        $rx_totalrx[]=array("date"=>$row_rx_totalrx["req_month"],"count"=>$row_rx_totalrx["count"]);
    
    }
}
usort($rx_totalrx, "sortFunction");

foreach ($rx_totalrx as $key => $value) {
   $dataPointsBar_rx_totalrx_label[] =  $value["date"];
   $dataPointsBar_rx_totalrx_count[] = $value["count"];
}
?>

<div class="page-header">
  <h3 class="page-title"> Analytics </h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <!-- <li class="breadcrumb-item"><a href="#">Charts</a></li>
      <li class="breadcrumb-item active" aria-current="page">Chart-js</li> -->
    </ol>
  </nav>
</div>
<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Pending Medication Refills Request for the month of <?php echo date('F Y'); ?></h4>
        <!-- <canvas id="lineChart" style="height:250px"></canvas> -->
        <canvas id="barChart_pending" style="height:230px"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Completed Medication Refills Request by Month</h4>
        <canvas id="barChart_completed" style="height:230px"></canvas>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Rejected Medication Refills Request by Month</h4>
        <canvas id="barChart_rejected" style="height:230px"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Total of Medication Refills Request by Month</h4>
        <canvas id="barChart_totalrx" style="height:230px"></canvas>
      </div>
    </div>
  </div>
</div>


        <!-- <script src="assets/vendors/js/vendor.bundle.base.js"></script> -->
        <!-- <script src="assets/vendors/chart.js/Chart.min.js"></script> -->
        <!-- <script src="assets/js/chart.js"></script> -->
        <script>
        $(function () {
          /* ChartJS
           * -------
           * Data and config for chartjs
           */
          'use strict';
          var dataBar_pending = {
            labels: <?php echo json_encode($dataPointsBar_rx_pending_label, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
              label: '# of Pending',
              data: <?php echo json_encode($dataPointsBar_rx_pending_count, JSON_NUMERIC_CHECK); ?>,
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
              fill: false
            }]
          };

          var dataBar_completed = {
            labels: <?php echo json_encode($dataPointsBar_rx_completed_label, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
              label: '# of Completed',
              data: <?php echo json_encode($dataPointsBar_rx_completed_count, JSON_NUMERIC_CHECK); ?>,
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
              fill: false
            }]
          };

          var dataBar_rejected = {
            labels: <?php echo json_encode($dataPointsBar_rx_rejected_label, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
              label: '# of Rejected',
              data: <?php echo json_encode($dataPointsBar_rx_rejected_count, JSON_NUMERIC_CHECK); ?>,
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
              fill: false
            }]
          };

          var dataBar_totalrx = {
            labels: <?php echo json_encode($dataPointsBar_rx_totalrx_label, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
              label: '# of Medication Request',
              data: <?php echo json_encode($dataPointsBar_rx_totalrx_count, JSON_NUMERIC_CHECK); ?>,
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
              fill: false
            }]
          };

          var dataLine = {
            labels: ["Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
            datasets: [{
              label: '# of Pending Appointment',
              data: [1,1,1,1,1],
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
              fill: false
            }]
          };
          var dataDark = {
            labels: ["2013", "2014", "2014", "2015", "2016", "2017"],
            datasets: [{
              label: '# of Votes',
              data: [10, 19, 3, 5, 2, 3],
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
              fill: false
            }]
          };
          var multiLineData = {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
              label: 'Dataset 1',
              data: [12, 19, 3, 5, 2, 3],
              borderColor: [
                '#587ce4'
              ],
              borderWidth: 2,
              fill: false
            },
            {
              label: 'Dataset 2',
              data: [5, 23, 7, 12, 42, 23],
              borderColor: [
                '#ede190'
              ],
              borderWidth: 2,
              fill: false
            },
            {
              label: 'Dataset 3',
              data: [15, 10, 21, 32, 12, 33],
              borderColor: [
                '#f44252'
              ],
              borderWidth: 2,
              fill: false
            }
            ]
          };
          var options = {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            },
            legend: {
              display: false
            },
            elements: {
              point: {
                radius: 0
              }
            }

          };
          var optionsDark = {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                },
                gridLines: {
                  color: '#322f2f',
                  zeroLineColor: '#322f2f'
                }
              }],
              xAxes: [{
                ticks: {
                  beginAtZero: true
                },
                gridLines: {
                  color: '#322f2f',
                }
              }],
            },
            legend: {
              display: false
            },
            elements: {
              point: {
                radius: 0
              }
            }

          };
          var doughnutPieData = {
            datasets: [{
              data: [10, 40, 50],
              backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
              'Pink',
              'Blue',
              'Yellow',
            ]
          };
          var doughnutPieOptions = {
            responsive: true,
            animation: {
              animateScale: true,
              animateRotate: true
            }
          };
          var areaData = {
            labels: ["2013", "2014", "2015", "2016", "2017"],
            datasets: [{
              label: '# of Votes',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
              fill: true, // 3: no fill
            }]
          };

          var areaDataDark = {
            labels: ["2013", "2014", "2015", "2016", "2017"],
            datasets: [{
              label: '# of Votes',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
              fill: true, // 3: no fill
            }]
          };

          var areaOptions = {
            plugins: {
              filler: {
                propagate: true
              }
            }
          }

          var areaOptionsDark = {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                },
                gridLines: {
                  color: '#322f2f',
                  zeroLineColor: '#322f2f'
                }
              }],
              xAxes: [{
                ticks: {
                  beginAtZero: true
                },
                gridLines: {
                  color: '#322f2f',
                }
              }],
            },
            plugins: {
              filler: {
                propagate: true
              }
            }
          }

          var multiAreaData = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
              label: 'Facebook',
              data: [8, 11, 13, 15, 12, 13, 16, 15, 13, 19, 11, 14],
              borderColor: ['rgba(255, 99, 132, 0.5)'],
              backgroundColor: ['rgba(255, 99, 132, 0.5)'],
              borderWidth: 1,
              fill: true
            },
            {
              label: 'Twitter',
              data: [7, 17, 12, 16, 14, 18, 16, 12, 15, 11, 13, 9],
              borderColor: ['rgba(54, 162, 235, 0.5)'],
              backgroundColor: ['rgba(54, 162, 235, 0.5)'],
              borderWidth: 1,
              fill: true
            },
            {
              label: 'Linkedin',
              data: [6, 14, 16, 20, 12, 18, 15, 12, 17, 19, 15, 11],
              borderColor: ['rgba(255, 206, 86, 0.5)'],
              backgroundColor: ['rgba(255, 206, 86, 0.5)'],
              borderWidth: 1,
              fill: true
            }
            ]
          };

          var multiAreaOptions = {
            plugins: {
              filler: {
                propagate: true
              }
            },
            elements: {
              point: {
                radius: 0
              }
            },
            scales: {
              xAxes: [{
                gridLines: {
                  display: false
                }
              }],
              yAxes: [{
                gridLines: {
                  display: false
                }
              }]
            }
          }

          var scatterChartData = {
            datasets: [{
              label: 'First Dataset',
              data: [{
                x: -10,
                y: 0
              },
              {
                x: 0,
                y: 3
              },
              {
                x: -25,
                y: 5
              },
              {
                x: 40,
                y: 5
              }
              ],
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)'
              ],
              borderWidth: 1
            },
            {
              label: 'Second Dataset',
              data: [{
                x: 10,
                y: 5
              },
              {
                x: 20,
                y: -30
              },
              {
                x: -25,
                y: 15
              },
              {
                x: -10,
                y: 5
              }
              ],
              backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
              ],
              borderColor: [
                'rgba(54, 162, 235, 1)',
              ],
              borderWidth: 1
            }
            ]
          }

          var scatterChartDataDark = {
            datasets: [{
              label: 'First Dataset',
              data: [{
                x: -10,
                y: 0
              },
              {
                x: 0,
                y: 3
              },
              {
                x: -25,
                y: 5
              },
              {
                x: 40,
                y: 5
              }
              ],
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)'
              ],
              borderWidth: 1
            },
            {
              label: 'Second Dataset',
              data: [{
                x: 10,
                y: 5
              },
              {
                x: 20,
                y: -30
              },
              {
                x: -25,
                y: 15
              },
              {
                x: -10,
                y: 5
              }
              ],
              backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
              ],
              borderColor: [
                'rgba(54, 162, 235, 1)',
              ],
              borderWidth: 1
            }
            ]
          }

          var scatterChartOptions = {
            scales: {
              xAxes: [{
                type: 'linear',
                position: 'bottom'
              }]
            }
          }

          var scatterChartOptionsDark = {
            scales: {
              xAxes: [{
                type: 'linear',
                position: 'bottom',
                gridLines: {
                  color: '#322f2f',
                  zeroLineColor: '#322f2f'
                }
              }],
              yAxes: [{
                gridLines: {
                  color: '#322f2f',
                  zeroLineColor: '#322f2f'
                }
              }]
            }
          }
          // Get context with jQuery - using jQuery's .get() method.
          if ($("#barChart_pending").length) {
            var barChartCanvas = $("#barChart_pending").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_pending,
              options: options
            });
          }

          if ($("#barChart_completed").length) {
            var barChartCanvas = $("#barChart_completed").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_completed,
              options: options
            });
          }

          if ($("#barChart_rejected").length) {
            var barChartCanvas = $("#barChart_rejected").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_rejected,
              options: options
            });
          }

          if ($("#barChart_totalrx").length) {
            var barChartCanvas = $("#barChart_totalrx").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_totalrx,
              options: options
            });
          }

          if ($("#lineChart").length) {
            var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
            var lineChart = new Chart(lineChartCanvas, {
              type: 'line',
              data: dataLine,
              options: options
            });
          }

          if ($("#areaChart").length) {
            var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
            var areaChart = new Chart(areaChartCanvas, {
              type: 'line',
              data: dataLine,
              options: areaOptions
            });
          }


          if ($("#linechart-multi").length) {
            var multiLineCanvas = $("#linechart-multi").get(0).getContext("2d");
            var lineChart = new Chart(multiLineCanvas, {
              type: 'line',
              data: multiLineData,
              options: options
            });
          }

          if ($("#areachart-multi").length) {
            var multiAreaCanvas = $("#areachart-multi").get(0).getContext("2d");
            var multiAreaChart = new Chart(multiAreaCanvas, {
              type: 'line',
              data: multiAreaData,
              options: multiAreaOptions
            });
          }

          if ($("#doughnutChart").length) {
            var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");
            var doughnutChart = new Chart(doughnutChartCanvas, {
              type: 'doughnut',
              data: doughnutPieData,
              options: doughnutPieOptions
            });
          }

          if ($("#pieChart").length) {
            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
              type: 'pie',
              data: doughnutPieData,
              options: doughnutPieOptions
            });
          }


          if ($("#areaChartDark").length) {
            var areaChartCanvas = $("#areaChartDark").get(0).getContext("2d");
            var areaChart = new Chart(areaChartCanvas, {
              type: 'line',
              data: areaDataDark,
              options: areaOptionsDark
            });
          }

          if ($("#scatterChart").length) {
            var scatterChartCanvas = $("#scatterChart").get(0).getContext("2d");
            var scatterChart = new Chart(scatterChartCanvas, {
              type: 'scatter',
              data: scatterChartData,
              options: scatterChartOptions
            });
          }

          if ($("#scatterChartDark").length) {
            var scatterChartCanvas = $("#scatterChartDark").get(0).getContext("2d");
            var scatterChart = new Chart(scatterChartCanvas, {
              type: 'scatter',
              data: scatterChartDataDark,
              options: scatterChartOptionsDark
            });
          }

          if ($("#browserTrafficChart").length) {
            var doughnutChartCanvas = $("#browserTrafficChart").get(0).getContext("2d");
            var doughnutChart = new Chart(doughnutChartCanvas, {
              type: 'doughnut',
              data: browserTrafficData,
              options: doughnutPieOptions
            });
          }
        });

        </script>
