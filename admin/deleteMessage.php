<?php
include('../database/connection.php');
if(!isset($_SESSION['admin'])){
    header("location:login.php");
}
$id = mysqli_escape_string($con,$_GET['id']);
$query = "DELETE  FROM contacts WHERE id='$id'";
if(mysqli_query($con,$query)){
    mysqli_query($con,$query);
    header("location:contact-messages.php?deleted");
}