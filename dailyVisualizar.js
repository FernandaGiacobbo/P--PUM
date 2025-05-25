document.addEventListener('DOMContentLoaded', () => {
    const abrirModal = document.getElementById("abrir");
    const modal = document.getElementById("modal");
    const fecharModal = document.getElementById("fechar");

    if (!modal) {
        console.error('Modal não encontrado');
        return;
    }

    // Abrir modal ao clicar no botão "Aqui"
    abrirModal.onclick = function() {
        modal.showModal();
    }

    // Fechar modal ao clicar no botão Cancelar
    fecharModal.onclick = function() {
        modal.close();
        // Resetar o formulário ao cancelar
        document.querySelector('#modal form').reset();
    }

    // Fechar modal ao clicar no backdrop e resetar formulário
    modal.addEventListener('click', (e) => {
        const dialogDimensions = modal.getBoundingClientRect();
        if (
            e.clientX < dialogDimensions.left ||
            e.clientX > dialogDimensions.right ||
            e.clientY < dialogDimensions.top ||
            e.clientY > dialogDimensions.bottom
        ) {
            modal.close();
            // Resetar o formulário ao clicar fora
            document.querySelector('#modal form').reset();
        }
    });
});