document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal-editar');
    const btnSalvar = document.getElementById('salvar-edicao');
    const btnFechar = document.getElementById('fechar-modal');

    if (!modal || !btnSalvar || !btnFechar) return;

    // Abre o modal automaticamente ao carregar a página
    modal.showModal();

    // Fechar modal
    btnFechar.addEventListener('click', () => {
        modal.close();
        window.location.href = 'dailyVisualizar.php';
    });

    // Salvar dados
    btnSalvar.addEventListener('click', async () => {
        const idDaily = modal.dataset.idDaily;
        const dados = {};

        // Coleta dados dos campos com data-field
        document.querySelectorAll('[data-field]').forEach(campo => {
            if (campo.type === 'radio') {
                if (campo.checked) dados[campo.name] = campo.value;
            } else {
                dados[campo.name] = campo.value;
            }
        });

        try {
            const response = await fetch('dailyEdicao.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id_daily: idDaily,
                    ...dados
                })
            });

            if (response.ok) {
                alert('Dados atualizados!');
                window.location.href = 'dailyVisualizar.php';
            } else {
                throw new Error('Erro ao salvar');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Falha na atualização.');
        }
    });
});