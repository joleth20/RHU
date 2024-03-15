<?php
$user_type = $_SESSION["user_type"];
$user_id = $_SESSION["user_id"];
$doctor = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
if ($user_type != "1") {
  echo "<script>alert('Action Not Allowed')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";

}
include 'pages/view/config/dbconfig.php';

// DATE SORTER
function sortFunction( $a, $b ) {
    return strtotime($a["date"]) - strtotime($b["date"]);
}



$sql_patient = "SELECT
    DATE_FORMAT(date_registered, '%b %Y') AS registered_month,
	user_type,
	verified,
    COUNT(user_id) AS count
  FROM user_details WHERE user_type = '4' and verified = '1'
  GROUP BY registered_month";

$result_patient = mysqli_query($conn, $sql_patient);
$bar_patient=[];
if($result_patient){
  while($row_patient=mysqli_fetch_assoc($result_patient)){

      $bar_patient[]=array("date"=>$row_patient["registered_month"],"count"=>$row_patient["count"]);
  }

}

usort($bar_patient, "sortFunction");

foreach ($bar_patient as $key => $value) {
   $dataPointsBar_patient_label[] =  $value["date"];
   $dataPointsBar_patient_count[] = $value["count"];
}

$sql_doctor = "SELECT
    DATE_FORMAT(date_registered, '%b %Y') AS registered_month,	user_type, verified,
    COUNT(user_id) AS count
  FROM user_details WHERE user_type = '2' and verified = '1'
  GROUP BY registered_month";

$result_doctor = mysqli_query($conn, $sql_doctor);
$bar_doctor=[];
if($result_doctor){
  while($row_doctor=mysqli_fetch_assoc($result_doctor)){
     
      $bar_doctor[]=array("date"=>$row_doctor["registered_month"],"count"=>$row_doctor["count"]);
  }

}
usort($bar_doctor, "sortFunction");

foreach ($bar_doctor as $key => $value) {
   $dataPointsBar_doctor_label[] =  $value["date"];
   $dataPointsBar_doctor_count[] = $value["count"];
}


$sql_consultation = "SELECT
  DATE_FORMAT(req_date, '%b %Y') AS req_month,
  COUNT(appt_id) AS count
FROM appointment_details
GROUP BY req_month";

$result_consultation = mysqli_query($conn, $sql_consultation);
$bar_consultation=[];
if($result_consultation){
  while($row_consultation=mysqli_fetch_assoc($result_consultation)){
      $bar_consultation[]=array("date"=>$row_consultation["req_month"],"count"=>$row_consultation["count"]);
  }

}
usort($bar_consultation, "sortFunction");

foreach ($bar_consultation as $key => $value) {
   $dataPointsBar_consultation_label[] =  $value["date"];
   $dataPointsBar_consultation_count[] = $value["count"];
}

$sql_medication = "SELECT
  DATE_FORMAT(req_date, '%b %Y') AS req_month,
  COUNT(rx_id) AS count
FROM medication_refills
GROUP BY req_month";

$result_medication = mysqli_query($conn, $sql_medication);
$bar_medication=[];
if($result_medication){
  while($row_medication=mysqli_fetch_assoc($result_medication)){
      $bar_medication[]=array("date"=>$row_medication["req_month"],"count"=>$row_medication["count"]);
  }

}
usort($bar_medication, "sortFunction");

foreach ($bar_medication as $key => $value) {
   $dataPointsBar_medication_label[] =  $value["date"];
   $dataPointsBar_medication_count[] = $value["count"];
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
        <h4 class="card-title">Total Number of Patients</h4>
        <!-- <canvas id="lineChart" style="height:250px"></canvas> -->
        <canvas id="barChart_patient" style="height:230px"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Total Number of Doctors</h4>
        <canvas id="barChart_doctor" style="height:230px"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Total Number of Consultation</h4>
        <canvas id="barChart_consultation" style="height:230px"></canvas>
      </div>
    </div>
  </div>
    <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Total Number of Medication</h4>
        <canvas id="barChart_medication" style="height:230px"></canvas>
      </div>
    </div>
  </div>
</div>

        <script>
        $(function () {
          /* ChartJS
           * -------
           * Data and config for chartjs
           */
          'use strict';
          var dataBar_patient = {
            labels: <?php echo json_encode($dataPointsBar_patient_label, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
              label: '# of Patients',
              data: <?php echo json_encode($dataPointsBar_patient_count, JSON_NUMERIC_CHECK); ?>,
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

          var dataBar_doctor = {
            labels: <?php echo json_encode($dataPointsBar_doctor_label, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
              label: '# of Doctors',
              data: <?php echo json_encode($dataPointsBar_doctor_count, JSON_NUMERIC_CHECK); ?>,
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

          var dataBar_consultation = {
            labels: <?php echo json_encode($dataPointsBar_consultation_label, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
              label: '# of Consultation',
              data: <?php echo json_encode($dataPointsBar_consultation_count, JSON_NUMERIC_CHECK); ?>,
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
          
          
          var dataBar_medication = {
            labels: <?php echo json_encode($dataPointsBar_medication_label, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
              label: '# of Consultation',
              data: <?php echo json_encode($dataPointsBar_medication_count, JSON_NUMERIC_CHECK); ?>,
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
          if ($("#barChart_patient").length) {
            var barChartCanvas = $("#barChart_patient").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_patient,
              options: options
            });
          }

          if ($("#barChart_doctor").length) {
            var barChartCanvas = $("#barChart_doctor").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_doctor,
              options: options
            });
          }

          if ($("#barChart_consultation").length) {
            var barChartCanvas = $("#barChart_consultation").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_consultation,
              options: options
            });
          }
          
          if ($("#barChart_medication").length) {
            var barChartCanvas = $("#barChart_medication").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_medication,
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
