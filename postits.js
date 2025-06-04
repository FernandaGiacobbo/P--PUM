function excluirPostit(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3A4A68',
        cancelButtonColor: '#E2B354',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
        
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "postits_excluir.php?id=" + id;
        }
    });
}

// Tornando os post-its arrastáveis
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
    xhr.open("POST", "postits_atualizarPosicao.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`id=${id}&x=${x}&y=${y}`);
}
