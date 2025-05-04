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
    $kd_rule = isset($_POST['kd_rule']) ? trim($_POST['kd_rule']) : '';
    $kd_penyakit = isset($_POST['kd_penyakit']) ? trim($_POST['kd_penyakit']) : '';
    $kd_gejala = isset($_POST['kd_gejala']) ? trim($_POST['kd_gejala']) : '';

    if (empty($kd_rule) || empty($kd_penyakit) || empty($kd_gejala)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Kode rule, kode penyakit, dan kode gejala wajib diisi!']);
        exit;
    }

    // Check if kd_rule exists
    $sqlCheck = "SELECT kd_rule FROM tb_rule WHERE kd_rule = ?";
    if ($stmtCheck = $db->prepare($sqlCheck)) {
        $stmtCheck->bind_param('s', $kd_rule);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows === 0) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => "Kode rule '{$kd_rule}' tidak ditemukan!"]);
            exit;
        }
        $stmtCheck->close();
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => "Gagal mengecek kode rule: {$db->error}"]);
        exit;
    }

    // Update rule
    $sql = "UPDATE tb_rule SET kd_penyakit = ?, kd_gejala = ? WHERE kd_rule = ?";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('sss', $kd_penyakit, $kd_gejala, $kd_rule);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Data rule berhasil diperbarui!']);
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
