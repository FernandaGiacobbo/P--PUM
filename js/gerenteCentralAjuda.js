document.querySelectorAll('.caixaDuvidas').forEach(item => {
    item.addEventListener('click', () => {
        const id = item.dataset.id;
        
        // Requisição AJAX para obter detalhes da dúvida
        fetch('gerenteCentralAjudaSelect.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitulo').innerText = data.titulo;
                document.getElementById('modalTexto').innerText = data.texto;
                document.getElementById('modalUsuario').innerText = data.usuario;
                document.getElementById('modalData').innerText = data.data;
                document.getElementById('excluirDuv').dataset.id = id;

                // Limpa e insere respostas
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
                //exibe o modal
                document.getElementById('duvidamodal').style.display = 'block';
            });
    });
});

//fechar modal
document.getElementById('closeModal').addEventListener('click', () => {
    document.getElementById('duvidamodal').style.display = 'none';
});


//enviar resposta
document.getElementById('enviarResposta').addEventListener('click', () => {
    const texto = document.getElementById('textoResposta').value;
    const id = document.getElementById('excluirDuv').dataset.id;

    fetch('gerenteCentralAjudaInsert.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&texto=${encodeURIComponent(texto)}`
    }).then(response => response.text())
      .then(resposta => {
        if (resposta.trim() == "sucesso") { //aqui a gente verifica na pagina de insert se o mensagem sucesso foi realizada, caso sim aparece O POPUP de mensagem enviada
            Swal.fire({
                    title: 'Sucesso',
                    text: 'Resposta enviada com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                            popup: 'popup-personalizado',
                            confirmButton: 'botao-confirmar',
                            cancelButton: 'botao-cancelar'
                    }
            }).then(() => {
                location.reload();
            });
        } else if(resposta.trim() == "error") { //verifica se o requisito error foi realizado
            Swal.fire({
                title: 'Tamanho da mensagem!! ',
                text: 'A sua mensagem tem que ter no mínimo 100 caracteres.',
                icon: 'warning',
                confirmButtonText: 'OK',
                customClass: {
                        popup: 'popup-personalizado',
                        confirmButton: 'botao-confirmar',
                        cancelButton: 'botao-cancelar'
                    }
            }).then(() =>{
                location.reload();
            });
        } else { //caso nenhum dos dois campos foi preenchido ele realiza essa ultima verificação
            Swal.fire({
                title: 'Tamanho da mensagem!! ',
                text: 'A sua mensagem tem que ter no máximo 500 caracteres.',
                icon: 'warning',
                confirmButtonText: 'OK',
                customClass: {
                        popup: 'popup-personalizado',
                        confirmButton: 'botao-confirmar',
                        cancelButton: 'botao-cancelar'
                    }
            }).then(() =>{
                location.reload();
            });
        }
      });  
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
                 location.reload();
            }
        })
    }   
});
        

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

//Excluir Divida do usuario
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
                location.reload();
            }
        })

});