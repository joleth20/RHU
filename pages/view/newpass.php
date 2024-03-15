<?php
session_start();
if ($_SESSION["newpass"] == "") {
  header('Location: ../RHU/?p=login');
}
 ?>

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
    <link rel="shortcut icon" href="" />
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
                <h4>Create New Password</h4>
                <form class="pt-3" action="../RHU/?p=newpass_p" method="POST" autocomplete="off">
                  <div class="form-group" >
                    <h4>Your Password Must Contain the following:</h4>
                    <ul><li>At Least 8 characters</li>
                    <li>At Least 1 Number</li>
                    <li>At Least 1 Capital Letter</li>
                    <li>At Least 1 Lowercase Letter</li>
                    <li>At Least 1 Special Character (Ex.@#~?)</li></ul>
                    <div id="display_error"></div>
                    <h6 class="font-weight-light">New Password</h6>
                    <input type="password" class="form-control form-control-lg" id="pw" name="pw" placeholder="New Password" required onchange="validateInput()">
                  </div>
                  <div class="form-group" >
                    <h6 class="font-weight-light">Confirm Password</h6>
                    <input type="password" class="form-control form-control-lg" id="cpw" name="cpw" placeholder="Confirm Password" required onchange="validateInput()">
                  </div>
                  <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input" onclick="showHide()">Show Password </label>
                    </div>
                  </div>
                  <div class="mt-3">
                    <input type="submit" id="sbmt_form" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
                    <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='../RHU/?p=sched'";">Back to Login</button>
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
    </script>
    <!-- endinject -->
  </body>
</html>
