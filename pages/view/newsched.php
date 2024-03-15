<?php
$user_type = $_SESSION["user_type"];
if ($user_type != "2") {
  echo "<script>alert('Action Not Allowed!')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";

}

 ?>
<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-primary text-white me-2">
              <i class="mdi mdi-calendar"></i>
            </span> Schedule
          </h3>
          <nav aria-label="breadcrumb">
            <!-- <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul> -->
            <button onclick="location.href = '../RHU/?p=schedule';" class="btn btn-info btn-rounded btn-icon">
              <i class="mdi mdi-close"></i>
            </button>
          </nav>
        </div>
        <div class="row">
          <div class="auth-form-light text-left p-5">
            <form class="pt-3" action="../RHU/?p=newsched_p" method="POST" autocomplete="off" enctype="multipart/form-data">
              <h4>Schedule Details</h4><br>
              <div class="form-group">
                <label for="date">Date</label>
                <input type="date" style="max-width:11%" class="form-control form-control-lg" id="input_date" name="input_date" required>
                <div id="display"></div>
              </div>
              <div class="mb-4">
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="input_time[]" value="08:00 AM">08:00 AM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="input_time[]" value="09:00 AM">09:00 AM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="input_time[]" value="10:00 AM">10:00 AM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="input_time[]" value="11:00 AM">11:00 AM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="input_time[]" value="01:00 PM">01:00 PM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="input_time[]" value="02:00 PM">02:00 PM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="input_time[]" value="03:00 PM">03:00 PM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="input_time[]" value="04:00 PM">04:00 PM</label>
                </div>
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="input_time[]" value="05:00 PM">05:00 PM</label>
                </div>
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
</div>

        <script>
        // Everything except weekend days
        // const validate = dateString => {
        //   const day = (new Date(dateString)).getDay();
        //   if (day==0 || day==6) {
        //     document.getElementById("display").style.color = "Red";
        //     document.getElementById("display").innerHTML = "<b>ERROR:</b> No available appointment on Weekends. <br>Please select dates on Weekdays only.";
        //     return false;
        //   }
        //   document.getElementById("display").innerHTML = "";
        //   return true;
        // }
        
        document.addEventListener('DOMContentLoaded', function () {
      var datePicker = document.getElementById('input_date');

      // Add an event listener to the input
      datePicker.addEventListener('input', function () {
        // Check if the selected date is a weekend (Saturday or Sunday)
        var selectedDate = new Date(datePicker.value);
        var dayOfWeek = selectedDate.getDay();

        if (dayOfWeek === 0 || dayOfWeek === 6) {
            document.getElementById("display").style.color = "Red";
            document.getElementById("display").innerHTML = "<b>ERROR:</b> No available appointment on Weekends. <br>Please select dates on Weekdays only.";
          datePicker.value = ''; // Clear the input value
        }else{
            document.getElementById("display").innerHTML = "";
        }
      });
    });

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
            $('#input_date').attr('min', maxDate);
        });
        </script>
