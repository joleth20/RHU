<?php
echo "<script>alert('You successfully logged out')</script>";
session_start();
session_destroy();
header("Refresh: 0.01 url=../RHU");


 ?>
