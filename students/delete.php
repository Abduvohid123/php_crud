<?php
include "../database.php";

extract($_GET);

$user = $conn->query("DELETE FROM users WHERE id = '$id'");

header("Location:index.php");
?>
