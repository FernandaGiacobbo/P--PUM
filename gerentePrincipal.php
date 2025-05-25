<?php

session_start();

if(!isset($_SESSION['id'])) {
    header('Location: index.html');
    exit();
}

include_once('conecta_db.php');
$oMysql = conecta_db();

$logado = $_SESSION['nome'];
$id_us = $_SESSION['id'];
$cargo = $_SESSION['cargo'];

if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
        header('location: indexLogin.php');
} 

$query = "SELECT * from tb_usuario WHERE id_usuario = '$id_us'";
$resultado = $oMysql->query($query);


if (isset($_GET['page'])) {
    if ($_GET['page'] == 1) {
        include 'mainwewewe.php';
    
    } else {
        include 'gerenteMain.php';
    }
} else {
    include 'gerenteMain.php';
}


        
?>