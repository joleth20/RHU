<?php

$sender = $_SESSION["user_id"];


?>


<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-primary text-white me-2">
      <i class="mdi mdi-message-text"></i>
    </span> View Message
  </h3>
  <nav aria-label="breadcrumb">
    <!-- <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ul> -->
    <button onclick="location.href = '../RHU/?p=message';" class="btn btn-info btn-rounded btn-icon">
      <i class="mdi mdi-close"></i>
    </button>
  </nav>
</div>
 <div class="col-lg-4">
 <div class="auth-form-light text-left p-5">

   <h4>Message Details</h4>
   <form class="pt-3" action="../RHU/?p=message_p" method="POST" autocomplete="off">
     <div class="form-group" >
       <h6 class="font-weight-light">Send To:</h6>
       <select class="form-control form-control-lg" id="received_by" name="received_by"  required style="color:black" >
          <option value="" disabled selected>--Select Recipient--</option>
       <?php
              include 'pages/view/config/dbconfig.php';
              $sql = "SELECT * FROM user_details WHERE user_type = '2' or user_type = '1' ORDER BY services";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $doctor = $row["fname"]." ".$row["mi"]." ".$row["lname"];
                    $user_id = $row["user_id"];
                    $services = $row["services"];
                    if($services == ""){
                        $services = "Administrator";
                    }else{
                        $services = $row["services"];
                    }
                    echo '<option value="'.$user_id.'" style="color:black">'.$services. ' - ' .$doctor.'</option>';
                }
              }else{
                  echo "0 results";
              }
        ?>
        </select>
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">Subject</h6>
       <select class="form-control form-control-lg" id="msg_title" name="msg_title"  required style="color:black" >
          <option value="" disabled selected>--Select Concern/Inquiry--</option>
          <option value="Appointment" >Appointment</option>
          <option value="Consultation" >Consultation</option>
          <option value="Medication Refills" >Medication Refills</option>
          <option value="Patient Account Issue" >Patient Account Issue</option>
          <option value="Others" >Others</option>
      
        </select>
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">Message Content</h6>
       <textarea class="form-control form-control-lg" id="msg_content" name="msg_content" placeholder="Enter Message Content..." required style="height:200px"></textarea>
     </div>
     <div class="input-group">
     <div class="mt-3">
       <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" value="Send">
     </div>&nbsp;
     <div class="mt-3">
       <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='../RHU/?p=message';">Cancel</button>
     </div>
    </div>
    <input type="hidden" name="sent_by" value="<?php echo $sender;?>">
    <input type="hidden" name="msg_value" value="New">
   </form>
    </div>
 </div>
 
 <script>
     const inputElements = document.querySelectorAll('.form-control');

    // Attach the event listener to each input element
    inputElements.forEach(input => {
      input.addEventListener('input', function() {
        // Get the current value of the input
        let inputValue = this.value;

        // Check if the input contains an apostrophe
        if (inputValue.includes("'")) {
          // If apostrophe found, remove it from the input value
          inputValue = inputValue.replace(/'/g, '');

          // Update the input value without apostrophes
          this.value = inputValue;
        }
      });
    });
 </script>
