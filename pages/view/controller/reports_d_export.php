<?php
$export_type = $_POST["export_type"];
// Load the database configuration file
include 'pages/view/config/dbconfig.php';
// Include XLSX generator library
require_once 'pages/view/controller/PhpXlsxGenerator.php';

// Excel file name for download
$fileName = "doctors-data_" . date('Y-m-d') . ".xlsx";

// Define column names
$excelData[] = array('User ID', 'Firstname', 'MI', 'Lastname', 'Birthday', 'Age', 'Gender', 'Address stblc', 'Barangay', 'City', 'Contact #', 'PhilHealth #', 'Service', 'Email', 'Date Registered', 'Time Registered', 'Verified');


// Fetch records from database and store in an array
if($export_type == "ytd"){
    $query = "SELECT * FROM user_details WHERE user_type = '2' ORDER BY user_id ASC";
}else{
   $query = "SELECT * FROM user_details WHERE user_type = '2' AND DATE_FORMAT(date_registered, '%m %Y') = DATE_FORMAT(CURDATE(),'%m %Y') ORDER BY user_id ASC"; 
}
$result = mysqli_query($conn, $query);

if($result->num_rows > 0){
  while($row=mysqli_fetch_assoc($result)){
        $verified = ($row["verified"] == 1)?"yes":"no";
        $bday = date_create($row["bday"]);
        $bday = date_format($bday, 'm-d-Y');
        $date_registered = date_create($row["date_registered"]);
        $date_registered = date_format($date_registered, 'm-d-Y');

        $lineData = array($row['user_id'], $row['fname'], $row['mi'], $row['lname'], $bday, $row['age'], $row['gender'], $row['address_stblc'], $row['address_brgy'], $row['address_city'], $row['contact_no'], $row['phealth'], $row['services'], $row['eml'], $date_registered, $row['time_registered'], $verified);
        $excelData[] = $lineData;

    }
}


// Export data to excel and download as xlsx file
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData );
$xlsx->downloadAs($fileName);

exit;

?>
