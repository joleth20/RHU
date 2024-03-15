<?php

$user_type = $_SESSION["user_type"];

$user_id = $_POST["user_id"];

$doctor = $_SESSION["user_id"];

if ($user_type != "2") {

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

  $sql_patient = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
	  services,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE services = '$services' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";



  $sql_medication = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      user_id,
      COUNT(rx_id) AS count

    FROM medication_refills WHERE user_id = '$user_id' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";



  $sql_concern = "SELECT

      concern AS concern_label,
      
      user_id,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE services = '$services' AND user_id = '$user_id'

    GROUP BY concern_label";



}else{

  $sql_patient = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";



  $sql_medication = "SELECT

      DATE_FORMAT(req_date, '%b %Y') AS req_month,
      user_id,
      COUNT(rx_id) AS count

    FROM medication_refills WHERE user_id = '$user_id' and req_date > DATE_SUB(now(), INTERVAL 3 MONTH)

    GROUP BY req_month";



  $sql_concern = "SELECT

      services AS concern_label,

      COUNT(appt_id) AS count

    FROM appointment_details WHERE user_id = '$user_id'

    GROUP BY concern_label";

}

// DATE SORTER
function sortFunction( $a, $b ) {
    return strtotime($a["date"]) - strtotime($b["date"]);
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


//BARCHART MEDICATION

$result_medication = mysqli_query($conn, $sql_medication);

$chartBar_medication=[];

if($result_medication){

  while($row_medication=mysqli_fetch_assoc($result_medication)){
     $chartBar_medication[] = array("date" => $row_medication["req_month"], "count" =>  $row_medication["count"]);

  }

}


usort($chartBar_medication, "sortFunction");

foreach ($chartBar_medication as $key => $value) {
   $dataPointsBar_medication_label[] =  $value["date"];
   $dataPointsBar_medication_count[] = $value["count"];
}


//PIECHART SERVICES/CONCERNS

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



echo mysqli_error($conn);

?>



<div class="page-header">

  <h3 class="page-title"> Patient Summary </h3>

  <nav aria-label="breadcrumb">

    <ol class="breadcrumb">

      <!-- <li class="breadcrumb-item"><a href="#">Charts</a></li>

      <li class="breadcrumb-item active" aria-current="page">Chart-js</li> -->

    </ol>

  </nav>

</div>

<div class="row">

  <form  action="../RHU/?p=analytics_p" method="POST">

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
       <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
    </form>
    <form id="form_clear" action="../RHU/?p=analytics_p" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
    <label><a class="form-control bg-transparent border-0" onclick="document.getElementById('form_clear').submit();">Clear filter</a></label>
    </form>
    </div>
</div>

<div class="row">

  <!--<div class="col-md-4 stretch-card grid-margin">-->

  <!--  <div class="card bg-gradient-danger card-img-holder text-white">-->

  <!--    <div class="card-body">-->

  <!--      <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />-->

  <!--      <h4 class="font-weight-normal mb-3">New Patients for the month of <?php echo date('F');?> <i class="mdi mdi-account-plus mdi-24px float-right"></i>-->

  <!--      </h4>-->

  <!--      <h2 class="mb-5"><?php echo $new_patient_curr;?></h2>-->

  <!--      <h6 class="card-text" >Increased by 60%</h6>-->

  <!--    </div>-->

  <!--  </div>-->

  <!--</div>-->

</div>

<div class="row">

  <!--<div class="col-lg-6 grid-margin stretch-card">-->

  <!--  <div class="card">-->

  <!--    <div class="card-body">-->

  <!--      <h4 class="card-title">Total Number of Patients by Month</h4>-->

  <!--      <canvas id="barChart_patient" style="height:230px"></canvas>-->

  <!--    </div>-->

  <!--  </div>-->

  <!--</div>-->
   <div class="col-lg-6 grid-margin stretch-card">

    <div class="card">

      <div class="card-body">

        <h4 class="card-title">Most Demand Concerns by Services YTD</h4>

        <canvas id="pieChart" style="height:250px"></canvas>

      </div>

    </div>

  </div>

  <div class="col-lg-6 grid-margin stretch-card">

    <div class="card">

      <div class="card-body">

        <h4 class="card-title">Total Number of Medication Request by Month</h4>

        <canvas id="barChart_medication" style="height:230px"></canvas>

      </div>

    </div>

  </div>

</div>

<div class="row">

  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <!--<div class="search-field d-none d-md-block">-->
        <!--  <form  action="../RHU/?p=analytics_p" method="POST">-->
        <!--    <div class="input-group">-->
        <!--        <i class="input-group-text border-0 mdi mdi-magnify"></i>-->
        <!--          <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by" >-->
        <!--            <option selected disabled>Search By...</option>-->
        <!--            <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="appt_id")?"selected":"";?> value="appt_id">Appointment ID</option>-->
        <!--            <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="fname")?"selected":"";?> value="fname">Patient Name</option>-->
        <!--            <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="services")?"selected":"";?> value="services">Services</option>-->
        <!--            <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="concern")?"selected":"";?> value="concern">Concern</option>-->
        <!--            <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="status")?"selected":"";?> value="status">Status</option>-->
        <!--          </select>-->
        <!--          <input type="hidden" name="user_id" value="<?php echo $user_id;?>">-->
        <!--      <input type="text" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">-->
        <!--    </div>-->
        <!--  </form>-->
        <!--</div>-->
        <h4 class="card-title">Appointment Summary</h4>
        <div id="status_filter_button" class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=analytics_p" method="post" id="status_form">
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('status_filter').value='All';this.form.submit();">All</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('status_filter').value='Pending';this.form.submit();">Pending</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_approved" onclick="document.getElementById('status_filter').value='Approved';this.form.submit();">Approved</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_rejected" onclick="document.getElementById('status_filter').value='Rejected';this.form.submit();">Rejected</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_completed" onclick="document.getElementById('status_filter').value='Completed';this.form.submit();">Completed</button>
        </div>
        <div class="form-group" id="status_filter_select">
            
              <div class="input-group">
                    <i class="input-group-text border-0 mdi mdi-filter"></i>
                    <select class="form-control form-control-lg" style="color:black" required onchange="document.getElementById('status_filter').value=this.value;this.form.submit();">
                      <option disabled selected>--Select Status--</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="All")?"selected":"";?> value="All" style="color:black">All</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Pending")?"selected":"";?> value="Pending" style="color:black">Pending</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Approved")?"selected":"";?> value="Approved" style="color:black">Approved</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Rejected")?"selected":"";?> value="Rejected" style="color:black">Rejected</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Completed")?"selected":"";?> value="Completed" style="color:black">Completed</option>
                    </select>
                    </div>
           </div>
           <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
          <input type="hidden" id="status_filter" name="status_filter">
        </form>
        <div class="table-responsive">
          <table class="table" id="rhu_table">
            <thead>
              <tr>
                <th> Appt.ID </th>
                <th> Patient Name </th>
                <th> Service </th>
                <th> Date Requested</th>
                <th> Time Requested</th>
                <th> Status </th>
              </tr>
            </thead>
            <tbody>

                <?php
                include 'pages/view/config/dbconfig.php';
                if (isset($_POST["search"])) {
                  $search = $_POST["search"];
                  $search_by = $_POST["search_by"];
                  if ($user_type == 2) {
                    $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id' AND doctor = '$doctor' and $search_by LIKE '%$search%'";
                  }else{
                    $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id' and $search_by LIKE '%$search%'";
                  }
                }else {
                    if (isset($_POST["status_filter"])) {
                      if ($user_type == "2") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id' AND doctor = '$doctor'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id' AND doctor = '$doctor' and status = '$status_filter'";
                        }
                      }elseif ($user_type == "1" || $user_type == "3") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM appointment_details";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM appointment_details WHERE status = '$status_filter'";
                        }
                      }else{
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id' and status = '$status_filter'";
                        }
                      }

                    }else{
                      if ($user_type == "2") {
                        $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id' AND doctor = '$doctor'";
                      }elseif ($user_type == "1" || $user_type == "3") {
                        $sql = "SELECT * FROM appointment_details";
                      }else{
                        $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id'";
                      }
                    }
                }

                $result = mysqli_query($conn, $sql);
                while($row=mysqli_fetch_assoc($result)){
                  if ($row["status"] == "Pending") {
                    $status = "warning";
                  }elseif ($row["status"] == "Completed") {
                    $status = "info";
                  }elseif ($row["status"] == "Approved") {
                    $status = "success";
                  }else{
                    $status = "danger";
                  }
                  
                  $patient_user_id = $row["user_id"];
                  
                  $sql2 = "SELECT * FROM user_details WHERE user_id = '$patient_user_id'";
                  $result2 = mysqli_query($conn, $sql2);
                  $user_details = mysqli_fetch_assoc($result2);
                  $patient_fullname = $user_details["fname"].' '.$user_details["mi"].' '.$user_details["lname"];
                  
                  echo '<tr><td>'.$row["appt_id"].'</td>';
                  echo '<td>'.$patient_fullname.'</td>';
                  echo '<td>'.$row["services"].'</td>';
                  echo '<td>'.$row["req_date"].'</td>';
                  echo '<td>'.$row["req_time"].'</td>';
                  echo '<td><label class="badge badge-'.$status.'">'.$row["status"].'</label></td>';
                  
                }
                ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


