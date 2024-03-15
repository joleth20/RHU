<div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
         <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-primary text-white me-2">
              <i class="mdi mdi-hospital"></i>
            </span> Medication
          </h3>
          <nav aria-label="breadcrumb">
            <!-- <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul> -->
            <button onclick="location.href = '../RHU/?p=rx';" class="btn btn-info btn-rounded btn-icon">
              <i class="mdi mdi-close"></i>
            </button>
          </nav>
        </div>
        <div class="row">
            <form class="pt-3" action="../RHU/?p=newrx_p" method="POST" autocomplete="off" enctype="multipart/form-data">
              <h4>Medication Refills Details</h4><br>
              <div class="form-group">
                <label for="rx_name">Medicine Name</label>
                <input type="text" class="form-control form-control-lg" id="rx_name" name="rx_name" placeholder="Medicine Name" >
              </div>
              <div class="form-group">
                <label for="quantity">Quantity (Optional)</label>
                <input type="number" class="form-control form-control-lg" id="quantity" name="quantity" placeholder="Quantity">
              </div>
              <div class="form-group">
                <label for="dosage">Dosage (Optional)</label>
                <input type="text" class="form-control form-control-lg" id="dosage" name="dosage" placeholder="dosage">
              </div>

              <div class="form-group">
                <label for="prescription">Upload Prescription Receipt</label>
                <input type="file" class="form-control form-control-lg" id="prescription" name="prescription" placeholder="dosage" onchange="file_upload();" accept=".pdf, image/*" required>
                <div id="display"></div>
              </div>

              <div class="form-group">
                <label for="doctor">Doctor</label>
                <select class="form-control form-control-lg" id="doctor" name="doctor"  required style="color:black" >
                  <option disabled selected>--Select Doctor--</option>
                <?php
                  include 'pages/view/config/dbconfig.php';
                  $sql = "SELECT * FROM user_details WHERE user_type = '2'";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $doctor = $row["fname"]." ".$row["mi"]." ".$row["lname"];
                        $user_id = $row["user_id"];
                        echo '<option value="'.$user_id.'" style="color:black" id="'.$row["services"].'">'.$doctor.'</option>';
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
              <input type="date" class="form-control form-control-lg" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
              <label for="end_date">End Date</label>
              <input type="date" class="form-control form-control-lg" id="end_date" name="end_date" required>
            </div>
            <div class="input-group">
              <div class="mt-3">
                <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
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
        


        // Sets the value to '' in case of an invalid date
        document.querySelector('input').onchange = evt => {
          if (!validate(evt.target.value)) {
            evt.target.value = '';
          }
        }

        $(function(){
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate() + 1;
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
             day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;
            $('#start_date').attr('min', maxDate);
            $('#end_date').attr('min', maxDate);
        });
        </script>
