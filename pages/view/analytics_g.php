<?php
$user_type = $_SESSION["user_type"];
$user_id = $_SESSION["user_id"];
$doctor = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
if ($user_type != "1") {
  echo "<script>alert('Action Not Allowed!')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";

}
include 'pages/view/config/dbconfig.php';



if (isset($_POST["search_by"])) {
  $search_by = $_POST["search_by"];
  
    $sql_age_curr = "SELECT
            CASE
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 0 AND 18 THEN '0-18'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 19 AND 30 THEN '19-30'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 31 AND 40 THEN '31-40'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 41 AND 50 THEN '41-50'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 51 AND 60 THEN '51-60'
                ELSE '61+'
            END AS age_range,
            COUNT(*) AS count
        FROM appointment_details WHERE gender = '$search_by' and DATE_FORMAT(req_date, '%b %Y') = DATE_FORMAT(CURDATE(), '%b %Y')
        GROUP BY age_range
        ORDER BY FIELD(age_range, '0-18', '19-30', '31-40', '41-50', '51-60', '61+')";


    $sql_age_ytd = "SELECT
            CASE
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 0 AND 18 THEN '0-18'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 19 AND 30 THEN '19-30'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 31 AND 40 THEN '31-40'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 41 AND 50 THEN '41-50'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 51 AND 60 THEN '51-60'
                ELSE '61+'
            END AS age_range,
            COUNT(*) AS count
        FROM appointment_details WHERE gender = '$search_by'
        GROUP BY age_range
        ORDER BY FIELD(age_range, '0-18', '19-30', '31-40', '41-50', '51-60', '61+')";
        
   //BARGRAPH GENDER CONSULTATION CURRENT MONTH
    $sql_gender_male_curr = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      gender,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE gender = '$search_by' and DATE_FORMAT(req_date, '%m %Y') = DATE_FORMAT(CURDATE(),'%m %Y')
      GROUP BY req_month";
    
    //BARGRAPH GENDER CONSULTATION YTD
    $sql_gender_male_ytd = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      gender,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE gender = '$search_by' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
      GROUP BY req_month";
    
    //BARGRAPH GENDER PENDING CONSULTATION YTD
    $sql_gender_pending_ytd = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      gender,
      status,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE status = 'Pending' and gender = '$search_by' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
      GROUP BY req_month";
      
    //BARGRAPH GENDER APPROVED CONSULTATION YTD
    $sql_gender_approved_ytd = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      gender,
      status,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE status = 'Approved' and gender = '$search_by' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
      GROUP BY req_month";
    
    //BARGRAPH GENDER REJECTED CONSULTATION YTD
    $sql_gender_rejected_ytd = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      gender,
      status,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE status = 'Rejected' and gender = '$search_by' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
      GROUP BY req_month";
      
    //BARGRAPH GENDER COMPLETED CONSULTATION YTD
    $sql_gender_completed_ytd = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      gender,
      status,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE status = 'Completed' and gender = '$search_by' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
      GROUP BY req_month";
      
    

}else{
    
    $sql_age_curr = "SELECT
            CASE
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 0 AND 18 THEN '0-18'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 19 AND 30 THEN '19-30'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 31 AND 40 THEN '31-40'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 41 AND 50 THEN '41-50'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 51 AND 60 THEN '51-60'
                ELSE '61+'
            END AS age_range,
            COUNT(*) AS count
        FROM appointment_details WHERE DATE_FORMAT(req_date, '%b %Y') = DATE_FORMAT(CURDATE(), '%b %Y')
        GROUP BY age_range
        ORDER BY FIELD(age_range, '0-18', '19-30', '31-40', '41-50', '51-60', '61+')";

    
    $sql_age_ytd = "SELECT
            CASE
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 0 AND 18 THEN '0-18'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 19 AND 30 THEN '19-30'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 31 AND 40 THEN '31-40'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 41 AND 50 THEN '41-50'
                WHEN TIMESTAMPDIFF(YEAR, bday, CURDATE()) BETWEEN 51 AND 60 THEN '51-60'
                ELSE '61+'
            END AS age_range,
            COUNT(*) AS count
        FROM appointment_details
        GROUP BY age_range
        ORDER BY FIELD(age_range, '0-18', '19-30', '31-40', '41-50', '51-60', '61+')";
        
        
    //BARGRAPH GENDER CURRENT MONTH
    $sql_gender_male_curr = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE DATE_FORMAT(req_date, '%m %Y') = DATE_FORMAT(CURDATE(),'%m %Y')
      GROUP BY req_month";
    
    //BARGRAPH GENDER YTD
    $sql_gender_male_ytd = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
      GROUP BY req_month";
    
    //BARGRAPH GENDER PENDING CONSULTATION YTD
    $sql_gender_pending_ytd = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      status,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE status = 'Pending' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
      GROUP BY req_month";
      
    //BARGRAPH GENDER APPROVED CONSULTATION YTD
    $sql_gender_approved_ytd = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      status,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE status = 'Approved' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
      GROUP BY req_month";
    
    //BARGRAPH GENDER REJECTED CONSULTATION YTD
    $sql_gender_rejected_ytd = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      status,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE status = 'Rejected' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
      GROUP BY req_month";
      
    //BARGRAPH GENDER COMPLETED CONSULTATION YTD
    $sql_gender_completed_ytd = "SELECT
      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      status,
      COUNT(appt_id) AS count
      FROM appointment_details WHERE status = 'Completed' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)
      GROUP BY req_month";
}

