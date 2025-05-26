<?php

session_start();

$id_us = $_SESSION['id'];

include_once('conecta_db.php');
$oMysql = conecta_db();

$queryEstudantes = "SELECT COUNT(*) as total FROM tb_usuario WHERE cargo='estudante'";
$resultadoEstudantes = $oMysql->query($queryEstudantes);
$totalEstudantes = $resultadoEstudantes->fetch_object()->total;

$queryGerentes = "SELECT COUNT(*) as total FROM tb_usuario WHERE cargo='gerente'";
$resultadoGerentes = $oMysql->query($queryGerentes);
$totalGerentes = $resultadoGerentes->fetch_object()->total;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PA-PUM</title>
    <link rel="stylesheet" href="css/adminMain.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=preview" />

</head>
<body>
    
    <?php 
        include 'adminHeader.php';
    ?>

<section class="home">
<h2>Visão Geral do Sistema</h2>
<p class="subtitulo">Acompanhe os números de usuários do site</p>

    <div class="usuarios-geral">
        <div class="estudantes">
            <h4>Estudantes Cadastrados</h4>
            <p class="numero-estudantes"><?php echo $totalEstudantes; ?></p>
            
        </div>
        <div class="gerentes">
            <h4>Gerentes Cadastrados</h4>
            <p class="numero-gerentes"><?php echo $totalGerentes; ?></p>
            
        </div>

    </div>
</section>

</body> 
</html>