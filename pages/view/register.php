<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RHU - Patient Registration</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo text-center">
                  <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                  <img src="assets/images/rhu_logo.png">
                  <div class="display-5 text-center">RHU Montalban</div>
                </div>
                <h6 class="font-weight-light">Patient Registration</h6>
                <form class="pt-3" action="../RHU/?p=register_p" method="POST" autocomplete="off" onkeydown="return event.key != 'Enter';">
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
                      <option disabled selected>--Select Gender--</option>
                      <option value="m" style="color:black">Male</option>
                      <option value="f" style="color:black">Female</option>
                      <option value="Others" style="color:black">Others</option>
                      <option value="Prefer not to say" style="color:black">Prefer not to say</option>
                      
                    </select>
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Address</h6>
                    <div id="display_error_address"></div>
                    <input type="text" class="form-control form-control-lg" id="address_stblc" name="address_stblc" placeholder="House # / Block / Lot / Street" required onchange="checkMinimumCharacters()">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="address_brgy" name="address_brgy" placeholder="Barangay" required onchange="checkMinimumCharacters()">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="address_city" name="address_city" placeholder="City" required onchange="checkMinimumCharacters()">
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">Contact Number (11 digits)</h6>
                    <input type="number" class="form-control form-control-lg" id="contact_no" name="contact_no" placeholder="Contact Number 09XXXXXXXXX" required>
                  </div>
                  <div class="form-group">
                    <h6 class="font-weight-light">PhilHealth Number (Optional)</h6>
                    <input type="number" class="form-control form-control-lg" id="phealth" name="phealth" placeholder="Philhealth Number">
                  </div>
                  <div class="form-group">
                    <h4>Login Account Information</h4>
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
                
                  <h6 class="font-weight-light">By clicking Register, you agree on our <a href="?p=termsandconditions" target="_blank">Terms & Conditions</a> and <a href="?p=dataprivacy" target="_blank">Data Privacy Policy</a></h6>
                  <div class="mt-3">
                    <input type="submit" id="sbmt_form" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" value="Register">
                  </div>
                  <div class="text-center mt-4 font-weight-light"><h6 class="font-weight-light"> Already have an account? <a href="../RHU/?p=login" class="text-primary">Login</a></h6>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
  </body>
</html>
