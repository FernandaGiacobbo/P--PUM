<?php

session_start();
$id_us = $_SESSION['id']; 


if (!empty($id_us)) {

    $senha_log = $_SESSION['senha'];
    $email_log = $_SESSION['email'];
    $logado = $_SESSION['nome'];
    

    include_once('conecta_db.php');
    $oMysql = conecta_db();
} else {
    header('Location: index.html');
    die();
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Perfil</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/usuarioPerfil.css">


</head>
<body>

<?php include 'header.php';?>

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

