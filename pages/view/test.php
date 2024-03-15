<?php
  $datenow = date('Y-m-d');
  $date1 = new DateTime($datenow);  //current date or any date
  $date2 = new DateTime("2023-11-28");   //Future date
  $diff = $date2->diff($date1)->format("%a");  //find difference
  $days = intval($diff);   //rounding days
  echo $days;

 ?>