//PIECHART age current month
$result_age_curr = mysqli_query($conn, $sql_age_curr);
while($row_age_curr = mysqli_fetch_array($result_age_curr)) {
    $pieChart_age_curr_label[] = "Age ".$row_age_curr['age_range'];
    $pieChart_age_curr_count[] = $row_age_curr['count'];
}
$dataPointsPie_age_curr_label = $pieChart_age_curr_label;
$dataPointsPie_age_curr_count = $pieChart_age_curr_count;


//PIECHART age current ytd
$result_age_ytd = mysqli_query($conn, $sql_age_ytd);
while($row_age_ytd = mysqli_fetch_array($result_age_ytd)) {
    $pieChart_age_ytd_label[] = "Age ".$row_age_ytd['age_range'];
    $pieChart_age_ytd_count[] = $row_age_ytd['count'];
}
$dataPointsPie_age_ytd_label = $pieChart_age_ytd_label;
$dataPointsPie_age_ytd_count = $pieChart_age_ytd_count;


// DATE SORTER
function sortFunction( $a, $b ) {
    return strtotime($a["date"]) - strtotime($b["date"]);
}


//BARGRAPH GENDER CONSULTATION CURRENT MONTH
$result_gender_male_curr = mysqli_query($conn, $sql_gender_male_curr);
$chartBar_gender_male_curr=[];
if($result_gender_male_curr){
    while($row_gender_male_curr=mysqli_fetch_assoc($result_gender_male_curr)){
     $chartBar_gender_male_curr[] = array("date" => $row_gender_male_curr["req_month"], "count" =>  $row_gender_male_curr["count"]);
    }
}
usort($chartBar_gender_male_curr, "sortFunction");
foreach ($chartBar_gender_male_curr as $key => $value) {
   $dataPointsBar_gender_male_curr_label[] =  $value["date"];
   $dataPointsBar_gender_male_curr_count[] = $value["count"];
}

//BARGRAPH GENDER CONSULTATION YTD
$result_gender_male_ytd = mysqli_query($conn, $sql_gender_male_ytd);
$chartBar_gender_male_ytd=[];
if($result_gender_male_ytd){
    while($row_gender_male_ytd=mysqli_fetch_assoc($result_gender_male_ytd)){
     $chartBar_gender_male_ytd[] = array("date" => $row_gender_male_ytd["req_month"], "count" =>  $row_gender_male_ytd["count"]);
    }
}
usort($chartBar_gender_male_ytd, "sortFunction");
foreach ($chartBar_gender_male_ytd as $key => $value) {
   $dataPointsBar_gender_male_ytd_label[] =  $value["date"];
   $dataPointsBar_gender_male_ytd_count[] = $value["count"];
}


//BARGRAPH GENDER PENDING CONSULTATION YTD
$result_gender_pending_ytd = mysqli_query($conn, $sql_gender_pending_ytd);
$chartBar_gender_pending_ytd=[];
if($result_gender_pending_ytd){
    while($row_gender_pending_ytd=mysqli_fetch_assoc($result_gender_pending_ytd)){
     $chartBar_gender_pending_ytd[] = array("date" => $row_gender_pending_ytd["req_month"], "count" =>  $row_gender_pending_ytd["count"]);
    }
}
usort($chartBar_gender_pending_ytd, "sortFunction");
foreach ($chartBar_gender_pending_ytd as $key => $value) {
   $dataPointsBar_gender_pending_ytd_label[] =  $value["date"];
   $dataPointsBar_gender_pending_ytd_count[] = $value["count"];
}

//BARGRAPH GENDER APPROVED CONSULTATION YTD
$result_gender_approved_ytd = mysqli_query($conn, $sql_gender_approved_ytd);
$chartBar_gender_approved_ytd=[];
if($result_gender_approved_ytd){
    while($row_gender_approved_ytd=mysqli_fetch_assoc($result_gender_approved_ytd)){
     $chartBar_gender_approved_ytd[] = array("date" => $row_gender_approved_ytd["req_month"], "count" =>  $row_gender_approved_ytd["count"]);
    }
}
usort($chartBar_gender_approved_ytd, "sortFunction");
foreach ($chartBar_gender_approved_ytd as $key => $value) {
   $dataPointsBar_gender_approved_ytd_label[] =  $value["date"];
   $dataPointsBar_gender_approved_ytd_count[] = $value["count"];
}

