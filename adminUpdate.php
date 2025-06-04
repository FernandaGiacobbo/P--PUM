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

    $id_us = $_SESSION['id'];

      $atualizado = false; // flag pra saber se deve mostrar o SweetAlert
      $error = false;

    if (!empty($id_us)) {
      
      include_once('conecta_db.php');
      $oMysql = conecta_db();

      $senha_log = $_SESSION['senha'];
      $email_log = $_SESSION['email'];
      $logado = $_SESSION['nome'];


      $querySenha = "SELECT senha_usuario FROM tb_usuario WHERE id_usuario = '$id_us'";
      $resultadoSenha = $oMysql->query($querySenha);
      $linhaSenha = $resultadoSenha->fetch_assoc();
      $senhaAtualHash = $linhaSenha['senha_usuario']; 



      if (isset($_POST['submit']) ) {
          
          $confirmSenha = $_POST['ConfirmSenha'];

          if (password_verify($confirmSenha, $senhaAtualHash)) {

                if(!empty($_POST['senha'])){

                  $nome = $_POST['nome'];
                  $email = $_POST['email'];
                  $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

                    function validarSenha($senhaInput){
                      $senhaMaiuscula = preg_match('@[A-Z]@', $senhaInput); 
                      $senhaMinuscula = preg_match('@[a-z]@', $senhaInput);
                      $senhaNumero = preg_match('@[0-9]@', $senhaInput);
                      $senhaCaracter = preg_match('@[^\w]@', $senhaInput);
                      $senhaTamanho = strlen($senhaInput) >= 8;

                      return $senhaMaiuscula && $senhaMinuscula && $senhaNumero && $senhaCaracter && $senhaTamanho;

                    }

                    if (validarSenha($senhaInput)) {
                      $query = "UPDATE tb_usuario SET email_usuario = '$email', nome_usuario = '$nome', senha_usuario = '$senha' WHERE id_usuario = '$id_us'";
                      $resultado = $oMysql->query($query);

                          $_SESSION['nome'] = $nome;
                          $_SESSION['email'] = $email;
                          $_SESSION['senha'] = $senha;

                          $atualizado = true;
                    } else {
                      $error = true;
                      
                    }
                
                } else {
                  $nome = $_POST['nome'];
                  $email = $_POST['email'];
                  
                  $query2 = "UPDATE tb_usuario SET email_usuario = '$email', nome_usuario = '$nome' WHERE id_usuario = '$id_us'";
                  $resultado2 = $oMysql->query($query2);

                  $_SESSION['nome'] = $nome;
                  $_SESSION['email'] = $email;

                  $atualizado = true;
                }

          } else {
              $error = true;
          }      
          
      } 
    } else {
      header('Location: index.php');
      die();
    }
?>

<!DOCTYPE html>
<?php include 'adminHeader.php'; ?>
<html lang="pt-br">
<head>
  <title>Editar Perfil</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="css/usuarioEditar.css">
</head>
<body>

<section class="home">
  <section class="quadro-infos">
    <h3 class="titulo-caixa">Editar Perfil</h3>

    <div class="infos">
      <form id="form-editar" action="" method="post">
        <div class="nome">
          <div class="titulos-labels">
            <h2>Nome:</h2>
            <div class="panel panel-default">
              <div class="panel-body">
                <input type="text" class="inputs" id="nome" value="<?php echo $logado; ?>" name="nome">
              </div>
            </div>
          </div>
        </div>

        <div class="email">
          <div class="titulos-labels">
            <h2>E-mail:</h2>
            <div class="panel panel-default">
              <div class="panel-body">
                <input type="email" class="inputs" id="email" value="<?php echo $email_log; ?>" name="email">
              </div>
            </div>
          </div>
        </div>

        <div class="senha">
          <div class="titulos-labels">
            <h2>Senha:</h2>
            <div class="panel panel-default">
              <div class="panel-body">
                <input type="password" class="inputs" id="senha" placeholder="preencha apenas caso queira mudar de senha!!" name="senha">
              </div>
            </div>
          </div>
        </div>

        <br>

        <button type="button" class="button-submit" id="ModalAbrir">Salvar</button>
          <dialog id="senhaConfirm">
            <div class="ModalSenha">
              <h2>Confirme sua senha para alterar o perfil</h2>
              <div class=""> <input type="password" name="ConfirmSenha" id="ConfirmSenha"></div>
              
              <div class="btnModal">
                  <button type="button" id="cancelar"> Cancelar</button>
                  <button type="submit" name="submit"> Confirmar</button>
              </div>

            </div>
          </dialog>
      </form>
    </div>
  </section>
</section>


<script>
      const modal = document.getElementById('senhaConfirm');
      const abrirM = document.getElementById('ModalAbrir');
      const fecharM = document.getElementById('cancelar');


      abrirM.onclick = function (event){
        event.preventDefault(); // impede envio imediato
        modal.showModal();
      }

      fecharM.onclick = function(event){
        event.preventDefault();
        modal.close();
      }
</script>

<?php if ($atualizado): ?>
  <script>


    Swal.fire({
      title: "Perfil atualizado com sucesso!",
      icon: "success",
      confirmButtonText: "OK"
    }).then(() => {
      window.location.href = "adminPerfil.php";
    });
  </script>
<?php endif?>

<?php if ($error): ?>

  <script>

    Swal.fire({
      title: "Não foi possível atualizar seu perfil!",
      icon: "error",
      confirmButtonText: "OK"
    }).then(() => {
      window.location.href = "adminPerfil.php";
    });
  </script>
<?php endif; ?>

</body>
</html>