<?php

session_start();
include_once('conecta_db.php');
$oMysql = conecta_db();

$id_duvida = $_GET['id'];

$query = "DELETE FROM tb_resDuvidas WHERE duvida_resposta = $id_duvida";
$resultado = $oMysql->query($query);

$query2 = "DELETE FROM tb_duvidas WHERE id_duvidas = $id_duvida";
$resultado2 = $oMysql->query($query2);
?>