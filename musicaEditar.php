<?php
require_once 'conecta_db.php';

$nomeMusica = '';

if(isset($_POST['salvar'])) {
    $id_musica = $_GET['id'];
    $nomeMusica = $_POST['nome_musica'];

    $conn = conecta_db();

    $stmt = $conn->prepare("UPDATE musicas_tb SET nome_musica = ? WHERE id_musica = ?");
    $stmt->bind_param("si", $nomeMusica, $id_musica);

    if ($stmt->execute()) {
        echo 'Música atualizada com sucesso!';
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

    $resultado = $conn->query("SELECT nome_musica FROM musicas_tb WHERE id_musica = $id_musica");

    if ($resultado->num_rows > 0) {
        $linha = $resultado->fetch_assoc();
        $nomeMusica = $linha['nome_musica'];
    } else {
        echo 'Música não encontrada.';
        exit;
    }

    $conn->close();
} else {
    echo 'ID não fornecido.';
    exit;
}
?>

<form action="musicaEditar.php?id=<?php echo $id_musica; ?>" method="post">
    <label for="nome_musica">Nome da Música:</label>
    <input type="text" name="nome_musica" value="<?php echo htmlspecialchars($nomeMusica); ?>" required>
    <input type="submit" name="salvar" value="Salvar Alterações">
</form>
