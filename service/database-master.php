<?php
session_start();
include "service/database.php"; // Include the database connection

// Access control: only allow admin users
if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true || !isset($_SESSION["level"]) || $_SESSION["level"] !== "admin") {
    header("Location: index.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
}

// Handle update penyakit request
if (isset($_POST['action']) && $_POST['action'] === 'update_penyakit') {
    $original_kd_penyakit = $_POST['original_kode_penyakit'] ?? '';
    $kd_penyakit = $_POST['kode_penyakit'] ?? '';
    $nama_penyakit = $_POST['nama_penyakit'] ?? '';

    if ($original_kd_penyakit === '' || $kd_penyakit === '' || $nama_penyakit === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Kode penyakit dan nama penyakit harus diisi']);
        exit();
    }

    // Update tb_penyakit table
    $stmt = $db->prepare("UPDATE tb_penyakit SET id_penyakit = ?, nama_penyakit = ? WHERE id_penyakit = ?");
    $stmt->bind_param("sss", $kd_penyakit, $nama_penyakit, $original_kd_penyakit);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data penyakit berhasil diperbarui']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui data penyakit']);
    }
    $stmt->close();
    exit();
}

// Handle update gejala request
if (isset($_POST['action']) && $_POST['action'] === 'update_gejala') {
    $original_kd_gejala = $_POST['original_kode_gejala'] ?? '';
    $kd_gejala = $_POST['kode_gejala'] ?? '';
    $gejala = $_POST['gejala'] ?? '';

    if ($original_kd_gejala === '' || $kd_gejala === '' || $gejala === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Kode gejala dan gejala harus diisi']);
        exit();
    }

    // Update tb_gejala table
    $stmt = $db->prepare("UPDATE tb_gejala SET kd_gejala = ?, gejala = ? WHERE kd_gejala = ?");
    $stmt->bind_param("sss", $kd_gejala, $gejala, $original_kd_gejala);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data gejala berhasil diperbarui']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui data gejala']);
    }
    $stmt->close();
    exit();
}

// Handle update rule request
if (isset($_POST['action']) && $_POST['action'] === 'update_rule') {
    $original_kd_rule = $_POST['original_kode_rule'] ?? '';
    $kd_rule = $_POST['kode_rule'] ?? '';
    $kd_gejala = $_POST['kode_gejala'] ?? '';
    $kd_penyakit = $_POST['kode_penyakit'] ?? '';

    if ($original_kd_rule === '' || $kd_rule === '' || $kd_gejala === '' || $kd_penyakit === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi']);
        exit();
    }

    // Update tb_rule table
    $stmt = $db->prepare("UPDATE tb_rule SET kd_rule = ?, kd_gejala = ?, kd_penyakit = ? WHERE kd_rule = ?");
    $stmt->bind_param("ssss", $kd_rule, $kd_gejala, $kd_penyakit, $original_kd_rule);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data rule berhasil diperbarui']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui data rule']);
    }
    $stmt->close();
    exit();
}

// Handle add penyakit request
if (isset($_POST['action']) && $_POST['action'] === 'add_penyakit') {
    $kd_penyakit = $_POST['kode_penyakit'] ?? '';
    $nama_penyakit = $_POST['nama_penyakit'] ?? '';

    if ($kd_penyakit === '' || $nama_penyakit === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Kode penyakit dan nama penyakit harus diisi']);
        exit();
    }

    // Insert into tb_penyakit table
    $stmt = $db->prepare("INSERT INTO tb_penyakit (id_penyakit, nama_penyakit) VALUES (?, ?)");
    $stmt->bind_param("ss", $kd_penyakit, $nama_penyakit);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data penyakit berhasil ditambahkan']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan data penyakit']);
    }
    $stmt->close();
    exit();
}

// Handle delete penyakit request
if (isset($_POST['action']) && $_POST['action'] === 'delete_penyakit') {
    $kd_penyakit = $_POST['kode_penyakit'] ?? '';

    if ($kd_penyakit === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Kode penyakit harus diisi']);
        exit();
    }

    // Delete from tb_penyakit table
    $stmt = $db->prepare("DELETE FROM tb_penyakit WHERE id_penyakit = ?");
    $stmt->bind_param("s", $kd_penyakit);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data penyakit berhasil dihapus']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus data penyakit']);
    }
    $stmt->close();
    exit();
}

// Handle check duplicate penyakit request
if (isset($_POST['action']) && $_POST['action'] === 'check_duplicate_penyakit') {
    $kd_penyakit = $_POST['kode_penyakit'] ?? '';

    if ($kd_penyakit === '') {
        http_response_code(400);
        echo json_encode(['exists' => false]);
        exit();
    }

    $stmt = $db->prepare("SELECT COUNT(*) FROM tb_penyakit WHERE id_penyakit = ?");
    $stmt->bind_param("s", $kd_penyakit);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    echo json_encode(['exists' => $count > 0]);
    exit();
}

// Handle add gejala request
if (isset($_POST['action']) && $_POST['action'] === 'add_gejala') {
    $kd_gejala = $_POST['kode_gejala'] ?? '';
    $gejala = $_POST['gejala'] ?? '';

    if ($kd_gejala === '' || $gejala === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Kode gejala dan gejala harus diisi']);
        exit();
    }

    // Insert into tb_gejala table
    $stmt = $db->prepare("INSERT INTO tb_gejala (kd_gejala, gejala) VALUES (?, ?)");
    $stmt->bind_param("ss", $kd_gejala, $gejala);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data gejala berhasil ditambahkan']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan data gejala']);
    }
    $stmt->close();
    exit();
}

// Handle add rule request
if (isset($_POST['action']) && $_POST['action'] === 'add_rule') {
    $kd_rule = $_POST['kode_rule'] ?? '';
    $kd_gejala = $_POST['kode_gejala'] ?? '';
    $kd_penyakit = $_POST['kode_penyakit'] ?? '';

    if ($kd_rule === '' || $kd_gejala === '' || $kd_penyakit === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi']);
        exit();
    }

    // Insert into tb_rule table
    $stmt = $db->prepare("INSERT INTO tb_rule (kd_rule, kd_gejala, kd_penyakit) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $kd_rule, $kd_gejala, $kd_penyakit);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data rule berhasil ditambahkan']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan data rule']);
    }
    $stmt->close();
    exit();
}
?>