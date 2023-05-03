<?php
include '../db/config.php';
session_start();

if($_POST['user_type'] == 1){
    $update_AdminNotif = "UPDATE requests SET checked = 1";
    mysqli_query($db, $update_AdminNotif);
} else if($_POST['user_type'] == 2){
    $id = $_SESSION['id'];
    $update_AdminNotif = "UPDATE requests SET user_checked = 1 WHERE userid = '$id' AND status != 0";
    mysqli_query($db, $update_AdminNotif);
}
?>