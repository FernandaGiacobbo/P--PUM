<?php

session_start();

include_once('conecta_db.php');
$oMysql = conecta_db();

if (isset($_POST['salvar-edicao'])) {
    $id_day = $_SESSION['id_daily'];
    $resumo_dia = $_POST['resumo_dia'];
    $inicio_planejado = $_POST['inicio_planejado'];
    $metas_definidas = $_POST['metas_definidas'];
    $metas_concluidas = $_POST['metas_concluidas'];
    $adiantou_tarefa = $_POST['adiantou_tarefa'];
    $postura_pendencias = $_POST['postura_pendencias'];
    $emocao_dia = $_POST['emocao_dia'];
    $conselho_para_si = $_POST['conselho_para_si'];
    $texto_livre = $_POST['texto_livre'];
    

    $queryTroca = "UPDATE tb_daily SET 
                    resumo_dia = '".$oMysql->real_escape_string($resumo_dia)."', 
                    inicio_planejado = '".$oMysql->real_escape_string($inicio_planejado)."',
                    metas_definidas = ".(int)$metas_definidas.", 
                    metas_concluidas = ".(int)$metas_concluidas.", 
                    adiantou_tarefa = ".(int)$adiantou_tarefa.", 
                    postura_pendencias = '".$oMysql->real_escape_string($postura_pendencias)."', 
                    emocao_dia = '".$oMysql->real_escape_string($emocao_dia)."', 
                    conselho_para_si = '".$oMysql->real_escape_string($conselho_para_si)."', 
                    texto_livre = '".$oMysql->real_escape_string($texto_livre)."'
                    WHERE id_daily = $id_day";
    $Troca = $oMysql->query($queryTroca);

    if ($Troca) {
        header('Location: dailyVisualizar.php');
        exit();
    } else {
        echo "Erro ao atualizar: " . $oMysql->error;
    }
} else {
    echo "Acesso inválido";
}

?>