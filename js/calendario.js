// Obtém referências aos elementos do DOM
const monthYear = document.getElementById("month-year"); // Elemento que exibe mês/ano
const datesContainer = document.getElementById("calendar-dates"); // Container dos dias do calendário
const prevBtn = document.getElementById("prev"); // Botão de mês anterior
const nextBtn = document.getElementById("next"); // Botão de próximo mês
const hoje = new Date(); // Data atual
let currentDate = new Date(); // Data sendo exibida no calendário (pode navegar entre meses)

// Elementos dos modais
const modalAdd = document.getElementById("modal"); // Modal de adicionar evento
const modalEdit = document.getElementById("modal-edit"); // Modal de edição
const modalDelete = document.getElementById("modalDelete"); // Modal de deletar
const modalEditar = document.getElementById("modalEditar"); // Modal de confirmação de edição
const openModalBtn = document.getElementById("openModal"); // Botão para abrir modal de adição
const closeAdd = modalAdd.querySelector(".close"); // Botão para fechar modal de adição
const closeEdit = modalEdit.querySelector("#close-edit"); // Botão para fechar modal de edição
const closeDelete = document.querySelector(".close-delete"); // Botão para fechar modal de deletar
const confirmDelete = document.getElementById("confirmDelete"); // Botão de confirmação de deleção
const cancelDelete = document.getElementById("cancelDelete"); // Botão de cancelar deleção
const closeEditar = document.querySelector(".close-edit"); // Botão para fechar modal de confirmação de edição
const confirmEdit = document.getElementById("confirmEdit"); // Botão de confirmação de edição
const cancelEdit = document.getElementById("cancelEdit"); // Botão de cancelar edição

// Variável para armazenar o ID do evento sendo editado
let currentEventId = null; // Armazena temporariamente o ID do evento em edição

// FUNÇÕES PRINCIPAIS DO CALENDÁRIO
function renderizarCalendario() {
  // Obtém ano, mês e primeiro dia da semana do mês atual
  const ano = currentDate.getFullYear();
  const mes = currentDate.getMonth();
  const primeiroDia = new Date(ano, mes, 1).getDay(); //Dias da semana
  const totalDiasDoMes = new Date(ano, mes + 1, 0).getDate(); //Total de dias no mês

   // Atualiza o cabeçalho com mês/ano formatado
  monthYear.textContent = currentDate.toLocaleDateString("pt-BR", {
    year: "numeric",
    month: "long"
  });

  // Limpa o container de datas
  datesContainer.innerHTML = "";

  // Adiciona divs vazias para os dias da semana antes do primeiro dia do mês
  for (let i = 0; i < primeiroDia; i++) {
    datesContainer.innerHTML += "<div></div>";
  }

   // Adiciona divs para cada dia do mês
  for (let dia = 1; dia <= totalDiasDoMes; dia++) {
    const hoje = new Date();
    const dataAtual = new Date(ano, mes, dia);
    const divDia = document.createElement("div");
    divDia.textContent = dia;

    // Destaca o dia atual
    if (
      dataAtual.getDate() === hoje.getDate() &&
      dataAtual.getMonth() === hoje.getMonth() &&
      dataAtual.getFullYear() === hoje.getFullYear()
    ) {
      divDia.classList.add("hoje");
    }

    datesContainer.appendChild(divDia);
  }
}

// NAVEGAÇÃO ENTRE MESES
// Navega para o mês anterior
prevBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderizarCalendario();
};

// Navega para o mês seguinte
nextBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderizarCalendario();
};

// GERENCIAMENTO DE MODAIS

// Abre o modal de adicionar evento
openModalBtn.addEventListener('click', () => {
  modalAdd.style.display = "flex";
});

// Fecha o modal de adicionar evento
closeAdd.addEventListener('click', () => {
  modalAdd.style.display = "none";
});

// Fecha o modal de edição
closeEdit.addEventListener('click', () => {
  modalEdit.style.display = "none";
});

