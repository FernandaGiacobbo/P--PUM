<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');//transforma a data padrão para São Paulo 

$id_us = $_SESSION['id'];
$resumo_dia = "";
$inicio_planejado = "";
$metas_definidas = "";
$metas_concluidas = "";
$adiantou_tarefa = "";
$postura_pendencias = "";
$emocao_dia = "";
$conselho_para_si = "";
$texto_livre = "";


if(isset($_POST['submit'])){
    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $data = date('Y-m-d');
    $query2 = "SELECT data_daily, id_daily FROM tb_daily WHERE id_usuario = $id_us AND data_daily = CURDATE()";

    $resultado2 = $oMysql->query($query2);

    if ($res = mysqli_fetch_assoc($resultado2)) {

        $id_day = $res['id_daily'];
        echo "<script>alert('Parece que você já criou um daily hoje: ');</script>";
        echo "<script>window.location.href = 'dailyEditar.php?id_daily=$id_day';</script>";//levar para a pagina de editar do id da tarfefa daquela data em especifico
        
        die(); 
    } else {
        

        $resumo_dia = $_POST['resumo_dia'];
        $inicio_planejado = $_POST['inicio_planejado'];
        $data = date('Y-m-d');
        $metas_definidas = $_POST['metas_definidas'];
        $metas_concluidas = $_POST['metas_concluidas'];
        $adiantou_tarefa = $_POST['adiantou_tarefa'];
        $postura_pendencias = $_POST['postura_pendencias'];
        $emocao_dia = $_POST['emocao_dia'];
        $conselho_para_si = $_POST['conselho_para_si'];
        $texto_livre = $_POST['texto_livre'];

        $query = "INSERT INTO tb_daily(id_usuario, data_daily, resumo_dia, inicio_planejado, metas_definidas, metas_concluidas, adiantou_tarefa, postura_pendencias, emocao_dia, conselho_para_si, texto_livre) VALUES ('$id_us', '$data', '$resumo_dia', '$inicio_planejado' , '$metas_definidas', '$metas_concluidas', '$adiantou_tarefa',  '$postura_pendencias', '$emocao_dia', '$conselho_para_si', '$texto_livre')";
        $resultado = $oMysql->query($query);

        header('location: dailyVisualizar.php');
    }


}

?>