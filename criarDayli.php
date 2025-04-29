<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');//transforma a data padrão para São Paulo 

$id_us = $_SESSION['id'];

if(isset($_POST['submit'])){
    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $data = date('Y-m-d');
    $query2 = "SELECT data_daily, id_daily FROM tb_daily WHERE usuario_id = $id_us AND data_daily = '$data'";

    $resultado2 = $oMysql->query($query2);

    if ($res = mysqli_fetch_assoc($resultado2)) {

        $id_day = $res['id_daily'];
        echo "<script>alert('Parece que você já criou um daily hoje: ');</script>";
        echo "<script>window.location.href = 'Dailyeditar.php?id_daily=$id_day';</script>";//levar para a pagina de editar do id da tarfefa daquela data em especifico
        
        die(); 
    } else {
        
        $rotina = $_POST['daylist'];
        $rotina = mysqli_real_escape_string($oMysql, $rotina); //permite o que o usuario ultilize carcteres 
        $mood = $_POST['mood'];
        $data = date('Y-m-d');

        $query = "INSERT INTO tb_daily(data_daily, mooday_daily, texto_daily, usuario_id) VALUES ('$data', '$mood', '$rotina', '$id_us')";
        $resultado = $oMysql->query($query);

        header('location: dayli.php');
    }


}

?>