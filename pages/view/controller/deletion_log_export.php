<?php
session_start();
$user_type = $_SESSION["user_type"];

if ($user_type != "1") {
  echo "<script>alert('Action Not Allowed!')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";
}else{
  if($_SESSION["password_req"] != "ON"){
      echo '<form id="password_req" action="../RHU/?p=password_req" method="post">';
      echo '<input type="hidden" name="reports_title" value="Deletion Log">';
      echo '<input type="hidden" name="reports_link" value="deletion_log">';
      echo '<script>document.getElementById("password_req").submit();</script>';
  }else{
    if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {
        unset($_SESSION['password_req']);
        echo '<form id="password_req" action="../RHU/?p=password_req" method="post">';
        echo '<input type="hidden" name="reports_title" value="Deletion Log">';
        echo '<input type="hidden" name="reports_link" value="deletion_log">';
        echo '<script>document.getElementById("password_req").submit();</script>';
      }else{
         // Load the database configuration file
        include 'pages/view/config/dbconfig.php';
        // Include XLSX generator library
        require_once 'pages/view/controller/PhpXlsxGenerator.php';
        
        // Excel file name for download
        $fileName = "deletion-log_" . date('Y-m-d') . ".xlsx";
        
        // Define column names
        $excelData[] = array('Deletion ID', 'Data Title', 'Data ID', 'Date Deleted', 'Time Deleted', 'Deleted By');
        
        
        // Fetch records from database and store in an array
        $query = "SELECT * FROM data_deletion_log ORDER BY del_id ASC";
        $result = mysqli_query($conn, $query);
        
        if($result->num_rows > 0){
          while($row=mysqli_fetch_assoc($result)){
        
                
                $lineData = array($row['del_id'], $row['data_title'], $row['data_id'], $row['date_deleted'], $row['time_deleted'], $row['deleted_by']);
                $excelData[] = $lineData;
        
            }
        }
        
        
        // Export data to excel and download as xlsx file
        $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData );
        $xlsx->downloadAs($fileName);
        echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";
        exit;
      }
    }

}

    

?>
