<?php

if(isset($_POST["appt_id"])){
    $appt_id = $_POST["appt_id"];
}else{
   echo "<script>alert('Action Not Allowed')</script>";
   echo "<script>window.top.location.href='../RHU/?p=login';</script>";
}

include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM appointment_details WHERE appt_id = '$appt_id'";
$result = mysqli_query($conn, $sql);
$appt_details = mysqli_fetch_assoc($result);


?>
            <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Patient Information</h4>
                    <form class="forms-sample" action="../RHU/?p=updatewalkins_p" method="POST">
                      <div class="form-group row">
                        <label for="fname" class="col-sm-3 col-form-label">Firstname</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="fname" name="fname" placeholder="Firstname" required value="<?php echo $appt_details["fname"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="mi" class="col-sm-3 col-form-label">Middle Initial</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="mi" name="mi" placeholder="Middle Initial" required value="<?php echo $appt_details["mi"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="lname" class="col-sm-3 col-form-label">Lastname</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="lname" name="lname" placeholder="Lastname" required value="<?php echo $appt_details["lname"]; ?>">
                        </div>
                      </div>
                        <div class="form-group row">
                        <div id="display_error_bday"></div>
                        <label for="bday" class="col-sm-3 col-form-label">Birthday</label>
                        <div class="col-sm-9">
                          <input type="date" class="form-control" id="bday" name="bday" placeholder="Birthday" required onchange="calculateAge()" value="<?php echo $appt_details["bday"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="age" class="col-sm-3 col-form-label">Age</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="age" name="age" placeholder="Age" required value="<?php echo $appt_details["age"]; ?>">
                        </div>
                      </div>
                      
                    </div>
                </div>
               </div>
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <h4 class="card-title"></h4>
                     
                      <div class="form-group row">
                        <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">
                          <select class="form-control form-control-lg" id="gender" name="gender" style="color:black" required>
                              <option value="" disabled selected>--Select Gender--</option>
                              <option <?php echo ($appt_details["gender"]=="m")?"selected":"";?> value="m" style="color:black">Male</option>
                              <option <?php echo ($appt_details["gender"]=="f")?"selected":"";?> value="f" style="color:black">Female</option>
                              <option <?php echo ($user_details["gender"]=="Others")?"selected":"";?> value="Others" style="color:black">Others</option>
                              <option <?php echo ($user_details["gender"]=="Prefer not to say")?"selected":"";?> value="Prefer not to say" style="color:black">Prefer not to say</option>
                            </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="contact_no" class="col-sm-3 col-form-label">Contact Number</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" id="contact_no" name="contact_no" placeholder="Contact Number" value="<?php echo $appt_details["contact_no"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="eml" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="eml" name="eml" placeholder="Email" value="<?php echo $appt_details["eml"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="phealth" class="col-sm-3 col-form-label">PhilHealth</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="phealth" name="phealth" placeholder="PhilHealth Number" value="<?php echo $appt_details["phealth"]; ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Complete Address</h4>
                      <div id="display_error_address"></div>
                      <div class="form-group row">
                        <label for="address_stblc" class="col-sm-3 col-form-label">Lot/Block/Street</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="address_stblc" name="address_stblc" placeholder="House#/Lot/Block/Street" required value="<?php echo $appt_details["address_stblc"]; ?>" onchange="checkMinimumCharacters()">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="address_brgy" class="col-sm-3 col-form-label">Barangay</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="address_brgy" name="address_brgy" placeholder="Barangay" required value="<?php echo $appt_details["address_brgy"]; ?>" onchange="checkMinimumCharacters()">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="address_city" class="col-sm-3 col-form-label">City</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="address_city" name="address_city" placeholder="City" required value="<?php echo $appt_details["address_city"]; ?>" onchange="checkMinimumCharacters()">
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
                
              
                
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Services Details</h4>
                      <div class="form-group row">
                        <label for="services" class="col-sm-3 col-form-label">Service</label>
                        <div class="col-sm-9">
                          <select class="form-control form-control-lg" id="services" name="services" required onclick="updateServices()" style="color:black" >
                          <option disabled selected>--Select Services--</option>
                          <?php
                            include 'services.php';
                            foreach ($services_array as $services_key => $services_value) {
                              $services = $appt_details["services"];
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
                      </div>
                      <div class="form-group row">
                        <label for="concern" class="col-sm-3 col-form-label">Concern</label>
                        <div class="col-sm-9">
                          <select class="form-control form-control-lg" id="concern" name="concern"  required style="color:black" onchange="otherConcern()" onclick="updateConcern()">
                            <option disabled selected>--Select Concern--</option>
                          <?php
                          foreach ($services_array as $services_key => $services_value) {
                            foreach ($services_value as $concern_key => $concern_value) {
                              $concern = $appt_details["concern"];
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
                      </div>
                      <div class="form-group row" id="lbl_other" style="display: none">
                        <label for="other_concern" class="col-sm-3 col-form-label">Other Concern</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control" id="other_concern" name="other_concern" placeholder="Please provide more details about your concern..." value="<?php echo $appt_details["other_concern"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="address_city" class="col-sm-3 col-form-label">Doctor</label>
                        <div class="col-sm-9">
                          <select class="form-control form-control-lg" id="doctor" name="doctor"  required style="color:black" onclick="updateDoctor()">
                              <option value="" disabled selected>--Select Doctor--</option>
                            <?php
                              include 'pages/view/config/dbconfig.php';
                              $sql = "SELECT * FROM user_details WHERE user_type = '2'";
                              $result = mysqli_query($conn, $sql);
            
                              if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                  $doctor_list = $row["fname"]." ".$row["mi"]." ".$row["lname"];
                                  $user_id_list = $row["user_id"];
                                  $curr_doctor = $appt_details["doctor"];
                                  $selected_doctor = "";
                                  if ($curr_doctor == $user_id_list) {
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
                      </div>
                      <div class="form-group row">
                        <label for="req_date" class="col-sm-3 col-form-label">Date of Visit</label>
                        <div class="col-sm-9">
                          <input type="date" class="form-control" id="req_date" name="req_date" required value="<?php echo $appt_details["req_date"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="req_date" class="col-sm-3 col-form-label">Time of Visit</label>
                        <div class="col-sm-9">
                          <?php
                            if(!empty($appt_details["req_time"])){
                                $req_time = date("H:i", strtotime($appt_details["req_time"]));
                            }
                          ?>
                          <input type="time" class="form-control" id="req_time" name="req_time" value="<?php echo $req_time; ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Vital Details</h4>
                      <div class="form-group row">
                        <label for="vdate" class="col-sm-3 col-form-label">Vitals Date</label>
                        <div class="col-sm-9">
                          <input type="date" class="form-control" id="vdate" name="vdate" value="<?php echo $appt_details["vdate"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="weight" class="col-sm-3 col-form-label">Weight (lbs)</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight" value="<?php echo $appt_details["weight"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="height" class="col-sm-3 col-form-label">Height (ft.)</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="height" name="height" placeholder="Height" value="<?php echo $appt_details["height"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="bp" class="col-sm-3 col-form-label">Blood Pressure (mmHg)</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="bp" name="bp" placeholder="Blood Pressure" value="<?php echo $appt_details["bp"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="pulse_rate" class="col-sm-3 col-form-label">Pulse Rate (minute)</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="pulse_rate" name="pulse_rate" placeholder="Pulse Rate" value="<?php echo $appt_details["pulse_rate"]; ?>">
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <div class="form-group row">
                        <label for="temp" class="col-sm-3 col-form-label">Temperature (C)</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="temp" name="temp" placeholder="Temperature" value="<?php echo $appt_details["temp"]; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="oxy_sat" class="col-sm-3 col-form-label">Oxygen Saturation (%)</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="oxy_sat" name="oxy_sat" placeholder="Oxygen Saturation" value="<?php echo $appt_details["oxy_sat"]; ?>">
                        </div>
                      </div>  
                     <div class="form-group" >
                       <h6 class="font-weight-light">Findings</h6>
                       <textarea class="form-control form-control-lg" id="findings" name="findings" placeholder="Findings..." required style="height:200px"><?php echo $appt_details["findings"]; ?></textarea>
                     </div>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="appt_id" value="<?php echo $appt_id; ?>">
                <input type="hidden" name="walkins_type" value="Update">
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <div class="input-group">
                          <div class="mt-3">
                            <input type="submit" id="sbmt_form" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
                          </div>&nbsp;
                          <div class="mt-3">
                            <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='../RHU/?p=walkins';">Cancel</button>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              

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

    function calculateAge() {
        const birthdateInput = document.getElementById('bday').value;
    
        // Check if a birthdate is provided
        if (!birthdateInput) {
            document.getElementById("display_error_bday").style.color = "Red";
            document.getElementById('display_error_bday').innerHTML = "<b>ERROR:<b> Please enter a valid birthdate."
            return;
        }
    
        const birthdate = new Date(birthdateInput);
        const today = new Date();
    
        let age = today.getFullYear() - birthdate.getFullYear();
    
        // Adjust age if the birthday hasn't occurred yet this year
        if (
            today.getMonth() < birthdate.getMonth() ||
            (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate())
        ) {
            age--;
        }
    
        // Display the result
        document.getElementById("display_error_bday").innerHTML = "";
        document.getElementById('age').value = `${age}`;
    }
    
        function checkMinimumCharacters(inputId, inputValue) {
            var address1 = document.getElementById("address_stblc").value;
            var address2 = document.getElementById("address_brgy").value;
            var address3 = document.getElementById("address_city").value;
          if (address1.length < 5 || address2.length < 5 || address3.length < 5) {
                document.getElementById("display_error_address").style.color = "Red";
                document.getElementById("display_error_address").innerHTML = "<b>ERROR:</b> Please provide valid address. ";
                document.getElementById("sbmt_form").disabled = true;
            }else{
                document.getElementById("display_error_address").innerHTML = "";
                document.getElementById("sbmt_form").disabled = false;
            }
        }
  
        
</script>