<?php
$user_type = $_SESSION["user_type"];
if ($user_type != "1") {

  echo "<script>alert('Action Not Allowed!')</script>";

  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";

}else{
  if($_SESSION["password_req"] != "ON"){
      echo '<form id="password_req" action="../RHU/?p=password_req" method="post">';
      echo '<input type="hidden" name="reports_title" value="Add Account">';
      echo '<input type="hidden" name="reports_link" value="new_account">';
      echo '<script>document.getElementById("password_req").submit();</script>';
  }else{
    if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {
        unset($_SESSION['password_req']);
        echo '<form id="password_req" action="../RHU/?p=password_req" method="post">';
        echo '<input type="hidden" name="reports_title" value="Add Account">';
      echo '<input type="hidden" name="reports_link" value="new_account">';
        echo '<script>document.getElementById("password_req").submit();</script>';
      } 
    }
}


?>
<div class="row">
<div class="col-12 grid-margin">
<div class="card">
<div class="card-body">
<div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-primary text-white me-2">
              <i class="mdi mdi-hospital"></i>
            </span> Add Account
          </h3>
          <nav aria-label="breadcrumb">
            <!-- <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul> -->
            <button onclick="location.href = '../RHU/?p=account_mgmt';" class="btn btn-info btn-rounded btn-icon">
              <i class="mdi mdi-close"></i>
            </button>
          </nav>
        </div>


