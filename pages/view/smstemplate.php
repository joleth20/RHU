<?php
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];
$doctor_fullname = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
if ($user_type == "4" || $user_type == "3") {
  echo "<script>alert('You are not allowed to access this page.')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";

}
?>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        
        <div id="filter_pc">
          <form  action="../RHU/?p=smstemplate" method="POST">
            <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                  <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by" >
                    <option selected disabled>Search By...</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="sms_id")?"selected":"";?> value="sms_id">SMS ID</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="sms_title")?"selected":"";?> value="sms_title">SMS Title</option>
                  </select>
                <input type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">
                <label><a class="form-control bg-transparent border-0 text-muted" href="../RHU/?p=smstemplate" title="Clear">Clear filter</a></label>
            </div>
          </form>
       </div>
       
       <div id="filter_mobile">
          <form  action="../RHU/?p=smstemplate" method="POST">
             <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                  <select type="text"  class="form-control bg-transparent " placeholder="Search projects" name="search_by" >
                    <option selected disabled>Search By...</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="sms_id")?"selected":"";?> value="sms_id">SMS ID</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="sms_title")?"selected":"";?> value="sms_title">SMS Title</option>
                  </select></div>
                   <div class="input-group">
                <input type="text" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">
                <label><a class="form-control bg-transparent border-0 text-muted" href="../RHU/?p=smstemplate"><i class="mdi mdi-close-circle"></i></a></label>  </div>
          
          </form>
       </div>
        <div class="table-responsive">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">

          <table class="table table-hover" id="rhu_table" style="max-width:60%;">
            <thead>
              <tr>
                <th> SMS ID </th>
                <th> SMS Title </th>
                <th> SMS Content </th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

                <?php
                include 'pages/view/config/dbconfig.php';
                if (isset($_POST["search"])) {
                  $search = $_POST["search"];
                  $search_by = $_POST["search_by"];
                  if($user_type == "1"){
                     $sql = "SELECT * FROM sms_template WHERE $search_by LIKE '%$search%'"; 
                  }else{
                    $sql = "SELECT * FROM sms_template WHERE user_id = '$user_id' and $search_by LIKE '%$search%'";
                  }
                }else{
                  if($user_type == "1"){
                     $sql = "SELECT * FROM sms_template"; 
                  }else{
                  $sql = "SELECT * FROM sms_template WHERE user_id = '$user_id'";
                  }
                }
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows == 0) {
                    echo "No records found!";
                }else{
                  while($row=mysqli_fetch_assoc($result)){
                    echo '<tr><td>'.$row["sms_id"].'</td>';
                    echo '<td>'.$row["sms_title"].'</td>';
                    echo '<td><textarea class="form-control form-control-lg" readonly>'.$row["sms_content"].'</textarea></td>';

                    echo '<td><form action="../RHU/?p=smstemplate_p" method="post">';
                    if($user_type == 2){
                  ?>
                    
                    <button  class="btn btn-inverse-primary btn-rounded btn-icon" title="Edit" onclick="document.getElementById('sms_value<?php echo $row["sms_id"];?>').value='Edit';this.form.submit();"><i class="mdi mdi-pencil"></i></button>
                    <button  class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('sms_value<?php echo $row["sms_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                    <?php
                    }else{
                         ?>
                    
                   
                    <button  class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('sms_value<?php echo $row["sms_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                    <?php
                    }
                    echo '<input type="hidden" id="sms_value'.$row["sms_id"].'" name="sms_value">';
                    echo '<input type="hidden" id="sms_id" name="sms_id" value="'.$row["sms_id"].'">';
                    echo '<input type="hidden" name="sms_id" value="'.$row["sms_id"].'"></form></td></tr>';
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
