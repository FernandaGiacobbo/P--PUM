    <?php
    require_once 'conecta_db.php';

    if (isset($_POST['save_audio'])) {
        $dir = 'musicas/';
        $nome_arquivo = basename($_FILES['audiofile']['name']);
        $caminho_completo = $dir . $nome_arquivo;

        // Tenta mover o arquivo para a pasta 'musicas/'
        if (move_uploaded_file($_FILES['audiofile']['tmp_name'], $caminho_completo)) {
            if (salvarMusica($nome_arquivo, $caminho_completo)) {
                header("Location: musicaIndex.php?status=sucesso");
                exit;
            } else {
                header("Location: musicaIndex.php?status=erro");
                exit;
            }
        }
    }

    function salvarMusica($nomeArquivo, $caminhoCompleto) {
        $conn = conecta_db();
        $stmt = $conn->prepare("INSERT INTO tb_musicas (nome_musica, caminho_arquivo) VALUES (?, ?)");
        $stmt->bind_param("ss", $nomeArquivo, $caminhoCompleto);
        $resultado = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $resultado;
    }

    if (salvarMusica($nome_arquivo, $caminho_completo)) {
    header("Location: musicaIndex.php?status=sucesso");
    } else {
        header("Location: musicaIndex.php?status=erro_db"); // Erro no banco
    }
?>