<?php
session_start();
include "database.php";

// Check connection
if ($db->connect_error) {
    die("Koneksi gagal: {$db->connect_error}");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kd_rule = $_POST['kd_rule'];
    $kd_penyakit = $_POST['kd_penyakit'];
    $kd_gejala_str = $_POST['kd_gejala'];

    // Split kd_gejala by comma and trim spaces
    $kd_gejala_list = array_map('trim', explode(',', $kd_gejala_str));

    // Prepare insert statement
    $stmt = $db->prepare("INSERT INTO tb_rule (kd_rule, kd_gejala, kd_penyakit) VALUES (?, ?, ?)");

    if (!$stmt) {
        http_response_code(500);
        echo "Gagal menyiapkan statement: " . $db->error;
        exit;
    }

    $db->begin_transaction();

    try {
        foreach ($kd_gejala_list as $kd_gejala) {
            $stmt->bind_param("sss", $kd_rule, $kd_gejala, $kd_penyakit);
            if (!$stmt->execute()) {
                throw new Exception("Gagal menyimpan data: " . $stmt->error);
            }
        }
        $db->commit();
        echo "Sukses";
    } catch (Exception $e) {
        $db->rollback();
        http_response_code(500);
        echo $e->getMessage();
    }

    $stmt->close();
    $db->close();
} else {
    http_response_code(405);
    echo "Metode tidak diizinkan.";
}
?>
