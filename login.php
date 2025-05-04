<?php

include "service/database.php";
session_start();

$login_message = "";

if (isset($_SESSION["is_login"])) {
  header("location: dashboard.php");
}

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $level = $_POST['level'];

  $sql = "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password' AND level='$level' ";

  $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION["username"] = $data["username"];
        $_SESSION["is_login"] = true;
        $_SESSION["level"] = $data["level"];

        header("location: dashboard.php");
    } else {
        $login_message =  "akun tidak ditemukan";
    }
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MALDI || MASUK</title>
  <link rel="stylesheet" href="login-daftar.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>

<body>

  <i><?= $login_message ?></i>
  <form action="login.php" method="POST" class="login">
    <h1 class="maldi_header">MALDI</h1>
    <h2 class="login_hearder">SILAHKAN LOGIN</h2>

    <div class="container">
      <div class="fontuser">
        <label><b>Username</b></label>
        <input type="text" placeholder=" Username" name="username" required>
        <i class="fa fa-user fa-lg"></i>
      </div>

      <div class="fontpassword">
        <label><b>Password</b></label>
        <input type="password" placeholder=" Password" name="password" required>
        <i class="fa fa-key fa-lg"></i>
      </div>

      <div class="dropdown-gender">
        <label class="gender-select"><b>Level</b></label>
        <select name="level" id="level" required>
          <option selected disabled>Pilih Level</option>
          <option value="admin">Admin</option>
          <option value="nakes">nakes</option>
        </select>
      </div>

      <button type="submit" name="login" class="btn">Login</button>
      <a href="login.php"><button class="cancelbtn" type="cancel" name="cancel" value="cancel">Cancel</button></a>
      
      <span class="">Belum punya akun? Silahkan <a href="register.php" class="link">daftar.</a></span>
    </div>
  </form>
</body>

</html>