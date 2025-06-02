<?php
// Inclui o arquivo que contém a função de conexão com o banco de dados
include('conecta_db.php');

// Verifica se foi passado um 'id' pela URL (método GET)
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Captura o ID do post-it que será excluído
    $conexao = conecta_db();
    
    // Conecta ao banco de dados 
    $sql = "DELETE FROM tb_postits WHERE id_postit = $id";

    // Executa o comando SQL
    $conexao->query($sql);

    // Redireciona de volta para o mural após a exclusão
    header("Location: postits.php");
}
?>
