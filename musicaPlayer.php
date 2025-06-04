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

  $id_usuario = $_SESSION['id'];

  if(!empty($id_usuario)){

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Player de Músicas</title>
  <link rel="stylesheet" href="css/musicaPlayer.css">
</head>
<body>

<?php include 'header.php'; ?>

    <h2>Playlist de Músicas: </h2>
    <table id="lista-musicas" class="tabela-musicas">
        <thead>
            <tr>
                <th>#</th>
                <th>Música</th>
            </tr>
        </thead>
            <tbody></tbody>
    </table>

  <audio id="audio" controls></audio>

<script src="js/player.js"></script>

</body>
</html>

<?php
  } else {
    header('Location: index.php');
    die();
  }

?>