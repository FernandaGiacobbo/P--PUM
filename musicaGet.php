<?php
require_once 'conecta_db.php';

$conn = conecta_db();

// Lê todos os registros da tabela
$sql = "SELECT * FROM musicas_tb";
$result = $conn->query($sql);

$musicas = [];

while ($row = $result->fetch_assoc()) {
    $musicas[] = [
        'nome' => $row['nome_musica'],
        'caminho' => $row['caminho_arquivo'] // ✅ Usa o caminho real salvo no banco!
    ];
}

$conn->close();

// Retorna JSON
header('Content-Type: application/json');
echo json_encode($musicas);
?>