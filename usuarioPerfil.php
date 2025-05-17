<?php

session_start();

include 'header.php';

    $senha_log = $_SESSION['senha'];
    $email_log = $_SESSION['email'];
    $logado = $_SESSION['nome'];
    $id_us = $_SESSION['id']; 

    include_once('conecta_db.php');
    $oMysql = conecta_db();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Perfil</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="usuarioPerfil.css">


</head>
<body>


<section class="home">
    <section class="quadro-infos">
        <h3 class="titulo-caixa">Perfil</h3>


        <div class="nome">
            <div class="titulos-labels">
                <h1>Nome:</h1>
                <div class="placeholder"><?php echo $logado;?></div>
            </div>
        </div>

        <div class="email">
            <div class="titulos-labels">
                <h1>E-mail:</h1>
                <div class="placeholder"><?php echo $email_log;?></div>
            </div>
        </div>

        <div class="senha">
            <div class="titulos-labels">
                <h1>Senha:</h1>
                <div class="placeholder"><?php echo $senha_log;?></div>
            </div>
        </div>

        <br>
        
            <button type="button" class="edit "><a href="usuarioEditar.php">Editar</a></button>
            <button type="submit" class="delete" id="Excluir" name="Excluir"><a href="usuarioExcluir.php">Excluir</a></button>
            <button type="submit" class="logout" id="Excluir" name="Excluir"><a href="sairsession.php">Sair</a></button>


    </section>
</section>
 


</body>
</html>

