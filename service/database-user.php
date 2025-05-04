<?php
session_start();
include "service/database.php"; // Include the database connection

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
}

// Initialize user data
$userData = [
    'nama' => 'Guest',
    'asal' => 'City/Province',
    'tgl_lahir' => 'DD/MM/YYYY',
    'gender' => 'Laki-laki/Perempuan',
    'no_hp' => 'Nomor Telepon',
    'email' => 'Email',
    'level' => 'Level'
];

// Check if user is logged in
if (isset($_SESSION["username"])) {
    // Query the database for user information
    $username = $_SESSION["username"];
    $query = "SELECT * FROM tb_user WHERE username = '$username'"; // Assuming the table is named 'users'
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result); // Fetch user data
    } else {
        echo "User data not found.";
    }
}
?>