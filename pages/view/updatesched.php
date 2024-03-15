<?php
$sched_id = $_POST["sched_id"];
$sched_value = $_POST["sched_value"];

if (!isset($sched_id)) {
  echo "<script>alert('Invalid Schedule ID')</script>";
  echo "<script>window.top.location.href='../RHU/?p=schedule';</script>";
}
include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM schedule WHERE sched_id = '$sched_id'";
$result = mysqli_query($conn, $sql);
$sched_details = mysqli_fetch_assoc($result);
$user_id = $sched_details["user_id"];
$input_date = $sched_details["input_date"];
$input_time = $sched_details["input_time"];
$input_time = explode(',', $input_time);
$time8am = "";
$time9am = "";
$time10am = "";
$time11am = "";
$time1pm = "";
$time2pm = "";
$time3pm = "";
$time4pm = "";
$time5pm = "";
foreach ($input_time as $value) {
  if ($value == "08:00 AM") {
    $time8am = "checked";
  }
}
foreach ($input_time as $value) {
  if ($value == "09:00 AM") {
    $time9am = "checked";

  }
}
foreach ($input_time as $value) {
  if ($value == "10:00 AM") {
    $time10am = "checked";

  }
}
foreach ($input_time as $value) {
  if ($value == "11:00 AM") {
    $time11am = "checked";

  }
}
foreach ($input_time as $value) {
  if ($value == "01:00 PM") {
    $time1pm = "checked";
  }
}
foreach ($input_time as $value) {
  if ($value == "02:00 PM") {
    $time2pm = "checked";
  }
}
foreach ($input_time as $value) {
  if ($value == "03:00 PM") {
    $time3pm = "checked";
  }
}
foreach ($input_time as $value) {
  if ($value == "04:00 PM") {
    $time4pm = "checked";
  }
}
foreach ($input_time as $value) {
  if ($value == "05:00 PM") {
    $time5pm = "checked";
  }
}


 ?>


        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-primary text-white me-2">
              <i class="mdi mdi-calendar"></i>
            </span> Schedule
          </h3>
          <nav aria-label="breadcrumb">
            <!-- <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul> -->
            <button onclick="location.href = '../RHU/?p=schedule';" class="btn btn-info btn-rounded btn-icon">
              <i class="mdi mdi-close"></i>
            </button>
          </nav>
        </div>

        <div class="row">
          <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">List of Patients Booked on this Date/Time</h4>
                 <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Appt ID</th>
                      <th>Patient Name</th>
                      <th>Date Booked</th>
                      <th>Time Booked</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql2 = "SELECT * FROM appointment_details WHERE req_date ='$input_date' and doctor = '$user_id'";
                    $result2 = mysqli_query($conn, $sql2);
                      while($row=mysqli_fetch_assoc($result2)){
                        if ($row["req_time"] == "08:00 AM") {
                          $time = '<script>function activeTimeChecker1(){
                              alert("This time slot has been previously booked by a patient, and it cannot be modified.");
                              document.getElementById("time8am").checked = "true";
                            }
                            </script>';
                        }
                        if ($row["req_time"] == "09:00 AM") {
                          $time = '<script>function activeTimeChecker2(){
                              alert("This time slot has been previously booked by a patient, and it cannot be modified.");
                              document.getElementById("time9am").checked = "true";
                            }
                            </script>';
                        }
                        if ($row["req_time"] == "10:00 AM") {
                          $time = '<script>function activeTimeChecker3(){
                              alert("This time slot has been previously booked by a patient, and it cannot be modified.");
                              document.getElementById("time10am").checked = "true";
                            }
                            </script>';
                        }
                        if ($row["req_time"] == "11:00 AM") {
                          $time = '<script>function activeTimeChecker4(){
                              alert("This time slot has been previously booked by a patient, and it cannot be modified.");
                              document.getElementById("time11am").checked = "true";
                            }
                            </script>';
                        }
                        if ($row["req_time"] == "01:00 PM") {
                          $time = '<script>function activeTimeChecker5(){
                              alert("This time slot has been previously booked by a patient, and it cannot be modified.");
                              document.getElementById("time1pm").checked = "true";
                            }
                            </script>';
                        }
                        if ($row["req_time"] == "02:00 PM") {
                          $time = '<script>function activeTimeChecker6(){
                              alert("This time slot has been previously booked by a patient, and it cannot be modified.");
                              document.getElementById("time2pm").checked = "true";
                            }
                            </script>';
                        }
                        if ($row["req_time"] == "03:00 PM") {
                          $time = '<script>function activeTimeChecker7(){
                              alert("This time slot has been previously booked by a patient, and it cannot be modified.");
                              document.getElementById("time3pm").checked = "true";
                            }
                            </script>';
                        }
                        if ($row["req_time"] == "04:00 PM") {
                          $time = '<script>function activeTimeChecker8(){
                              alert("This time slot has been previously booked by a patient, and it cannot be modified.");
                              document.getElementById("time4pm").checked = "true";
                            }
                            </script>';
                        }
                        if ($row["req_time"] == "05:00 PM") {
                          $time = '<script>function activeTimeChecker9(){
                              alert("This time slot has been previously booked by a patient, and it cannot be modified.");
                              document.getElementById("time5pm").checked = "true";
                            }
                            </script>';
                        }
                        
                        $patient_user_id = $row["user_id"];
                        $sql2 = "SELECT * FROM user_details WHERE user_id = '$patient_user_id'";
                        $result2 = mysqli_query($conn, $sql2);
                        $user_details = mysqli_fetch_assoc($result2);
                        $patient_fullname = $user_details["fname"].' '.$user_details["mi"].' '.$user_details["lname"];
                  
                        echo '<tr><td>'.$row["appt_id"].'</td>';
                        echo '<td>'.$patient_fullname.'</td>';
                        echo '<td>'.$row["req_date"].'</td>';
                        echo '<td><div style="display:none">'.$time.'</div>'.$row["req_time"].'</div></td>';
                        echo '<td>'.$row["status"].'</td>';
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
          <div class="auth-form-light text-left p-5">
            <form class="pt-3" id="sched" action="../RHU/?p=updatesched_p" method="POST" autocomplete="off" enctype="multipart/form-data">
              <h4>Update Schedule Details</h4><br>
              <p class="card-description" style="color: red">Note: A reserved time slot for a patient cannot be modified.
              </p>
              <div class="form-group">
                <label for="date">Date</label>

                <input type="date" style="max-width:11%" class="form-control form-control-lg"  disabled required value="<?php echo $input_date; ?>" >
                <input type="hidden" style="max-width:11%" class="form-control form-control-lg" id="input_date" name="input_date"  required value="<?php echo $input_date; ?>" >
                <div id="display"></div>
              </div>
              <div class="mb-4">
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" id="time8am" onchange="activeTimeChecker1()" name="input_time[]" value="08:00 AM" <?php echo $time8am; ?>>08:00 AM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" id="time9am" onchange="activeTimeChecker2()" name="input_time[]" value="09:00 AM" <?php echo $time9am; ?>>09:00 AM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" id="time10am" onchange="activeTimeChecker3()" name="input_time[]" value="10:00 AM" <?php echo $time10am; ?>>10:00 AM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" id="time11am" onchange="activeTimeChecker4()" name="input_time[]" value="11:00 AM" <?php echo $time11am; ?>>11:00 AM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" id="time1pm" onchange="activeTimeChecker5()" name="input_time[]" value="01:00 PM" <?php echo $time1pm; ?>>01:00 PM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" id="time2pm" onchange="activeTimeChecker6()" name="input_time[]" value="02:00 PM" <?php echo $time2pm; ?>>02:00 PM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" id="time3pm" onchange="activeTimeChecker7()" name="input_time[]" value="03:00 PM" <?php echo $time3pm; ?>>03:00 PM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" id="time4pm" onchange="activeTimeChecker8()" name="input_time[]" value="04:00 PM" <?php echo $time4pm; ?>>04:00 PM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" id="time5pm" onchange="activeTimeChecker9()" name="input_time[]" value="05:00 PM" <?php echo $time5pm; ?>>05:00 PM</label>
                </div>
              </div>
              <input type="hidden" name="sched_id" value="<?php echo $sched_id;?>">
              <div class="input-group">
              <div class="mt-3">
                <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
              </div>&nbsp;
              <div class="mt-3">
                <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='../RHU/?p=schedule';">Cancel</button>
              </div>
            </div>
            </form>
          </div>
        </div>



        <script>
        window.onload = schedView();


        // Everything except weekend days
        const validate = dateString => {
          const day = (new Date(dateString)).getDay();
          if (day==0 || day==6) {
            document.getElementById("display").style.color = "Red";
            document.getElementById("display").innerHTML = "<b>ERROR:</b> No available appointment on Weekends. <br>Please select dates on Weekdays only.";
            return false;
          }
          document.getElementById("display").innerHTML = "";
          return true;
        }

        // Sets the value to '' in case of an invalid date
        document.querySelector('input').onchange = evt => {
          if (!validate(evt.target.value)) {
            evt.target.value = '';
          }
        }

        $(function(){
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate() + 1;
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
             day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;
            $('#input_date').attr('min', maxDate);
        });

        function schedView(){
          var sched_value = "<?php echo $sched_value;?>";
          if (sched_value == "View") {
            document.getElementById('input_date').disabled = "True";
          $('input[type=checkbox]').attr('disabled',true)
          }
        }
        </script>
