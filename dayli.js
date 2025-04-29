const entrar = document.getElementById("modal");
const modal = document.getElementById("criar");
const sair = document.getElementById("Sair");



entrar.onclick = function() {
    modal.showModal();
};

Sair.onclick = function() {
    modal.close();
};

