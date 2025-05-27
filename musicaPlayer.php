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

  <script>
    const listaDiv = document.getElementById('lista-musicas');
    const audio = document.getElementById('audio');
    let musicas = [];
    let atual = 0;

    // Carrega as músicas do PHP
    fetch('musicaGet.php')
      .then(res => res.json())
      .then(data => {
        musicas = data;
        exibirLista();
        carregarMusica(0);
      });

function exibirLista() {
  const tbody = document.querySelector('#lista-musicas tbody');
  tbody.innerHTML = '';
  musicas.forEach((musica, index) => {
    const tr = document.createElement('tr');
    tr.className = 'linha-musica';
    tr.onclick = () => {
      carregarMusica(index);
      audio.play();
    };

    const tdIndex = document.createElement('td');
    tdIndex.textContent = index + 1;

    const tdNome = document.createElement('td');
    tdNome.textContent = musica.nome;

    tr.appendChild(tdIndex);
    tr.appendChild(tdNome);
    tbody.appendChild(tr);
  });
}

    function carregarMusica(index) {
      atual = index;
      audio.src = musicas[index].caminho;
      atualizarEstilo();
    }

    function atualizarEstilo() {
    document.querySelectorAll('.linha-musica').forEach((linha, i) => {
        linha.classList.toggle('ativa', i === atual);
    });
    }

    // Toca a próxima música ao terminar
    audio.addEventListener('ended', () => {
      atual = (atual + 1) % musicas.length;
      carregarMusica(atual);
      audio.play();
    });
  </script>

</body>
</html>
