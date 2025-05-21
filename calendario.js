// DEFINIÇÃO DE CONSTANTES E VARIÁVEIS GLOBAIS
const monthYear = document.getElementById("month-year");
const datesContainer = document.getElementById("calendar-dates"); 
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next"); 
const hoje = new Date(); 
let currentDate = new Date();

// Elementos dos modais
const modalAdd = document.getElementById("modal");
const modalEdit = document.getElementById("modal-edit");
const modalDelete = document.getElementById("modalDelete");
const modalEditar = document.getElementById("modalEditar");
const openModalBtn = document.getElementById("openModal");
const closeAdd = modalAdd.querySelector(".close");
const closeEdit = modalEdit.querySelector("#close-edit");
const closeDelete = document.querySelector(".close-delete");
const confirmDelete = document.getElementById("confirmDelete");
const cancelDelete = document.getElementById("cancelDelete");
const closeEditar = document.querySelector(".close-edit");
const confirmEdit = document.getElementById("confirmEdit");
const cancelEdit = document.getElementById("cancelEdit");


// Variável para armazenar o ID do evento sendo editado
let currentEventId = null;

// FUNÇÕES PRINCIPAIS DO CALENDÁRIO
function renderizarCalendario() {
  const ano = currentDate.getFullYear();
  const mes = currentDate.getMonth();
  const primeiroDia = new Date(ano, mes, 1).getDay();
  const totalDiasDoMes = new Date(ano, mes + 1, 0).getDate();

  monthYear.textContent = currentDate.toLocaleDateString("pt-BR", {
    year: "numeric",
    month: "long"
  });

  datesContainer.innerHTML = "";

  for (let i = 0; i < primeiroDia; i++) {
    datesContainer.innerHTML += "<div></div>";
  }

  for (let dia = 1; dia <= totalDiasDoMes; dia++) {
    const hoje = new Date();
    const dataAtual = new Date(ano, mes, dia);
    const divDia = document.createElement("div");
    divDia.textContent = dia;

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
prevBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderizarCalendario();
};

nextBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderizarCalendario();
};

// GERENCIAMENTO DE MODAIS
openModalBtn.addEventListener('click', () => {
  modalAdd.style.display = "flex";
});

closeAdd.addEventListener('click', () => {
  modalAdd.style.display = "none";
});

closeEdit.addEventListener('click', () => {
  modalEdit.style.display = "none";
});

closeDelete.addEventListener('click', () => {
  modalDelete.style.display = "none";
});

cancelDelete.addEventListener('click', () => {
  modalDelete.style.display = "none";
});

closeEditar.addEventListener('click', () => {
  modalEditar.style.display = "none";
})

cancelEdit.addEventListener('click', () => {
  modalEditar.style.display = "none";
})

window.addEventListener('click', (e) => {
  if (e.target === modalAdd) modalAdd.style.display = "none";
  if (e.target === modalEdit) modalEdit.style.display = "none";
  if (e.target === modalDelete) modalDelete.style.display = "none";
  if (e.target === modalEditar) modalEditar.style.display = "none"
});

// GERENCIAMENTO DE EVENTOS
function abrirModalEdicao(e) {
  e.stopPropagation();
  
  const eventCard = e.currentTarget;
  currentEventId = eventCard.dataset.id;
  
  const titulo = eventCard.querySelector('h3')?.textContent || '';
  const inicio = eventCard.querySelector('p:nth-child(2)')?.textContent.replace('Início: ', '') || '';
  const fim = eventCard.querySelector('p:nth-child(3)')?.textContent.replace('Término: ', '') || '';
  const descricao = eventCard.querySelector('p:nth-child(4)')?.textContent.replace('Descrição: ', '') || '';

  const form = document.querySelector('#modal-edit form');
  form.reset();
  
  const [dataInicio, horaInicio] = inicio.split(' ');
  const [dataFim, horaFim] = fim.split(' ');

  document.getElementById('titulo-edit').value = titulo;
  document.getElementById('datai-edit').value = dataInicio || '';
  document.getElementById('horai-edit').value = horaInicio || '00:00';
  document.getElementById('datat-edit').value = dataFim || '';
  document.getElementById('horat-edit').value = horaFim || '00:00';
  document.getElementById('descricao-edit').value = descricao;
  document.getElementById('id-edit').value = currentEventId;

  modalEdit.style.display = "flex";
}

