

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/musicaIndex.css">
    <title>Upload Musica</title>
</head>
<body>
    <H1>Upload Musica:</H1>

    <form id="formulario" action="musicaUpload.php" method="POST" enctype="multipart/form-data">
        <input id="botoes" type="file" name="audiofile"/>
        <input id="botoes" type="submit" value="Upload" name="save_audio"/>

    </form>

<?php
// importa o arquivo que possui a função para conectar o db
require_once 'conecta_db.php';
//função de listar musicas 
function listarMusicas() {
    //conecta com o banco usando a func conecta_db
    $conn = conecta_db();
    
    //executa consulta para pegar o ID e o nome das musicas     
    $resultado = $conn->query("SELECT id_musica, nome_musica FROM musicas_tb");
    //verifica se existem musicas (foram retornadas linhas)
    if ($resultado->num_rows > 0) {
        //comeca a fazer a tabela em html
        echo '<table>';
        echo '<tr><th>ID</th><th>Nome da Música</th><th>Ações</th></tr>';
        //loop por todas as linhas retornadas (cada musica)
        while ($linha = $resultado->fetch_assoc()) {
            echo '<tr>';
            //mostra id da musica
            echo '<td>' . $linha['id_musica'] . '</td>';
            //mostra nome da musica
            echo '<td>' . $linha['nome_musica'] . '</td>';
            echo '<td>';
            //link para editar a musica
            echo '<a href="musicaEditar.php?id=' . $linha['id_musica'] . '">Editar</a> | ';
            //link para deletar a musica
            echo '<a href="musicaDelete.php?id=' . $linha['id_musica'] . '" onclick="return confirm(\'Tem certeza?\')">Deletar</a>';
            echo '</td>';
            echo '</tr>';
        }
        //fecha a tabela
        echo '</table>';
    } else {
        //caso nenhuma musica seja encontrada, printa isso:
        echo 'Nenhuma música encontrada.';
    }
    //fecha conexao com o banco
    $conn->close();
}
//chama a funcao para mostrar musicas na tela
listarMusicas();

?>
    
</body>
</html>

