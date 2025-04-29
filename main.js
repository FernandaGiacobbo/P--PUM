function excluirPostit(id) {
    // Mostra uma janela de confirmação ao usuário antes de excluir
    if (confirm("Tem certeza que deseja excluir esta nota?")) {

        // Redireciona o navegador para o script PHP de exclusão, passando  o ID do post-it na URL
        window.location.href = "excluir_postit.php?id=" + id;
    }
}

// Tornando os post-its arrastáveis (drag e drop):
document.querySelectorAll('.postit').forEach(postit => {
    postit.draggable = true; // Permite que o elemento possa ser arrastado


    // Quando o usuário começa a arrastar
    postit.addEventListener('dragstart', function(e) {
        postit.style.zIndex = 1000; // Coloca o post-it acima dos outros visualmente
    });

    // Quando o usuário solta o post-it em algum lugar da tela
    postit.addEventListener('dragend', function(e) {
        postit.style.zIndex = '';
        // Reseta a posição visual

        // Calcula a nova posição com base no ponteiro do mouse
        const x = e.pageX - postit.offsetWidth / 2;
        const y = e.pageY - postit.offsetHeight / 2;

        // Atualiza a posição visual do post-it na tela
        postit.style.left = `${x}px`;
        postit.style.top = `${y}px`;

        // Recupera o ID  do post-it pelo atributo personalizado data-id
        const id = postit.getAttribute('data-id');

        // Chama a função para atualizar a posição no bando de dados
        atualizarPosicaoPostit(id, x, y);
    });
});

//Essa função é chamada toda vez que o usuário solta um post-it em uma nova posição
    // Usa AJAX para enviar os dados sem recarregar a página.
        // Envia os valores de ID, posição X e posição Y como se fosse um formulário POST.
            // O arquivo PHP atualizar_posicao.php recebe esses dados e atualiza o banco de dados
function atualizarPosicaoPostit(id, x, y) {
    const xhr = new XMLHttpRequest(); // Cria uma requisição AJAX
    xhr.open("POST", "atualizar_posicao.php", true); // Define o método e o destino
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Define o tipo de dado enviado
    xhr.send(`id=${id}&x=${x}&y=${y}`); // Envia os dados do post-it (id, x e y)
}
