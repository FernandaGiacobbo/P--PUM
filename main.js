function excluirPostit(id) {
    if (confirm("Tem certeza que deseja excluir esta nota?")) {
        window.location.href = "excluir_postit.php?id=" + id;
    }
}

document.querySelectorAll('.postit').forEach(postit => {
    postit.draggable = true;

    postit.addEventListener('dragstart', function(e) {
        postit.style.zIndex = 1000;
    });

    postit.addEventListener('dragend', function(e) {
        postit.style.zIndex = '';
        const x = e.pageX - postit.offsetWidth / 2;
        const y = e.pageY - postit.offsetHeight / 2;

        postit.style.left = `${x}px`;
        postit.style.top = `${y}px`;

        const id = postit.getAttribute('data-id');
        atualizarPosicaoPostit(id, x, y);
    });
});

function atualizarPosicaoPostit(id, x, y) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "atualizar_posicao.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`id=${id}&x=${x}&y=${y}`);
}
