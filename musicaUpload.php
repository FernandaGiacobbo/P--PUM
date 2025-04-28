<?php
require_once 'conecta_db.php';

if (isset($_POST['save_audio'])) {
    $dir = 'musicas/';
    $nome_arquivo = basename($_FILES['audiofile']['name']);
    $caminho_completo = $dir . $nome_arquivo;

    if (move_uploaded_file($_FILES['audiofile']['tmp_name'], $caminho_completo)) {
        echo 'Upload realizado com sucesso!';
        salvarMusica($nome_arquivo); 
    } else {
        echo 'Erro ao enviar o arquivo.';
    }
}

function salvarMusica($nomeMusica) {
    $conn = conecta_db();

    $stmt = $conn->prepare("INSERT INTO musicas_tb (nome_musica) VALUES (?)");
    $stmt->bind_param("s", $nomeMusica);

    if ($stmt->execute()) {
        echo "<br>Música '$nomeMusica' salva no banco!";
    } else {
        echo "<br>Erro ao salvar no banco: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<form action="musicaIndex.php">
    <button>Voltar</button>
    
</form>

