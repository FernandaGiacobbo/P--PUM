<?php
include 'gerenteHeader.php';
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

$logado = $_SESSION['nome'];
$id_us = $_SESSION['id'];
if (!empty($id_us)) {
    require_once 'conecta_db.php';
    $nomeMusica = '';

    if (isset($_POST['salvar'])) {
        $id_musica = $_GET['id'];
        $nomeMusica = $_POST['nome_musica'];

        $conn = conecta_db();

        // Atualiza o nome no banco
        $stmt = $conn->prepare("UPDATE tb_musicas SET nome_musica = ? WHERE id_musica = ?");
        $stmt->bind_param("si", $nomeMusica, $id_musica);

        if ($stmt->execute()) {
            // Busca o caminho atual do arquivo
            $query = $conn->prepare("SELECT caminho_arquivo FROM tb_musicas WHERE id_musica = ?");
            $query->bind_param("i", $id_musica);
            $query->execute();
            $query->bind_result($caminhoAtual);
            $query->fetch();
            $query->close();

            // Renomear arquivo
            $diretorio = dirname($caminhoAtual);
            $extensao = pathinfo($caminhoAtual, PATHINFO_EXTENSION);

            $nomeSanitizado = preg_replace("/[^a-zA-Z0-9-_]/", "_", $nomeMusica);
            $novoCaminho = $diretorio . '/' . $nomeSanitizado . '.' . $extensao;

            if (file_exists($caminhoAtual)) {
                if (rename($caminhoAtual, $novoCaminho)) {
                    // Atualiza o caminho no banco
                    $updateCaminho = $conn->prepare("UPDATE tb_musicas SET caminho_arquivo = ? WHERE id_musica = ?");
                    $updateCaminho->bind_param("si", $novoCaminho, $id_musica);
                    $updateCaminho->execute();
                    $updateCaminho->close();
                } else {
                    echo "Erro ao renomear o arquivo real.";
                }
            } else {
                echo "Arquivo original não encontrado.";
            }

            $stmt->close();
            $conn->close();

            header('Location: musicaIndex.php');
            exit;
        } else {
            echo 'Erro ao atualizar a música.';
        }

        $stmt->close();
        $conn->close();
    }

    if (isset($_GET['id'])) {
        $id_musica = $_GET['id'];
        $conn = conecta_db();
        $resultado = $conn->query("SELECT nome_musica FROM tb_musicas WHERE id_musica = $id_musica");

        if ($resultado->num_rows > 0) {
            $linha = $resultado->fetch_assoc();
            $nomeMusica = $linha['nome_musica'];
        } else {
            echo 'Música não encontrada';
            exit;
        }

        $conn->close();
    } else {
        echo 'ID não fornecido.';
        exit;
    }
} else {
    header('Location: index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="css/musicaEditar.css">
</head>
<body>
    <h1 id="titulo">Edição de arquivo: </h1>

    <form action="musicaEditar.php?id=<?php echo $id_musica; ?>" method="post">
        <label for="nome_musica">Nome da Música:</label>
        <input id="caixaTexto" type="text" name="nome_musica" value="<?php echo htmlspecialchars($nomeMusica); ?>" required>
        <input id="botao" type="submit" name="salvar" value="Salvar Alterações">
    </form>

            <div class="caminho">
                <a href="adminPerfil.php"><?php echo $logado;?></a> /
                <a href="gerentePrincipal.php">Home</a> / 
                <a href="musicaIndex.php">Musica</a> / 
                <a href=""><b>EditarMusica</b></a>
            </div>
</body>
</html>
