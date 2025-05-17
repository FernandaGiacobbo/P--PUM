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
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;

            header('location: usuarioPerfil.php');
 
}


?>


<!DOCTYPE html>
<?php include 'header.php';?>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="usuarioEditar.css">
</head>
<body>

<section class="home">

    <section class="quadro-infos">
        <h3 class="titulo-caixa">Editar Perfil</h3>

        <div class="infos">
            <form action="" method="post">

                <div class="nome">
                    <div class="titulos-labels">
                        <h2>Nome:</h2>
                        <div class="panel panel-default">
                            <div class="panel-body"><input type="text" class="inputs" id="nome" value="<?php echo $logado;?>" name="nome">
                        </div>
                        </div>
                    </div>
                </div>

                <div class="email">
                    <div class="titulos-labels">
                        <h2>E-mail</h2>
                        <div class="panel panel-default">
                            <div class="panel-body"><input type="email" class="inputs" id="email" value="<?php echo $email_log;?>" name="email">
                        </div>
                        </div>
                    </div>
                </div>

                <div class="senha">
                    <div class="titulos-labels">
                        <h2>Senha</h2>
                        <div class="panel panel-default">
                            <div class="panel-body"><input type="password" class="inputs" id="senha" value="<?php echo $senha_log;?>" name="senha">
                        </div>
                        </div>
                    </div>
                </div>

                <br>

                <button type="submit" class="button-submit" id="submit" name="subimit">Submit</button>
            </form>
        </div>
            

    </section>
</section>

</body>
</html>