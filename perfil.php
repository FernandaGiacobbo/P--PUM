<?php

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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="main.css">


</head>
<body>


<section class="home">

        <h3>Perfil</h3> 
            <div class="container">
                <h2>Nome:</h2>
                <div class="panel panel-default">
                <div class="panel-body"><?php echo $logado;?></div>
                </div>
                </div>

                <div class="container">
                <h2>E-mail</h2>
                <div class="panel panel-default">
                <div class="panel-body"><?php echo $email_log;?></div>
                </div>
                </div>

                <div class="container">
                <h2>Senha</h2>
                <div class="panel panel-default">
                <div class="panel-body"><?php echo $senha_log;?></div>
                </div>
            </div>

            <button type="button" class="btn "><a href="editar_usuario.php">Editar</a></button>
            <button type="submit" class="btn" id="Excluir" name="Excluir"><a href="excluir_usuario.php">Excluir</a></button>
            <button type="submit" class="btn" id="Excluir" name="Excluir"><a href="sairsession.php">Sair</a></button>

            </section>
 


</body>
</html>

