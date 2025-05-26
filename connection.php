<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');



$host = "localhost";
$username = "root";
$password = "";
$database = "school";

$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    echo ("Connection failed: " . mysqli_connect_error());
}
