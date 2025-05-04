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
    $kodePenyakit = isset($_POST['id_penyakit']) ? trim($_POST['id_penyakit']) : '';
    $namaPenyakit = isset($_POST['nama_penyakit']) ? trim($_POST['nama_penyakit']) : '';

    if (empty($kodePenyakit) || empty($namaPenyakit)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Kode penyakit dan nama penyakit wajib diisi!']);
        exit;
    }

    // Check if kode_penyakit exists
    $sqlCheck = "SELECT id_penyakit FROM tb_penyakit WHERE id_penyakit = ?";
    if ($stmtCheck = $db->prepare($sqlCheck)) {
        $stmtCheck->bind_param('s', $kodePenyakit);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows === 0) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => "Kode penyakit '{$kodePenyakit}' tidak ditemukan!"]);
            exit;
        }
        $stmtCheck->close();
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => "Gagal mengecek kode penyakit: {$db->error}"]);
        exit;
    }

    // Update penyakit
    $sql = "UPDATE tb_penyakit SET nama_penyakit = ? WHERE id_penyakit = ?";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('ss', $namaPenyakit, $kodePenyakit);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Data penyakit berhasil diperbarui!']);
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
