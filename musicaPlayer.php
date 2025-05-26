<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Player de Músicas</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    .musica { cursor: pointer; margin: 10px 0; }
    .musica.ativa { font-weight: bold; color: blue; }
  </style>
</head>
<body>

  <h2>🎵 Playlist</h2>
  <div id="lista-musicas"></div>
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
      listaDiv.innerHTML = '';
      musicas.forEach((musica, index) => {
        const div = document.createElement('div');
        div.textContent = musica.nome;
        div.className = 'musica';
        div.onclick = () => {
          carregarMusica(index);
          audio.play();
        };
        listaDiv.appendChild(div);
      });
    }

    function carregarMusica(index) {
      atual = index;
      audio.src = musicas[index].caminho;
      atualizarEstilo();
    }

    function atualizarEstilo() {
      document.querySelectorAll('.musica').forEach((el, i) => {
        el.classList.toggle('ativa', i === atual);
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
