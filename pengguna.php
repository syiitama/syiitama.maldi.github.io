<?php
include 'service/database.php';
include 'service/database-user.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MALDI || PENGGUNA</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <?php include "layout/header.php" ?>

    <main>
        <section class="pengguna">

            <div class="profile-container">
                <h2 class="header-section">INFORMASI PENGGUNA</h2>
                <?php if (isset($_SESSION["username"])): ?>
                    <h2><?= $userData['username'] ?></h2>
                    <div class="profile-info">
                        <table>
                            <tr>
                                <td> <p><strong>Nama</strong></p></td>
                                <td><p>:</p></td>
                                <td><p> <?= $userData['nama'] ?></p></td>
                            </tr>
                            <tr>
                                <td> <p><strong>Asal</strong></p></td>
                                <td><p>:</p></td>
                                <td><p> <?= $userData['asal'] ?></p></td>
                            </tr>
                            <tr>
                                <td> <p><strong>Tanggal Lahir</strong></p></td>
                                <td><p>:</p></td>
                                <td><p> <?= $userData['tgl_lahir'] ?></p></td>
                            </tr>
                            <tr>
                                <td> <p><strong>Jenis Kelamin</strong></p></td>
                                <td><p>:</p></td>
                                <td><p> <?= $userData['gender'] ?></p></td>
                            </tr>
                            <tr>
                                <td> <p><strong>Nomor Telepon</strong></p></td>
                                <td><p>:</p></td>
                                <td><p> <?= $userData['no_hp'] ?></p></td>
                            </tr>
                            <tr>
                                <td> <p><strong>Email</strong></p></td>
                                <td><p>:</p></td>
                                <td><p> <?= $userData['email'] ?></p></td>                                
                            </tr>
                            <tr>
                                <td>Level</td>                
                                <td>:</td>
                                <td><?= $userData['level'] ?></td>
                            </tr>
                        </table>
              

                    </div>
                    <form action="pengguna.php" method="POST">
                        <button class="cancelbtn" type="submit" name="logout">Logout</button>
                    </form>
                <?php else: ?>
                    <p>Silahkan <a href="login.php" class="cta-button">log in</a>, untuk melihat informasi pengguna.</p>
                    <p>Silahkan <a href="register.php" class="cta-button">daftar</a>, jika belum memiliki akun.</p>
                <?php endif; ?>

                <?php if (isset($_SESSION["is_login"])): ?> 
                    <a href="diagnosa.php" class="cta-button">Mulai Diagnosa</a>
                <?php endif; ?>

            </div>

        </section>
    </main>

    <?php include "layout/footer.php" ?>
</body>

</html>