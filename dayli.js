const entrar = document.getElementById("modal");
const modal = document.getElementById("criar");
const sair = document.getElementById("Sair");



const editarm = document.querySelectorAll('.Editar');
const modaleditar = document.getElementById("editarmodal");
const saireditar = document.getElementById("SairEditar");


entrar.onclick = function() {
    modal.showModal();
};

Sair.onclick = function() {
    modal.close();
};

