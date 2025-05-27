<?php

session_start();
include_once('conecta_db.php');
$oMysql = conecta_db();

$id_duvidas = $_POST['id'];
$texto = $_POST['texto'];
$id_usuario = $_SESSION['id'];

date_default_timezone_set('America/Sao_Paulo');
$data_resposta = date('Y-m-d');

if ($id_duvidas && $texto && $id_usuario) {
    $query = "INSERT INTO tb_resDuvidas (duvida_resposta, usuario_resposta, texto_resposta, data_resposta) VALUES ($id_duvidas, $id_usuario, '$texto', '$data_resposta')";

    $resultado = $oMysql->query($query);
} else {
    die("erro");
}

?>