<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['id_penyakit']) || empty($_POST['id_penyakit'])) {
    echo json_encode(['success' => false, 'message' => 'Missing id_penyakit parameter']);
    exit;
}

$id_penyakit = $_POST['id_penyakit'];

include 'database.php'; // Include your database connection

// Prepare and execute delete query
$stmt = $db->prepare("DELETE FROM tb_penyakit WHERE id_penyakit = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . $db->error]);
    exit;
}

$stmt->bind_param('s', $id_penyakit);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Data penyakit berhasil dihapus']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Data penyakit tidak ditemukan']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus data penyakit: ' . $stmt->error]);
}

$stmt->close();
$db->close();
?>
