<?php

//Inclui o arquivo que contém a função para conectar ao banco de dados.
    // Garante que a função conecta_db() posso ser utilizada maia adiante.
include('conecta_db.php');

//Verifica se os dados 'id', 'x' e 'y' foram enviados via método POST.
    // Essa verificação é importante para garantir que só tentaremos atualizar o post-it
    //se tivermos todos os dados necessários (id do post-it e suas coordenadas).
if (isset($_POST['id']) && isset($_POST['x']) && isset($_POST['y'])) {

    // Armazena os dados recebidos do formulário ou requisição JavaScript nas variáveis locais.
    $id = $_POST['id']; // Identificador único do post-it que será movido.
    $x = $_POST['x']; // Nova coordenada horizontal (posição X)
    $y = $_POST['y']; // Nova coordenada vertical (posição Y)


    // Chama a função conecta_db(), definida no arquivo incluído anteriormente,
    //para abrir um conexão com o banco de dados.
    $conexao = conecta_db();

    // Monta a instrução SQL que atualiza as coordenadas dos post-its com base no ID.
    // A query atualiza os valores de 'posicaoX' e 'posicaoY' na tabela 'postits'.
        // A query UPDATE garante persistência da posição dos post-its mesmo após atualizar ou fechar a página.
    $sql = "UPDATE postits SET posicaoX = $x, posicaoY = $y WHERE id_postit = $id";
    
    // Executa a query no banco de dados utilizando conexão aberta.
    // Isso efetivamente move o post-it para a nova posição salva.
    $conexao->query($sql);
}
?>
