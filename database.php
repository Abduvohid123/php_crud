<?php

$conn = mysqli_connect("localhost", "dragon", "password", "php_crud");

if ($conn) {

    $conn->query("INSERT INTO users (id,name, mobile_numer,created_at) VALUES (2,'Abdurahmon2','998991112234',now())");

 $users=   $conn->query('select * from users')->fetch_all();
 var_dump($users);

}else{
    echo "Connection Failed";
}