// Fecha o modal de deletar
closeDelete.addEventListener('click', () => {
  modalDelete.style.display = "none";
});

// Cancela a deleção
cancelDelete.addEventListener('click', () => {
  modalDelete.style.display = "none";
});

// Fecha o modal de confirmação de edição
closeEditar.addEventListener('click', () => {
  modalEditar.style.display = "none";
})

// Cancela a edição
cancelEdit.addEventListener('click', () => {
  modalEditar.style.display = "none";
})

// Fecha modais ao clicar fora deles
window.addEventListener('click', (e) => {
  if (e.target === modalAdd) modalAdd.style.display = "none";
  if (e.target === modalEdit) modalEdit.style.display = "none";
  if (e.target === modalDelete) modalDelete.style.display = "none";
  if (e.target === modalEditar) modalEditar.style.display = "none"
});


// Função para marcar os eventos no calendário
async function marcarEventosNoCalendario() {
    try {
        // Busca todos os eventos do servidor
        const res = await fetch('buscar_todos_eventos.php');
        const eventos = await res.json();
        
        // Remove marcadores antigos
        document.querySelectorAll('.marcador-evento').forEach(m => m.remove());
        
        // Obtém todos os dias não vazios do calendário
        const dates = document.querySelectorAll('.calendar-dates div:not(:empty)');
        
        // Para cada dia, verifica se tem evento
        dates.forEach(dateDiv => {
            const dia = dateDiv.textContent.trim().padStart(2, '0');
            const mes = String(currentDate.getMonth() + 1).padStart(2, '0');
            const ano = currentDate.getFullYear();
            const dataFormatada = `${ano}-${mes}-${dia}`;

            // Verifica se há evento começando nesta data
            const temEvento = eventos.some(ev => {
                const dataInicio = ev.data_evento.split(' ')[0];
                return dataFormatada === dataInicio;
            });

            // Adiciona marcador se houver evento
            if (temEvento) {
                const marcador = document.createElement('span');
                marcador.className = 'marcador-evento';
                dateDiv.appendChild(marcador);
            }
        });
    } catch (error) {
        console.error("Erro ao marcar eventos:", error);
    }
}

//Função de renderizar o calendário
function renderizarCalendario() {
    
    const ano = currentDate.getFullYear(); // Obtém o ano atual da data selecionada
    const mes = currentDate.getMonth(); // Obtém o mês atual da data selecionada (0 a 11)
    const primeiroDia = new Date(ano, mes, 1).getDay(); // Calcula o dia da semana do primeiro dia do mês (0 = domingo)
    const totalDiasDoMes = new Date(ano, mes + 1, 0).getDate(); // Obtém o total de dias do mês atual

    monthYear.textContent = currentDate.toLocaleDateString("pt-BR", { // Define o texto do mês e ano atual no formato brasileiro
        year: "numeric",
        month: "long"
    });

    // Limpa o contêiner de datas antes de renderizar
    datesContainer.innerHTML = "";

    // Adiciona divs vazias para alinhar o primeiro dia corretamente
    for (let i = 0; i < primeiroDia; i++) {
        datesContainer.innerHTML += "<div></div>";
    }

    // Loop para criar os dias do mês
    for (let dia = 1; dia <= totalDiasDoMes; dia++) {
        const hoje = new Date(); // Data de hoje
        const dataAtual = new Date(ano, mes, dia); // Data do dia atual do loop
        const divDia = document.createElement("div"); // Cria uma div para o dia
        divDia.textContent = dia; // Define o número do dia

        // Verifica se é o dia atual (hoje)
        if (
            dataAtual.getDate() === hoje.getDate() &&
            dataAtual.getMonth() === hoje.getMonth() &&
            dataAtual.getFullYear() === hoje.getFullYear()
        ) {
            divDia.classList.add("hoje"); // Adiciona a classe "hoje"
        }

        datesContainer.appendChild(divDia); // Adiciona a div ao calendário
    }

    // Chama a função para marcar os eventos após renderizar o calendário
    marcarEventosNoCalendario();
}


