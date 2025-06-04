<?php

session_start();

if(isset($_POST['cadastro'])){

    include_once('conecta_db.php');
    $oMysql = conecta_db();

    

    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $cargo = 'estudante';

    function validarSenha($senha){
    $senhaMaiuscula = preg_match('@[A-Z]@', $senha); //preg_match funciona para realizar verificações de acordo com os padões criados
    $senhaMinuscula = preg_match('@[a-z]@', $senha);
    $senhaNumero = preg_match('@[0-9]@', $senha);
    $senhaCaracter = preg_match('@[^\w]@', $senha);
    $senhaTamanho = strlen($senha) >= 8;

    return $senhaMaiuscula && $senhaMinuscula && $senhaNumero && $senhaCaracter && $senhaTamanho;
    }

    // função criada para validar se a senha é forte ou não 

    


    $query2 = "SELECT id_usuario FROM tb_usuario WHERE email_usuario = '$email' ";
    $resultado2 = $oMysql->query($query2);
  // query feita para verificar se existe algum id associado ao e-mail, caso não exista a pessoa pode cadastrar normalmente 


    if(empty($nome) || empty($senha) || empty($email)){
      echo "<script>alert('Campos obrigatorios incompletos');</script>";
      echo "<script>window.location.href = 'index.php';</script>";
      die();
      //verificando se todos os campos estão preenchidos

    }elseif (mysqli_fetch_assoc($resultado2) > 0) {
        
        echo "<script>window.location.href = 'index.php?error=1';</script>";
        die();
        // validar se e-mail já existe

        } else if (!validarSenha($_POST['senha'])) {
          echo "<script>window.location.href = 'index.php?error=2';</script>";
          die();
          //validar chama a função e verifica se a senha cumpre os requisitos

        } else {

          //caminho feliz, cliente é cadastrado com sucesso 

            $query = "INSERT INTO tb_usuario(email_usuario, nome_usuario, senha_usuario, cargo) VALUES ('$email', '$nome', '$senha', 'estudante')";
            $resultado = $oMysql->query($query);

            if($resultado){
              $id_usuario = $oMysql->insert_id; //retorna o valor que foi gerado para o id criado 
      
            
      
              $_SESSION['nome'] = $nome;
              $_SESSION['email'] =$email;
              $_SESSION['id'] = $id_usuario;
              $_SESSION['senha'] =$senha;
              $_SESSION['cargo'] = $cargo;
        
              echo "<script>window.location.href = 'principal.php?sucesso=1';</script>";
            } else {
              header('Location: index.php');
              die("Erro no cadastro: " . $oMysql->error);
            }
         
  
        }
          
        }


?>

