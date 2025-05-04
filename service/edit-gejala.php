<?php
session_start();
include "database.php";

// Check connection
if ($db->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => "Koneksi gagal: {$db->connect_error}"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kd_gejala = isset($_POST['kd_gejala']) ? trim($_POST['kd_gejala']) : '';
    $gejala = isset($_POST['gejala']) ? trim($_POST['gejala']) : '';

    if (empty($kd_gejala) || empty($gejala)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Kode gejala dan nama gejala wajib diisi!']);
        exit;
    }

    // Check if kd_gejala exists
    $sqlCheck = "SELECT kd_gejala FROM tb_gejala WHERE kd_gejala = ?";
    if ($stmtCheck = $db->prepare($sqlCheck)) {
        $stmtCheck->bind_param('s', $kd_gejala);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows === 0) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => "Kode gejala '{$kd_gejala}' tidak ditemukan!"]);
            exit;
        }
        $stmtCheck->close();
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => "Gagal mengecek kode gejala: {$db->error}"]);
        exit;
    }

    // Update gejala
    $sql = "UPDATE tb_gejala SET gejala = ? WHERE kd_gejala = ?";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('ss', $gejala, $kd_gejala);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Data gejala berhasil diperbarui!']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => "Gagal memperbarui data: {$stmt->error}"]);
        }
        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => "Gagal menyiapkan query: {$db->error}"]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metode tidak diizinkan.']);
}

$db->close();
?>
