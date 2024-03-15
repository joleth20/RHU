<?php
$export_type = $_POST["export_type"];
// Load the database configuration file
include 'pages/view/config/dbconfig.php';
// Include XLSX generator library
require_once 'pages/view/controller/PhpXlsxGenerator.php';

// Excel file name for download
$fileName = "MedicationRefills-data_" . date('Y-m-d') . ".xlsx";

// Define column names
$excelData[] = array('Rx ID', 'Patient Name', 'Birthday', 'Age', 'Gender', 'Address', 'Contact #', 'PhilHealth #', 'Email', 'Medicine Name', 'Quantity', 'Dosage', 'Prescription', 'Doctor', 'Start Date', 'End Date', 'Request Date', 'Request Time', 'Action Date', 'Action Time', 'Status');


// Fetch records from database and store in an array
if($export_type == "ytd"){
    $query = "SELECT * FROM medication_refills ORDER BY user_id ASC";
}else{
    $query = "SELECT * FROM medication_refills WHERE DATE_FORMAT(req_date, '%m %Y') = DATE_FORMAT(CURDATE(),'%m %Y') ORDER BY user_id ASC";
}
$result = mysqli_query($conn, $query);

if($result->num_rows > 0){
  while($row=mysqli_fetch_assoc($result)){
        $verified = ($row["verified"] == 1)?"yes":"no";
        $bday = date_create($row["bday"]);
        $bday = date_format($bday, 'm-d-Y');
        $start_date = date_create($row["start_date"]);
        $start_date = date_format($start_date, 'm-d-Y');
        $end_date = date_create($row["end_date"]);
        $end_date = date_format($end_date, 'm-d-Y');
        $req_date = date_create($row["req_date"]);
        $req_date = date_format($req_date, 'm-d-Y');
        $act_date = date_create($row["act_date"]);
        $act_date = date_format($act_date, 'm-d-Y');
        
        $doctor_user_id = $row["doctor"];
        $sql2 = "SELECT * FROM user_details WHERE user_id = '$doctor_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $user_details = mysqli_fetch_assoc($result2);
        $doctor_fullname = $user_details["fname"].' '.$user_details["mi"].' '.$user_details["lname"];

        $lineData = array($row['rx_id'], $row['fullname'], $bday, $row['age'], $row['gender'], $row['address'], $row['contact_no'], $row['phealth'], $row['eml'], $row['rx_name'], $row['quantity'], $row['dosage'], $row['prescription'], $doctor_fullname, $start_date, $end_date, $req_date,  $row['req_time'], $act_date,  $row['time'],  $row['status']);
        $excelData[] = $lineData;

    }
}


// Export data to excel and download as xlsx file
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData );
$xlsx->downloadAs($fileName);

exit;

?>
