
// DEFINIÇÃO DE CONSTANTES E VARIÁVEIS GLOBAIS


// Obtém referências aos elementos do DOM para o calendário
const monthYear = document.getElementById("month-year");
const datesContainer = document.getElementById("calendar-dates"); 
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next"); 
const hoje = new Date(); 
let currentDate = new Date();

// FUNÇÕES PRINCIPAIS DO CALENDÁRIO

//Renderiza o calendário com os dias do mês
function renderizarCalendario() {
  // Obtém ano e mês da data atual sendo exibida
  const ano = currentDate.getFullYear();
  const mes = currentDate.getMonth();

  // Calcula qual dia da semana é o primeiro dia do mês
  const primeiroDia = new Date(ano, mes, 1).getDay();
  // Calcula quantos dias tem o mês atual
  const totalDiasDoMes = new Date(ano, mes + 1, 0).getDate();

  // Atualiza o cabeçalho com o nome do mês e ano
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

  // Adiciona os dias do mês ao calendário
  for (let dia = 1; dia <= totalDiasDoMes; dia++) {
    const hoje = new Date();
    const dataAtual = new Date(ano, mes, dia);
    const divDia = document.createElement("div"); // Cria div para o dia
    divDia.textContent = dia; // Define o número do dia

    // Verifica se o dia sendo renderizado é hoje
    if (
      dataAtual.getDate() === hoje.getDate() &&
      dataAtual.getMonth() === hoje.getMonth() &&
      dataAtual.getFullYear() === hoje.getFullYear()
    ) {
      divDia.classList.add("hoje"); // Adiciona classe para estilizar o dia atual
    }

    // Adiciona o dia ao calendário
    datesContainer.appendChild(divDia);
  }
}

// NAVEGAÇÃO ENTRE MESES

// Evento para botão de mês anterior
prevBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() - 1); // Vai para o mês anterior
  renderizarCalendario();
};

// Evento para botão de próximo mês
nextBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() + 1); // Vai para o próximo mês
  renderizarCalendario();
};


renderizarCalendario();


// GERENCIAMENTO DE MODAIS

const modalAdd = document.getElementById("modal"); // Modal adicionar evento
const modalEdit = document.getElementById("modal-edit"); // Modal editar evento

const openModalBtn = document.getElementById("openModal"); // Abrir modal de adicionar evento
const closeAdd = modalAdd.querySelector(".close"); // Fechar modal de aadicionar evento
const closeEdit = modalEdit.querySelector("#close-edit"); // Botão para fechar modal de edição

// Evento para abrir modal de adicionar evento
openModalBtn.addEventListener('click', () => {
  modalAdd.style.display = "flex";
});

// Evento para fechar modal de adicionar evento
closeAdd.addEventListener('click', () => {
  modalAdd.style.display = "none";
});

// Evento para fechar modal de editar evento
closeEdit.addEventListener('click', () => {
  modalEdit.style.display = "none";
});

// Fecha modais ao clicar fora deles
window.addEventListener('click', (e) => {
  if (e.target === modalAdd) {
    modalAdd.style.display = "none";
  }
  if (e.target === modalEdit) {
    modalEdit.style.display = "none";
  }
});

// GERENCIAMENTO DE EVENTOS

// Variável para armazenar o ID do evento sendo editado
let currentEventId = null;

/**
 * Abre o modal de edição quando um evento é clicado
 * @param {Event} e - Objeto de evento
 */
function abrirModalEdicao(e) {
  e.stopPropagation(); // Impede a propagação do evento
  
  const eventCard = e.currentTarget; // Card do evento clicado
  currentEventId = eventCard.dataset.id; // Armazena o ID do evento
  
  // Extrai informações do evento
  const titulo = eventCard.querySelector('h3')?.textContent || '';
  const inicio = eventCard.querySelector('p:nth-child(2)')?.textContent.replace('Início: ', '') || '';
  const fim = eventCard.querySelector('p:nth-child(3)')?.textContent.replace('Término: ', '') || '';
  const descricao = eventCard.querySelector('p:nth-child(4)')?.textContent.replace('Descrição: ', '') || '';

  // Reseta e preenche o formulário de edição
  const form = document.querySelector('#modal-edit form');
  form.reset();
  
  // Separa data e hora dos campos de início e fim
  const [dataInicio, horaInicio] = inicio.split(' ');
  const [dataFim, horaFim] = fim.split(' ');

  // Preenche os campos do formulário
  document.getElementById('titulo-edit').value = titulo;
  document.getElementById('datai-edit').value = dataInicio || '';
  document.getElementById('horai-edit').value = horaInicio || '00:00';
  document.getElementById('datat-edit').value = dataFim || '';
  document.getElementById('horat-edit').value = horaFim || '00:00';
  document.getElementById('descricao-edit').value = descricao;
  document.getElementById('id-edit').value = currentEventId;

  // Exibe o modal de edição
  modalEdit.style.display = "flex";
}

/**
 * Edita um evento existente
 * @param {Event} e - Objeto de evento
 */
