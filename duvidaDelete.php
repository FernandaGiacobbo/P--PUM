<?php

session_start();
include_once('conecta_db.php');
$oMysql = conecta_db();

if(isset($_GET['id_duvidas'])){
    $id_duvidas = $_GET['id_duvidas'];
    $query = "DELETE FROM tb_duvidas WHERE id_duvidas = $id_duvidas";
    $resultado = $oMysql->query($query);

    if($resultado){
        header('Location: duvidasVisualizar.php');
    } else {
        echo "<p>Erro ao atualizar: " . $oMysql->error . "</p>";
    }
} else {
    die("Dúvida não encontrada.");
}

?>