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

$id_usuario = $_SESSION['id'];

if(!empty($id_usuario)){

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

<?php
    } else {
        header('Location: index.php');
        die();
    }
?>