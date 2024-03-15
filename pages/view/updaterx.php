<?php
$rx_id = $_POST["rx_id"];
if (!isset($rx_id)) {
  echo "<script>alert('Invalid Medication ID')</script>";
  echo "<script>window.top.location.href='../RHU/?p=rx';</script>";
}


$user_type = $_SESSION["user_type"];
include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM medication_refills WHERE rx_id = '$rx_id'";
$result = mysqli_query($conn, $sql);
$rx_details = mysqli_fetch_assoc($result);

//rx details
$rx_name = $rx_details["rx_name"];
$quantity = $rx_details["quantity"];
$dosage = $rx_details["dosage"];
$prescription = $rx_details["prescription"];
$doctor = $rx_details["doctor"];
$start_date = $rx_details["start_date"];
$end_date = $rx_details["end_date"];
$req_date = $rx_details["req_date"];
$req_time = $rx_details["req_time"];
$act_date = $rx_details["act_date"];
$act_time = $rx_details["act_time"];
$status = $rx_details["status"];
$user_id = $rx_details["user_id"];

if($status == "Completed"){
  $findings = $rx_details["findings"];
}else{
  $findings = "";
}

//user details
$sql1 = "SELECT * FROM user_details WHERE user_id = '$user_id'";
$result1 = mysqli_query($conn, $sql1);
$user_details = mysqli_fetch_assoc($result1);

$fullname = $user_details["fname"]." ".$user_details["mi"]." ".$user_details["lname"];
$age = $user_details["age"];
$gender = $user_details["gender"];
$bday = $user_details["bday"];
$contact_no = $user_details["contact_no"];
$eml = $user_details["eml"];
$phealth = $user_details["phealth"];
$address = $user_details["address_stblc"]." ".$user_details["address_brgy"]." ".$user_details["address_city"];
 ?>

<div class="row">
<div class="col-12 grid-margin">
<div class="card">
<div class="card-body">
 <div class="page-header">
   <h3 class="page-title">
     <span class="page-title-icon bg-primary text-white me-2">
       <i class="mdi mdi-account-multiple-plus"></i>
     </span> Medication
   </h3>
   <nav aria-label="breadcrumb">
     <ul class="breadcrumb">
       <!-- <li class="breadcrumb-item active" aria-current="page">
         <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
       </li> -->
       <button onclick="location.href = '../RHU/?p=rx';" class="btn btn-info btn-rounded btn-icon">
         <i class="mdi mdi-close"></i>
       </button>
     </ul>
   </nav>
 </div>
