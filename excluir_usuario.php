<?php

session_start();

    $senha_log = $_SESSION['senha'];
    $email_log = $_SESSION['email'];
    $logado = $_SESSION['nome'];
    $id_us = $_SESSION['id']; 

    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $query = "DELETE FROM tb_usuario WHERE id_usuario = $id_us";
    $resultado = $resultado2 = $oMysql->query($query);

    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    unset($_SESSION['id']);
    unset($_SESSION['senha']);

    header('location: index.php');

?>