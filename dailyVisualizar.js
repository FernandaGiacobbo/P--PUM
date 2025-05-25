
const abrirModal = document.getElementById("abrir");
const modal = document.getElementById("modal");
const fecharModal = document.getElementById("fechar");
const editar = document.getElementById("editar");
const abrirModalEditar = document.getElementById("editar");
const formDaily = document.querySelector("#modal form");

    // Abrir modal
abrirModal.onclick = function() {
    modal.showModal();
}

    // Fechar modal
fecharModal.onclick = function() {
    modal.close();
}

abrirModalEditar.onclick = function() {
    modal.showModal();
}

fecharModalEditar.onclick = function() {
    modal.close();
}