//BARGRAPH GENDER REJECTED CONSULTATION YTD
$result_gender_rejected_ytd = mysqli_query($conn, $sql_gender_rejected_ytd);
$chartBar_gender_rejected_ytd=[];
if($result_gender_rejected_ytd){
    while($row_gender_rejected_ytd=mysqli_fetch_assoc($result_gender_rejected_ytd)){
     $chartBar_gender_rejected_ytd[] = array("date" => $row_gender_rejected_ytd["req_month"], "count" =>  $row_gender_rejected_ytd["count"]);
    }
}
usort($chartBar_gender_rejected_ytd, "sortFunction");
foreach ($chartBar_gender_rejected_ytd as $key => $value) {
   $dataPointsBar_gender_rejected_ytd_label[] =  $value["date"];
   $dataPointsBar_gender_rejected_ytd_count[] = $value["count"];
}

//BARGRAPH GENDER COMPLETED CONSULTATION YTD
$result_gender_completed_ytd = mysqli_query($conn, $sql_gender_completed_ytd);
$chartBar_gender_completed_ytd=[];
if($result_gender_completed_ytd){
    while($row_gender_completed_ytd=mysqli_fetch_assoc($result_gender_completed_ytd)){
     $chartBar_gender_completed_ytd[] = array("date" => $row_gender_completed_ytd["req_month"], "count" =>  $row_gender_completed_ytd["count"]);
    }
}
usort($chartBar_gender_completed_ytd, "sortFunction");
foreach ($chartBar_gender_completed_ytd as $key => $value) {
   $dataPointsBar_gender_completed_ytd_label[] =  $value["date"];
   $dataPointsBar_gender_completed_ytd_count[] = $value["count"];
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
  <form  action="../RHU/?p=analytics_g" method="POST">
    <div class="input-group">
        <i class="input-group-text border-0 mdi mdi-filter"></i>
      <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by" onchange="this.form.submit();">
        <option disabled selected>FILTER BY GENDER...</option>
        <?php
            if (isset($_POST["search_by"])) {
              if ($_POST["search_by"] == "m") {
                echo '<option selected value="m">Male</option>';
                echo '<option value="f">Female</option>';
                echo '<option value="Others">Others</option>';
                echo '<option value="Prefer not to say">Prefer not to say</option>';
              }elseif($_POST["search_by"] == "f"){
                echo '<option value="m">Male</option>';
                echo '<option selected value="f">Female</option>';
                echo '<option value="Others">Others</option>';
                echo '<option value="Prefer not to say">Prefer not to say</option>';
              }elseif($_POST["search_by"] == "Others"){
                echo '<option value="m">Male</option>';
                echo '<option value="f">Female</option>';
                echo '<option selected value="Others">Others</option>';
                echo '<option value="Prefer not to say">Prefer not to say</option>';
              }elseif($_POST["search_by"] == "Prefer not to say"){
                echo '<option value="m">Male</option>';
                echo '<option value="f">Female</option>';
                echo '<option value="Others">Others</option>';
                echo '<option selected value="Prefer not to say">Prefer not to say</option>';
              }
            }else{
              echo '<option value="m">Male</option>';
              echo '<option value="f">Female</option>';
              echo '<option value="Others">Others</option>';
              echo '<option value="Prefer not to say">Prefer not to say</option>';
            }
         ?>
      </select>
       
      <label><a class="form-control bg-transparent border-0" href="../RHU/?p=analytics_g">Clear filter</a></label>
      </form>
    </div>
 
</div>
<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Age of Patients based on Gender for the month of <?php echo date('F Y');?></h4>
        <canvas id="pieChart_curr" style="height:250px"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Age of Patient based on Gender YTD</h4>
        <canvas id="pieChart_ytd" style="height:250px"></canvas>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Total # of Consultation for the month of <?php echo date('F Y');?></h4>
        <canvas id="chart_gender_male_curr" style="height: 250px; width: 100%;"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Total # of Consultation YTD</h4>
        <canvas id="chart_gender_male_ytd" style="height: 250px; width: 100%;"></canvas>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Total # of Pending Consultation YTD</h4>
        <canvas id="chart_gender_pending_ytd" style="height: 250px; width: 100%;"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Total # of Approved Consultation YTD</h4>
        <canvas id="chart_gender_approved_ytd" style="height: 250px; width: 100%;"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Total # of Rejected Consultation YTD</h4>
        <canvas id="chart_consultation_rejected_ytd" style="height: 250px; width: 100%;"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Total # of Completed Consultation YTD</h4>
        <canvas id="chart_consultation_completed_ytd" style="height: 250px; width: 100%;"></canvas>
      </div>
    </div>
  </div>
</div>



        <!-- <script src="assets/vendors/js/vendor.bundle.base.js"></script> -->
        <!-- <script src="assets/vendors/chart.js/Chart.min.js"></script> -->
        <!-- <script src="assets/js/chart.js"></script> -->
        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
        <script>
        $(function () {
          /* ChartJS
           * -------
           * Data and config for chartjs
           */
          'use strict';

         var dataBar_gender_male_curr = {

            labels: <?php echo json_encode($dataPointsBar_gender_male_curr_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Patients',

              data: <?php echo json_encode($dataPointsBar_gender_male_curr_count, JSON_NUMERIC_CHECK); ?>,

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
          
         
            //Barchart Gender Consultatiton YTD
            var dataBar_gender_male_ytd = {

            labels: <?php echo json_encode($dataPointsBar_gender_male_ytd_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Patients',

              data: <?php echo json_encode($dataPointsBar_gender_male_ytd_count, JSON_NUMERIC_CHECK); ?>,

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
          
          
          //Barchart Gender Pending Consultatiton YTD
            var dataBar_gender_pending_ytd = {

            labels: <?php echo json_encode($dataPointsBar_gender_pending_ytd_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Patients',

              data: <?php echo json_encode($dataPointsBar_gender_pending_ytd_count, JSON_NUMERIC_CHECK); ?>,

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
          
          
          //Barchart Gender Approved Consultatiton YTD
          var dataBar_gender_approved_ytd = {

            labels: <?php echo json_encode($dataPointsBar_gender_approved_ytd_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Patients',

              data: <?php echo json_encode($dataPointsBar_gender_approved_ytd_count, JSON_NUMERIC_CHECK); ?>,

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
          
          
          //Barchart Gender Rejected Consultatiton YTD
          var dataBar_consultation_rejected_ytd = {

            labels: <?php echo json_encode($dataPointsBar_gender_rejected_ytd_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Patients',

              data: <?php echo json_encode($dataPointsBar_gender_rejected_ytd_count, JSON_NUMERIC_CHECK); ?>,

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
          
          //Barchart Gender Completed Consultatiton YTD
          var dataBar_consultation_completed_ytd = {

            labels: <?php echo json_encode($dataPointsBar_gender_completed_ytd_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Patients',

              data: <?php echo json_encode($dataPointsBar_gender_completed_ytd_count, JSON_NUMERIC_CHECK); ?>,

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
          var pieChart_curr = {
            datasets: [{
              data: <?php echo json_encode($dataPointsPie_age_curr_count, JSON_NUMERIC_CHECK); ?>,
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
            labels: <?php echo json_encode($dataPointsPie_age_curr_label, JSON_NUMERIC_CHECK); ?>,
          };

          var pieChart_ytd = {
            datasets: [{
              data: <?php echo json_encode($dataPointsPie_age_ytd_count, JSON_NUMERIC_CHECK); ?>,
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
            labels: <?php echo json_encode($dataPointsPie_age_ytd_label, JSON_NUMERIC_CHECK); ?>,
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
          if ($("#chart_gender_male_curr").length) {
            var barChartCanvas = $("#chart_gender_male_curr").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_gender_male_curr,
              options: options
            });
          }
          
          
          if ($("#chart_gender_male_ytd").length) {
            var barChartCanvas = $("#chart_gender_male_ytd").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_gender_male_ytd,
              options: options
            });
          }
          
          
          if ($("#chart_gender_pending_ytd").length) {
            var barChartCanvas = $("#chart_gender_pending_ytd").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_gender_pending_ytd,
              options: options
            });
          }
          
          if ($("#chart_gender_approved_ytd").length) {
            var barChartCanvas = $("#chart_gender_approved_ytd").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_gender_approved_ytd,
              options: options
            });
          }
          
          if ($("#chart_consultation_rejected_ytd").length) {
            var barChartCanvas = $("#chart_consultation_rejected_ytd").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_consultation_rejected_ytd,
              options: options
            });
          }
          
          if ($("#chart_consultation_completed_ytd").length) {
            var barChartCanvas = $("#chart_consultation_completed_ytd").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: dataBar_consultation_completed_ytd,
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

          if ($("#pieChart_curr").length) {
            var pieChartCanvas = $("#pieChart_curr").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
              type: 'pie',
              data: pieChart_curr,
              options: doughnutPieOptions
            });
          }

          if ($("#pieChart_ytd").length) {
            var pieChartCanvas = $("#pieChart_ytd").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
              type: 'pie',
              data: pieChart_ytd,
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
