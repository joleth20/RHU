<?php

// Set session cookie parameters with the 'secure' flag
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,  // Set the secure flag
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

if ($_SERVER['HTTPS']) {
    // Check if the request is made over HTTPS
    $params = session_get_cookie_params();
    session_set_cookie_params($params['lifetime'], $params['path'], $params['domain'], true, true);
}
$session_dashboard = $_SESSION["dashboard"];

    if ($session_dashboard == "on") {
        if($_SESSION["user_type"] == 1){
            header('Location: ../RHU/?p=dashboard_a');
        }else{
            header('Location: ../RHU/?p=dashboard');
        }
    }


 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RHU - Login</title>
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
                
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <form class="pt-3" action="../RHU/?p=login_p" method="POST" autocomplete="off">
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" id="un" name="un" placeholder="example@gmail.com">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="pw" name="pw" placeholder="Password">
                  </div>
                  <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input" onclick="showHide()">Show Password </label>
                    </div>
                  </div>
                  <div class="mt-3">

                    <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <a href="../RHU/?p=reset" class="auth-link text-black">Forgot password?</a>
                  </div>

                  <div class="text-center font-weight-light"><h6 class="font-weight-light"> New Patient? <a href="../RHU/?p=register" class="text-primary">Sign up here</a></h6>
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
      if (pw.type === "password" ) {
        pw.type = "text";
      } else {
        pw.type = "password";
      }
    }
    </script>
    <!-- endinject -->
  </body>
</html>
