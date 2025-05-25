<?php

session_start();

    if (!isset($_SESSION['id'])) {
        header('Location: index.php');
        exit();
    }

    include 'conecta_db.php';   

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
                include 'mainInsert.php';
    
            } else if ($_GET['page'] == 2) {
                include 'mainUpdate.php';
    
            } else if ($_GET['page'] == 3) {
                include 'mainDelete.php';
    
            } else {
                include 'main.php';
            }
        } else {
            include 'main.php';
    }
?>

