<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['kd_gejala']) || empty($_POST['kd_gejala'])) {
    echo json_encode(['success' => false, 'message' => 'Missing kd_gejala parameter']);
    exit;
}

$kd_gejala = $_POST['kd_gejala'];

include 'database.php'; // Adjust path if needed

// Prepare and execute delete query
$stmt = $db->prepare("DELETE FROM tb_gejala WHERE kd_gejala = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $db->error]);
    exit;
}

$stmt->bind_param('s', $kd_gejala);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Data gejala berhasil dihapus']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Data gejala tidak ditemukan']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
}

$stmt->close();
$db->close();
?>
