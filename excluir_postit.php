<?php
include('conecta_db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conexao = conecta_db();
    $sql = "DELETE FROM postits WHERE id_postit = $id";
    $conexao->query($sql);
    header("Location: mural.php");
}
?>