<div class="row">
    <form class="pt-3" action="../RHU/?p=updaterx_p" method="POST" autocomplete="off" enctype="multipart/form-data">

      <div id="patient_details" style="display: none">
        <h4>Patient Details</h4><br>
            <div class="form-group">
              <label for="fullname">Patient Name</label>
              <input type="text" class="form-control form-control-lg" id="fullname" name="fullname" value="<?php echo $fullname; ?>" >
            </div>
            <div class="form-group">
              <label for="age">Age</label>
              <input type="text" class="form-control form-control-lg" id="age" name="age" value="<?php echo $age; ?>" >
            </div>
            <div class="form-group">
              <label for="gender">Gender</label>
              <input type="text" class="form-control form-control-lg" id="gender" name="gender" value="<?php echo $gender; ?>" >
            </div>
            <div class="form-group">
              <label for="bday">Birthday</label>
              <input type="text" class="form-control form-control-lg" id="bday" name="bday" value="<?php echo $bday; ?>" >
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control form-control-lg" id="address" name="address" value="<?php echo $address; ?>" >
            </div>
            <div class="form-group">
              <label for="address">Email</label>
              <input type="text" class="form-control form-control-lg" id="eml" name="eml" value="<?php echo $eml; ?>" >
            </div>
            <div class="form-group">
              <label for="address">Contact No</label>
              <input type="text" class="form-control form-control-lg" id="contact_no" name="contact_no" value="<?php echo $contact_no; ?>" >
            </div>
            <div class="form-group">
              <label for="phealth">PhilHealth No.</label>
              <input type="text" class="form-control form-control-lg" id="phealth" name="phealth" value="<?php echo $phealth; ?>" >
            </div>
      </div>

      <h4>Medication details</h4><br>
      <div class="form-group">
        <label for="rx_name">Medicine Name</label>
        <input type="text" class="form-control form-control-lg" id="rx_name" name="rx_name" placeholder="Medicine Name" value="<?php echo $rx_name;?>" >
      </div>
      <div class="form-group">
        <label for="quantity">Quantity (Optional)</label>
        <input type="number" class="form-control form-control-lg" id="quantity" name="quantity" placeholder="Quantity"  value="<?php echo $quantity;?>">
      </div>
      <div class="form-group">
        <label for="dosage">Dosage (Optional)</label>
        <input type="text" class="form-control form-control-lg" id="dosage" name="dosage" placeholder="dosage"  value="<?php echo $dosage;?>">
      </div>

      <div class="form-group">
        <label for="prescription">Upload Prescription Receipt</label>
        <input type="hidden" name="prescription_backup" value="<?php echo $prescription;?>">
        <input type="file" class="form-control form-control-lg" id="prescription" name="prescription" onchange="file_upload();" accept=".pdf, image/*">
        <div id="display"><a href="../RHU/assets/images/receipt/<?php echo $prescription;?>" target="_blank">View Current Uploaded Receipt</a></div>
      </div>

      <div class="form-group">
        <label for="doctor">Doctor</label>
      <select class="form-control form-control-lg" id="doctor" name="doctor"  required style="color:black">
        <option disabled selected>--Select Doctor--</option>
      <?php
        include 'pages/view/config/dbconfig.php';
        $sql = "SELECT * FROM user_details WHERE user_type = '2'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
              $doctor_list = $row["fname"]." ".$row["mi"]." ".$row["lname"];
              $doctor_user_id = $row["user_id"];
              $selected_doctor = "";
              if ($doctor_user_id == $doctor) {
                $selected_doctor = "selected";
              }
              echo '<option '.$selected_doctor.' value="'.$doctor_user_id.'" style="color:black">'.$doctor_list.'</option>';
          }
        }else{
            echo "0 results";
        }

       ?>
     </select>
   </div>

    <h4>Medication Schedule</h4>
    <div class="form-group">
      <label for="start_date">Start Date</label>
      <input type="date" style="max-width:11%" class="form-control form-control-lg" id="start_date" name="start_date" value="<?php echo $start_date;?>" required >
    </div>
    <div class="form-group">
      <label for="end_date">End Date</label>
      <input type="date" style="max-width:11%" class="form-control form-control-lg" id="end_date" name="end_date" value="<?php echo $end_date;?>" required>
    </div>
    <div class="form-group">
     <label for="findings" id="findings_label">Findings</label>
     <textarea class="form-control" id="findings" name="findings" rows="4" <?php echo ($user_type == "2")?"required":"";?>><?php echo $findings; ?></textarea>
   </div>
         <input type="hidden" id="status" name="status" value="<?php echo $status; ?>">
         <input type="hidden" id="rx_id" name="rx_id" value="<?php echo $rx_id; ?>">
         <div class="input-group">
          <div class="mt-3">
            <input type="submit" id="rx_submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
          </div>&nbsp;
          <div class="mt-3">
          </div>
         </div>
    </form>
</div>
</div>
</div>
</div>
</div>
<script>

window.onload = rxView();

function file_upload(){
  var file = document.getElementById("prescription").files[0];
  var file_type = file.type.replace(/^.*[\\\/]/, '');
  if(file_type == "png" || file_type == "pdf" || file_type == "jpeg"){
    if(file.size > 1000000) {
      document.getElementById("display").style.color = "Red";
      document.getElementById("display").innerHTML = "<b>ERROR:</b> "+ file.name + " is to large, maximum file size is 1 MB.";
      document.getElementById("prescription").value = "";
    }else{
      document.getElementById("display").style.color = "Green";
      document.getElementById("display").innerHTML = "<b>&check;</b> " + file.name;
      }
  } else {
    document.getElementById("display").style.color = "Red";
    document.getElementById("display").innerHTML = "<b>ERROR:</b> "+ file.name + " file type is invalid. Please upload PDF or JPG/PNG file type only.";
    document.getElementById("prescription").value = "";
  }
}

