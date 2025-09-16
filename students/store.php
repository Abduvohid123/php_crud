<?php
include "../database.php";
extract($_POST);

$conn->query("INSERT INTO `users` ( `name`, `mobile_numer`, `created_at`) VALUES ('$name','$mobile_numer',now())");

header("location:index.php");




