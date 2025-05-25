<?php

// Inclui o arquivo de conexão com o banco de dados
include('conecta_db.php');

// Verifica se o botão de adicionar foi acionado via POST
if (isset($_POST['adicionar'])) {

    //Recupera os dados do formulário
    $texto = $_POST['texto_postit'];
    $cor = $_POST['cor_postit'];

    // Conecta ao banco de dados
    $conexao = conecta_db();

    // Monta e executa a query para inserir uma nova nota na tabela 'postits'.
    // Os valores iniciais de posição (X e Y) são fixos em 100px.
    $sql = "INSERT INTO postits (texto_postit, cor_postit, posicaoX, posicaoY) VALUES ('$texto', '$cor', 100, 100)";
    $conexao->query($sql);

    // Redireciona para a prórpia página após o insert, evitando reenvio do formulário após atualizar
        // Esse redirecionamento com header() serve para evitar múltiplos enviois acidentais.
    header("Location: mural.php");
}

// Essa função traz todos os registros da tabela postits e os armazena em um array para uso posterior no HTML.
function buscar_postits() {
    $conexao = conecta_db();
    $sql = "SELECT * FROM postits";
    $resultado = $conexao->query($sql);

    // Inicializa array que armazenará os post-its
    $postits = [];

    // Adiciona cada linha retornada ao array
    while ($linha = $resultado->fetch_assoc()) {
        // O uso do fetch_assoc() retorna os dados como um array associativo, onde as chaves são os nomes das colunas.
        $postits[] = $linha;
    }
    return $postits;
}

// Chama a função e armazena os post-its na variável $postits para exibição
$postits = buscar_postits();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mural de Post-its</title>
    <link rel="stylesheet" href="css/mural.css">
</head>
<body>
    <?php
        include('header.php');
    ?>
<section class="home">
    <div class="mural">
        <?php foreach ($postits as $postit): ?>
            <div class="postit" style="background-color: <?= $postit['cor_postit']; ?>; top: <?= $postit['posicaoY']; ?>px; left: <?= $postit['posicaoX']; ?>px;" data-id="<?= $postit['id_postit']; ?>">
                <div class="texto"><?= $postit['texto_postit']; ?></div>
                <button class="excluir-btn" onclick="excluirPostit(<?= $postit['id_postit']; ?>)">Excluir</button>
            </div>
        <?php endforeach; ?>
    </div>

    <form id="formPostit" method="POST" action="mural.php">
        <textarea name="texto_postit" required></textarea><br>
        <input type="color" name="cor_postit" value="#fffc00" required><br>
        <button type="submit" name="adicionar">Adicionar Nota</button>
    </form>
    

    <script src="main.js"></script>

    <script src="mural.js"></script>
</section>
</body>
</html>