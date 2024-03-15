<?php
$doctor ="";
if (isset($_POST["services_val"])) {
  $services = $_POST["services_val"];
  $concern = $_POST["concern_val"];
  $other_concern = $_POST["other_concern_val"];
  $doctor = $_POST["doctor_val"];

  // echo $services."<br>";
  // echo $concern."<br>";
  // echo $doctor."<br>";

}else{
  $services = "";
  $concern = "";
  $other_concern = "";
  $doctor = "";
}
 ?>
 <style>
 body {font-family: Arial, Helvetica, sans-serif;}

 /* The Modal (background) */
 .modal {
   display: none; /* Hidden by default */
   position: fixed; /* Stay in place */
   z-index: 1; /* Sit on top */
   padding-top: 15%; /* Location of the box */
   left: 0;
   top: 0;
   width: 100%; /* Full width */
   height: 100%; /* Full height */
   overflow: auto; /* Enable scroll if needed */
   background-color: rgb(0,0,0); /* Fallback color */
   background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
 }

 /* Modal Content */
 .modal-content {
   background-color: #fefefe;
   margin: auto;
   padding: 50px;
   border: 1px solid #888;
   width: 25%;
 }

 /* The Close Button */
 .close {
   color: #aaaaaa;
   float: left;
   margin-left: 97%;
   font-size: 28px;
   font-weight: bold;
 }

.time:hover{
  color: #198ae3;
}

.time{
  background: none;
  border-radius: none;
}

 .close:hover,
 .close:focus {
   color: #000;
   text-decoration: none;
   cursor: pointer;
 }

 @media (max-width:1024px){
   .modal-content{
     width: 50%;
   }
 }

@media (max-width:600px){
  .modal-content{
    width: 80%;
  }
}

 </style>
