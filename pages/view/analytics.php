<?php

$user_type = $_SESSION["user_type"];

$user_id = $_SESSION["user_id"];

$doctor = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];

if ($user_type != "1") {

  echo "<script>alert('Action Not Allowed!')</script>";

  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";



}

include 'pages/view/config/dbconfig.php';

$sql = "SELECT

    COUNT(user_id) AS count

  FROM user_details WHERE user_type = '4' and verified = '1' and DATE_FORMAT(date_registered, '%m %Y') = DATE_FORMAT(CURDATE(),'%m %Y')";



$result_curr = mysqli_query($conn, $sql);

$user_details = mysqli_fetch_assoc($result_curr);

$new_patient_curr = 0;

if($result_curr){

    $new_patient_curr = $user_details["count"];

}

$services = "";

if (isset($_POST["services"])) {

  $services = $_POST["services"];
  
    $sql_new_patient = "SELECT

      DATE_FORMAT(date_registered, '%b %Y') AS reg_month,

      COUNT(user_id) AS count

    FROM user_details WHERE user_type = '4' and verified = '1' and date_registered > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY reg_month";

  $sql_patient = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
	  services,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE services = '$services' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";



  $sql_consultation = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
	  services,
	  status,
      COUNT(appt_id) AS count

    FROM appointment_details WHERE services = '$services' and status = 'Completed' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";
    
 $sql_pending_consultation = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
	  services,
	  status,
      COUNT(appt_id) AS count

    FROM appointment_details WHERE services = '$services' and status = 'Pending' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";
    
 $sql_rejected_consultation = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
	  services,
	  status,
      COUNT(appt_id) AS count

    FROM appointment_details WHERE services = '$services' and status = 'Rejected' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";
    
 $sql_approved_consultation = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
	  services,
	  status,
      COUNT(appt_id) AS count

    FROM appointment_details WHERE services = '$services' and status = 'Approved' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";


  //PIECHART SERVICES CURRENT MONTH
  $sql_concern_curr_month = "SELECT
  
      concern AS concern_label,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE services = '$services' AND DATE_FORMAT(req_date, '%m %Y') = DATE_FORMAT(CURDATE(),'%m %Y')

    GROUP BY concern_label";
    
  //PIECHART SERVICES YTD
  $sql_concern = "SELECT

      concern AS concern_label,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE services = '$services'

    GROUP BY concern_label";



}else{
    
    $sql_new_patient = "SELECT
    
      DATE_FORMAT(date_registered, '%b %Y') AS reg_month,
    
      COUNT(user_id) AS count
    
    FROM user_details WHERE user_type = '4' and verified = '1' and date_registered > DATE_SUB(now(), INTERVAL 3 MONTH)
    
    GROUP BY reg_month";

  $sql_patient = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";



  $sql_consultation = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
	  status,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE status = 'Completed' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";
    
  $sql_pending_consultation = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
	  status,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE status = 'Pending' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";
    
  $sql_rejected_consultation = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
	  status,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE status = 'Rejected' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";
    
  $sql_approved_consultation = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
	  status,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE status = 'Approved' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";


  //PIECHART SERVICES CURRENT MONTH
  $sql_concern_curr_month = "SELECT
  
      services AS concern_label,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE DATE_FORMAT(req_date, '%m %Y') = DATE_FORMAT(CURDATE(),'%m %Y')

    GROUP BY concern_label";
  
  //PIECHART SERVICES YTD
  $sql_concern = "SELECT

      services AS concern_label,

      COUNT(appt_id) AS count

    FROM appointment_details

    GROUP BY concern_label";

}

// DATE SORTER
function sortFunction( $a, $b ) {
    return strtotime($a["date"]) - strtotime($b["date"]);
}

//BARCHART PATIENT

$result_new_patient = mysqli_query($conn, $sql_new_patient);

$chartBar_new_patient=[];

if($result_new_patient){

  while($row_new_patient=mysqli_fetch_assoc($result_new_patient)){
     $chartBar_new_patient[] = array("date" => $row_new_patient["reg_month"], "count" =>  $row_new_patient["count"]);

  }

}


usort($chartBar_new_patient, "sortFunction");

foreach ($chartBar_new_patient as $key => $value) {
   $dataPointsBar_new_patient_label[] =  $value["date"];
   $dataPointsBar_new_patient_count[] = $value["count"];
}

//BARCHART PATIENT

$result_patient = mysqli_query($conn, $sql_patient);

$chartBar_patient=[];

if($result_patient){

  while($row_patient=mysqli_fetch_assoc($result_patient)){
     $chartBar_patient[] = array("date" => $row_patient["req_month"], "count" =>  $row_patient["count"]);

  }

}


usort($chartBar_patient, "sortFunction");

foreach ($chartBar_patient as $key => $value) {
   $dataPointsBar_patient_label[] =  $value["date"];
   $dataPointsBar_patient_count[] = $value["count"];
}


//BARCHART COMPLETED CONSULTATION

$result_consultation = mysqli_query($conn, $sql_consultation);

$chartBar_consultation=[];

