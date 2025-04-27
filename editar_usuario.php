<?php

session_start();



    $senha_log = $_SESSION['senha'];
    $email_log = $_SESSION['email'];
    $logado = $_SESSION['nome'];
    $id_us = $_SESSION['id']; 

if(isset($_POST['subimit'])){

    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = "UPDATE tb_usuario SET email_usuario = '$email', nome_usuario = '$nome', senha_usuario = '$senha' WHERE id_usuario = '$id_us'";
    $resultado = $oMysql->query($query);

     $_SESSION['nome'] = $nome;

    header('location: perfil.php');
 // querry funcionando com sucesso
}
?>


<!DOCTYPE html>
<?php include 'header.php';?>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="main.css">
</head>
<body>

<section class="home">

<div class="container">
    <div class="jumbotron">
        <h3>Editar Perfil</h3> 
        <form action="" method="post">
            <div class="container">
                <h2>Nome:</h2>
                <div class="panel panel-default">
                <div class="panel-body"><input type="text" class="form-control" id="nome" value="<?php echo $logado;?>" name="nome"></div>
                </div>
                </div>

                <div class="container">
                <h2>E-mail</h2>
                <div class="panel panel-default">
                <div class="panel-body"><input type="email" class="form-control" id="email" value="<?php echo $email_log;?>" name="email"></div>
                </div>
                </div>

                <div class="container">
                <h2>Senha</h2>
                <div class="panel panel-default">
                <div class="panel-body"><input type="password" class="form-control" id="senha" value="<?php echo $senha_log;?>" name="senha"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="submit" name="subimit">Submit</button>
  </div>
        </form>
</div>

</section>

</body>
</html>