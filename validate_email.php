<?php

include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM user_details";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
   $array_values[] = $row["eml"];
};
echo json_encode($array_values)




 ?>
