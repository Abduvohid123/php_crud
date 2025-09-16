<?php
include "../database.php";
ini_set('display_errors', 1);

extract($_POST);

$conn->query("UPDATE  users set  name='$name', mobile_numer='$mobile_numer'  WHERE id =$id");

header("Location:index.php");
?>