document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal-editar');
    const btnSalvar = document.getElementById('botaosalvar');
    const btnCancelar = document.getElementById('botaocancelar');
    const btnExcluir = document.getElementById('botaoexcluir');

    if (!modal) {
        console.error('Modal não encontrado');
        return;
    }

    modal.showModal();

    if (btnCancelar) {
        btnCancelar.addEventListener('click', (event) => {
            event.preventDefault(); // Impede o redirecionamento imediato

            modal.inert = true; 

            Swal.fire({
                title: 'Tem certeza?',
                text: 'As informações preenchidas não serão salvas!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f9d57f',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, sair',
                cancelButtonText: 'Não, continuar editando',
                customClass: {
                    confirmButton: 'swal2-styled swal2-confirm',
                    cancelButton: 'swal2-styled swal2-cancel'
                },
                didClose: () => {
                    modal.inert = false;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    modal.close();
                    window.location.href = 'dailyVisualizar.php';
                } else {
                    modal.inert = false; // <--- ADICIONE ESTA LINHA (ou garanta que didClose já a faça)
                }
            });
        });
    }

    if (btnExcluir) {
        btnExcluir.addEventListener('click', (event) => {
            event.preventDefault();

            const idDaily = btnExcluir.getAttribute('data-id-daily');

            modal.inert = true;

            Swal.fire({
                title: 'Tem certeza?',
                text: 'Você não poderá reverter esta ação!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f9d57f',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: 'swal2-styled swal2-confirm',
                    cancelButton: 'swal2-styled swal2-cancel'
                },
                didClose: () => {
                    modal.inert = false;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `dailyExcluir.php?id_daily=${idDaily}`;
                } else {
                    modal.inert = false;
                }
            });
        });
    }
});