<?php
session_start();
include "service/database.php"; 
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MALDI || TENTANG</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php

    include "layout/header.php";
    ?>

    <main>
        <section class="feature-card">
            <h2 class="header-section">Tentang MALDI</h2>
            <p>Maldi atau Malaria disease diagnose adalah sistem yang dirancang untuk membantu dalam mendiagnosis
                penyakit malaria dengan cepat dan akurat. Sistem ini menggunakan algoritma canggih untuk menganalisis
                gejala dan memberikan rekomendasi diagnosis.</p>
            <img src="assets\test\img\logo-maldi-crop.png" alt="MALDI System" class="responsive-image">
            <p>Dengan menggunakan MALDI pengguna (tenaga medis) dapat mendiagnosa penyakit pasien dengan cepat dan akurat. Berikut adalah kelebihan dari MALDI</p>
            <ul>
                <li>Mendapatkan penilaian kesehatan yang cepat</li>
                <li>Akses rekomendasi medis dari ahli</li>
                <li>Memahami lebih baik tentang gejala yang dialami</li>
            </ul>
            <?php if (isset($_SESSION["is_login"])): ?> 
                <a href="diagnosa.php" class="cta-button">Mulai Diagnosa</a>
            <?php endif; ?>
        </section>


    </main>
    <?php include "layout/footer.php" ?>
</body>

</html>