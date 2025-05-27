<?php
header('Content-Type: application/json');
include 'conecta_db.php';

$feedbackId = $_GET['id'] ?? 0;
$conn = conecta_db();

$sql = "SELECT * FROM tb_feedback WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $feedbackId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['error' => 'Feedback não encontrado']);
}

$stmt->close();
$conn->close();
?>