<?php
include('conecta_db.php');

if (isset($_POST['id']) && isset($_POST['x']) && isset($_POST['y'])) {
    $id = $_POST['id'];
    $x = $_POST['x'];
    $y = $_POST['y'];

    $conexao = conecta_db();
    $sql = "UPDATE postits SET posicaoX = $x, posicaoY = $y WHERE id_postit = $id";
    $conexao->query($sql);
}
?>
