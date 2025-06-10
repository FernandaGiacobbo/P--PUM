document.querySelectorAll('.caixaDuvidas').forEach(item => {
    item.addEventListener('click', () => {
        const id = item.dataset.id;

        fetch('gerenteCentralAjudaSelect.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitulo').innerText = data.titulo;
                document.getElementById('modalTexto').innerText = data.texto;
                document.getElementById('modalUsuario').innerText = data.usuario;
                document.getElementById('modalData').innerText = data.data;
                document.getElementById('excluirDuv').dataset.id = id;

                document.getElementById('respostaDuvidaId').value = id;

                
                const lista = document.getElementById('respostasLista');
                lista.innerHTML = '';
                data.respostas.forEach(resp => {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <hr>
                        <p><strong>${resp.usuario}:</strong> ${resp.texto}</p>
                        <button class="editarResposta" data-id="${resp.id}" data-texto="${resp.texto}">Editar</button>
                        <button class="excluirResposta" data-id="${resp.id}">Excluir</button>
                    `;
                    lista.appendChild(div);
                });

                document.getElementById('duvidamodal').style.display = 'block';
            });
    });
});


//fechar modal
document.getElementById('closeModal').addEventListener('click', () => {
    document.getElementById('duvidamodal').style.display = 'none';
});



let idRespostaEditando = null;

//Editar Resposta
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('editarResposta')) {
        idRespostaEditando = e.target.dataset.id;
        const texto = e.target.dataset.texto;
        document.getElementById('textoResposta').value = texto;

        
        document.getElementById('salvarEdicao').style.display = 'inline-block';
        document.getElementById('enviarResposta').style.display = 'none';
        document.getElementById('cancelarResposta').style.display = 'inline-block';
    }

    //excluir Resposta
    if (e.target.classList.contains('excluirResposta')) {
        const id = e.target.dataset.id;
        
        Swal.fire({
            title: 'Tem certeza?',
            text: "Você realmente quer excluir sua resposta?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'popup-personalizado',
                    confirmButton: 'botao-confirmar',
                    cancelButton: 'botao-cancelar'
                }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('gerenteCentralAjudaDelete.php?id=' + id)
            }
        }) .then(() =>{
                location.reload();
        });
    }   
});
        
///Salvar edições das respostas
document.getElementById('salvarEdicao').addEventListener('click', () => {
    const texto = document.getElementById('textoResposta').value;
    fetch('gerenteCentralAjudaUpdate.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${idRespostaEditando}&texto=${encodeURIComponent(texto)}`
    }).then(() => location.reload());
});

document.getElementById('cancelarResposta').addEventListener('click', () => {
    idRespostaEditando = null;
    document.getElementById('textoResposta').value = '';
    document.getElementById('salvarEdicao').style.display = 'none';
    document.getElementById('enviarResposta').style.display = 'inline-block';
});

//Excluir Duvida do usuario
document.getElementById('excluirDuv').addEventListener('click', () => {
    const id = document.getElementById('excluirDuv').dataset.id;
    Swal.fire({
            title: 'Tem certeza?',
            text: "Você realmente quer excluir essa duvida?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'popup-personalizado',
                    confirmButton: 'botao-confirmar',
                    cancelButton: 'botao-cancelar'
                }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('gerenteDeletDuvida.php?id=' + id)
            }
        }) .then(() =>{
                location.reload();
        });

});