if($result_consultation){

  while($row_consultation=mysqli_fetch_assoc($result_consultation)){
     $chartBar_consultation[] = array("date" => $row_consultation["req_month"], "count" =>  $row_consultation["count"]);

  }

}


usort($chartBar_consultation, "sortFunction");

foreach ($chartBar_consultation as $key => $value) {
   $dataPointsBar_consultation_label[] =  $value["date"];
   $dataPointsBar_consultation_count[] = $value["count"];
}

//BARCHART PENDING CONSULTATION

$result_pending_consultation = mysqli_query($conn, $sql_pending_consultation);

$chartBar_pending_consultation=[];

if($result_pending_consultation){

  while($row_pending_consultation=mysqli_fetch_assoc($result_pending_consultation)){
     $chartBar_pending_consultation[] = array("date" => $row_pending_consultation["req_month"], "count" =>  $row_pending_consultation["count"]);

  }

}


usort($chartBar_pending_consultation, "sortFunction");

foreach ($chartBar_pending_consultation as $key => $value) {
   $dataPointsBar_pending_consultation_label[] =  $value["date"];
   $dataPointsBar_pending_consultation_count[] = $value["count"];
}

//BARCHART REJECTED CONSULTATION

$result_rejected_consultation = mysqli_query($conn, $sql_rejected_consultation);

$chartBar_rejected_consultation=[];

if($result_rejected_consultation){

  while($row_rejected_consultation=mysqli_fetch_assoc($result_rejected_consultation)){
     $chartBar_rejected_consultation[] = array("date" => $row_rejected_consultation["req_month"], "count" =>  $row_rejected_consultation["count"]);

  }

}


usort($chartBar_rejected_consultation, "sortFunction");

foreach ($chartBar_rejected_consultation as $key => $value) {
   $dataPointsBar_rejected_consultation_label[] =  $value["date"];
   $dataPointsBar_rejected_consultation_count[] = $value["count"];
}


//BARCHART APPROVED CONSULTATION

$result_approved_consultation = mysqli_query($conn, $sql_approved_consultation);

$chartBar_approved_consultation=[];

if($result_approved_consultation){

  while($row_approved_consultation=mysqli_fetch_assoc($result_approved_consultation)){
     $chartBar_approved_consultation[] = array("date" => $row_approved_consultation["req_month"], "count" =>  $row_approved_consultation["count"]);

  }

}


usort($chartBar_approved_consultation, "sortFunction");

foreach ($chartBar_approved_consultation as $key => $value) {
   $dataPointsBar_approved_consultation_label[] =  $value["date"];
   $dataPointsBar_approved_consultation_count[] = $value["count"];
}


//PIECHART SERVICES/CONCERNS CURRENT MONTH

$result_concern_curr_month = mysqli_query($conn, $sql_concern_curr_month);

$pieChart_concern_curr_month_label=[];

$pieChart_concern_curr_month_count=[];

if($result_concern_curr_month){

  while($row_concern_curr_month = mysqli_fetch_array($result_concern_curr_month)) {

   $pieChart_concern_curr_month_label[] = $row_concern_curr_month['concern_label'];

   $pieChart_concern_curr_month_count[] = $row_concern_curr_month['count'];

  }

}



$dataPointsPie_concern_curr_month_label = $pieChart_concern_curr_month_label;

$dataPointsPie_concern_curr_month_count = $pieChart_concern_curr_month_count;


//PIECHART SERVICES/CONCERNS YTD

$result_concern = mysqli_query($conn, $sql_concern);

$pieChart_concern_label=[];

$pieChart_concern_count=[];

if($result_concern){

  while($row_concern = mysqli_fetch_array($result_concern)) {

   $pieChart_concern_label[] = $row_concern['concern_label'];

   $pieChart_concern_count[] = $row_concern['count'];

  }

}



$dataPointsPie_concern_label = $pieChart_concern_label;

$dataPointsPie_concern_count = $pieChart_concern_count;





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

  <form  action="../RHU/?p=analytics" method="POST">

    <div class="input-group">

        <i class="input-group-text border-0 mdi mdi-filter"></i>

      <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="services" onchange="this.form.submit();">

        <option disabled selected>FILTER BY SERVICES...</option>

        <?php

          include 'services.php';

          foreach ($services_array as $services_key => $services_value) {

            if ($services == $services_key) {

              $selected_services = "selected";

              echo '<option '.$selected_services.' value="'.$services_key.'" style="color:black" id="'.$services_key.'">'.$services_key.'</option>';

            }else{

              echo '<option value="'.$services_key.'" style="color:black" id="'.$services_key.'">'.$services_key.'</option>';

            }

          }

        ?>

      </select>
    <label><a class="form-control bg-transparent border-0" href="../RHU/?p=analytics">Clear filter</a></label>
    </div>

  </form>

</div>



<div class="row">

    <div class="col-lg-6 grid-margin stretch-card">

    <div class="card">

      <div class="card-body">

        <h4 class="card-title">Total Number of Pending Consultation by Month</h4>

        <canvas id="barChart_pending_consultation" style="height:250px"></canvas>

      </div>

    </div>

  </div>
  
  <div class="col-lg-6 grid-margin stretch-card">

    <div class="card">

      <div class="card-body">

        <h4 class="card-title">Total Number of Approved Consultation by Month</h4>

        <canvas id="barChart_approved_consultation" style="height:230px"></canvas>

      </div>

    </div>

  </div>

