<?php

session_start();
include_once('conecta_db.php');
$oMysql = conecta_db();

$id_resposta = $_POST['id'];
$texto = $oMysql->real_escape_string($_POST['texto']); 
date_default_timezone_set('America/Sao_Paulo');
$data_resposta = date('Y-m-d');

$query = "UPDATE tb_resDuvidas SET texto_resposta = '$texto', data_resposta = '$data_resposta' WHERE id_resposta = $id_resposta";
$resultado = $oMysql->query($query);


if (!$resultado) {
        die("Erro ao inserir: " . $oMysql->error);
    }


?>