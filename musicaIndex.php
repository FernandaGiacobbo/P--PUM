

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="insert.css">
    <title>Upload Musica</title>
</head>
<body>
    <H1>Upload Musica:</H1>

    <form action="musicaUpload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="audiofile"/>
        <input type="submit" value="Upload" name="save_audio"/>

    </form>
    
</body>
</html>

<?php
require_once 'conecta_db.php';

function listarMusicas() {
    $conn = conecta_db();
    

    $resultado = $conn->query("SELECT id_musica, nome_musica FROM musicas_tb");
    
    if ($resultado->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Nome da Música</th><th>Ações</th></tr>';
        
        while ($linha = $resultado->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $linha['id_musica'] . '</td>';
            echo '<td>' . $linha['nome_musica'] . '</td>';
            echo '<td>';
            echo '<a href="musicaEditar.php?id=' . $linha['id_musica'] . '">Editar</a> | ';
            echo '<a href="musicaDelete.php?id=' . $linha['id_musica'] . '" onclick="return confirm(\'Tem certeza?\')">Deletar</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo 'Nenhuma música encontrada.';
    }

    $conn->close();
}

listarMusicas();
?>