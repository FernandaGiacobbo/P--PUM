<?php

session_start();

if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])){
    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $email = $_POST['email'];
    $senha = $_POST['senha']; 

    $query = "SELECT * from tb_usuario WHERE email_usuario = '$email'";
    $resultado = $oMysql->query($query);

    $usuario = mysqli_fetch_assoc($resultado);

    if(!password_verify($senha, $usuario['senha_usuario']) || $email != $usuario['email_usuario']){ //faz verificação da senha descodificando o hash
        
        echo "<script>alert('Usuário ou senha incorretos!');</script>";
        echo "<script>window.location.href = 'index.php';</script>";

    } else {

      $_SESSION['nome'] = $usuario['nome_usuario'];
      $_SESSION['email'] = $usuario['email_usuario'];
      $_SESSION['id'] = $usuario['id_usuario'];
      $_SESSION['senha'] = $usuario['senha_usuario'];
      $_SESSION['cargo'] = $usuario['cargo'];
        
      switch ($usuario['cargo']) {
        case 'estudante':
          header('Location: principal.php');
          exit();
        case 'gerente':
          header('Location: gerentePrincipal.php');
          exit();
        case 'admin':
          header('Location: adminMain.php');
          exit();
        default:
          echo "<script>
                alert('Cargo inválido! Contate o suporte.');
                window.location.href = 'index.php';
              </script>";
          exit();
        }
    }

}

