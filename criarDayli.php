<?php

session_start();

$id_us = $_SESSION['id'];

if(isset($_POST['submit'])){
    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $rotina = $_POST['daylist'];
    $rotina = mysqli_real_escape_string($oMysql, $rotina);
    $mood = $_POST['mood'];
    $data = date('Y-m-d');

    $query = "INSERT INTO tb_daily(data_daily, mooday_daily, texto_daily, usuario_id) VALUES ('$data', '$mood', '$rotina', '$id_us')";
    $resultado = $oMysql->query($query);

    $id_daily = $oMysql->insert_id;

    header('location: dayli.php');

}

?>
