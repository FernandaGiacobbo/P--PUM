<?php

session_start();

if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])){
    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $email = $_POST['email'];
    $senha = $_POST['senha']; 

    $query = "SELECT * from tb_usuario WHERE email_usuario = '$email' and senha_usuario = '$senha'";
    $resultado = $oMysql->query($query);

    echo "Query: " . $query . "<br>";
    echo "Resultados: " . mysqli_num_rows($resultado) . "<br>";

    if(mysqli_num_rows($resultado) < 1){
        
        echo "<script>alert('Usuário ou senha incorretos!');</script>";
        echo "<script>window.location.href = 'index.html';</script>";

    } else {

      $usuario = mysqli_fetch_assoc($resultado);

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
          header('Location: home_admin.php');
          exit();
        default:
          echo "<script>
                alert('Cargo inválido! Contate o suporte.');
                window.location.href = 'index.html';
              </script>";
          exit();
        }
    }

}

