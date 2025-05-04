<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['kd_rule']) || empty($_POST['kd_rule'])) {
    echo json_encode(['success' => false, 'message' => 'Missing kd_rule parameter']);
    exit;
}

$kd_rule = $_POST['kd_rule'];

include 'database.php'; // Adjust path if needed

// Prepare and execute delete query
$stmt = $db->prepare("DELETE FROM tb_rule WHERE kd_rule = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $db->error]);
    exit;
}

$stmt->bind_param('s', $kd_rule);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Data rule berhasil dihapus']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Data rule tidak ditemukan']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
}

$stmt->close();
$db->close();
?>
