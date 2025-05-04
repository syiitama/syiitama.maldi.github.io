<?php
session_start();
header('Content-Type: application/json');
include "database.php"; // Mengganti backslash dengan slash

// Cek koneksi
if ($db->connect_error) {
    echo json_encode(['success' => false, 'message' => "Koneksi gagal: {$db->connect_error}"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_penyakit']) || !isset($_POST['nama_penyakit'])) {
        echo json_encode(['success' => false, 'message' => 'Parameter tidak lengkap']);
        exit;
    }

    $kode = $_POST['id_penyakit'];
    $nama = $_POST['nama_penyakit'];

    $stmt = $db->prepare("INSERT INTO tb_penyakit (id_penyakit, nama_penyakit) VALUES (?, ?)");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare statement gagal: ' . $db->error]);
        exit;
    }
    $stmt->bind_param("ss", $kode, $nama);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data penyakit berhasil disimpan']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data: ' . $stmt->error]);
    }

    $stmt->close();
    $db->close();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metode tidak diizinkan']);
}
?>
