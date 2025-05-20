<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "school";

$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    echo ("Connection failed: " . mysqli_connect_error());
}
