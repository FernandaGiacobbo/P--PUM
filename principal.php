<?php

    include 'conecta_db.php';
    include 'header.php';

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
        header('location: index.php');
     } 
        include_once('conecta_db.php');
        $oMysql = conecta_db();
    
        $logado = $_SESSION['nome'];
        $id_us = $_SESSION['id']; 
    
        $query = "SELECT * from tb_usuario WHERE id_usuario = '$id_us'";
        $resultado = $oMysql->query($query);
    
        if (isset($_GET['page'])) {
            if ($_GET['page'] == 1) {
                include 'insert.php';
    
            } else if ($_GET['page'] == 2) {
                include 'update.php';
    
            } else if ($_GET['page'] == 3) {
                include 'delete.php';
    
            } else {
                include 'main.php';
            }
        } else {
            include 'main.php';
    }
?>