// GERENCIAMENTO DE EVENTOS
function abrirModalEdicao(e) {
  e.stopPropagation(); // Impede propagação do clique

  const eventCard = e.currentTarget; // Cartão de evento clicado
  currentEventId = eventCard.dataset.id; // ID do evento

  // Extrai informações do cartão
  const titulo = eventCard.querySelector('h3')?.textContent || '';
  const inicio = eventCard.querySelector('p:nth-child(2)')?.textContent.replace('Início: ', '') || '';
  const fim = eventCard.querySelector('p:nth-child(3)')?.textContent.replace('Término: ', '') || '';
  const descricao = eventCard.querySelector('p:nth-child(4)')?.textContent.replace('Descrição: ', '') || '';

  const form = document.querySelector('#modal-edit form');
  form.reset(); // Limpa o formulário

  // Divide data e hora
  const [dataInicio, horaInicio] = inicio.split(' ');
  const [dataFim, horaFim] = fim.split(' ');

// Preenche o campo "título" do formulário de edição com o valor extraído do cartão do evento
document.getElementById('titulo-edit').value = titulo;
// Preenche o campo "data de início" com a data extraída ou deixa em branco se não houver
document.getElementById('datai-edit').value = dataInicio || '';
// Preenche o campo "hora de início" com a hora extraída ou usa "00:00" como valor padrão
document.getElementById('horai-edit').value = horaInicio || '00:00';
// Preenche o campo "data de término" com a data extraída ou deixa em branco se não houver
document.getElementById('datat-edit').value = dataFim || '';
// Preenche o campo "hora de término" com a hora extraída ou usa "00:00" como valor padrão
document.getElementById('horat-edit').value = horaFim || '00:00';
// Preenche o campo "descrição" com o texto extraído da descrição do evento
document.getElementById('descricao-edit').value = descricao;
// Preenche o campo oculto "id-edit" com o ID do evento, usado para saber qual evento está sendo editado
document.getElementById('id-edit').value = currentEventId;


  // Exibe o modal de edição
  modalEdit.style.display = "flex";
}

async function deletarEvento(e) {
  e.preventDefault(); // Previne comportamento padrão do botão
  modalDelete.style.display = "flex"; // Abre o modal de confirmação
  modalEdit.style.display = "none"; // Fecha o modal de edição
}

confirmDelete.addEventListener('click', async () => {
  try {
    // Envia requisição para deletar o evento
    const response = await fetch('deletar_evento.php', {
      method: 'POST',
      body: new URLSearchParams({ id_evento: currentEventId })
    });

    const result = await response.text(); // Lê o resultado

    // Se a resposta indicar sucesso
    if (result.includes("sucesso")) {
      modalDelete.style.display = "none"; // Fecha modal
      await carregarEventosDoDia(); // Recarrega os eventos

      // Exibe alerta de sucesso
      Swal.fire({
        title: "Evento deletado com sucesso!",
        icon: "success",
        draggable: true
      });

    } else {
      throw new Error(result); // Lança erro se falhou
    }
  } catch (error) {
    console.error('Erro ao deletar:', error); // Loga erro no console
    alert('Erro ao deletar evento: ' + error.message); // Mostra alerta de erro
  }
});

//Função de editar evento
async function editarEvento(e) {
  e.preventDefault(); // Previne envio do formulário
  modalEditar.style.display = "flex"; // Mostra o modal de confirmação
}

// Listener para confirmação da edição
confirmEdit.addEventListener('click', async () => {
  try {
    const form = document.querySelector('#modal-edit form');
    const formData = new FormData(form); // Pega os dados do formulário

    // Envia os dados para o backend
    const response = await fetch('editar_evento.php', {
      method: 'POST',
      body: formData
    });

    const result = await response.text(); // Lê a resposta

    // Se a edição foi bem-sucedida
    if (result.includes("sucesso")) {
      modalEditar.style.display = "none"; // Fecha modal de confirmação
      modalEdit.style.display = "none"; // Fecha modal de edição
      await carregarEventosDoDia(); // Atualiza os eventos no frontend

      // Modal de confirmação de alteração
      await Swal.fire({
        title: "Evento alterado com sucesso!",
        icon: "success",
        draggable: true
      });

      location.reload(); // Faz a página recarregar automaticamente depois de alterar o evento

    } else {
      throw new Error(result); // Se falhar, lança erro
    }
  } catch (error) {
    console.error('Erro ao editar:', error); // Loga erro
    modalEditar.style.display = "none"; // Fecha modal de confirmação
  }
});


