<?php

session_start();
$eml = $_SESSION["eml"];
$user_id = $_SESSION["user_id"];
if(isset($_POST["image"]))
{
	$data = $_POST["image"];

	$image_array_1 = explode(";", $data);

	$image_array_2 = explode(",", $image_array_1[1]);

	$data = base64_decode($image_array_2[1]);
    
	$imageName = 'assets/images/pp/' . 'userid_' . $user_id . '.png';
	
	$filename = 'userid_' . $user_id . '.png';
	
	include 'pages/view/config/dbconfig.php';
	$query = "UPDATE user_details
       SET profile_pic = '$filename'
       WHERE eml = '$eml'";
    $result = mysqli_query($conn, $query);
    if($result){
        file_put_contents($imageName, $data);
	    echo $imageName;
	    $_SESSION["profile_pic"] = $filename;
    }

	
	
	

}

?>