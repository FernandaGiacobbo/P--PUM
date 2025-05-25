<?php

session_start();

include_once('conecta_db.php');
$oMysql = conecta_db();

if (isset($_POST['editar'])) {
    $id_daily = $_SESSION['id_daily'];
    $resumo_dia = $_POST['resumo_dia'];
    $inicio_planejado = $_POST['inicio_planejado'];
    $metas_definidas = $_POST['metas_definidas'];
    $metas_concluidas = $_POST['metas_concluidas'];
    $adiantou_tarefa = $_POST['adiantou_tarefa'];
    $postura_pendencias = $_POST['postura_pendencias'];
    $emocao_dia = $_POST['emocao_dia'];
    $conselho_para_si = $_POST['conselho_para_si'];
    $texto_livre = $_POST['texto_livre'];
    

    $queryTroca = "UPDATE tb_daily SET resumo_dia = '$resumo_dia', inicio_planejado = '$inicio_planejado', metas_definidas = '$metas_definidas', metas_concluidas = '$metas_concluidas', adiantou_tarefa = '$adiantou_tarefa', postura_pendencias = '$postura_pendencias', emocao_dia = '$emocao_dia', conselho_para_si = '$conselho_para_si', texto_livre = '$texto_livre' WHERE id_daily = $id_daily";
    $Troca = $oMysql->query($queryTroca);

    header('Location: dailyVisualizar.php');
} else {
    echo"error";
}

?>