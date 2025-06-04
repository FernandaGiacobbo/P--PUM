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

$id_us = $_SESSION['id'];
if (!empty($id_us)) {
    include('conecta_db.php');

    if (isset($_POST['adicionar'])) {
        $texto = $_POST['texto_postit'];
        $cor = $_POST['cor_postit'];

        // Validação do campo vazio (critério de aceite)
        if (empty(trim($texto))) {
            $_SESSION['alert'] = [
                'type' => 'error',
                'message' => 'Não foi possível criar uma nota sem informação'
            ];
            header("Location: postits.php");
            exit();
        }

        // Se o texto não estiver vazio, insere no banco
        $conexao = conecta_db();
        $sql = "INSERT INTO tb_postits (texto_postit, cor_postit, posicaoX, posicaoY) VALUES ('$texto', '$cor', 100, 100)";
        
        if ($conexao->query($sql)) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Registrado com sucesso'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'error',
                'message' => 'Erro ao registrar a nota'
            ];
        }
        header("Location: postits.php");
        exit();
    }

    function buscar_postits() {
        $conexao = conecta_db();
        $sql = "SELECT * FROM tb_postits";
        $resultado = $conexao->query($sql);
        $postits = [];
        while ($linha = $resultado->fetch_assoc()) {
            $postits[] = $linha;
        }
        return $postits;
    }

    $postits = buscar_postits();
} else {
    header('Location: index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mural de Post-its</title>
    <link rel="stylesheet" href="css/postits.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include('header.php'); ?>
    <section class="home">
        <?php if (isset($_SESSION['alert'])): ?>
            <script>
                Swal.fire({
                    icon: '<?= $_SESSION['alert']['type'] ?>',
                    title: '<?= $_SESSION['alert']['message'] ?>',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>

        <div class="mural">
            <?php foreach ($postits as $postit): ?>
                <div class="postit" style="background-color: <?= $postit['cor_postit']; ?>; top: <?= $postit['posicaoY']; ?>px; left: <?= $postit['posicaoX']; ?>px;" data-id="<?= $postit['id_postit']; ?>">
                    <div class="texto"><?= $postit['texto_postit']; ?></div>
                    <button class="excluir-btn" onclick="excluirPostit(<?= $postit['id_postit']; ?>)">Excluir</button>
                </div>
            <?php endforeach; ?>
        </div>

        <form id="formPostit" method="POST" action="postits.php">
            <div class="form-group">
                <label for="texto_postit">Texto do Post-it:</label>
                <textarea name="texto_postit" id="texto_postit" placeholder="Escreva aqui..." required></textarea>
            </div>
            <div class="form-group">
                <label for="cor_postit">Cor do Post-it:</label>
                <input type="color" name="cor_postit" id="cor_postit" value="#fffc00" required>
            </div>
            <button type="submit" name="adicionar">Adicionar Nota</button>
        </form>

        <script src="postits.js"></script>
    </section>

</body>
</html>