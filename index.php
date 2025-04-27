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
        echo "<script>window.location.href = 'index.php';</script>";

    } else {

        $usuario = mysqli_fetch_assoc($resultado);

        $_SESSION['nome'] = $usuario['nome_usuario'];
        $_SESSION['email'] = $usuario['email_usuario'];
        $_SESSION['id'] = $usuario['id_usuario'];
        $_SESSION['senha'] = $usuario['senha_usuario'];
        
        header('Location: principal.php');
        exit();
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>PaPum</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="well" >
  <h2>PaPum</h2>      
  <p>Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI,</p>
</div>

<div class="container">
  <h2>Login:</h2>
  
  <form action="" method="post">
    <div class="mb-3 mt-3">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="nome" placeholder="Enter email" name="email">
    </div>

    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="senha" placeholder="Enter password" name="senha">
    </div>
    <div class="form-check mb-3">

    </div>
    <button type="submit" class="btn btn-primary" id="submit" name="submit">Submit</button>
  </form>

  <button type="button" class="btn btn-link" ><a href="cadastro.php">Não tem cadastro? <br> Clique Aqui!</a></button>
</div>

</body>
</html>