<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-primary text-white me-2">
              <i class="mdi mdi-account-multiple-plus"></i>
            </span> Consultation
          </h3>
          <nav aria-label="breadcrumb">
            <!-- <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul> -->
            <button onclick="location.href = '../RHU/?p=appt';" class="btn btn-info btn-rounded btn-icon">
              <i class="mdi mdi-close"></i>
            </button>
          </nav>
        </div>
        <div class="row">
            <form class="pt-3" id="form_appt" action="../RHU/?p=newappt_p" method="POST" autocomplete="off">
              <h4>Add New Appointment</h4><br>
              
              
              <div id="patient_details" style="display: none">
                <h4>Patient Details</h4><br>
                 <div class="form-group">
                   <label for="fullname">Patient Name</label>
                   <input type="text" class="form-control form-control-lg" id="fullname" name="fullname" value="<?php echo $fullname; ?>" >
                 </div>
                 <div class="form-group">
                   <label for="age">Age</label>
                   <input type="text" class="form-control form-control-lg" id="age" name="age" value="<?php echo $age; ?>" >
                 </div>
                 <div class="form-group">
                   <label for="gender">Gender</label>
                   <input type="text" class="form-control form-control-lg" id="gender" name="gender" value="<?php echo $gender; ?>" >
                 </div>
                 <div class="form-group">
                   <label for="bday">Birthday</label>
                   <input type="text" class="form-control form-control-lg" id="bday" name="bday" value="<?php echo $bday; ?>" >
                 </div>
                 <div class="form-group">
                   <label for="address">Address</label>
                   <input type="text" class="form-control form-control-lg" id="address" name="address" value="<?php echo $address; ?>" >
                 </div>
                 <div class="form-group">
                   <label for="phealth">PhilHealth No.</label>
                   <input type="text" class="form-control form-control-lg" id="phealth" name="phealth" value="<?php echo $phealth; ?>" >
                 </div>
             </div>
              
              
              <div class="form-group">
                <label for="services">Services</label>
                <select class="form-control form-control-lg" id="services" name="services"  required onchange="updateServices()" style="color:black">
                  <option disabled selected>--Select Services--</option>
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
                </div>
                <div class="form-group">
                  <label for="concern">Concern</label>
                  <select class="form-control form-control-lg" id="concern" name="concern"  required style="color:black" onchange="otherConcern()" onclick="updateConcern()">
                    <option disabled selected>--Select Concern--</option>
                  <?php
                  foreach ($services_array as $services_key => $services_value) {
                    foreach ($services_value as $concern_key => $concern_value) {
                      if ($concern == $concern_value) {
                        $selected_concern = "selected";
                        echo '<option '.$selected_concern.' value="'.$concern_value.'" style="color:black" id="'.$services_key.'">'.$concern_value.'</option>';
                      }else {
                        echo '<option value="'.$concern_value.'" style="color:black" id="'.$services_key.'">'.$concern_value.'</option>';
                      }
                    }
                  }
                  ?>
                  </select>
                </div>
              <div class="form-group" id="lbl_other" style="display: none">
                <label for="other_concern">Other Concern</label>
                <input type="text" class="form-control form-control-lg" id="other_concern" name="other_concern" placeholder="Please provide more details about your concern..." value="<?php echo $other_concern; ?>">
              </div>
              <div class="form-group">
                <label for="doctor">Doctor</label>
                <select class="form-control form-control-lg" id="doctor" name="doctor"  required style="color:black" onchange="doctorSched()" onclick="updateDoctor()">
                  <option disabled selected>--Select Doctor--</option>
                <?php
                  include 'pages/view/config/dbconfig.php';
                  $sql = "SELECT * FROM user_details WHERE user_type = '2'";
                  $result = mysqli_query($conn, $sql);

                  if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                      $doctor_list = $row["fname"]." ".$row["mi"]." ".$row["lname"];
                      $user_id_list = $row["user_id"];
                      $selected_doctor = "";
                      if ($user_id_list == $doctor) {
                        $selected_doctor = "selected";
                      }
                      echo '<option '.$selected_doctor.' value="'.$user_id_list.'" style="color:black" id="'.$row["services"].'">'.$doctor_list.'</option>';
                    }
                  }else{
                      echo "0 results";
                  }

                 ?>
               </select>
            </div>

            <div class="form-group">
              <div class="card">
                <div class="card-body">
                        <?php
                            $default_time = array("08:00 AM", "09:00 AM", "10:00 AM", "11:00 AM", "01:00 PM", "02:00 PM", "03:00 PM", "04:00 PM", "05:00 PM");
                            include 'pages/view/config/dbconfig.php';
                            $sql = "SELECT * FROM schedule WHERE user_id = '$doctor'  AND input_date >= ADDDATE(CURDATE(),1) ORDER BY input_date";
                            $result_dates = mysqli_query($conn, $sql);
                            $result_8am = mysqli_query($conn, $sql);
                            $result_9am = mysqli_query($conn, $sql);
                            $result_10am = mysqli_query($conn, $sql);
                            $result_11am = mysqli_query($conn, $sql);
                            $result_1pm = mysqli_query($conn, $sql);
                            $result_2pm = mysqli_query($conn, $sql);
                            $result_3pm = mysqli_query($conn, $sql);
                            $result_4pm = mysqli_query($conn, $sql);
                            $result_5pm = mysqli_query($conn, $sql);
                            if ($result_dates->num_rows == 0) {
                                echo "No Available Schedule";
                            }else{
                              echo '<h4 class="card-title">Calendar Schedule</h4>';
                              echo '<p class="card-description"> Select Date/Time Below:</p>';
                              echo '<div id="modal_display"></div>';
                              echo '<div class="table-responsive"><table class="table table-bordered table-info">';
                              echo '<thead><tr>';
                              echo '<th class="bg-primary text-light"> TIME </th>';
                              while($row = mysqli_fetch_assoc($result_dates)) {
                                $dates = $row["input_date"];
                                $day = date('D', strtotime($dates));
                                $dates = date('Md', strtotime($dates));
                                echo '<th class="bg-primary text-light">'.$day.'<br>'.$dates.'</th>';
                              }
                              echo '</tr></thead>';
                              echo '<tbody>';
                              echo '<tr>';
                              echo '<td class="bg-primary text-light">08:00 AM</td>';
                              while($row = mysqli_fetch_assoc($result_8am)) {
                              ?>
                                <td><label class="time" id="<?php echo $row["sched_id"].$row["time8am"];?>" onclick="apptDateTime('<?php $time8am=$row["time8am"];($time8am=="Open") ? $time8am=$row["sched_id"].$row["time8am"]:$time8am=""; echo $time8am;?>','<?php echo $row["input_date"];?>','08:00 AM','<?php echo $row["time8am"];?>','<?php echo $row["time8am"].$row["sched_id"];?>')"><?php echo $row["time8am"]; ?></label></td>
                              <?php
                              }
                              echo '</tr>';
                              echo '<tr>';
                              echo '<td class="bg-primary text-light">09:00 AM</td>';
                              while($row = mysqli_fetch_assoc($result_9am)) {
                                ?>
                                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time9am"];?>" onclick="apptDateTime('<?php $time9am=$row["time9am"];($time9am=="Open") ? $time9am=$row["sched_id"].$row["time9am"]:$time9am=""; echo $time9am;?>','<?php echo $row["input_date"];?>','09:00 AM','<?php echo $row["time9am"];?>','<?php echo $row["time9am"].$row["sched_id"];?>')"><?php echo $row["time9am"]; ?></label></td>
                                <?php
                              }
                              echo '</tr>';
                              echo '<tr>';
                              echo '<td class="bg-primary text-light">10:00 AM</td>';
                              while($row = mysqli_fetch_assoc($result_10am)) {
                                ?>
                                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time10am"];?>" onclick="apptDateTime('<?php $time10am=$row["time10am"];($time10am=="Open") ? $time10am=$row["sched_id"].$row["time10am"]:$time10am=""; echo $time10am;?>','<?php echo $row["input_date"];?>','10:00 AM','<?php echo $row["time10am"];?>','<?php echo $row["time10am"].$row["sched_id"];?>')"><?php echo $row["time10am"]; ?></label></td>
                                <?php
                              }
                              echo '</tr>';
                              echo '<tr>';
                              echo '<td class="bg-primary text-light">11:00 AM</td>';
                              while($row = mysqli_fetch_assoc($result_11am)) {
                                ?>
                                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time11am"];?>" onclick="apptDateTime('<?php $time11am=$row["time11am"];($time11am=="Open") ? $time11am=$row["sched_id"].$row["time11am"]:$time11am=""; echo $time11am;?>','<?php echo $row["input_date"];?>','11:00 AM','<?php echo $row["time11am"];?>','<?php echo $row["time11am"].$row["sched_id"];?>')"><?php echo $row["time11am"]; ?></label></td>
                                <?php
                              }
                              echo '</tr>';
                              echo '<tr>';
                              echo '<td class="bg-primary text-light">01:00 PM</td>';
                              while($row = mysqli_fetch_assoc($result_1pm)) {
                                ?>
                                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time1pm"];?>" onclick="apptDateTime('<?php $time1pm=$row["time1pm"];($time1pm=="Open") ? $time1pm=$row["sched_id"].$row["time1pm"]:$time1pm=""; echo $time1pm;?>','<?php echo $row["input_date"];?>','01:00 PM','<?php echo $row["time1pm"];?>','<?php echo $row["time1pm"].$row["sched_id"];?>')"><?php echo $row["time1pm"]; ?></label></td>
                                <?php
                              }
                              echo '</tr>';
                              echo '<tr>';
                              echo '<td class="bg-primary text-light">02:00 PM</td>';
                              while($row = mysqli_fetch_assoc($result_2pm)) {
                                ?>
                                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time2pm"];?>" onclick="apptDateTime('<?php $time2pm=$row["time2pm"];($time2pm=="Open") ? $time2pm=$row["sched_id"].$row["time2pm"]:$time2pm=""; echo $time2pm;?>','<?php echo $row["input_date"];?>','02:00 PM','<?php echo $row["time2pm"];?>','<?php echo $row["time2pm"].$row["sched_id"];?>')"><?php echo $row["time2pm"]; ?></label></td>
                                <?php
                              }
                              echo '</tr>';
                              echo '<tr>';
                              echo '<td class="bg-primary text-light">03:00 PM</td>';
                              while($row = mysqli_fetch_assoc($result_3pm)) {
                                ?>
                                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time3pm"];?>" onclick="apptDateTime('<?php $time3pm=$row["time3pm"];($time3pm=="Open") ? $time3pm=$row["sched_id"].$row["time3pm"]:$time3pm=""; echo $time3pm;?>','<?php echo $row["input_date"];?>','03:00 PM','<?php echo $row["time3pm"];?>','<?php echo $row["time3pm"].$row["sched_id"];?>')"><?php echo $row["time3pm"]; ?></label></td>
                                <?php
                              }
                              echo '</tr>';
                              echo '<tr>';
                              echo '<td class="bg-primary text-light">04:00 PM</td>';
                              while($row = mysqli_fetch_assoc($result_4pm)) {
                                ?>
                                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time4pm"];?>" onclick="apptDateTime('<?php $time4pm=$row["time4pm"];($time4pm=="Open") ? $time4pm=$row["sched_id"].$row["time4pm"]:$time4pm=""; echo $time4pm;?>','<?php echo $row["input_date"];?>','04:00 PM','<?php echo $row["time4pm"];?>','<?php echo $row["time4pm"].$row["sched_id"];?>')"><?php echo $row["time4pm"]; ?></label></td>
                                <?php

                              }
                              echo '</tr>';
                              echo '<tr>';
                              echo '<td class="bg-primary text-light">05:00 PM</td>';
                              while($row = mysqli_fetch_assoc($result_5pm)) {
                                ?>
                                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time5pm"];?>" onclick="apptDateTime('<?php $time5pm=$row["time5pm"];($time5pm=="Open") ? $time5pm=$row["sched_id"].$row["time5pm"]:$time5pm=""; echo $time5pm;?>','<?php echo $row["input_date"];?>','05:00 PM','<?php echo $row["time5pm"];?>','<?php echo $row["time5pm"].$row["sched_id"];?>')"><?php echo $row["time5pm"]; ?></label></td>
                                <?php
                              }
                              echo '</tr>';
                              echo '</tbody></table>';
                              echo '</div>';
                            }
                         ?>

                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>

            <!-- Trigger/Open The Modal -->
            <!-- <button id="myBtn">Open Modal</button> -->

            <!-- The Modal -->
            <div id="myModal" class="modal">

              <!-- Modal content -->
              <div class="modal-content">
                <div class="close">&times;</div>
                <div id="curr_date"></div><br>


              <div class="form-group">
                <label for="req_date">Date</label>
                <input type="date"  class="form-control form-control-lg" id="input_date" >
                <div id="display"></div>
              </div>
              <div class="form-group">
                <label for="req_time">Time</label>
                <input type="text"  class="form-control form-control-lg" id="req_time" >
                <!-- <select class="form-control form-control-lg" id="req_time" name="req_time"  required  style="color:black">
                  <option disabled selected>--Select Time--</option>
                  <option value="08:00 am" style="color:black">8:00 AM</option>
                  <option value="09:00 am" style="color:black">9:00 AM</option>
                  <option value="10:00 am" style="color:black">10:00 AM</option>
                  <option value="11:00 am" style="color:black">11:00 AM</option>
                  <option disabled>12:00 NN</option>
                  <option value="01:00 pm" style="color:black">1:00 PM</option>
                  <option value="02:00 pm" style="color:black">2:00 PM</option>
                  <option value="03:00 pm" style="color:black">3:00 PM</option>
                  <option value="04:00 pm" style="color:black">4:00 PM</option>
                  <option value="05:00 pm" style="color:black">5:00 PM</option>
                </select> -->
              </div>
              <div class="input-group">
              <div class="mt-3">
                <div id="confirm" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="apptDateTime()">Confirm</div>
            </div>&nbsp;
            <div class="mt-3">
                <div id="cancel" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="apptDateTime()">Cancel</div>
            </div>
            </div>
            </div>
            </div>
            <input type="hidden" id="input_date_hidden" name="req_date">
            <input type="hidden" id="input_time_hidden" name="req_time">
            <!-- <div class="mt-3">
              <input type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
            </div> -->
            </form>
            <form id="form_val" action="../RHU/?p=newappt" method="post">
              <input type="hidden" name="services_val" id="services_val">
              <input type="hidden" name="concern_val" id="concern_val">
              <input type="hidden" name="other_concern_val" id="other_concern_val">
              <input type="hidden" name="doctor_val" id="doctor_val">
            </form>
          </div>
          
        <script>
        window.onload = otherConcern();
        function updateServices(){
          const servicesValue = document.getElementById("services").value;
          const concernValue = document.getElementById("concern");
          const doctorSelector = document.getElementById("doctor");
          Array.from(concernValue.options).forEach((node) => node.style.display = node.id === servicesValue ? "block": "none");
          Array.from(doctorSelector.options).forEach((node) => node.style.display = node.id === servicesValue ? "block": "none");

          document.getElementById("concern").value = "--Select Concern--";
          document.getElementById("doctor").value = "--Select Doctor--";
        }

        function updateConcern(){
          const servicesValue = document.getElementById("services").value;
          const concernValue = document.getElementById("concern");
          const doctorSelector = document.getElementById("doctor");
          Array.from(concernValue.options).forEach((node) => node.style.display = node.id === servicesValue ? "block": "none");
          Array.from(doctorSelector.options).forEach((node) => node.style.display = node.id === servicesValue ? "block": "none");

          document.getElementById("doctor").value = "--Select Doctor--";
        }

        function updateDoctor(){
          const servicesValue = document.getElementById("services").value;
          const concernValue = document.getElementById("concern");
          const doctorSelector = document.getElementById("doctor");
          Array.from(doctorSelector.options).forEach((node) => node.style.display = node.id === servicesValue ? "block": "none");
        }



        function otherConcern(){
          const lbl_other = document.getElementById('lbl_other');
          const concern = document.getElementById('concern').value;
          if (document.getElementById('concern').value == "Others") {
            document.getElementById('lbl_other').style.display = "block";
          }else{
            document.getElementById('lbl_other').style.display = "none";
          }
        }


        function doctorSched(){
          var services = document.getElementById("services").value;
          var concern = document.getElementById("concern").value;
          var other_concern = document.getElementById("other_concern").value;
          var doctor = document.getElementById("doctor").value;
          document.getElementById("services_val").value = services;
          document.getElementById("concern_val").value = concern;
          document.getElementById("other_concern_val").value = other_concern;
          document.getElementById("doctor_val").value = doctor;
          document.getElementById("form_val").submit();
        }

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
        document.getElementById('input_date').onchange = evt => {
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

          function apptDateTime(x,y,z,a,b){
            var modal = document.getElementById("myModal");
            // Get the button that opens the modal
            const btn = document.getElementById(x);
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            var confirm = document.getElementById("confirm");
            var cancel = document.getElementById("cancel");


            if (a == "Not Available") {
              document.getElementById("modal_display").style.color = "Red";
              document.getElementById("modal_display").innerHTML = "<b>ERROR: Date/Time selected is Not Available. Please select another Date/Time.</b>";
            }else if (a == "Booked") {
              document.getElementById("modal_display").style.color = "Red";
              document.getElementById("modal_display").innerHTML = "<b>ERROR: Date/Time selected is already booked by another Patient. <br>Please select another Date/Time.</b>";
            }else {
              document.getElementById("modal_display").innerHTML = "";
              modal.style.display = "block";
              document.getElementById("input_date").value = y;
              document.getElementById("req_time").value = z;
              document.getElementById("input_date").disabled = "true";
              document.getElementById("req_time").disabled = "true";
              document.getElementById("curr_date").innerHTML = "<b>Confirm your Appointment Date/Time</b>";
            }

            // When the user clicks on <span> (x), close the modal
            confirm.onclick = function(){
              document.getElementById("input_date_hidden").value = y;
              document.getElementById("input_time_hidden").value = z;
              document.getElementById(x).innerHTML = "Blocked";
              document.getElementById("form_appt").submit();
            }
            cancel.onclick = function(){

                modal.style.display = "none";
            }
            span.onclick = function() {
              modal.style.display = "none";
            }
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
              if (event.target == modal) {
                modal.style.display = "none";
              }
            }

          }


        </script>