</div>

<div class="row">
 
  
  <div class="col-lg-6 grid-margin stretch-card">

    <div class="card">

      <div class="card-body">

        <h4 class="card-title">Total Number of Rejected Consultation by Month</h4>

        <canvas id="barChart_rejected_consultation" style="height:250px"></canvas>

      </div>

    </div>

  </div>
  
  <div class="col-lg-6 grid-margin stretch-card">

    <div class="card">

      <div class="card-body">

        <h4 class="card-title">Total Number of Completed Consultation by Month</h4>

        <canvas id="barChart_consultation" style="height:230px"></canvas>

      </div>

    </div>

  </div>
  

</div>



<div class="row">

  <div class="col-lg-6 grid-margin stretch-card">

    <div class="card">

      <div class="card-body">

        <h4 class="card-title">Most Demand Concerns by Services for the month of <?php echo date('F Y');?></h4>

        <canvas id="pieChart_curr_month" style="height:250px"></canvas>

      </div>

    </div>

  </div>
  
  <div class="col-lg-6 grid-margin stretch-card">

    <div class="card">

      <div class="card-body">

        <h4 class="card-title">Most Demand Concerns by Services YTD</h4>

        <canvas id="pieChart" style="height:250px"></canvas>

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
          
          var dataBar_new_patient = {

            labels: <?php echo json_encode($dataPointsBar_new_patient_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Patients',

              data: <?php echo json_encode($dataPointsBar_new_patient_count, JSON_NUMERIC_CHECK); ?>,

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
          
          var dataBar_pending_consultation = {

            labels: <?php echo json_encode($dataPointsBar_pending_consultation_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Consultation',

              data: <?php echo json_encode($dataPointsBar_pending_consultation_count, JSON_NUMERIC_CHECK); ?>,

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
          
          var dataBar_rejected_consultation = {

            labels: <?php echo json_encode($dataPointsBar_rejected_consultation_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Consultation',

              data: <?php echo json_encode($dataPointsBar_rejected_consultation_count, JSON_NUMERIC_CHECK); ?>,

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
          
          
          var dataBar_approved_consultation = {

            labels: <?php echo json_encode($dataPointsBar_approved_consultation_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Consultation',

              data: <?php echo json_encode($dataPointsBar_approved_consultation_count, JSON_NUMERIC_CHECK); ?>,

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
          
          var pieChart_services_curr_month = {

            datasets: [{

              data: <?php echo json_encode($dataPointsPie_concern_curr_month_count, JSON_NUMERIC_CHECK); ?>,

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

            labels: <?php echo json_encode($dataPointsPie_concern_curr_month_label, JSON_NUMERIC_CHECK); ?>,

          };

          var pieChart_services = {

            datasets: [{

              data: <?php echo json_encode($dataPointsPie_concern_count, JSON_NUMERIC_CHECK); ?>,

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

            labels: <?php echo json_encode($dataPointsPie_concern_label, JSON_NUMERIC_CHECK); ?>,

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
          
          if ($("#barChart_new_patient").length) {

            var barChartCanvas = $("#barChart_new_patient").get(0).getContext("2d");

            // This will get the first returned node in the jQuery collection.

            var barChart = new Chart(barChartCanvas, {

              type: 'bar',

              data: dataBar_new_patient,

              options: options

            });

          }

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
          
          if ($("#barChart_pending_consultation").length) {

            var barChartCanvas = $("#barChart_pending_consultation").get(0).getContext("2d");

            // This will get the first returned node in the jQuery collection.

            var barChart = new Chart(barChartCanvas, {

              type: 'bar',

              data: dataBar_pending_consultation,

              options: options

            });

          }
          
          if ($("#barChart_rejected_consultation").length) {

            var barChartCanvas = $("#barChart_rejected_consultation").get(0).getContext("2d");

            // This will get the first returned node in the jQuery collection.

            var barChart = new Chart(barChartCanvas, {

              type: 'bar',

              data: dataBar_rejected_consultation,

              options: options

            });

          }
          
          if ($("#barChart_approved_consultation").length) {

            var barChartCanvas = $("#barChart_approved_consultation").get(0).getContext("2d");

            // This will get the first returned node in the jQuery collection.

            var barChart = new Chart(barChartCanvas, {

              type: 'bar',

              data: dataBar_approved_consultation,

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
          
          
          if ($("#pieChart_curr_month").length) {

            var pieChartCanvas = $("#pieChart_curr_month").get(0).getContext("2d");

            var pieChart = new Chart(pieChartCanvas, {

              type: 'pie',

              data: pieChart_services_curr_month,

              options: doughnutPieOptions

            });

          }


          if ($("#pieChart").length) {

            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");

            var pieChart = new Chart(pieChartCanvas, {

              type: 'pie',

              data: pieChart_services,

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