async function deletarEvento(e) {
  e.preventDefault();
  modalDelete.style.display = "flex";
  modalEdit.style.display = "none";
}

confirmDelete.addEventListener('click', async () => {
  try {
    const response = await fetch('deletar_evento.php', {
      method: 'POST',
      body: new URLSearchParams({ id_evento: currentEventId })
    });

    const result = await response.text();

    if (result.includes("sucesso")) {
      modalDelete.style.display = "none";
      await carregarEventosDoDia();
    } else {
      throw new Error(result);
    }
  } catch (error) {
    console.error('Erro ao deletar:', error);
    alert('Erro ao deletar evento: ' + error.message);
  }
});

// Modifique a função editarEvento para abrir o modal de confirmação
// Substitua as duas funções editarEvento por esta única versão:
async function editarEvento(e) {
  e.preventDefault();
  
  // Primeiro mostra o modal de confirmação
  modalEditar.style.display = "flex";
  
  // Não fecha o modal de edição ainda, pois o usuário pode cancelar
  // A submissão real só acontece se confirmar no modalEditar
}

// Mantenha este listener para o botão de confirmação
confirmEdit.addEventListener('click', async () => {
  try {
    const form = document.querySelector('#modal-edit form');
    const formData = new FormData(form);
    
    const response = await fetch('editar_evento.php', {
      method: 'POST',
      body: formData
    });
    
    const result = await response.text();
    
    if (result.includes("sucesso")) {
      modalEditar.style.display = "none";
      modalEdit.style.display = "none"; // Fecha ambos os modais
      await carregarEventosDoDia();
    } else {
      throw new Error(result);
    }
  } catch (error) {
    console.error('Erro ao editar:', error);
    modalEditar.style.display = "none";
    // alert('Erro ao editar evento: ' + error.message);
  }
});

// Adicione este listener para o botão de cancelar no modal de edição
cancelEdit.addEventListener('click', () => {
  modalEditar.style.display = "none";
  // Volta para o modal de edição ou fecha tudo, conforme sua preferência
  modalEdit.style.display = "flex"; // Se quiser voltar para edição
});

async function carregarEventosDoDia() {
  const activeDay = document.querySelector('.calendar-dates div:not(:empty)');
  if (activeDay) activeDay.click();
}

function setupEventListeners() {
  document.querySelectorAll('.event-card').forEach(card => {
    card.removeEventListener('click', abrirModalEdicao);
    card.addEventListener('click', abrirModalEdicao);
  });
  
  const editBtn = document.querySelector('.edit-evento');
  const deleteBtn = document.querySelector('.delete-evento');
  
  editBtn.removeEventListener('click', editarEvento);
  deleteBtn.removeEventListener('click', deletarEvento);
  
  editBtn.addEventListener('click', editarEvento);
  deleteBtn.addEventListener('click', deletarEvento);
}

// CARREGAMENTO DE EVENTOS POR DATA
datesContainer.addEventListener("click", async (e) => {
  if (e.target.tagName === "DIV" && e.target.textContent.trim() !== "") {
    const dia = e.target.textContent.padStart(2, '0');
    const mes = String(currentDate.getMonth() + 1).padStart(2, '0');
    const ano = currentDate.getFullYear();
    const dataFormatada = `${ano}-${mes}-${dia}`;

    try {
      const res = await fetch(`buscar_eventos.php?data=${dataFormatada}`);
      const eventos = await res.json();

      const containerEventos = document.getElementById("eventosDoDia");
      containerEventos.innerHTML = "";

      if (eventos.length === 0) {
        containerEventos.innerHTML = "<p>Nenhum evento encontrado para essa data.</p>";
      } else {
        eventos.forEach(ev => {
          const eventCard = document.createElement('div');
          eventCard.className = 'event-card';
          eventCard.dataset.id = ev.id_evento;
          
          eventCard.innerHTML = `
            <h3>${ev.titulo_evento}</h3>
            <p><strong>Início:</strong> ${ev.data_evento} ${ev.horario_evento}</p>
            <p><strong>Término:</strong> ${ev.data_prazo} ${ev.hora_prazo}</p>
            <p><strong>Descrição:</strong> ${ev.descricao}</p>
          `;
          
          containerEventos.appendChild(eventCard);
        });

        setupEventListeners();
      }
    } catch (error) {
      console.error("Erro ao buscar eventos:", error);
    }
  }
});

// INICIALIZAÇÃO
renderizarCalendario();