async function editarEvento(e) {
  e.preventDefault(); // Impede o comportamento padrão do formulário
  
  const form = document.querySelector('#modal-edit form');
  const formData = new FormData(form); // Obtém dados do formulário
  
  try {
    // Envia requisição para editar o evento
    const response = await fetch('editar_evento.php', {
      method: 'POST',
      body: formData
    });
    
    const result = await response.text();
    
    if (result.includes("sucesso")) {
      modalEdit.style.display = "none"; // Fecha o modal
      await carregarEventosDoDia(); // Recarrega os eventos
    } else {
      throw new Error(result); // Lança erro se não foi bem-sucedido
    }
  } catch (error) {
    console.error('Erro ao editar:', error);
    alert('Erro ao editar evento: ' + error.message);
  }
}

/**
 * Deleta um evento existente
 * @param {Event} e - Objeto de evento
 */
async function deletarEvento(e) {
  e.preventDefault(); // Impede o comportamento padrão
  
  // Confirmação antes de deletar
  if (!confirm('Tem certeza que deseja deletar este evento?')) return;
  
  try {
    // Envia requisição para deletar o evento
    const response = await fetch('deletar_evento.php', {
      method: 'POST',
      body: new URLSearchParams({ id_evento: currentEventId })
    });
    
    const result = await response.text();
    
    if (result.includes("sucesso")) {
      modalEdit.style.display = "none"; // Fecha o modal
      await carregarEventosDoDia(); // Recarrega os eventos
    } else {
      throw new Error(result); // Lança erro se não foi bem-sucedido
    }
  } catch (error) {
    console.error('Erro ao deletar:', error);
    alert('Erro ao deletar evento: ' + error.message);
  }
}


 // Recarrega os eventos do dia sem refresh na página

async function carregarEventosDoDia() {
  // Encontra o dia ativo no calendário
  const activeDay = document.querySelector('.calendar-dates div:not(:empty)');
  if (activeDay) {
    activeDay.click(); // Simula clique para recarregar os eventos
  }
}


// Configura os event listeners para os cards de evento e botões do modal
// Listeners são funções que são chamadas quando um evento específico ocorre em um elemento HTML (clique do mouse, tecla etc)

function setupEventListeners() {
  // Remove listeners antigos dos cards de evento
  document.querySelectorAll('.event-card').forEach(card => {
    card.removeEventListener('click', abrirModalEdicao);
  });
  
  // Adiciona novos listeners aos cards de evento
  document.querySelectorAll('.event-card').forEach(card => {
    card.addEventListener('click', abrirModalEdicao);
  });
  
  // Obtém referências aos botões do modal
  const editBtn = document.querySelector('.edit-evento');
  const deleteBtn = document.querySelector('.delete-evento');
  
  // Remove listeners antigos dos botões
  editBtn.removeEventListener('click', editarEvento);
  deleteBtn.removeEventListener('click', deletarEvento);
  
  // Adiciona novos listeners aos botões
  editBtn.addEventListener('click', editarEvento);
  deleteBtn.addEventListener('click', deletarEvento);
}

// CARREGAMENTO DE EVENTOS POR DATA

// Evento para carregar eventos quando um dia é clicado

datesContainer.addEventListener("click", async (e) => {
  // Verifica se o elemento clicado é um dia válido
  if (e.target.tagName === "DIV" && e.target.textContent.trim() !== "") {
    // Formata dia, mês e ano para a requisição
    const dia = e.target.textContent.padStart(2, '0');
    const mes = String(currentDate.getMonth() + 1).padStart(2, '0');
    const ano = currentDate.getFullYear();
    const dataFormatada = `${ano}-${mes}-${dia}`;

    try {
      // Busca eventos para a data selecionada
      const res = await fetch(`buscar_eventos.php?data=${dataFormatada}`);
      const eventos = await res.json();

      const containerEventos = document.getElementById("eventosDoDia");
      containerEventos.innerHTML = ""; // Limpa os eventos anteriores

      if (eventos.length === 0) {
        // Exibe mensagem se não houver eventos
        containerEventos.innerHTML = "<p>Nenhum evento encontrado para essa data.</p>";
      } else {
        // Cria cards para cada evento
        eventos.forEach(ev => {
          const eventCard = document.createElement('div');
          eventCard.className = 'event-card';
          eventCard.dataset.id = ev.id_evento;
          
          // Preenche o card com as informações do evento
          eventCard.innerHTML = `
            <h3>${ev.titulo_evento}</h3>
            <p><strong>Início:</strong> ${ev.data_evento} ${ev.horario_evento}</p>
            <p><strong>Término:</strong> ${ev.data_prazo} ${ev.hora_prazo}</p>
            <p><strong>Descrição:</strong> ${ev.descricao}</p>
          `;
          
          containerEventos.appendChild(eventCard);
        });

        // Configura os listeners para os novos cards
        setupEventListeners();
      }
    } catch (error) {
      console.error("Erro ao buscar eventos:", error);
    }
  }
});

