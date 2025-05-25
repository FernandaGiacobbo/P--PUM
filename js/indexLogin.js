const entarModal = document.getElementById("modal");
const modal = document.getElementById("abirModal");
const fechar = document.getElementById("fecharModal");

entarModal.onclick = function () {
    modal.showModal();
};

fechar.onclick = function () {
    modal.close();
};

