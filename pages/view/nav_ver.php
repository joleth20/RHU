<?php

$user_type = $_SESSION["user_type"];
$eml = $_SESSION["eml"];
include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM user_details WHERE eml = '$eml'";
$result = mysqli_query($conn, $sql);
$user_details = mysqli_fetch_assoc($result);
$profile_pic = $user_details["profile_pic"];

 ?>

<!-- partial:partials/_sidebar.php -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#profile" class="nav-link" data-bs-toggle="collapse">
        <div class="nav-profile-image">
          <img src="assets/images/pp/<?php echo $profile_pic;?>" alt="profile">
          <span class="login-status online"></span>

        </div>
         <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2"><?php echo $_SESSION["fname"];?></span>
          <span class="text-secondary text-small">Edit Profile</span>

        </div>
       <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
      <div class="collapse" id="profile">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=uploadpp">Upload Profile Picture</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=update_profile_p">Update Profile</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=update_profilepassword_p">Change Password</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=logout">Logout</a></li>
        </ul>
      </div>
    </li>
    
      <?php
        if ($user_type == 2 || $user_type == 3 || $user_type == 4) {
       ?>
       <li class="nav-item">
          <a class="nav-link" href="../RHU/?p=dashboard">
            <span class="menu-title">Dashboard</span>
            <i class="mdi mdi mdi-view-dashboard menu-icon"></i>
          </a>
        </li>
    <?php } else{ ?>
    <li class="nav-item">
      <a class="nav-link" href="../RHU/?p=dashboard_a">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi mdi-view-dashboard menu-icon"></i>
      </a>
     </li>
     <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#analytics" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Analytics</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi mdi-chart-bar menu-icon"></i>
      </a>
      <div class="collapse" id="analytics">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=analytics">By Services</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=analytics_g">By Gender</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=analytics_m">Medication</a></li>
        </ul>
      </div>
      </li>
      <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Reports</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi mdi-file-document-box menu-icon"></i>
      </a>
      <div class="collapse" id="reports">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=reports_p">Patients</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=reports_d">Doctors</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=reports_c">Consultation</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=reports_m">Medication Refills</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=deletion_log">Deletion Log</a></li>
        </ul>
      </div>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="../RHU/?p=rx_reminder">
        <span class="menu-title">RX Reminder</span>
        <i class="mdi mdi mdi-bell-ring menu-icon"></i>
      </a>
      </li>
      <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#accountmgmt" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Account Mgmt</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi mdi-file-document-box menu-icon"></i>
      </a>
      <div class="collapse" id="accountmgmt">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=new_account">New Account</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=account_mgmt">Accounts Summary</a></li>
        </ul>
      </div>
      </li>
      

      <li class="nav-item">
      <a class="nav-link" href="../RHU/?p=smstemplate">
        <span class="menu-title">SMS Template Summary</span>
        <i class="mdi mdi mdi-account-multiple menu-icon"></i>
      </a>
    </li>

  <?php  } ?>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#consultation" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Consultation</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi mdi-account-multiple-plus menu-icon"></i>
      </a>
      <div class="collapse" id="consultation">
        <ul class="nav flex-column sub-menu">
          <?php
            if ($user_type == "4") {
           ?>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=newappt">New Appointment</a></li>
        <?php } ?>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=appt">Appointment Summary</a></li>
          <?php
            if ($user_type == "1") {
           ?>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=walkins">Walk-ins Summary</a></li>
          <?php } ?>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#medication" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Medication</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi mdi-hospital menu-icon"></i>
      </a>
      <div class="collapse" id="medication">
        <ul class="nav flex-column sub-menu">
          <?php
            if ($user_type == "4") {
           ?>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=newrx">New Medication</a></li>
        <?php }?>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=rx">Medication Summary</a></li>
        </ul>
      </div>
    </li>
    <?php
    if ($user_type == "2") {
    ?>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#schedule" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Schedule</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi mdi-calendar menu-icon"></i>
      </a>

      <div class="collapse" id="schedule">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=newsched">New Schedule</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=schedule">Schedule Summary</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#smstemplate" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">SMS Template</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-comment-processing-outline menu-icon"></i>
      </a>

      <div class="collapse" id="smstemplate">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=newtemplate">New SMS Template</a></li>
          <li class="nav-item"> <a class="nav-link" href="../RHU/?p=smstemplate">SMS Template Summary</a></li>
        </ul>
      </div>
     </li>
     <li class="nav-item">
      <a class="nav-link" href="../RHU/?p=patient_records">
        <span class="menu-title">Patient Records</span>
        <i class="mdi mdi mdi-account-multiple menu-icon"></i>
      </a>
    </li>

      <?php  }
      
      
      ?>
    
    <!-- <li class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title">Profile</span>
        <i class="mdi mdi mdi-account menu-icon"></i>
      </a>
    </li> -->

  </ul>
</nav>
<!-- partial -->
