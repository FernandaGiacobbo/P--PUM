const abrirModal = document.getElementById("abrir");
const modal = document.getElementById("modal");
const fecharModal = document.getElementById("fechar");

abrirModal.onclick = function () {
    modal.showModal();
}

fecharModal.onclick = function() {
    modal.close();
}
