<?php
// Importa o arquivo com a função de conexão com o banco de dados
require_once 'conecta_db.php';

// Verifica se o formulário de upload foi enviado
if (isset($_POST['save_audio'])) {

    // Define o diretório onde os arquivos serão salvos
    $dir = 'musicas/';

    // Pega apenas o nome do arquivo enviado (sem o caminho temporário)
    $nome_arquivo = basename($_FILES['audiofile']['name']);

    // Monta o caminho completo onde o arquivo será salvo
    $caminho_completo = $dir . $nome_arquivo;

    // move_uploaded_file() move o arquivo da pasta temporária para o destino final
    if (move_uploaded_file($_FILES['audiofile']['tmp_name'], $caminho_completo)) {
        echo 'Upload realizado com sucesso!';
        // Chama a função para salvar o nome do arquivo no banco
        salvarMusica($nome_arquivo); 
    } else {
        // Caso o upload falhe
        echo 'Erro ao enviar o arquivo.';
    }
}
// Função que insere o nome do arquivo no banco de dados
function salvarMusica($nomeMusica) {
    // Conecta ao banco de dados
    $conn = conecta_db();

    // Prepara o comando SQL para inserir o nome do arquivo
    $stmt = $conn->prepare("INSERT INTO musicas_tb (nome_musica) VALUES (?)");
    $stmt->bind_param("s", $nomeMusica);

    // Executa a inserção
    if ($stmt->execute()) {
        echo "<br>Música '$nomeMusica' salva no banco!";
    } else {
        echo "<br>Erro ao salvar no banco: " . $stmt->error;
    }

    // Fecha a conexão com o banco
    $stmt->close();
    $conn->close();
}
?>
<!-- Botão simples que volta para a página de listagem -->
<form action="musicaIndex.php">
    <button>Voltar</button>
    
</form>

