<?php
session_start();

if(!isset($_SESSION['id'])) {
    header('Location: index.html');
    exit();
} else {
    include_once('conecta_db.php');
    $oMysql = conecta_db();

    include 'gerenteHeader.php';

        $senha_log = $_SESSION['senha'];
        $email_log = $_SESSION['email'];
        $logado = $_SESSION['nome'];
        $id_us = $_SESSION['id']; 
        $cargo = $_SESSION['cargo'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuarioPerfil.css">

    <title>Perfil</title>
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
            
                <button type="button" class="edit "><a href="#">Editar</a></button>
                <button type="submit" class="delete" id="Excluir" name="Excluir"><a href="#">Excluir</a></button>
                <button type="submit" class="logout" id="Excluir" name="Excluir"><a href="#">Sair</a></button>


        </section>
    </section>

</body>
</html>