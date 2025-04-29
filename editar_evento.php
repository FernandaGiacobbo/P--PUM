<?php
include 'conecta_db.php';

header('Content-Type: text/plain');

try {
    $requiredFields = [
        'id_evento', 'titulo_evento', 'data_evento', 
        'horario_evento', 'data_prazo', 'hora_prazo', 'descricao'
    ];
    
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field])) {
            throw new Exception("Campo $field não fornecido");
        }
    }

    $oMysql = conecta_db();
    
    // Verifica se o evento existe
    $id = $oMysql->real_escape_string($_POST['id_evento']);
    $checkQuery = "SELECT id_evento FROM tb_evento WHERE id_evento = $id";
    $checkResult = $oMysql->query($checkQuery);
    
    if ($checkResult->num_rows === 0) {
        throw new Exception('Evento não encontrado');
    }

    // Prepara os dados
    $titulo = $oMysql->real_escape_string($_POST['titulo_evento']);
    $datai = $oMysql->real_escape_string($_POST['data_evento']);
    $horai = $oMysql->real_escape_string($_POST['horario_evento']);
    $datat = $oMysql->real_escape_string($_POST['data_prazo']);
    $horat = $oMysql->real_escape_string($_POST['hora_prazo']);
    $descricao = $oMysql->real_escape_string($_POST['descricao']);

    $query = "UPDATE tb_evento SET
              titulo_evento = '$titulo',
              data_evento = '$datai',
              horario_evento = '$horai',
              data_prazo = '$datat',
              hora_prazo = '$horat',
              descricao = '$descricao'
              WHERE id_evento = $id";

    if ($oMysql->query($query)) {
        if ($oMysql->affected_rows > 0) {
            echo "sucesso";
        } else {
            echo "aviso: Nenhum dado alterado (valores idênticos)";
        }
    } else {
        throw new Exception($oMysql->error);
    }
} catch (Exception $e) {
    echo "erro: " . $e->getMessage();
}
?>