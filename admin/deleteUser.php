<?php
include('../database/connection.php');
if(!isset($_SESSION['admin'])){
    header("location:login.php");
}
$id = mysqli_escape_string($con,$_GET['id']);
$query = "DELETE  FROM users WHERE id='$id'";
if(mysqli_query($con,$query)){
    mysqli_query($con,$query);
    header("location:users.php?deleted");
}