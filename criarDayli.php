<?php

session_start();

$id_us = $_SESSION['id'];

if(isset($_POST['submit'])){
    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $query2 = "SELECT data_daily, id_daily from tb_daily WHERE usuario_id = $id_us";
    $resultado2 = $oMysql->query($query2);

    if ($res = mysqli_fetch_assoc($resultado2)) {

        $id_day = $res['id_daily'];
        echo "<script>alert('Parece que você já criou um daily hoje: ');</script>";
        echo "<script>window.location.href = 'Dailyeditar.php?id_daily=$id_day';</script>";
        die();
    } else {
        
        $rotina = $_POST['daylist'];
        $rotina = mysqli_real_escape_string($oMysql, $rotina);
        $mood = $_POST['mood'];
        $data = date('Y-m-d');

        $query = "INSERT INTO tb_daily(data_daily, mooday_daily, texto_daily, usuario_id) VALUES ('$data', '$mood', '$rotina', '$id_us')";
        $resultado = $oMysql->query($query);

        $id_daily = $oMysql->insert_id;

        header('location: dayli.php');
    }


}

?>
