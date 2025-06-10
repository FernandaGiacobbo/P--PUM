<?php

session_start();
include_once('conecta_db.php');
$oMysql = conecta_db();

$id_duvidas = $_POST['id'];  
$texto = $oMysql->real_escape_string($_POST['texto']); 
$id_usuario = $_SESSION['id'];

date_default_timezone_set('America/Sao_Paulo');
$data_resposta = date('Y-m-d');

if ($id_duvidas && $texto && $id_usuario) {

    if (strlen($_POST['texto']) < 100) {
        header('Location: gerenteCentralAjuda.php?error=3');
        die();
    } elseif (strlen($_POST['texto']) > 500) {
        header('Location: gerenteCentralAjuda.php?error=4');
        die();
    } else {

            $query = "INSERT INTO tb_resDuvidas (duvida_resposta, usuario_resposta, texto_resposta, data_resposta) VALUES ($id_duvidas, $id_usuario, '$texto', '$data_resposta')";

            $resultado = $oMysql->query($query);

            if (!$resultado) {
                die("Erro ao inserir: " . $oMysql->error);
            } else {
                header('Location: gerenteCentralAjuda.php?sucesso=1');
            }

    }


} else {
    die("erro");
}

?>