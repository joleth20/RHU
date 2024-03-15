<?php
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];
$fullname = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
?>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <!--<div class="search-field d-none d-md-block">-->
        <!--  <form  action="../RHU/?p=message" method="POST">-->
        <!--    <div class="input-group">-->
        <!--        <i class="input-group-text border-0 mdi mdi-magnify"></i>-->
        <!--      <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by">-->
        <!--        <option selected disabled>Search By...</option>-->
        <!--        <option value="msg_title">Subject</option>-->
        <!--        <option value="sent_by">Doctor</option>-->
        <!--      </select>-->
        <!--      <input type="text" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();">-->
        <!--    </div>-->
        <!--  </form>-->
        <!--</div>-->
        <h4 class="card-title">Message Summary</h4>
        <h6 class="font-weight-light">Feel free to send a concern or inquiry to your Doctor/Admin</h6>
         <div class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=message" method="post">
        <div class="input-group">
         <div class="mt-3">
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="window.top.location.href='../RHU/?p=newmessage';">Create New Message</button>
         </div>&nbsp;
         <div class="mt-3">
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('status_filter').value='Received';this.form.submit();">Received Message</button>
         </div>&nbsp;
         <div class="mt-3">
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_approved" onclick="document.getElementById('status_filter').value='Sent';this.form.submit();">Sent Message</button>
          </div>
        </div>
       </div>
          <input type="hidden" id="status_filter" name="status_filter">
        </form>
        <div class="table-responsive">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">

          <table class="table table-hover table-info" id="rhu_table" style="max-width:60%;">
            <thead>
              <tr>
                <?php
                    if (isset($_POST["status_filter"]) && $_POST["status_filter"] == "Sent"){?>
                        <th></th>
                        <th> Receiver </th>
                        <th> Subject </th>
                        <th> Date Sent </th>
                        <th> Time Sent </th>
                        <th>Action</th>
                 <?php }else{ ?>
                        <th></th>
                        <th> Sender </th>
                        <th> Subject </th>
                        <th> Date Received </th>
                        <th> Time Received </th>
                        <th> Status </th>
                        <th>Action</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>

                <?php
                include 'pages/view/config/dbconfig.php';
                if (isset($_POST["search"])) {
                  $search = $_POST["search"];
                  $search_by = $_POST["search_by"];
                  if ($user_type == 2) {
                    $sql = "SELECT * FROM message_details WHERE received_by = '$user_id' and $search_by LIKE '%$search%'";
                  }else{
                    $sql = "SELECT * FROM message_details WHERE $search_by LIKE '%$search%'";
                  }
                }else {
                    if (isset($_POST["status_filter"])) {
                        if($_POST["status_filter"] == "Received"){
                            $sql = "SELECT * FROM message_details WHERE received_by = '$user_id' and delete_received = '0' ORDER BY date_received DESC";
                        }elseif($_POST["status_filter"] == "Sent"){
                            $sql = "SELECT * FROM message_details WHERE sent_by = '$user_id' and delete_sent = '0' ORDER BY date_received DESC";
                        }
                    }else{
                        $sql = "SELECT * FROM message_details WHERE received_by = '$user_id' and delete_received = '0' ORDER BY msg_status DESC, date_received DESC";
                    }
                    
                        
                }
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows == 0) {
                    echo "No records found!";
                }else{
                  while($row=mysqli_fetch_assoc($result)){
                    if ($row["msg_status"] == "Unread") {
                        $status = "danger";
                      }else{
                        $status = "info";
                      }
                      
                    if(isset($_POST["status_filter"]) && $_POST["status_filter"] == "Sent"){
                        $received_by = $row["received_by"];
                        $sql_receivedBy = "SELECT * FROM user_details WHERE user_id = '$received_by'";
                        $result_receivedBy = mysqli_query($conn, $sql_receivedBy);
                        $user_receivedBy = mysqli_fetch_assoc($result_receivedBy);
                        $receivedBy_fullname = $user_receivedBy["fname"]." ".$user_receivedBy["mi"]." ".$user_receivedBy["lname"];
                        $profilepic_receivedBy = $user_receivedBy["profile_pic"];
                        
                        echo '<tr><td><div class="preview-thumbnail"><img src="assets/images/pp/'.$profilepic_receivedBy.'" alt="image" class="profile-pic"></div></td>';
                        echo '<td>'.$receivedBy_fullname.'</td>';
                        echo '<td>'.$row["msg_title"].'</td>';
                        echo '<td>'.$row["date_received"].'</td>';
                        echo '<td>'.$row["time_received"].'</td>';
                        echo '<td><form action="../RHU/?p=message_p" method="post">';
                        echo '<input type="hidden" name="msg_id" value="'.$row["msg_id"].'">';
                        ?>
                          <button  class="btn btn-inverse-primary btn-rounded btn-icon" title="Edit" onclick="document.getElementById('msg_value<?php echo $row["msg_id"];?>').value='View_Sent';this.form.submit();"><i class="mdi mdi-eye"></i></button>
                          <button  class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('msg_value<?php echo $row["msg_id"];?>').value='Delete_Sent';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                        <?php
                        echo '<input type="hidden" id="msg_value'.$row["msg_id"].'" name="msg_value">';
                        echo '<input type="hidden" id="msg_id" name="msg_id" value="'.$row["msg_id"].'">';
                        echo '<input type="hidden" name="msg_id" value="'.$row["msg_id"].'"></form></td></tr>';
                    }else{
                        $sent_by = $row["sent_by"];
                        $sql_sentBy = "SELECT * FROM user_details WHERE user_id = '$sent_by'";
                        $result_sentBy = mysqli_query($conn, $sql_sentBy);
                        $user_sentBy = mysqli_fetch_assoc($result_sentBy);
                        $sentBy_fullname = $user_sentBy["fname"]." ".$user_sentBy["mi"]." ".$user_sentBy["lname"];
                        $profilepic_sentBy = $user_sentBy["profile_pic"];
                        
                        echo '<tr><td><div class="preview-thumbnail"><img src="assets/images/pp/'.$profilepic_sentBy.'" alt="image" class="profile-pic"></div></td>';
                        echo '<td>'.$sentBy_fullname.'</td>';
                        echo '<td>'.$row["msg_title"].'</td>';
                        echo '<td>'.$row["date_received"].'</td>';
                        echo '<td>'.$row["time_received"].'</td>';
                        echo '<td><label class="badge badge-'.$status.'">'.$row["msg_status"].'</label></td>';echo '<td><form action="../RHU/?p=message_p" method="post">';
                        echo '<input type="hidden" name="msg_id" value="'.$row["msg_id"].'">';
                        ?>
                          <button  class="btn btn-inverse-primary btn-rounded btn-icon" title="Edit" onclick="document.getElementById('msg_value<?php echo $row["msg_id"];?>').value='View_Received';this.form.submit();"><i class="mdi mdi-eye"></i></button>
                          <button  class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('msg_value<?php echo $row["msg_id"];?>').value='Delete_Received';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                       <?php
                       echo '<input type="hidden" id="msg_value'.$row["msg_id"].'" name="msg_value">';
                       echo '<input type="hidden" id="msg_id" name="msg_id" value="'.$row["msg_id"].'">';
                       echo '<input type="hidden" name="msg_id" value="'.$row["msg_id"].'"></form></td></tr>';
                    }
                  }
                }

                ?>

            </tbody>
          </table>
          

        </div></div></div></div>
    
      </div>
    </div>
  </div>
</div>

<script src="assets/js/script.js"></script>