// Botão de cancelar a edição
cancelEdit.addEventListener('click', () => {
  modalEditar.style.display = "none"; // Fecha o modal de confirmação
  modalEdit.style.display = "flex"; // Volta para o modal de edição
});

async function carregarEventosDoDia() {
  // Tenta simular clique no primeiro dia do calendário para atualizar eventos
  const activeDay = document.querySelector('.calendar-dates div:not(:empty)');
  if (activeDay) activeDay.click();
}

function setupEventListeners() {
  // Adiciona o evento de clique para abrir modal de edição
  document.querySelectorAll('.event-card').forEach(card => {
    card.removeEventListener('click', abrirModalEdicao); // Garante que não duplica
    card.addEventListener('click', abrirModalEdicao);
  });

  // Adiciona os listeners para botões de editar e deletar
  const editBtn = document.querySelector('.edit-evento');
  const deleteBtn = document.querySelector('.delete-evento');

  editBtn.removeEventListener('click', editarEvento);
  deleteBtn.removeEventListener('click', deletarEvento);

  editBtn.addEventListener('click', editarEvento);
  deleteBtn.addEventListener('click', deletarEvento);
}

// Clique em um dia do calendário
datesContainer.addEventListener("click", async (e) => {
  // Verifica se o elemento clicado é uma div de dia válida
if (e.target.tagName === "DIV" && e.target.textContent.trim() !== "") { // Verifica se o elemento clicado é uma <div> (um dia do calendário)
  const dia = e.target.textContent.padStart(2, '0'); // Pega o número do dia clicado e adiciona um zero à esquerda, se necessário
  const mes = String(currentDate.getMonth() + 1).padStart(2, '0'); // Pega o mês atual (lembrando que getMonth() retorna de 0 a 11)
  const ano = currentDate.getFullYear(); // Obtém o ano atual a partir do objeto currentDate
  const dataFormatada = `${ano}-${mes}-${dia}`; // Junta ano, mês e dia no formato "YYYY-MM-DD". Formato usado para enviar a data ao backend

    try {
      // Busca eventos dessa data no backend
      const res = await fetch(`buscar_eventos.php?data=${dataFormatada}`);
      const eventos = await res.json(); // Converte para JSON

      const containerEventos = document.getElementById("eventosDoDia");
      containerEventos.innerHTML = ""; // Limpa os eventos anteriores

      // Se não houver eventos
      if (eventos.length === 0) {
        containerEventos.innerHTML = "<p>Nenhum evento encontrado para essa data.</p>";
      } else {
        // Cria um card para cada evento
        eventos.forEach(ev => {
          const eventCard = document.createElement('div');
          eventCard.className = 'event-card';
          eventCard.dataset.id = ev.id_evento;

          // Preenche o conteúdo do cartão
          eventCard.innerHTML = `
            <h3>${ev.titulo_evento}</h3>
            <p><strong>Início:</strong> ${ev.data_evento} ${ev.horario_evento}</p>
            <p><strong>Término:</strong> ${ev.data_prazo} ${ev.hora_prazo}</p>
            <p><strong>Descrição:</strong> ${ev.descricao}</p>
          `;

          containerEventos.appendChild(eventCard); // Adiciona o cartão
        });

        setupEventListeners(); // Atualiza os listeners dos novos cards
      }
    } catch (error) {
      console.error("Erro ao buscar eventos:", error); // Loga erro
    }
  }
});

// Inicializa o calendário ao carregar a página
renderizarCalendario();
