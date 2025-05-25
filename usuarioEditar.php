<?php
session_start();

$senha_log = $_SESSION['senha'];
$email_log = $_SESSION['email'];
$logado = $_SESSION['nome'];
$id_us = $_SESSION['id'];

$atualizado = false; // flag pra saber se deve mostrar o SweetAlert

if (isset($_POST['subimit'])) {
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

    $atualizado = true; // marca que foi atualizado
}
?>

<!DOCTYPE html>
<?php include 'header.php'; ?>
<html lang="pt-br">
<head>
  <title>Editar Perfil</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="usuarioEditar.css">
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
                <input type="password" class="inputs" id="senha" value="<?php echo $senha_log; ?>" name="senha">
              </div>
            </div>
          </div>
        </div>

        <br>

        <button type="submit" class="button-submit" id="submit" name="subimit">Salvar</button>
      </form>
    </div>
  </section>
</section>

<?php if ($atualizado): ?>
  <script>
    Swal.fire({
      title: "Perfil atualizado com sucesso!",
      icon: "success",
      confirmButtonText: "OK"
    }).then(() => {
      window.location.href = "usuarioPerfil.php";
    });
  </script>
<?php endif; ?>

</body>
</html>
