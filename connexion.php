<?php 

$con = mysqli_connect("localhost", "root", "", "cuisine");
if (!$con) {
    die('Error:' . mysqli_connect_error());
}
?>