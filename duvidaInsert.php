<?php

session_start();

include_once('conecta_db.php');
$oMysql = conecta_db();

date_default_timezone_set('America/Sao_Paulo');
$data_duvidas = date('Y-m-d');

$id_usuario = $_SESSION['id'];

if (isset($_POST['submit']) && isset($_POST['titulo']) && isset($_POST['duvida'])) {
    $titulo = $oMysql->real_escape_string($_POST['titulo']);
    $texto = $oMysql->real_escape_string($_POST['duvida']);
    
    $query = "INSERT INTO tb_duvidas (titulo_duvidas, texto_duvidas, data_duvidas, usuario_duvidas) VALUES ('$titulo', '$texto', '$data_duvidas', $id_usuario)";
    $resultado = $oMysql->query($query);
    

    header('location: duvidasVisualizar.php');
} else {
    die("erro");
}

?>