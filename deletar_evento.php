<?php
include 'conecta_db.php';

header('Content-Type: text/plain');

try {
    if (!isset($_POST['id_evento'])) {
        throw new Exception('ID não fornecido');
    }

    $oMysql = conecta_db();
    $id = $oMysql->real_escape_string($_POST['id_evento']);

    // Verifica se o evento existe
    $checkQuery = "SELECT id_evento FROM tb_evento WHERE id_evento = $id";
    $checkResult = $oMysql->query($checkQuery);
    
    if ($checkResult->num_rows === 0) {
        throw new Exception('Evento não encontrado');
    }

    $query = "DELETE FROM tb_evento WHERE id_evento = $id";
    
    if ($oMysql->query($query)) {
        if ($oMysql->affected_rows > 0) {
            echo "sucesso";
        } else {
            echo "erro: Nenhuma linha afetada";
        }
    } else {
        throw new Exception($oMysql->error);
    }
} catch (Exception $e) {
    echo "erro: " . $e->getMessage();
}
?>