function rxView(){
  var user_type = "<?php echo $user_type;?>";
  var status = "<?php echo $status;?>";
  if (user_type == "1") {
    if (status == "Pending") {
      //patient details
      document.getElementById("patient_details").style.display = "block";
      document.getElementById("fullname").disabled= "true";
      document.getElementById("age").disabled= "true";
      document.getElementById("gender").disabled= "true";
      document.getElementById("bday").disabled= "true";
      document.getElementById("address").disabled= "true";
      document.getElementById("contact_no").disabled= "true";
      document.getElementById("eml").disabled= "true";
      document.getElementById("phealth").disabled= "true";
      //rx details
      document.getElementById("rx_name").disabled= "true";
      document.getElementById("quantity").disabled= "true";
      document.getElementById("dosage").disabled= "true";
      document.getElementById("prescription").disabled= "true";
      document.getElementById("doctor").disabled= "true";
      document.getElementById("start_date").disabled= "true";
      document.getElementById("end_date").disabled= "true";
      document.getElementById("findings").disabled= "true";
      //submit button
      document.getElementById("rx_submit").disabled= "true";
      document.getElementById("rx_submit").style.display = "none";
    }else if (status == "Approved") {
      //patient details
      document.getElementById("patient_details").style.display = "block";
      document.getElementById("fullname").disabled= "true";
      document.getElementById("age").disabled= "true";
      document.getElementById("gender").disabled= "true";
      document.getElementById("bday").disabled= "true";
      document.getElementById("address").disabled= "true";
      document.getElementById("contact_no").disabled= "true";
      document.getElementById("eml").disabled= "true";
      document.getElementById("phealth").disabled= "true";
      //rx details
      document.getElementById("rx_name").disabled= "true";
      document.getElementById("quantity").disabled= "true";
      document.getElementById("dosage").disabled= "true";
      document.getElementById("prescription").disabled= "true";
      document.getElementById("doctor").disabled= "true";
      document.getElementById("start_date").disabled= "true";
      document.getElementById("end_date").disabled= "true";
      document.getElementById("findings").disabled= "true";
      
      //submit button
      document.getElementById("rx_submit").disabled= "true";
      document.getElementById("rx_submit").style.display = "none";
      
    }else if (status == "Completed") {
      //patient details
      document.getElementById("patient_details").style.display = "block";
      document.getElementById("fullname").disabled= "true";
      document.getElementById("age").disabled= "true";
      document.getElementById("gender").disabled= "true";
      document.getElementById("bday").disabled= "true";
      document.getElementById("address").disabled= "true";
      document.getElementById("contact_no").disabled= "true";
      document.getElementById("eml").disabled= "true";
      document.getElementById("phealth").disabled= "true";
      //rx details
      document.getElementById("rx_name").disabled= "true";
      document.getElementById("quantity").disabled= "true";
      document.getElementById("dosage").disabled= "true";
      document.getElementById("prescription").disabled= "true";
      document.getElementById("doctor").disabled= "true";
      document.getElementById("start_date").disabled= "true";
      document.getElementById("end_date").disabled= "true";
      document.getElementById("findings").disabled= "true";
      //submit button
      document.getElementById("rx_submit").disabled= "true";
      document.getElementById("rx_submit").style.display = "none";
    }else if (status == "Rejected") {
      //patient details
      document.getElementById("patient_details").style.display = "block";
      document.getElementById("fullname").disabled= "true";
      document.getElementById("age").disabled= "true";
      document.getElementById("gender").disabled= "true";
      document.getElementById("bday").disabled= "true";
      document.getElementById("address").disabled= "true";
      document.getElementById("contact_no").disabled= "true";
      document.getElementById("eml").disabled= "true";
      document.getElementById("phealth").disabled= "true";
      //rx details
      document.getElementById("rx_name").disabled= "true";
      document.getElementById("quantity").disabled= "true";
      document.getElementById("dosage").disabled= "true";
      document.getElementById("prescription").disabled= "true";
      document.getElementById("doctor").disabled= "true";
      document.getElementById("start_date").disabled= "true";
      document.getElementById("end_date").disabled= "true";
      document.getElementById("findings").disabled= "true";
      //submit button
      document.getElementById("rx_submit").disabled= "true";
      document.getElementById("rx_submit").style.display = "none";
    }
  }else if (user_type == "2" || user_type == "3") {
    if (status == "Pending") {
      //patient details
      document.getElementById("patient_details").style.display = "block";
      document.getElementById("fullname").disabled= "true";
      document.getElementById("age").disabled= "true";
      document.getElementById("gender").disabled= "true";
      document.getElementById("bday").disabled= "true";
      document.getElementById("address").disabled= "true";
      document.getElementById("contact_no").disabled= "true";
      document.getElementById("eml").disabled= "true";
      document.getElementById("phealth").disabled= "true";
      //rx details
      document.getElementById("rx_name").disabled= "true";
      document.getElementById("quantity").disabled= "true";
      document.getElementById("dosage").disabled= "true";
      document.getElementById("prescription").disabled= "true";
      document.getElementById("doctor").disabled= "true";
      document.getElementById("start_date").disabled= "true";
      document.getElementById("end_date").disabled= "true";
      document.getElementById("findings").disabled= "true";
      //submit button
      document.getElementById("rx_submit").disabled= "true";
      document.getElementById("rx_submit").style.display = "none";
    }else if (status == "Approved") {
      //patient details
      document.getElementById("patient_details").style.display = "block";
      document.getElementById("fullname").disabled= "true";
      document.getElementById("age").disabled= "true";
      document.getElementById("gender").disabled= "true";
      document.getElementById("bday").disabled= "true";
      document.getElementById("address").disabled= "true";
      document.getElementById("contact_no").disabled= "true";
      document.getElementById("eml").disabled= "true";
      document.getElementById("phealth").disabled= "true";
      //rx details
      document.getElementById("rx_name").disabled= "true";
      document.getElementById("quantity").disabled= "true";
      document.getElementById("dosage").disabled= "true";
      document.getElementById("prescription").disabled= "true";
      document.getElementById("doctor").disabled= "true";
      document.getElementById("start_date").disabled= "true";
      document.getElementById("end_date").disabled= "true";
      
    }else if (status == "Completed") {
      //patient details
      document.getElementById("patient_details").style.display = "block";
      document.getElementById("fullname").disabled= "true";
      document.getElementById("age").disabled= "true";
      document.getElementById("gender").disabled= "true";
      document.getElementById("bday").disabled= "true";
      document.getElementById("address").disabled= "true";
      document.getElementById("contact_no").disabled= "true";
      document.getElementById("eml").disabled= "true";
      document.getElementById("phealth").disabled= "true";
      //rx details
      document.getElementById("rx_name").disabled= "true";
      document.getElementById("quantity").disabled= "true";
      document.getElementById("dosage").disabled= "true";
      document.getElementById("prescription").disabled= "true";
      document.getElementById("doctor").disabled= "true";
      document.getElementById("start_date").disabled= "true";
      document.getElementById("end_date").disabled= "true";
      document.getElementById("findings").disabled= "true";
      //submit button
      document.getElementById("rx_submit").disabled= "true";
      document.getElementById("rx_submit").style.display = "none";
    }else if (status == "Rejected") {
      //patient details
      document.getElementById("patient_details").style.display = "block";
      document.getElementById("fullname").disabled= "true";
      document.getElementById("age").disabled= "true";
      document.getElementById("gender").disabled= "true";
      document.getElementById("bday").disabled= "true";
      document.getElementById("address").disabled= "true";
      document.getElementById("contact_no").disabled= "true";
      document.getElementById("eml").disabled= "true";
      document.getElementById("phealth").disabled= "true";
      //rx details
      document.getElementById("rx_name").disabled= "true";
      document.getElementById("quantity").disabled= "true";
      document.getElementById("dosage").disabled= "true";
      document.getElementById("prescription").disabled= "true";
      document.getElementById("doctor").disabled= "true";
      document.getElementById("start_date").disabled= "true";
      document.getElementById("end_date").disabled= "true";
      document.getElementById("findings").disabled= "true";
      //submit button
      document.getElementById("rx_submit").disabled= "true";
      document.getElementById("rx_submit").style.display = "none";
    }
  }else{
    if (status == "Approved") {
      //rx details
      document.getElementById("rx_name").disabled= "true";
      document.getElementById("quantity").disabled= "true";
      document.getElementById("dosage").disabled= "true";
      document.getElementById("prescription").disabled= "true";
      document.getElementById("doctor").disabled= "true";
      document.getElementById("start_date").disabled= "true";
      document.getElementById("end_date").disabled= "true";
      document.getElementById("findings").disabled= "true";
      
      document.getElementById("findings").style.display = "none";
      document.getElementById("findings_label").style.display = "none";
      //submit button
      document.getElementById("rx_submit").disabled= "true";
      document.getElementById("rx_submit").style.display = "none";
    }else if (status == "Pending" || status == "Rejected"){
       document.getElementById("findings").disabled= "true";
      document.getElementById("findings").style.display = "none";
      document.getElementById("findings_label").style.display = "none";
    }else if (status == "Completed") {
      //rx details
      document.getElementById("rx_name").disabled= "true";
      document.getElementById("quantity").disabled= "true";
      document.getElementById("dosage").disabled= "true";
      document.getElementById("prescription").disabled= "true";
      document.getElementById("doctor").disabled= "true";
      document.getElementById("start_date").disabled= "true";
      document.getElementById("end_date").disabled= "true";
      document.getElementById("findings").disabled= "true";
      //submit button
      document.getElementById("rx_submit").disabled= "true";
      document.getElementById("rx_submit").style.display = "none";
    }
  }

}

</script>