<div class="col-lg-4">
                <h4>Account Details</h4>
                <form class="pt-3" action="../RHU/?p=register_p" method="POST" autocomplete="off">
                  <div class="form-group" >
                    <h6 class="font-weight-light">Full Name</h6>
                    <input type="text" class="form-control form-control-lg" id="fname" name="fname" placeholder="Firstname" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="mi" name="mi" placeholder="Middle Initial" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="lname" name="lname" placeholder="Lastname" required>
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Birthday</h6>
                    <div id="display_error_bday"></div>
                    <input type="date" class="form-control form-control-lg" id="bday" name="bday" placeholder="Birthday" required onchange="calculateAge()">
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Age</h6>
                    <input type="number" class="form-control form-control-lg" id="age" name="age" placeholder="Age" required>
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Gender</h6>
                    <select class="form-control form-control-lg" id="gender" name="gender" style="color:black" required>
                      <option value="" disabled selected>--Select Gender--</option>
                      <option value="m" style="color:black">Male</option>
                      <option value="f" style="color:black">Female</option>
                      <option value="Others" style="color:black">Others</option>
                      <option value="Prefer not to say" style="color:black">Prefer not to say</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Address</h6>
                    <input type="text" class="form-control form-control-lg" id="address_stblc" name="address_stblc" placeholder="House # / Block / Lot / Street" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="address_brgy" name="address_brgy" placeholder="Barangay" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="address_city" name="address_city" placeholder="City" required>
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Contact Number (11 digits)</h6>
                    <input type="number" class="form-control form-control-lg" id="contact_no" name="contact_no" placeholder="Contact Number 09XXXXXXXXX" required>
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">PhilHealth Number</h6>
                    <input type="number" class="form-control form-control-lg" id="phealth" name="phealth" placeholder="Philhealth Number" >
                  </div>
                  <div class="form-group">
                    <h4>Login Account Information</h4>
                    <h6 class="font-weight-light">User Details</h6>
                    <select class="form-control form-control-lg" id="user_type" name="user_type" required onchange="selectServices()">
                      <option value="" disabled selected>--Select User Type--</option>
                      <option value="4" style="color:black">Patient</option>
                      <option value="3" style="color:black">Receptionist</option>
                      <option value="2" style="color:black">Doctor</option>
                      <option value="1" style="color:black">Admin</option>
                    </select>
                  </div>
                  <?php
                        
                            echo '<div class="form-group" id="select_services" style="display:none">';
                            echo '<label for="services">Services</label>';
                            echo '<select class="form-control form-control-lg" id="services" name="services" onchange="updateServices()" style="color:black">';
                            echo '<option value="" disabled selected>--Select Services--</option>';
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
                        
                 ?>
                  <div class="form-group">
                    <div id="display_error_email"></div>
                    <input type="email" class="form-control form-control-lg" id="eml" name="eml" placeholder="Email" onchange="validateEmail()" required>
                  </div>
                  
                  <div class="form-group">
                    <h4>Your Password Must Contain the following:</h4>
                    <ul><li>At Least 8 characters</li>
                    <li>At Least 1 Number</li>
                    <li>At Least 1 Capital Letter</li>
                    <li>At Least 1 Lowercase Letter</li>
                    <li>At Least 1 Special Character (Ex.@#~?)</li></ul>
                    <div id="display_error"></div>
                    <input type="password" class="form-control form-control-lg" id="pw" name="pw"placeholder="Password" onchange="validateInput()" required>
                  </div>
                  <div class="form-group">

                    <input type="password" class="form-control form-control-lg" id="cpw" name="cpw"placeholder="Confirm Password" onchange="validateInput()" required>
                  </div>
                  <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input" onclick="showHide()">Show Password </label>
                    </div>
                  </div>
                  <div class="input-group">
                  <div class="mt-3">
                    <input type="submit" id="sbmt_form" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
                  </div>&nbsp;
                  <div class="mt-3">
                  </div>
                  </div>
                    <input type="hidden" name="register_type" value="admin_register">
                  </div>
                </form>
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
    
    function validateInput() {
             var pw = document.getElementById('pw').value;
             var cpw = document.getElementById('cpw').value;

            // Regular expressions
            var capitalLetterRegex = /[A-Z]/;
            var numberRegex = /\d/;
            var specialCharRegex = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/;
            var lowercaseLetterRegex = /[a-z]/;

            // Validation
            if (pw === cpw){
                if (capitalLetterRegex.test(pw) && numberRegex.test(pw) && specialCharRegex.test(pw) && lowercaseLetterRegex.test(pw)) {
        
                         document.getElementById("display_error").innerHTML = "";
                         document.getElementById("sbmt_form").disabled = false;
                     
                        
                        
                        
                    
                } else{
                    
                        document.getElementById("display_error").style.color = "Red";
                        document.getElementById("display_error").innerHTML = "<b>ERROR:</b> Invalid input! Please enter text that includes at least one capital letter, one number, one special character, and one lowercase letter.";
                        document.getElementById("sbmt_form").disabled = true;
                   
                }
            }else{
                document.getElementById("display_error").style.color = "Red";
                document.getElementById("display_error").innerHTML = "<b>ERROR:</b> Password and Confirm Password not matched.";
                document.getElementById("sbmt_form").disabled = true;
            }
        }
    
      function validateEmail() {
            var emailInput = document.getElementById('eml').value;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (emailRegex.test(emailInput)) {
                // document.getElementById("display_error_email").innerHTML = "";
                // document.getElementById("sbmt_form").disabled = false;
                  callPhpScript();
            } else {
                document.getElementById("display_error_email").style.color = "Red";
                document.getElementById("display_error_email").innerHTML = "<b>ERROR:</b> Invalid Email!";
                document.getElementById("sbmt_form").disabled = true;
            }
        }
        
        
    function callPhpScript() {
      var eml = document.getElementById('eml').value;


      $.ajax({
        type: 'POST',
        url: 'validate_email.php',
        data: { value: eml },
        dataType: 'json', // Expecting JSON response
        success: function(response) {
          displayResult(response, eml);
        },
        error: function(error) {
          console.error('Error:', error);
        }
      });
    }

    function displayResult(data, inputValue) {
          var resultContainer = document.getElementById('display_error_email');
            resultContainer.innerHTML = ''; // Clear previous results
            var check = 0;


      Object.keys(data).forEach(function(key) {
        if (data[key] == inputValue) {
            check = 1;
        }
      });
      
      if(check == 1){
          document.getElementById("display_error_email").style.color = "Red";
            document.getElementById("display_error_email").innerHTML = "<b>ERROR:</b> Email already taken.";
            document.getElementById("sbmt_form").disabled = true;
      }else{
         document.getElementById("display_error_email").innerHTML = "";
         document.getElementById("sbmt_form").disabled = false;
      }
    }
    
    
    function calculateAge() {
        const birthdateInput = document.getElementById('bday').value;
    
     
        if (!birthdateInput) {
            document.getElementById("display_error_bday").style.color = "Red";
            document.getElementById('display_error_bday').innerHTML = "<b>ERROR:<b> Please enter a valid birthdate."
            return;
        }
    
        const birthdate = new Date(birthdateInput);
        const today = new Date();
    
        let age = today.getFullYear() - birthdate.getFullYear();
    

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
    
    
    function selectServices(){
        var user_type = document.getElementById("user_type").value;
        if(user_type == "2"){
            document.getElementById("select_services").style.display = "block";
            document.getElementById("services").required = true;
        }else{
            document.getElementById("select_services").style.display = "none";
            document.getElementById("services").value = "";
            document.getElementById("services").required = false;
        }
    }
    

    </script>
    <!-- endinject -->
  </body>
</html>
