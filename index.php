<?php

date_default_timezone_set('Asia/Manila');
// if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
// 	$uri = 'https://';
// } else {
// 	$uri = 'http://';
// }
// $uri .= $_SERVER['HTTP_HOST'];
// header('Location: '.$uri.'/RHU/pages/view/login.php/');
// exit;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
header("Strict-Transport-Security:max-age=31536000; includeSubDomains; preload");
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header("X-Frame-Options: DENY");
header("Referrer-Policy: no-referrer");
header("X-Content-Type-Options: nosniff");

    
    	if ($_GET["p"] == "") {
    	  header('Location: ../RHU/?p=login');
    	}
    
    	if ($_GET["p"] == "dashboard" || $_GET["p"] == "dashboard_a" || $_GET["p"] == "analytics" || $_GET["p"] == "analytics_g" || $_GET["p"] == "analytics_m" || $_GET["p"] == "analytics_p" || $_GET["p"] == "reports_p" || $_GET["p"] == "reports_d" || $_GET["p"] == "reports_c" || $_GET["p"] == "reports_m" || $_GET["p"] == "rx_reminder" || $_GET["p"] == "account_mgmt" || $_GET["p"] == "new_account" || $_GET["p"] == "update_account" || $_GET["p"] == "update_password" || $_GET["p"] == "newtemplate" || $_GET["p"] == "smstemplate" || $_GET["p"] == "updatetemplate" || $_GET["p"] == "patient_records" || $_GET["p"] == "newmessage" || $_GET["p"] == "replymessage" || $_GET["p"] == "message" ||  $_GET["p"] == "viewmessage" || $_GET["p"] == "uploadpp" || $_GET["p"] == "newappt" || $_GET["p"] == "appt" || $_GET["p"] == "updateappt" || $_GET["p"] == "newrx" || $_GET["p"] == "rx" || $_GET["p"] == "updaterx" || $_GET["p"] == "newsched" || $_GET["p"] == "schedule" || $_GET["p"] == "updatesched" || $_GET["p"] == "walkins" || $_GET["p"] == "newwalkins" || $_GET["p"] == "updatewalkins" || $_GET["p"] == "password_req" || $_GET["p"] == "deletion_log") {
    		include 'pages/view/index.php';
    	}
    
    	if ($_GET["p"] == "login") {
    	  include 'pages/view/login.php';
    	}
    
    	if ($_GET["p"] == "logout") {
    	  include 'pages/view/logout.php';
    	}
    
    	if ($_GET["p"] == "login_p") {
    	  include 'pages/view/controller/login_process.php';
    	}
    
    	if ($_GET["p"] == "register") {
    	  include 'pages/view/register.php';
    	}
    
    	if ($_GET["p"] == "register_p") {
    	  include 'pages/view/controller/register_process.php';
    	}
    
    	if ($_GET["p"] == "otp") {
    	  include 'pages/view/otp.php';
    	}
    
    	if ($_GET["p"] == "otp_p") {
    	  include 'pages/view/controller/otp_p.php';
    	}
    
    	if ($_GET["p"] == "otp_r") {
    		include 'pages/view/controller/otp_generator.php';
    	}
    
    	if ($_GET["p"] == "reset") {
    		include 'pages/view/resetpw_email.php';
    	}
    
    	if ($_GET["p"] == "reset_p") {
    		include 'pages/view/controller/resetpw_email_process.php';
    	}
    
    	if ($_GET["p"] == "newpass") {
    		include 'pages/view/newpass.php';
    	}
    
    	if ($_GET["p"] == "newpass_p") {
    		include 'pages/view/controller/newpass_process.php';
    	}
    
    	if ($_GET["p"] == "newappt_p") {
    		include 'pages/view/controller/newappt_process.php';
    	}
    
    	if ($_GET["p"] == "updateappt_p") {
    		include 'pages/view/controller/updateappt_process.php';
    	}
    
    	if ($_GET["p"] == "apptapproval_p") {
    		include 'pages/view/controller/apptapproval_process.php';
    	}
    
    	if ($_GET["p"] == "notify") {
    		include 'pages/view/controller/SMSApi.php';
    	}
    
    	if ($_GET["p"] == "newrx_p") {
    		include 'pages/view/controller/newrx_process.php';
    	}
    
    	if ($_GET["p"] == "updaterx_p") {
    		include 'pages/view/controller/updaterx_process.php';
    	}
    
    	if ($_GET["p"] == "rxapproval_p") {
    		include 'pages/view/controller/rxapproval_process.php';
    	}
    
    	if ($_GET["p"] == "newsched_p") {
    		include 'pages/view/controller/newsched_process.php';
    	}
    
    	if ($_GET["p"] == "sched_p") {
    		include 'pages/view/controller/sched_process.php';
    	}
    
    	if ($_GET["p"] == "updatesched_p") {
    		include 'pages/view/controller/updatesched_process.php';
    	}
    
    	if ($_GET["p"] == "reports_p_export") {
    		include 'pages/view/controller/reports_p_export.php';
    	}
    
    	if ($_GET["p"] == "reports_c_export") {
    		include 'pages/view/controller/reports_c_export.php';
    	}
    
    	if ($_GET["p"] == "reports_d_export") {
    		include 'pages/view/controller/reports_d_export.php';
    	}
    
    	if ($_GET["p"] == "reports_m_export") {
    		include 'pages/view/controller/reports_m_export.php';
    	}
    
    	if ($_GET["p"] == "account_mgmt_p") {
    		include 'pages/view/controller/account_mgmt_process.php';
    	}
    
    	if ($_GET["p"] == "add_account_p") {
    		include 'pages/view/controller/add_account_process.php';
    	}
    
    	if ($_GET["p"] == "update_account_p") {
    		include 'pages/view/controller/update_account_process.php';
    	}
    
    	if ($_GET["p"] == "update_profilepassword_p") {
    		include 'pages/view/controller/update_profilepassword_process.php';
    	}
    
    	if ($_GET["p"] == "update_profile_p") {
    		include 'pages/view/controller/update_profile_process.php';
    	}
    
    	if ($_GET["p"] == "newtemplate_p") {
    		include 'pages/view/controller/newtemplate_process.php';
    	}
    
    	if ($_GET["p"] == "smstemplate_p") {
    		include 'pages/view/controller/smstemplate_process.php';
    	}
    
    	if ($_GET["p"] == "updatetemplate_p") {
    		include 'pages/view/controller/updatetemplate_process.php';
    	}
    
    	if ($_GET["p"] == "patient_records_p") {
    		include 'pages/view/controller/patient_records_process.php';
    	}
    
    	if ($_GET["p"] == "notification_p") {
    		include 'pages/view/controller/notification_process.php';
    	}
    	
    	if ($_GET["p"] == "message_p") {
    		include 'pages/view/controller/message_process.php';
    	}
    	
    	if ($_GET["p"] == "termsandconditions") {
    		include 'pages/view/p_terms.php';
    	}
    	
    	if ($_GET["p"] == "dataprivacy") {
    		include 'pages/view/p_privacy.php';
    	}
    	
    	if ($_GET["p"] == "newwalkins_p") {
    		include 'pages/view/controller/newwalkins_process.php';
    	}
    	
    	if ($_GET["p"] == "updatewalkins_p") {
    		include 'pages/view/controller/updatewalkins_process.php';
    	}

    	
    	if ($_GET["p"] == "error404") {
    		include 'pages/view/error404.php';
    	}
    	
    	if ($_GET["p"] == "error500") {
    		include 'pages/view/error500.php';
    	}
    	
    	if ($_GET["p"] == "password_req_p") {
    		include 'pages/view/controller/password_req_process.php';
    	}
    	
    	if ($_GET["p"] == "deletion_log_p") {
    		include 'pages/view/controller/deletion_log_export.php';
    	}
    	

?>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/apostrophe.js"></script>
    <!-- End custom js for this page -->
<!-- Something is wrong with the XAMPP installation :-( -->
<!--Add the following script at the bottom of the web page (before </body></html>)-->

