<?php
session_start();
if ($_SESSION["verified"] == "") {
  header('Location: ../RHU/?p=login');
}

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RHU - Account Verification</title>
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
                <h4>Account Verification</h4>
                <form class="pt-3" action="../RHU/?p=otp_p" method="POST" autocomplete="off">
                  <div class="form-group">
                    Please enter 6 Digit verification code sent to your Mobile Number
                    <input type="text" class="form-control form-control-lg" id="otp" name="otp" placeholder="* * * * * *">
                  </div>
                  <div class="mt-3">
                    <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <a href="../RHU/?p=otp_r" class="auth-link text-black">Resend Code?</a>
                  </div>

                  <div class="text-center mt-4 font-weight-light"><a href="../RHU/?p=logout" class="text-primary">Logout</a>
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

    <!-- endinject -->
  </body>
</html>
