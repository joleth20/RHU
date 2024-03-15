<?php
$export_type = $_POST["export_type"];
// Load the database configuration file
include 'pages/view/config/dbconfig.php';
// Include XLSX generator library
require_once 'pages/view/controller/PhpXlsxGenerator.php';

// Excel file name for download
$fileName = "consultation-data_" . date('Y-m-d') . ".xlsx";

// Define column names
$excelData[] = array('Appt. ID', 'Firstname', 'MI', 'Lastname', 'Birthday', 'Age', 'Gender', 'Address stblc', 'Barangay', 'City', 'Contact #', 'PhilHealth #', 'Email', 'Vital Date', 'Weight', 'Height', 'BP', 'Pules Rate', 'Temperature', 'Oxygen Saturation', 'Findings', 'Request Date', 'Request Time', 'Action Date', 'Action Time', 'Services', 'Concern', 'Other Concern', 'Doctor', 'Status', 'Walk-in?');


// Fetch records from database and store in an array
if($export_type == "ytd"){
    $query = "SELECT * FROM appointment_details ORDER BY appt_id ASC";
}else{
    $query = "SELECT * FROM appointment_details WHERE DATE_FORMAT(req_date, '%m %Y') = DATE_FORMAT(CURDATE(),'%m %Y') ORDER BY appt_id ASC";
}
$result = mysqli_query($conn, $query);

if($result->num_rows > 0){
  while($row=mysqli_fetch_assoc($result)){
        if($row["walkin"] == "1"){
            $walkin = "Yes";
        }else{
            $walkin = "No";
        }
        $verified = ($row["verified"] == 1)?"yes":"no";
        $bday = date_create($row["bday"]);
        $bday = date_format($bday, 'm-d-Y');
        $vdate = date_create($row["vdate"]);
        $vdate = date_format($vdate, 'm-d-Y');
        $req_date = date_create($row["req_date"]);
        $req_date = date_format($req_date, 'm-d-Y');
        $act_date = date_create($row["act_date"]);
        $act_date = date_format($act_date, 'm-d-Y');
        
        $doctor_user_id = $row["doctor"];
        $sql2 = "SELECT * FROM user_details WHERE user_id = '$doctor_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $user_details = mysqli_fetch_assoc($result2);
        $doctor_fullname = $user_details["fname"].' '.$user_details["mi"].' '.$user_details["lname"];
        
        $lineData = array($row['appt_id'], $row['fname'], $row['mi'], $row['lname'], $bday, $row['age'], $row['gender'], $row['address_stblc'], $row['address_brgy'], $row['address_city'], $row['contact_no'], $row['phealth'], $row['eml'], $vdate, $row['weight'], $row['height'], $row['BP'], $row['pulse_rate'], $row['temp'], $row['oxy_sat'], $row['findings'], $req_date, $row['req_time'], $act_date, $row['act_time'], $row['services'], $row['concern'], $row['other_concern'], $doctor_fullname, $row['status'], $walkin);
        $excelData[] = $lineData;

    }
}


// Export data to excel and download as xlsx file
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData );
$xlsx->downloadAs($fileName);

exit;

?>
