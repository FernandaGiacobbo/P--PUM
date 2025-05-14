<?php

session_start();

include_once('conecta_db.php');
$oMysql = conecta_db();

$id_d = $_GET['id_daily'];

$query = "DELETE FROM tb_daily WHERE id_daily = $id_d";
$resultado = $oMysql->query($query);


header('location: dailyVisualizar.php');
?>