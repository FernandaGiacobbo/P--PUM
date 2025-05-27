<?php
header('Content-Type: application/json');
include 'conecta_db.php';

$feedbackId = $_GET['id'] ?? 0;
$conn = conecta_db();

$sql = "UPDATE tb_feedback SET lido = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $feedbackId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>