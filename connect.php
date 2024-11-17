<?php

$host = 'localhost';
$user = 'root';
$pass = "";
$db_name = "php_project";
$conn = new mysqli($host, $user, $pass, $db_name);
if($conn->connect_error){
    echo 'Failed to connect database' .$conn->connect_error;
}

?>