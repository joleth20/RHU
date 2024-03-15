<?php
session_start();
date_default_timezone_set('Asia/Manila');
if ($_SESSION["dashboard"] == "") {
  session_destroy();
  header('Location: ../RHU');
}else {
  unset($_SESSION["verified"]);
}
// if ($_SESSION["verified"] == "0") {
//   header('Location: ../RHU/?p=otp');
// }
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
 ?>


<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RHU - Montalban</title>
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
    <link rel="stylesheet" href="assets/css/chart.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  </head>
  <body>
    <div class="container-scroller">

      <?php

          include 'nav_hor.php';
          echo '<div class="container-fluid page-body-wrapper">';
          include 'nav_ver.php';

      ?>

        <div class="main-panel">
          <div class="content-wrapper">

              <?php

              if ($_GET["p"] == "dashboard") {
                include 'dashboard.php';
              }

              if ($_GET["p"] == "dashboard_a") {
                include 'dashboard_admin.php';
              }

              if ($_GET["p"] == "analytics") {
                include 'analytics.php';
              }

              if ($_GET["p"] == "analytics_g") {
                include 'analytics_g.php';
              }

              if ($_GET["p"] == "analytics_m") {
                include 'analytics_m.php';
              }
              
              if ($_GET["p"] == "analytics_p") {
                include 'analytics_p.php';
              }

              if ($_GET["p"] == "reports_p") {
                include 'reports_p.php';
              }

              if ($_GET["p"] == "reports_d") {
                include 'reports_d.php';
              }

              if ($_GET["p"] == "reports_c") {
                include 'reports_c.php';
              }

              if ($_GET["p"] == "reports_m") {
                include 'reports_m.php';
              }

              if ($_GET["p"] == "newappt") {
                include 'newappt.php';
              }

              if ($_GET["p"] == "appt") {
                include 'appointments.php';
              }

              if ($_GET["p"] == "updateappt") {
                include 'updateappt.php';
              }

              if ($_GET["p"] == "newrx") {
                include 'newrx.php';
              }

              if ($_GET["p"] == "rx") {
                include 'rx.php';
              }

              if ($_GET["p"] == "updaterx") {
                include 'updaterx.php';
              }

              if ($_GET["p"] == "newsched") {
            		include 'pages/view/newsched.php';
            	}

              if ($_GET["p"] == "schedule") {
                include 'pages/view/sched.php';
              }

              if ($_GET["p"] == "updatesched") {
                include 'pages/view/updatesched.php';
              }

              if ($_GET["p"] == "rx_reminder") {
                include 'pages/view/rx_reminder.php';
              }

              if ($_GET["p"] == "account_mgmt") {
                include 'pages/view/account_mgmt.php';
              }

              if ($_GET["p"] == "new_account") {
                include 'pages/view/add_account.php';
              }

              if ($_GET["p"] == "update_account") {
                include 'pages/view/update_account.php';
              }

              if ($_GET["p"] == "update_password") {
                include 'pages/view/update_password.php';
              }

              if ($_GET["p"] == "newtemplate") {
                include 'pages/view/newtemp.php';
              }

              if ($_GET["p"] == "smstemplate") {
                include 'pages/view/smstemplate.php';
              }

              if ($_GET["p"] == "updatetemplate") {
                include 'pages/view/updatetemplate.php';
              }

              if ($_GET["p"] == "patient_records") {
                include 'pages/view/patient_records.php';
              }
              
              if ($_GET["p"] == "newmessage") {
                include 'pages/view/messagenew.php';
              }
              
              if ($_GET["p"] == "updatemessage") {
                include 'pages/view/updatemessage.php';
              }
              
              if ($_GET["p"] == "message") {
                include 'pages/view/message.php';
              }
              
              if ($_GET["p"] == "viewmessage") {
                include 'pages/view/messageview.php';
              }
              
              if ($_GET["p"] == "replymessage") {
                include 'pages/view/messagereply.php';
              }
              
              if ($_GET["p"] == "uploadpp") {
                include 'pages/view/upload_profilepic.php';
              }
              
              if ($_GET["p"] == "walkins") {
                include 'pages/view/walkins.php';
              }
              
              
              if ($_GET["p"] == "newwalkins") {
                include 'pages/view/newwalkins.php';
              }
              
               if ($_GET["p"] == "updatewalkins") {
                include 'pages/view/updatewalkins.php';
              }
              
              if ($_GET["p"] == "password_req") {
                include 'pages/view/password_req.php';
              }
              
              if ($_GET["p"] == "deletion_log") {
                include 'pages/view/deletion_log.php';
              }

               ?>

          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
              <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © RHU 2023</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>


  </body>
</html>