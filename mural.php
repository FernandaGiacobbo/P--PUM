<?php

include('conecta_db.php');


if (isset($_POST['adicionar'])) {
    $texto = $_POST['texto_postit'];
    $cor = $_POST['cor_postit'];

    $conexao = conecta_db();
    $sql = "INSERT INTO postits (texto_postit, cor_postit, posicaoX, posicaoY) VALUES ('$texto', '$cor', 100, 100)";
    $conexao->query($sql);
    header("Location: mural.php");
}

function buscar_postits() {
    $conexao = conecta_db();
    $sql = "SELECT * FROM postits";
    $resultado = $conexao->query($sql);
    $postits = [];
    while ($linha = $resultado->fetch_assoc()) {
        $postits[] = $linha;
    }
    return $postits;
}

$postits = buscar_postits();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mural de Post-its</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
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
</body>
</html>