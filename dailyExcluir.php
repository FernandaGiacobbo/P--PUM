<?php

session_start();

include_once('conecta_db.php');
$oMysql = conecta_db();

$id_daily = $_GET['id_daily'];

$query = "DELETE FROM tb_daily WHERE id_daily = $id_daily";
$resultado = $oMysql->query($query);

//atenção
header('location: dailyVisualizar.php');
?>