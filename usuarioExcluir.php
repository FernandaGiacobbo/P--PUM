<?php

session_start();

    $senha_log = $_SESSION['senha'];
    $email_log = $_SESSION['email'];
    $logado = $_SESSION['nome'];
    $id_us = $_SESSION['id']; 

    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $queryTarefa = "DELETE FROM tb_tarefa WHERE usuario_id = $id_us";
    $queryDaily = "DELETE FROM tb_daily WHERE usuario_id = $id_us";
    $query = "DELETE FROM tb_usuario WHERE id_usuario = $id_us";
    
    $resultadoTarefa = $oMysql->query($queryTarefa);
    $resultadoDaily = $oMysql->query($queryDaily);  
    $resultado = $oMysql->query($query);
    


    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    unset($_SESSION['id']);
    unset($_SESSION['senha']);

    header('location: index.html');

?>