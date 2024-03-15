<?php
$user_type = $_SESSION["user_type"];
$user_id = $_SESSION["user_id"];
$doctor = $_SESSION["user_id"];
if ($user_type == "1") {
  echo "<script>alert('You are not allowed to access this page.')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard_a';</script>";

}
include 'pages/view/config/dbconfig.php';
if ($user_type == "2") {
  $sql = "SELECT
    DATE_FORMAT(req_date, '%b %Y') AS req_month,	
    doctor,	
    status,
    COUNT(appt_id) AS count
  FROM appointment_details WHERE doctor = '$doctor' and status = 'Pending'
  GROUP BY req_month";
}elseif ($user_type == "3") {
  $sql = "SELECT
    DATE_FORMAT(req_date, '%b %Y') AS req_month,	
    status,
    COUNT(appt_id) AS count
  FROM appointment_details WHERE status = 'Pending'
  GROUP BY req_month";
}else {
  $sql = "SELECT
    DATE_FORMAT(req_date, '%b %Y') AS req_month,	
    user_id,	
    status,
    COUNT(appt_id) AS count
  FROM appointment_details WHERE user_id = '$user_id' and status = 'Pending'
  GROUP BY req_month";
}

// DATE SORTER
function sortFunction( $a, $b ) {
    return strtotime($a["date"]) - strtotime($b["date"]);
}


$result = mysqli_query($conn, $sql);
$line_chart=[];
if($result){
  while($row=mysqli_fetch_assoc($result)){
       $line_chart[] = array("date" => $row["req_month"], "count" =>  $row["count"]);
  }
}
usort($line_chart, "sortFunction");
foreach ($line_chart as $key => $value) {
   $dataPointsLine_label[] =  $value["date"];
   $dataPointsLine_count[] = $value["count"];
}



if ($user_type == 2) {
  $sql_bar = "SELECT
    DATE_FORMAT(req_date, '%b %Y') AS req_month,		doctor,	status,
    COUNT(appt_id) AS count
  FROM appointment_details WHERE doctor = '$doctor' and status = 'Completed'
  GROUP BY req_month";
}elseif ($user_type == 3) {
  $sql_bar = "SELECT
    DATE_FORMAT(req_date, '%b %Y') AS req_month,	status,
    COUNT(appt_id) AS count
  FROM appointment_details WHERE status = 'Completed'
  GROUP BY req_month";
}else{
$sql_bar = "SELECT
  DATE_FORMAT(req_date, '%b %Y') AS req_month,  user_id,  status,
  COUNT(appt_id) AS count
FROM appointment_details WHERE user_id = '$user_id' and status = 'Completed'
GROUP BY req_month";
}
$result_bar = mysqli_query($conn, $sql_bar);
$bar_chart = [];
if($result_bar){
  while($row_bar=mysqli_fetch_assoc($result_bar)){
    $bar_chart[] = array("date" => $row_bar["req_month"], "count" =>  $row_bar["count"]);
  }
}

usort($bar_chart, "sortFunction");
foreach ($bar_chart as $key => $value) {
   $dataPointsBar_label[] =  $value["date"];
   $dataPointsBar_count[] = $value["count"];
}

?>

<div class="page-header">
  <h3 class="page-title"> Dashboard </h3>
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
        <h4 class="card-title">Pending Appointment</h4>
        <!-- <canvas id="lineChart" style="height:250px"></canvas> -->
        <canvas id="areaChart" style="height:250px"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Completed Appointment</h4>
        <canvas id="barChart" style="height:230px"></canvas>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        <h4 class="card-title"><?php echo ($user_type == "3")? "Pending":"Approved"; ?> Patient's Appointment (<a href="../RHU/?p=appt">View All</a>)  </h4>
        <!-- <canvas id="areaChart" style="height:250px"></canvas> -->
        <div class="table-responsive">
        <table class="table table-hover" id="rhu_table">
          <thead>
            <tr>
              <th>Appt ID</th>
              <th>Date Booked</th>
              <th>Time Booked</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($user_type == 2) {
              $sql2 = "SELECT * FROM appointment_details WHERE doctor = '$user_id' and status = 'Approved' ORDER BY req_date";
            }elseif ($user_type == 3) {
              $sql2 = "SELECT * FROM appointment_details WHERE status = 'Pending' ORDER BY req_date";
            }else{
              $sql2 = "SELECT * FROM appointment_details WHERE user_id = '$user_id' and status = 'Approved' ORDER BY req_date";
            }
            $result2 = mysqli_query($conn, $sql2);
              while($row=mysqli_fetch_assoc($result2)){
                if ($row["status"] == "Pending") {
                  $status = "warning";
                }elseif ($row["status"] == "Completed") {
                  $status = "info";
                }elseif ($row["status"] == "Approved") {
                  $status = "success";
                }else{
                  $status = "danger";
                }
                echo '<tr><td>'.$row["appt_id"].'</td>';
                echo '<td>'.$row["req_date"].'</td>';
                echo '<td>'.$row["req_time"].'</div></td>';
                echo '<td><label class="badge badge-'.$status.'">'.$row["status"].'</td>';
              }
             ?>

          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        <h4 class="card-title">Pending Medication Refill Request (<a href="../RHU/?p=rx">View All</a>)  </h4>
        <!-- <canvas id="areaChart" style="height:250px"></canvas> -->
        <div class="table-responsive">
        <table class="table table-hover" id="rhu_table1">
          <thead>
            <tr>
              <th>Appt ID</th>
              <th>Date Booked</th>
              <th>Time Booked</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($user_type == 2) {
              $sql2 = "SELECT * FROM medication_refills WHERE doctor = '$user_id' and status = 'Pending' ORDER BY req_date";
            }elseif ($user_type == 3) {
              $sql2 = "SELECT * FROM medication_refills WHERE status = 'Pending' ORDER BY req_date";
            }else{
              $sql2 = "SELECT * FROM medication_refills WHERE user_id = '$user_id' and status = 'Pending' ORDER BY req_date";
            }
            $result2 = mysqli_query($conn, $sql2);
              while($row=mysqli_fetch_assoc($result2)){
                if ($row["status"] == "Pending") {
                  $status = "warning";
                }elseif ($row["status"] == "Completed") {
                  $status = "info";
                }elseif ($row["status"] == "Approved") {
                  $status = "success";
                }else{
                  $status = "danger";
                }
                echo '<tr><td>'.$row["rx_id"].'</td>';
                echo '<td>'.$row["req_date"].'</td>';
                echo '<td>'.$row["req_time"].'</div></td>';
                echo '<td><label class="badge badge-'.$status.'">'.$row["status"].'</td>';
              }
             ?>

          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>

</div>
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>
        <script src="assets/vendors/chart.js/Chart.min.js"></script>
        <!-- <script src="assets/js/chart.js"></script> -->
        <script>
        $(function () {
          /* ChartJS
           * -------
           * Data and config for chartjs
           */
          'use strict';
          var dataBar = {
            labels: <?php echo json_encode($dataPointsBar_label, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
              label: '# of Completed Appointment',
              data: <?php echo json_encode($dataPointsBar_count, JSON_NUMERIC_CHECK); ?>,
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
            labels: <?php echo json_encode($dataPointsLine_label, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
              label: '# of Pending Appointment',
              data: <?php echo json_encode($dataPointsLine_count, JSON_NUMERIC_CHECK); ?>,
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
          if ($("#barChart").length) {
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar,
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
