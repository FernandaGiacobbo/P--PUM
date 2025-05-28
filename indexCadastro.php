<?php

session_start();

if(isset($_POST['cadastro'])){

    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $cargo = 'estudante';


    $query2 = "SELECT id_usuario FROM tb_usuario WHERE email_usuario = '$email' ";
    $resultado2 = $oMysql->query($query2);
  // query feita para verificar se existe algum id associado ao e-mail, caso não exista a pessoa pode cadastrar normalmente 


    if(empty($nome) || empty($senha) || empty($email)){
      echo "<script>alert('Campos obrigatorios incompletos');</script>";
      echo "<script>window.location.href = 'index.html';</script>";
      die();
      //verificando se todos os campos estão preenchidos

    }elseif (mysqli_fetch_assoc($resultado2) > 0) {
        echo "<script>alert('e-mail já cadastrado!!');</script>";
        echo "<script>window.location.href = 'index.html';</script>";
        die();
        // validar se e-mail já existe

        } else if (strlen($senha) > 30) {
          echo "<script>alert('não foi possível criar uma nova conta com essa senha, tente novamente seguindo o padrão exigido');</script>";
          echo "<script>window.location.href = 'index.html';</script>";
          die();
          //validar se a senha tem menos de 30 caracter

        } else {

          //caminho feliz, cliente é cadastrado com sucesso 

            $query = "INSERT INTO tb_usuario(email_usuario, nome_usuario, senha_usuario, cargo) VALUE ('$email', '$nome', '$senha', 'estudante')";
            $resultado = $oMysql->query($query);
        
    
            $id_usuario = $oMysql->insert_id; //retorna o valor que foi gerado para o id criado 
      
            
      
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] =$email;
            $_SESSION['id'] = $id_usuario;
            $_SESSION['senha'] =$senha;
            $_SESSION['cargo'] = $cargo;
      
            
            echo "<script>alert('Usuário cadastrado com sucesso');</script>";
            echo "<script>window.location.href = 'principal.php';</script>";
  
        }
          
        }



?>

