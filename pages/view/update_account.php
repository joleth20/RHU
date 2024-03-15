<?php
$user_id_curr = $_SESSION["user_id"];
$user_id = $_POST["user_id"];
include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM user_details WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user_details = mysqli_fetch_assoc($result);
$bday = $user_details["bday"];
$bday = date("Y-m-d", strtotime($bday));
$user_type = $user_details["user_type"];
$services = $user_details["services"];

if($user_id_curr == $user_id){
    $redirect = "../RHU/";
}else{
     $redirect = "../RHU/?p=account_mgmt";
}

 ?>
   <div class="row">
       <div class="col-12 grid-margin">
         <div class="card">
           <div class="card-body">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-primary text-white me-2">
                  <i class="mdi mdi-account-multiple-plus"></i>
                </span> Edit Profile
              </h3>
              <nav aria-label="breadcrumb">
                <!-- <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul> -->
                <button onclick="location.href = '<?php echo $redirect;?>';" class="btn btn-info btn-rounded btn-icon">
                  <i class="mdi mdi-close"></i>
                </button>
              </nav>
            </div>
              <div class="col-lg-4">
                <h4>Account Details</h4>
                <form class="pt-3" action="../RHU/?p=update_account_p" method="POST" autocomplete="off">
                  <div class="form-group" >
                    <h6 class="font-weight-light">Full Name</h6>
                    <input type="text" class="form-control form-control-lg" id="fname" name="fname" placeholder="Firstname" required value = "<?php echo $user_details["fname"];?>" oninput="restrictCharacters(this)">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="mi" name="mi" placeholder="Middle Initial" required value = "<?php echo $user_details["mi"];?>" oninput="restrictCharacters(this)">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="lname" name="lname" placeholder="Lastname" required value = "<?php echo $user_details["lname"];?>" oninput="restrictCharacters(this)">
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Birthday</h6>
                    <input type="date"  class="form-control form-control-lg" id="bday" name="bday" placeholder="Birthday" required value = "<?php echo $bday;?>">
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Age</h6>
                    <input type="number" class="form-control form-control-lg" id="age" name="age" placeholder="Age" required value = "<?php echo $user_details["age"];?>" oninput="restrictCharacters(this)">
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Gender</h6>
                    <select class="form-control form-control-lg" id="gender" name="gender" style="color:black" required>
                      <option disabled selected>--Select Gender--</option>
                      <option <?php echo ($user_details["gender"]=="m")?"selected":"";?> value="m" style="color:black">Male</option>
                      <option <?php echo ($user_details["gender"]=="f")?"selected":"";?> value="f" style="color:black">Female</option>
                      <option <?php echo ($user_details["gender"]=="Others")?"selected":"";?> value="Others" style="color:black">Others</option>
                      <option <?php echo ($user_details["gender"]=="Prefer not to say")?"selected":"";?> value="Prefer not to say" style="color:black">Prefer not to say</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Address</h6>
                    <div id="display_error_address"></div>
                    <input type="text" class="form-control form-control-lg" id="address_stblc" name="address_stblc" placeholder="House # / Block / Lot / Street" required value = "<?php echo $user_details["address_stblc"];?>" oninput="restrictCharacters(this)" onchange="checkMinimumCharacters()">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="address_brgy" name="address_brgy" placeholder="Barangay" required value = "<?php echo $user_details["address_brgy"];?>" oninput="restrictCharacters(this)" onchange="checkMinimumCharacters()">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="address_city" name="address_city" placeholder="City" required value = "<?php echo $user_details["address_city"];?>" oninput="restrictCharacters(this)" onchange="checkMinimumCharacters()">
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Contact Number (11 digits)</h6>
                    <input type="number" class="form-control form-control-lg" id="contact_no" name="contact_no" placeholder="Contact Number 09XXXXXXXXX" required value = "<?php echo $user_details["contact_no"];?>" oninput="restrictCharacters(this)">
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">PhilHealth Number</h6>
                    <input type="number" class="form-control form-control-lg" id="phealth" name="phealth" placeholder="Philhealth Number" value = "<?php echo $user_details["phealth"];?>" oninput="restrictCharacters(this)">
                  </div>
                  
                    <input type="hidden" name="user_type" value="<?php echo $user_details["user_type"];?>">
                 
                  <div class="form-group">
                    <h6 class="font-weight-light">Email</h6>
                    <input type="email" class="form-control form-control-lg" id="eml" name="eml" placeholder="Email" required value = "<?php echo $user_details["eml"];?>" oninput="restrictCharacters(this)">
                  </div>
                  <!-- <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="pw" name="pw"placeholder="Password" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="cpw" name="cpw"placeholder="Confirm Password" required>
                  </div> -->
                  <!-- <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input" onclick="showHide()">Show Password </label>
                    </div>
                  </div> -->
                   <?php
                        if($user_type == 2){
                            echo '<div class="form-group">';
                            echo '<label for="services">Services</label>';
                            echo '<select class="form-control form-control-lg" id="services" name="services"  required onchange="updateServices()" style="color:black">';
                            echo '<option disabled selected>--Select Services--</option>';
                     
                            include 'services.php';
                            foreach ($services_array as $services_key => $services_value) {
                              if ($services == $services_key) {
                                $selected_services = "selected";
                                echo '<option '.$selected_services.' value="'.$services_key.'" style="color:black" id="'.$services_key.'">'.$services_key.'</option>';
                              }else{
                                echo '<option value="'.$services_key.'" style="color:black" id="'.$services_key.'">'.$services_key.'</option>';
                              }
                            }
                     
                            echo '</select>';
                            echo '</div>';
                        }
                 ?>
                 <div class="input-group">
                  <div class="mt-3">
                    <input type="submit" id="sbmt_form" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
                  </div>&nbsp;
                          <div class="mt-3">
                            <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='../RHU/';">Cancel</button>
                          </div>
                  </div>
                  <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                  <input type="hidden" name="update_type" value="account_summary">
                </form>
              </div>
           </div>
         </div>
       </div>
   </div>


    <script>
    function showHide() {
      var pw = document.getElementById("pw");
      var cpw = document.getElementById("cpw");
      if (pw.type === "password" && cpw.type === "password") {
        pw.type = "text";
        cpw.type = "text";
      } else {
        pw.type = "password";
        cpw.type = "password";
      }
    }
    
     function restrictCharacters(input) {
      // Replace apostrophes and double quotes with an empty string
      input.value = input.value.replace(/['"]/g, '');
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
    <!-- endinject -->

