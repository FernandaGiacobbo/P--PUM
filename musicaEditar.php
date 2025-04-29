<?php
//importa o arquivo que conecta com o bd
require_once 'conecta_db.php';
//inicializa uma variavel vazia (para preencher o campo no form)
$nomeMusica = '';

// Verifica se o formulário foi enviado (botão "salvar" foi clicado)
if(isset($_POST['salvar'])) {
    // pega o ID da música pela URL (via GET)
    $id_musica = $_GET['id'];
     // Pega o novo nome da música enviado pelo formulário (via POST)
    $nomeMusica = $_POST['nome_musica'];

    // Conecta ao banco
    $conn = conecta_db();

    // Prepara o comando SQL para atualizar o nome da música com base no ID
    $stmt = $conn->prepare("UPDATE musicas_tb SET nome_musica = ? WHERE id_musica = ?");
    // Liga os parâmetros ao SQL de forma segura (s = string, i = inteiro)    
    $stmt->bind_param("si", $nomeMusica, $id_musica);

    // Executa a query
    if ($stmt->execute()) {
        echo 'Música atualizada com sucesso!';
        // Redireciona de volta para a página de listagem
        header('Location: musicaIndex.php');
        exit;
        // Se der erro, mostra mensagem
    } else {
        echo 'Erro ao atualizar a música.';
    }
    //fecha a query e a conexao
    $stmt->close();
    $conn->close();
}
// Se a página foi acessada com um ID via URL (sem ainda enviar o formulário)
if (isset($_GET['id'])) {
    $id_musica = $_GET['id'];
    $conn = conecta_db();
    // Busca o nome da música atual no banco, para exibir no formulário
    $resultado = $conn->query("SELECT nome_musica FROM musicas_tb WHERE id_musica = $id_musica");

    // Verifica se encontrou a musica
    if ($resultado->num_rows > 0) {
        // Pega os dados da música
        $linha = $resultado->fetch_assoc();
        $nomeMusica = $linha['nome_musica'];
    } else {
    
        echo 'Música não encontrada';
        exit;
    }
    // Fecha a conexão com o banco
    $conn->close();
} else {
    // Se o ID não foi informado na URL
    echo 'ID não fornecido.';
    exit;
}
?>
<!-- Formulário que envia os dados para a mesma página, mantendo o ID da música na URL -->
<form action="musicaEditar.php?id=<?php echo $id_musica; ?>" method="post">
    <label for="nome_musica">Nome da Música:</label>
     <!-- Campo de texto preenchido com o nome atual da música -->
    <input type="text" name="nome_musica" value="<?php echo htmlspecialchars($nomeMusica); ?>" required>
    <!-- Botão de envio -->
    <input type="submit" name="salvar" value="Salvar Alterações">
</form>
