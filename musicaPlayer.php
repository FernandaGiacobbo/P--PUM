<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Player de Músicas</title>
  <link rel="stylesheet" href="css/musicaPlayer.css">
</head>
<body>

<?php include 'header.php'; ?>

    <h2>Playlist de Músicas: </h2>
    <table id="lista-musicas" class="tabela-musicas">
        <thead>
            <tr>
                <th>#</th>
                <th>Música</th>
            </tr>
        </thead>
            <tbody></tbody>
    </table>

  <audio id="audio" controls></audio>

<script src="js/player.js"></script>

</body>
</html>
