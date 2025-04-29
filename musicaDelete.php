<?php
    // importa o arquivo que faz a conexão com o banco de dados
require_once 'conecta_db.php';

    // verifica se o parâmetro 'id' foi enviado pela URL (via GET)
if (isset($_GET['id'])) {
        // armazena o valor do 'id' da música vindo da URL
    $id_musica = $_GET['id'];
        // chama a função que conecta ao banco de dados
    $conn = conecta_db();
    
        // prepara a instrução SQL para deletar uma música com base no ID  
    $stmt = $conn->prepare("DELETE FROM musicas_tb WHERE id_musica = ?");
        // Substitui o ponto de interrOgação (?) pelo valor do ID de forma segura
    $stmt->bind_param("i", $id_musica);

      // executa a query preparada
    if ($stmt->execute()) {
        //se a query for preparada, mostra a mensagem e redireciona para o musicaIndex.php
        echo 'Música deletada.';
        header('Location: musicaIndex.php');
    } else {
        //se houver erro, mostra a mensagem:
        echo 'Erro ao deletar a música.';
    }
    //fecha a preparação da query e do bd
    $stmt->close();
    $conn->close();
} else {
    //se o ID nao tiver sido enviado pela URL
    echo 'ID da música não encontrado.';
}

?>
