<?php
include 'conecta_db.php';

//Informa ao navegador que o conteúdo retornado é um texto simples
header('Content-Type: text/plain');

try {
    //Verifica se o ID foi recebido via POST
    if (!isset($_POST['id_evento'])) {
        throw new Exception('ID não fornecido');
    }

    $oMysql = conecta_db();
    //Obtém o ID pra prevenir SQL injection
    $id = $oMysql->real_escape_string($_POST['id_evento']);

    // Verifica se o evento existe no bd antes de deletar
    $checkQuery = "SELECT id_evento FROM tb_evento WHERE id_evento = $id";
    $checkResult = $oMysql->query($checkQuery);
    
    //Se nada for encontrado com o ID requisitado
    if ($checkResult->num_rows === 0) {
        throw new Exception('Evento não encontrado');
    }

    $query = "DELETE FROM tb_evento WHERE id_evento = $id";
    
    //Executa a query de deletar
    if ($oMysql->query($query)) {
        if ($oMysql->affected_rows > 0) {
            echo "sucesso";
        } else {
            echo "erro: Nenhuma linha afetada";
        }
    } else {
        //Se houver erro, vai retornar isso
        throw new Exception($oMysql->error);
    }
} catch (Exception $e) {
    echo "erro: " . $e->getMessage();
}
?>