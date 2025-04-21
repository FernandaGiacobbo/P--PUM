<?php

session_start();

if(isset($_POST['submit'])){

    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];


    $query2 = "SELECT id_usuario FROM tb_usuario WHERE email_usuario = '$email' ";
    $resultado2 = $oMysql->query($query2);
  // query feita para verificar se existe algum id associado ao e-mail, caso não exista a pessoa pode cadastrar normalmente 


    if(empty($nome) || empty($senha) || empty($email)){
      echo "<script>alert('Campos obrigatorios incompletos');</script>";
      echo "<script>window.location.href = 'cadastro.php';</script>";
      die();
      //verificando se todos os campos estão preenchidos

    }elseif (mysqli_fetch_assoc($resultado2) > 0) {
        echo "<script>alert('não foi possível criar uma nova conta com esse e-mail, tente um novo endereço');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        die();
        // validar se e-mail já existe

        } else if (strlen($senha) > 30) {
          echo "<script>alert('não foi possível criar uma nova conta com essa senha, tente novamente seguindo o padrão exigido');</script>";
          echo "<script>window.location.href = 'cadastro.php';</script>";
          die();
          //validar se a senha tem menos de 30 caracter

        } else {

          //caminho feliz, cliente é cadastrado com sucesso 

            $query = "INSERT INTO tb_usuario(email_usuario, nome_usuario, senha_usuario) VALUE ('$email', '$nome', '$senha')";
            $resultado = $oMysql->query($query);
        
    
            $id_usuario = $oMysql->insert_id;
      
            //alterado o meio de pegar o ID
      
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] =$email;
            $_SESSION['id'] = $id_usuario;
            $_SESSION['senha'] =$senha;
      
            echo "<script>alert('Usuário cadastrado com sucesso');</script>";
            echo "<script>window.location.href = 'principal.php';</script>";
  
        }
          
        }



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cadastro</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body> 

<div class="container">
  <h2>Cadastro</h2>
  <div class="well">
  <form action="" method="post">
    <div class="mb-3 mt-3">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="nome" placeholder="Enter email" name="email">
    </div>

    <div class="mb-3 mt-3">
      <label for="nome">Nome:</label>
      <input type="text" class="form-control" id="nome" placeholder="Enter name" name="nome">
    </div>

    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="senha" placeholder="Enter password" name="senha">
    </div>
    <div class="form-check mb-3">

    </div>
    <button type="submit" class="btn btn-primary" id="submit" name="submit">Cadastro</button>
  </form>
  </div>
</div>

</body>
</html>
