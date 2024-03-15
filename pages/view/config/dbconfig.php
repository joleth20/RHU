<?php
// $host = "https://cpanel06wh.jpt1.cloud.z.com:2083/";
// $username = "lrtekrie_4rhu";
// $password = "Rhumontalban@1234";
// $database = "lrtekrie_aprmm";
//
// $conn_string = "host=$host dbname=$database user=$username password=$password";
$host = 'localhost:3306';
$dbname = 'lrtekrie_aprmm';
$username = 'lrtekrie_4rhu';
$password = 'Rhumontalban@1234';
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo 'Connected to the database successfully!';
// } catch (PDOException $e) {
//     echo 'Error connecting to the database: ' . $e->getMessage();
// }
 ?>
