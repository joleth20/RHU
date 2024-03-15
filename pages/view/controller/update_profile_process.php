<?php
session_start();
$user_id = $_SESSION["user_id"];
echo '<form id="edit" action="../RHU/?p=update_account" method="post">';
echo '<input type="hidden" name="user_id" value="'.$user_id.'">';
echo '<script>document.getElementById("edit").submit();</script>';
 ?>
