<?php
date_default_timezone_set('Asia/Manila');

?>

<!-- partial:partials/_navbar.php -->
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row bg-primary">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center bg-primary">
    <a class="navbar-brand brand-logo" href="../RHU/"><img src="assets/images/rhu_logo.png" alt="logo" /><h6 class="text-white">RHU Montalban</h6></a>
    <a class="navbar-brand brand-logo-mini" href="../RHU/"><img src="assets/images/rhu_logo.png" alt="logo" /></a>

    <!--<h2>RHU</h2>-->
    <!--<h2><i class="mdi mdi-hospital brand-logo"></i></h2>-->
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center text-white" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>

    <ul class="navbar-nav navbar-nav-right">
      <!-- <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img">
            <img src="assets/images/faces/face27.jpg" alt="image">
            <span class="availability-status online"></span>
          </div>
          <div class="nav-profile-text">
            <p class="mb-1 text-black"></p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="#">
            <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
        </div>
      </li> -->
      <li class="nav-item d-none d-lg-block full-screen-link text-white">
        <a class="nav-link">
          <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
        </a>
      </li>
       <li class="nav-item dropdown text-white">
        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-email-outline"></i>
          <?php
            
            $user_id = $_SESSION["user_id"];
            include 'pages/view/config/dbconfig.php';
            $sql = "SELECT * FROM message_details WHERE received_by = '$user_id' and delete_received = '0' and msg_status = 'Unread' ORDER BY date_received DESC";
            $result = mysqli_query($conn, $sql);
            if (!$result->num_rows == 0) {
                echo '<span class="count-symbol bg-warning"></span>';
            }
          ?>
          
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          <h6 class="p-3 mb-0">Messages</h6>
          
          <?php
            
            include 'pages/view/config/dbconfig.php';
            $sql2 = "SELECT * FROM message_details WHERE received_by = '$user_id' and delete_received = '0' and msg_status = 'Unread' ORDER BY date_received DESC";
            $result2 = mysqli_query($conn, $sql2);
            if ($result2->num_rows == 0) {
                echo '<div class="preview-item-content d-flex align-items-start flex-column justify-content-center"><h6 class="preview-subject ellipsis mb-1 font-weight-normal">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNo new messages</h6></div>';
            }else{
                while($row=mysqli_fetch_assoc($result2)){
                  
                    $sent_by = $row["sent_by"];
                    $sql_sentBy = "SELECT * FROM user_details WHERE user_id = '$sent_by'";
                    $result_sentBy = mysqli_query($conn, $sql_sentBy);
                    $user_sentBy = mysqli_fetch_assoc($result_sentBy);
                    $sentBy_fname = $user_sentBy["fname"];
                    $profilepic_sentBy = $user_sentBy["profile_pic"];
                ?>
          <div class="dropdown-divider"></div>   
          <a class="dropdown-item preview-item" onclick="document.getElementById('msg_id').value='<?php echo $row["msg_id"];?>'; document.getElementById('msg_form').submit();">
            <div class="preview-thumbnail">
              <img src="assets/images/pp/<?php echo $profilepic_sentBy; ?>" alt="image" class="profile-pic">
            </div>
            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                
              <h6 class="preview-subject ellipsis mb-1 font-weight-normal"><?php echo $sentBy_fname;?> send you a message</h6>
              <p class="text-gray mb-0">
                 <?php
                      $startTime = new DateTime($row["date_received"]." ".$row["time_received"]);
                      $currentDate = new DateTime();
                      $timeDifference = $currentDate->diff($startTime);
                      if ($timeDifference->d > 0) {
                        echo $timeDifference->d . ' day' . ($timeDifference->d > 1 ? 's' : '') . ' ago';
                      } elseif ($timeDifference->h > 0) {
                        echo $timeDifference->h . ' hour' . ($timeDifference->h > 1 ? 's' : '') . ' ago';
                      } elseif ($timeDifference->i > 0) {
                        echo $timeDifference->i . ' minute' . ($timeDifference->i > 1 ? 's' : '') . ' ago';
                      } else {
                        echo $timeDifference->s . ' second' . ($timeDifference->s > 1 ? 's' : '') . ' ago';
                      }
                ?> 
              </p>
            </div>
          </a>
          <?php }} ?>
          
          <a href="../RHU/?p=message" class=:""><h6 class="p-3 mb-0 text-center">See all messages</h6></a>
        </div>
      </li>
      
      <form id="msg_form" action="../RHU/?p=message_p" method="post">
        <input type="hidden" id="msg_id" name="msg_id">
        <input type="hidden"name="msg_value" value="View_Received">
      </form>
      <?php
        $user_id = $_SESSION["user_id"];
        $user_type = $_SESSION["user_type"];
        include 'pages/view/config/dbconfig.php';
        
        if($user_type == 2){
            $sql = "SELECT * FROM notification WHERE fullname = '$user_id' and notif_status = '1' and user_type = '2'";
        }elseif($user_type == 1 || $user_type == 3){
            $sql = "SELECT * FROM notification WHERE notif_status = '1' AND user_type = '2' ORDER BY notif_id DESC LIMIT 5";
        }elseif($user_type == 4){
            $sql = "SELECT * FROM notification WHERE fullname = '$user_id' and notif_status = '1' and user_type = '4' ORDER BY notif_id DESC";
        }else{
             $sql = "SELECT * FROM notification WHERE fullname = '$user_id' and notif_status = '1'";
        }
        
        
        
        
        $result = mysqli_query($conn, $sql );




       ?>
      <li class="nav-item dropdown text-white">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
          <i class="mdi mdi-bell-outline"></i>
          <?php
              if ($result->num_rows > 0) {
                echo '<span class="count-symbol bg-danger"></span>';
              }
           ?>

        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" style="margin-left:-20px">
          <h6 class="p-3 mb-0">Notifications</h6>

          <?php
            if($result){
            while($row=mysqli_fetch_assoc($result)){

           ?>
          <div class="dropdown-divider"></div>

          <a class="dropdown-item preview-item" onclick="document.getElementById('notif<?php echo $row["notif_id"]; ?>').submit()" >
            <div class="preview-thumbnail">
                <?php
                if ($row["status"]=="Approved") {
                  echo '<div class="preview-icon bg-success">';
                }elseif ($row["status"]=="Rejected") {
                  echo '<div class="preview-icon bg-danger">';
                }else{
                  echo '<div class="preview-icon bg-warning">';
                }


                if ($row["notif_type"] == "Appointment") {
                   echo '<i class="mdi mdi-calendar"></i>';
                }else {
                   echo '<i class="mdi mdi-hospital"></i>';
                } ?>

              </div>
            </div>
            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
              <h6 class="preview-subject font-weight-normal mb-1"><?php echo $row["notif_type"]." ID ".$row["id"];?></h6>
              <p class="text-gray ellipsis mb-0"><?php echo $row["status"];?></p>
            </div>
          </a>
          <form id="notif<?php echo $row["notif_id"]; ?>" method="post" action="../RHU/?p=notification_p">
            <input type="hidden" name="notif_status" value="0">
            <input type="hidden" name="notif_id" value="<?php echo $row["notif_id"];?>">
            <input type="hidden" name="notif_link" value="<?php echo $row["notif_link"];?>">
          </form>
        <?php }} ?>


          <!-- <div class="dropdown-divider"></div>
          <h6 class="p-3 mb-0 text-center">See all notifications</h6> -->
        </div>
      </li>
      <li class="nav-item nav-logout d-none d-lg-block text-white">
        <a class="nav-link" href="../RHU/?p=logout">
          <i class="mdi mdi-power"></i>
        </a>
      </li>
      <li class="nav-item nav-settings d-none d-lg-block text-white">
        <a class="nav-link" href="">
          <i class="mdi mdi-format-line-spacing"></i>
        </a>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center text-white" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
<!-- partial -->
