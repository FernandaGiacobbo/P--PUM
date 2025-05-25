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
        // Redireciona para dailyVisualizar.php ao invés de resetar
        window.location.href = 'dailyVisualizar.php';
    }

    // Fechar modal ao clicar no backdrop e redirecionar
    modal.addEventListener('click', (e) => {
        const dialogDimensions = modal.getBoundingClientRect();
        if (
            e.clientX < dialogDimensions.left ||
            e.clientX > dialogDimensions.right ||
            e.clientY < dialogDimensions.top ||
            e.clientY > dialogDimensions.bottom
        ) {
            modal.close();
            // Redireciona para dailyVisualizar.php ao invés de resetar
            window.location.href = 'dailyVisualizar.php';
        }
    });
});