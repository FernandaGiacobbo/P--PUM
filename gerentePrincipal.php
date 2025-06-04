<?php

$tempoExpiracao = 86400; //limita a 86400s = 1 dia a sessão do usuário caso não tenha nenhuma inatividade

ini_set('session.gc_maxlifetime', $tempoExpiracao); // controla quanto tempo o php mantém os dados no servidor 
session_set_cookie_params($tempoExpiracao); //Controla quanto tempo o PHP mantém os dados da sessão no servidor após inatividade.

session_start();

// Verifica se houve inatividade superior a 1 dia
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tempoExpiracao)) {
    session_unset();    
    session_destroy();  // destrói a sessão
    header('Location: index.php'); 
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // atualiza tempo da última atividade


if(!isset($_SESSION['id'])) {
    header('Location: index.php');
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