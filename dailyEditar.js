document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal-editar');
    const btnSalvar = document.getElementById('salvar-edicao');
    const btnFechar = document.querySelector('button[onclick*="dailyVisualizar.php"]');

    if (!modal) {
        console.error('Modal não encontrado');
        return;
    }

    // Abre o modal automaticamente ao carregar a página
    modal.showModal();

    // Fechar modal ao clicar no botão Cancelar
    if (btnFechar) {
        btnFechar.addEventListener('click', () => {
            modal.close();
        });
    }

    // Fechar modal ao clicar no backdrop
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.close();
            window.location.href = 'dailyVisualizar.php';
        }
    });
});