<?php
$user_id = $_POST["user_id"];
$eml = $_POST["eml"];
$eml_curr = $_SESSION["eml"];
$user_id_curr = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];

if($user_id_curr == $user_id){
    $redirect = "../RHU/";
}else{
     $redirect = "../RHU/?p=account_mgmt";
}
 ?>
   <div class="row">
       <div class="col-12 grid-margin">
         <div class="card">
           <div class="card-body">
                <h6 class="font-weight-light">Email: <?php echo ($user_id == $user_id_curr)? $eml_curr:$eml;?></h6>
                <h4>Create New Password</h4>
                <tr><td>Your Password Must Contain the following:
                <ul><li>At Least 8 characters</li>
                <li>At Least 1 Number</li>
                <li>At Least 1 Capital Letter</li>
                <li>At Least 1 Lowercase Letter</li>
                <li>At Least 1 Special Character (Ex.@#~?)</li></ul></td></tr>
                <div id="display_error"></div>
                <div class="col-lg-4">
                <form class="pt-3" action="../RHU/?p=newpass_p" method="POST" autocomplete="off">
                  <div class="form-group" >
                    <h6 class="font-weight-light">New Password</h6>
                    <input type="password" class="form-control form-control-lg" id="pw" name="pw" placeholder="New Password" required onchange="validateInput()">
                  </div>
                  <div class="form-group" >
                    <h6 class="font-weight-light">Confirm Password</h6>
                    <input type="password" class="form-control form-control-lg" id="cpw" name="cpw" placeholder="Confirm Password" required onchange="validateInput()">
                  </div>
                  <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input" onclick="showHide()">Show Password </label>
                    </div>
                  </div>
                  <div class="mt-3 mb-3">
                    <input type="submit" id="sbmt_form" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
                    <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='<?php echo $redirect;?>';">Cancel</button>
                  </div>

                  <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                  <input type="hidden" name="user_type_reset" value="<?php echo $user_type;?>">
                </form>
              </div>
           </div>
         </div>
       </div>
   </div>


    <script>
    function showHide() {
      var pw = document.getElementById("pw");
      var cpw = document.getElementById("cpw");
      if (pw.type === "password" && cpw.type === "password") {
        pw.type = "text";
        cpw.type = "text";
      } else {
        pw.type = "password";
        cpw.type = "password";
      }
    }
    
    function validateInput() {
             var pw = document.getElementById('pw').value;
             var cpw = document.getElementById('cpw').value;

            // Regular expressions
            var capitalLetterRegex = /[A-Z]/;
            var numberRegex = /\d/;
            var specialCharRegex = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/;
            var lowercaseLetterRegex = /[a-z]/;

            // Validation
            if (pw === cpw){
                if (capitalLetterRegex.test(pw) && numberRegex.test(pw) && specialCharRegex.test(pw) && lowercaseLetterRegex.test(pw)) {
        
                         document.getElementById("display_error").innerHTML = "";
                         document.getElementById("sbmt_form").disabled = false;
                     
                        
                        
                        
                    
                } else{
                    
                        document.getElementById("display_error").style.color = "Red";
                        document.getElementById("display_error").innerHTML = "<b>ERROR:</b> Invalid input! Please enter text that includes at least one capital letter, one number, one special character, and one lowercase letter.";
                        document.getElementById("sbmt_form").disabled = true;
                   
                }
            }else{
                document.getElementById("display_error").style.color = "Red";
                document.getElementById("display_error").innerHTML = "<b>ERROR:</b> Password and Confirm Password not matched.";
                document.getElementById("sbmt_form").disabled = true;
            }
        }
    </script>
    <!-- endinject -->
  </body>
</html>
