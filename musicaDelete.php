<?php
require_once 'conecta_db.php';

if (isset($_GET['id'])) {
    $id_musica = $_GET['id'];
    
    $conn = conecta_db();
    

    $stmt = $conn->prepare("DELETE FROM musicas_tb WHERE id_musica = ?");
    $stmt->bind_param("i", $id_musica);
    
    if ($stmt->execute()) {
        echo 'Música deletada.';

        header('Location: musicaIndex.php');
    } else {
        echo 'Erro ao deletar a música.';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'ID da música não encontrado.';
}
?>
