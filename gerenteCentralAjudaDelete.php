<?php

session_start();
include_once('conecta_db.php');
$oMysql = conecta_db();

$id_resposta = $_GET['id'];

$query = "DELETE FROM tb_resDuvidas WHERE id_resposta = $id_resposta";
$resultado = $oMysql->query($query);
?>