</div>

<div class="row">



<div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <!--<div class="search-field d-none d-md-block">-->
        <!--  <form  action="../RHU/?p=analytics_p" method="POST">-->
        <!--    <div class="input-group">-->
        <!--        <i class="input-group-text border-0 mdi mdi-magnify"></i>-->
        <!--      <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by">-->
        <!--        <option selected disabled>Search By...</option>-->
        <!--        <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="rx_id")?"selected":"";?> value="rx_id">Medecine ID</option>-->
        <!--        <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="fullname")?"selected":"";?> value="fullname">Patient Name</option>-->
        <!--        <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="rx_name")?"selected":"";?> value="rx_name">Medicine</option>-->
        <!--        <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="status")?"selected":"";?> value="status">Status</option>-->
        <!--      </select>-->
        <!--      <input type="text" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">-->
        <!--      <input type="hidden" name="user_id" value="<?php echo $user_id;?>">-->
        <!--    </div>-->
        <!--  </form>-->
        <!--</div>-->
        <h4 class="card-title">Medication Refills Summary</h4>
        <div id="status_filter_rx_button" class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=analytics_p" method="post">
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('status_filter_rx').value='All';this.form.submit();">All</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('status_filter_rx').value='Pending';this.form.submit();">Pending</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_approved" onclick="document.getElementById('status_filter_rx').value='Approved';this.form.submit();">Approved</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_rejected" onclick="document.getElementById('status_filter_rx').value='Rejected';this.form.submit();">Rejected</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_completed" onclick="document.getElementById('status_filter_rx').value='Completed';this.form.submit();">Completed</button>
        </div>
        <div class="form-group" id="status_filter_rx_select">
           <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-filter"></i>
                    <select class="form-control form-control-lg" style="color:black" required onchange="document.getElementById('status_filter_rx').value=this.value;this.form.submit();">
                      <option disabled selected>--Select Status--</option>
                      <option <?php echo (isset($_POST["status_filter_rx"]) && $_POST["status_filter_rx"]=="All")?"selected":"";?> value="All" style="color:black">All</option>
                      <option <?php echo (isset($_POST["status_filter_rx"]) && $_POST["status_filter_rx"]=="Pending")?"selected":"";?> value="Pending" style="color:black">Pending</option>
                      <option <?php echo (isset($_POST["status_filter_rx"]) && $_POST["status_filter_rx"]=="Approved")?"selected":"";?> value="Approved" style="color:black">Approved</option>
                      <option <?php echo (isset($_POST["status_filter_rx"]) && $_POST["status_filter_rx"]=="Rejected")?"selected":"";?> value="Rejected" style="color:black">Rejected</option>
                      <option <?php echo (isset($_POST["status_filter_rx"]) && $_POST["status_filter_rx"]=="Completed")?"selected":"";?> value="Completed" style="color:black">Completed</option>
                    </select>
             </div>
           </div>
          <input type="hidden" id="status_filter_rx" name="status_filter_rx">
          <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
        </form>
          <div class="table-responsive">
          <table class="table" id="rhu_table1">
            <thead>
              <tr>
                <th> Rx ID </th>
                <th> Patient Name </th>
                <th> Medicine </th>
                <th> Receipt</th>
                <th> Date Requested</th>
                <th> Time Requested</th>
                <th> Status </th>
              </tr>
            </thead>
            <tbody>

                <?php
                include 'pages/view/config/dbconfig.php';
                if (isset($_POST["search"])) {
                  $search = $_POST["search"];
                  $search_by = $_POST["search_by"];
                  if ($user_type == 2) {
                    $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id' AND doctor = '$doctor' and $search_by LIKE '%$search%'";
                  }else{
                    $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id' and $search_by LIKE '%$search%'";
                  }
                }else {
                    if (isset($_POST["status_filter_rx"])) {
                      if ($user_type == "2") {
                        if ($_POST["status_filter_rx"] == "All") {
                          $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id' AND doctor = '$doctor'";
                        }else{
                          $status_filter_rx = $_POST["status_filter_rx"];
                          $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id' AND doctor = '$doctor' and status = '$status_filter_rx'";
                        }
                      }elseif ($user_type == "1" || $user_type == "3") {
                        if ($_POST["status_filter_rx"] == "All") {
                          $sql = "SELECT * FROM medication_refills";
                        }else{
                          $status_filter_rx = $_POST["status_filter_rx"];
                          $sql = "SELECT * FROM medication_refills WHERE status = '$status_filter_rx'";
                        }
                      }else{
                        if ($_POST["status_filter_rx"] == "All") {
                          $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id'";
                        }else{
                          $status_filter_rx = $_POST["status_filter_rx"];
                          $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id' and status = '$status_filter_rx'";
                        }
                      }

                    }else{
                      if ($user_type == "2") {
                        $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id' AND doctor = '$doctor'";
                      }elseif ($user_type == "1" || $user_type == "3") {
                        $sql = "SELECT * FROM medication_refills";
                      }else{
                        $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id'";
                      }
                    }
                }
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows == 0) {
                    echo "No records found!";
                }else{
                  while($row=mysqli_fetch_assoc($result)){
                    if ($row["status"] == "Pending") {
                      $status = "warning";
                    }elseif ($row["status"] == "Completed") {
                      $status = "info";
                    }elseif ($row["status"] == "Approved") {
                      $status = "success";
                    }else{
                      $status = "danger";
                    }
                  $patient_user_id = $row["user_id"];
                  $sql2 = "SELECT * FROM user_details WHERE user_id = '$patient_user_id'";
                  $result2 = mysqli_query($conn, $sql2);
                  $user_details = mysqli_fetch_assoc($result2);
                  $patient_fullname = $user_details["fname"].' '.$user_details["mi"].' '.$user_details["lname"];

                    echo '<tr><td>'.$row["rx_id"].'</td>';
                    echo '<td>'.$patient_fullname.'</td>';
                    echo '<td>'.$row["rx_name"].'</td>';
                    echo '<td><a href="../RHU/assets/images/receipt/'.$row["prescription"].'" target="_blank">View Receipt</a></td>';
                    echo '<td>'.$row["req_date"].'</td>';
                    echo '<td>'.$row["req_time"].'</td>';
                    echo '<td><label class="badge badge-'.$status.'">'.$row["status"].'</label></td>';
                    
                  }
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



          var dataBar_medication = {

            labels: <?php echo json_encode($dataPointsBar_medication_label, JSON_NUMERIC_CHECK); ?>,

            datasets: [{

              label: '# of Medication',

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

