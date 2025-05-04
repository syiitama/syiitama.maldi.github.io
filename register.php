<?php
include "service/database.php";
session_start();

if (isset($_SESSION["is_login"])) {
  header("location: dashboard.php");
}

$register_message = "";
$login_message = "";

if (isset($_POST['register'])) {
  $nama = $_POST['nama'];
  $asal = $_POST['asal'];
  $tgl_lahir = $_POST['tgl_lahir'];
  $gender = $_POST['gender'];
  $email = $_POST['email'];
  $no_hp = $_POST['no_hp'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $level = $_POST['level'];

  try {
    $stmt = $db->prepare("INSERT INTO tb_user (nama, asal, tgl_lahir, gender, email, no_hp, username, password) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssss", $nama, $asal, $tgl_lahir, $gender, $email, $no_hp, $username, $password);

    if ($stmt->execute()) {
      $register_message = "daftar akun berhasil, silahkan login";
    } else {
      $register_message = "daftar akun gagal, silahkan coba lagi";
    }
  } catch (mysqli_sql_exception) {
    $register_message = "username sudah ada, ganti yang lain";
  }
  $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MALDI || DAFTAR</title>
  <link rel="stylesheet" href="login-daftar.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>

<body>

  <i contain><?= $register_message ?></i>
  <form action="register.php" method="POST" class="daftar">
    <h1 class="maldi_header">MALDI</h1>
    <h2 class="login_hearder">DAFTAR AKUN</h2>
    <h2 class="login_hearder"><?= $register_message ?></h2>

    <div class="container">
      <div class="fontname">
        <label><b>Nama</b></label>
        <input type="text" placeholder="Ketik Nama disini" name="nama" required>
        <i class="fa fa-user fa-lg"></i>
      </div>

      <div class="font-asal">
        <label><b>Asal</b></label>
        <input type="text" placeholder="Ketik Asal disini" name="asal" required>
        <i class="fa fa-user fa-lg"></i>
      </div>

      <div class="font-date">
        <label class="text_date"><b>Tanggal Lahir</b></label>
        <input type="date" id="tgl_lahir" placeholder="Pilih Tanggal Lahir" name="tgl_lahir" required>
      </div>

      <div class="dropdown-gender">
        <label class="gender-select"><b>Jenis Kelamin</b></label>
        <select name="gender" id="gender" required>
          <option selected disabled>Pilih Jenis Kelamin</option>
          <option value="laki-laki">Laki-laki</option>
          <option value="perempuan">Perempuan</option>
        </select>
      </div>

      <div class="fontno-telp">
        <label><b>Nomor Telepon</b></label>
        <input type="text" placeholder="08xxxxxxx" name="no_hp" required>
        <i class="fa fa-user fa-lg"></i>
      </div>

      <div class="fontemail">
        <label><b>Email</b></label>
        <input type="text" placeholder="email@mail.com" name="email" required>
        <i class="fa fa-user fa-lg"></i>
      </div>

      <div class="fontuser">
        <label><b>Username</b></label>
        <input type="text" placeholder="username" name="username" required>
        <i class="fa fa-user fa-lg"></i>
      </div>

      <div class="fontpassword">
        <label><b>Password</b></label>
        <input type="password" placeholder="MASUKKAN PASSWORD" name="password" required>
        <i class="fa fa-key fa-lg"></i>
      </div>
      <div class="fontpassword">
        <label><b>Confirm Password</b></label>
        <input type="password" placeholder="MASUKKAN ULANG PASSWORD" name="confirm_password" required>
        <i class="fa fa-key fa-lg"></i>
      </div>

      <div class="dropdown-level">
        <label class="level-select"><b>Level</b></label>
        <select name="level" id="level" required>
          <option selected disabled>Pilih Level</option>
          <option value="admin">Admin</option>
          <option value="nakes">Nakes</option>
        </select>
      </div>

      <button name="register" type="submit" value="Submit" class="btn">DAFTAR</button>
      <a href="index.php"><button class="cancelbtn" type="cancel" name="cancel" value="cancel">Cancel</button></a>

      <span class="psw">Sudah punya akun? Silahkan <a href="login.php" class="link">login.</a></span>

    </div>

  </form>
  <?php $db->close(); ?>

</body>

</html>