<?php
session_start();
include "service/database.php"; // Include the database connection
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
    <title>MALDI</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include "layout/header.php" ?>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h2>SELAMAT DATANG DI MALDI</h2>
                 
                <p>Pendamping kesehatan Anda untuk diagnosis penyakit malaria.</p>
                <a href="diagnosa.php" class="cta-button">Mulai Diagnosis</a>
            </div>

        </section>

        <section class="features">
            <div class="feature-card">
                <h3>Diagnosa Cepat</h3>
                <p>Mendapatkan penilaiain kesehatan cepat berdasarkan gejala</p>
            </div>
            <div class="feature-card">
                <h3>Saran Ahli</h3>
                <p>Akses rekomendari medis profesional</p>
            </div>
            <div class="feature-card">
                <h3>Mudah digunakan</h3>
                <p>Antarmuka yang sederhana dan intuitif</p>
            </div>
        </section>

    </main>
    <?php include "layout/footer.html" ?>

</body>
</html>