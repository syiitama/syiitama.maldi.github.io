<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "db_maldi";
$db = mysqli_connect($hostname, $username, $password, $database_name);

if (!$db) {
    echo "Koneksi database rusak: " . mysqli_connect_error();
    die("Error!");
}

// echo " koneksi database berhasil";

?>
