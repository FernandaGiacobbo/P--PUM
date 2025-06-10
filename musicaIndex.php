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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/musicaIndex.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Upload Musica</title>
    
</head>
<body>
    <H1>Upload Musica:</H1>

    <form id="formulario" action="musicaUpload.php" method="POST" enctype="multipart/form-data">
        <input id="botaoSub" type="file" name="audiofile" accept=".mp3, .wav"/>
        <input id="botaoSub" type="submit" value="Upload" name="save_audio"/>

    </form>

<?php

if (isset($_GET['status'])) {
    // Armazena a mensagem na sessão para exibir após o redirecionamento
    $_SESSION['upload_status'] = $_GET['status'];
    
    // Redireciona para limpar a URL
    header("Location: musicaIndex.php");
    exit;
}

// Verifica se há mensagem na sessão para exibir
if (isset($_SESSION['upload_status'])) {
    $status = $_SESSION['upload_status'];
    unset($_SESSION['upload_status']); // Remove para não exibir novamente
    
    // Define a mensagem e o tipo de alerta
    if ($status === 'sucesso') {
        $alert_message = 'Upload realizado com sucesso!';
        $alert_type = 'success';
    } else {
        $alert_message = 'Erro ao realizar o upload!';
        $alert_type = 'error';
    }
    
    // Adiciona o script para exibir o SweetAlert
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: '$alert_type',
            title: '$alert_message',
            showConfirmButton: false,
            timer: 3000
        });
    });
    </script>";

}


include 'gerenteHeader.php';

$id_us = $_SESSION['id'];
$logado = $_SESSION['nome'];

if (!empty($id_us)) {
    // importa o arquivo que possui a função para conectar o db
    require_once 'conecta_db.php';
    //função de listar musicas  
    function listarMusicas() {
        //conecta com o banco usando a func conecta_db
        $conn = conecta_db();
        
        //executa consulta para pegar o ID e o nome das musicas     
        $resultado = $conn->query("SELECT id_musica, nome_musica FROM tb_musicas");
        //verifica se existem musicas (foram retornadas linhas)
        if ($resultado->num_rows > 0) {
            //comeca a fazer a tabela em html
            echo '<table>';
            echo '<tr><th>ID</th><th>Nome da Música</th><th>Ações</th></tr>';
            //loop por todas as linhas retornadas (cada musica)
            while ($linha = $resultado->fetch_assoc()) {
                echo '<tr>';
                //mostra id da musica
                echo '<td>' . $linha['id_musica'] . '</td>';
                //mostra nome da musica
                echo '<td>' . $linha['nome_musica'] . '</td>';
                echo '<td>';
                //link para editar a musica
                echo '<a href="musicaEditar.php?id=' . $linha['id_musica'] . '">Editar</a> | ';
                //link para deletar a musica
                echo '<a href="musicaDelete.php?id=' . $linha['id_musica'] . '" onclick="confirmarExclusao(event)">Deletar</a>';
                echo '</td>';
                echo '</tr>';
            }
            //fecha a tabela
            echo '</table>';
        } else {
            //caso nenhuma musica seja encontrada, printa isso:
            echo '<h4 id="aviso">Nenhuma música encontrada.<h4>';
        }
        //fecha conexao com o banco
        $conn->close();
    }
    //chama a funcao para mostrar musicas na tela
    listarMusicas();
} else {
    header('Location: musicaIndex.php');
    die();
}
?>  

<script>
// Feedback simples após o envio do formulário
document.getElementById('formulario').addEventListener('submit', function(e) {
    // Pode adicionar uma verificação rápida do arquivo se quiser
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput.files.length === 0) {
        e.preventDefault();
        Swal.fire('Erro!', 'Selecione um arquivo antes de enviar.', 'error');
        return;
    }
    
    // Feedback visual simples
    Swal.fire({
        title: 'Enviando...',
        text: 'Por favor aguarde',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
});

// Substitui o confirm padrão da exclusão
function confirmarExclusao(event) {
    event.preventDefault();
    const url = event.target.getAttribute('href');
    
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você quer mesmo deletar esta música?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim, deletar!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

              <div class="caminho">
                <a href="gerentePerfil.php"><?php echo $logado;?></a> /
                <a href="gerentePrincipal.php">Home</a> / 
                <a href="musicaIndex.php"><b>Musicas</b></a>
            </div>

</body>
</html>


<?php
  } else {
    header('Location: index.php');
    die();
  }

?>