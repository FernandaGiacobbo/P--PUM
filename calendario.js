// Definindo constantes para montar o calendário
const monthYear = document.getElementById("month-year");
const datesContainer = document.getElementById("calendar-dates");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");
const hoje = new Date();
let currentDate = new Date();

// Função de renderizar calendário
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

  // Espaços antes do primeiro dia
  for (let i = 0; i < primeiroDia; i++) {
    datesContainer.innerHTML += "<div></div>";
  }

  // Dias do mês
  for (let dia = 1; dia <= totalDiasDoMes; dia++) {
    const dataAtual = new Date(ano, mes, dia);
    const divDia = document.createElement("div");
    divDia.textContent = dia;

    // Marca o dia de hoje
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

// Botões de trocar o mês
prevBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderizarCalendario();
};

nextBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderizarCalendario();
};

// Inicializa o calendário
renderizarCalendario();

// Modais de insert, delete e update
const modalAdd = document.getElementById("modal");
const modalEdit = document.getElementById("modal-edit");

const openModalBtn = document.getElementById("openModal");
const closeAdd = modalAdd.querySelector(".close"); 
const closeEdit = modalEdit.querySelector("#close-edit"); 

// Abrir modal de adicionar
openModalBtn.addEventListener('click', () => {
  modalAdd.style.display = "flex";
});

// Fechar modal de adicionar
closeAdd.addEventListener('click', () => {
  modalAdd.style.display = "none";
});

// Fechar modal de editar
closeEdit.addEventListener('click', () => {
  modalEdit.style.display = "none";
});

// Fechar clicando fora dos modais
window.addEventListener('click', (e) => {
  if (e.target === modalAdd) {
    modalAdd.style.display = "none";
  }
  if (e.target === modalEdit) {
    modalEdit.style.display = "none";
  }
});

// Abrir modal de edição ao clicar num evento
document.addEventListener('click', function (e) {
  const eventCard = e.target.closest('.event-card');

  if (eventCard) {
    const idEvento = eventCard.getAttribute('data-id');
    const titulo = eventCard.querySelector('h3')?.textContent || '';
    const inicio = eventCard.querySelector('p:nth-child(2)')?.textContent.replace('Início: ', '') || '';
    const fim = eventCard.querySelector('p:nth-child(3)')?.textContent.replace('Término: ', '') || '';
    const descricao = eventCard.querySelector('p:nth-child(4)')?.textContent.replace('Descrição: ', '') || '';

    modalEdit.style.display = "flex";

    document.getElementById('titulo-edit').value = titulo;
    document.getElementById('datai-edit').value = inicio.split(' ')[0];
    document.getElementById('horai-edit').value = inicio.split(' ')[1];
    document.getElementById('datat-edit').value = fim.split(' ')[0];
    document.getElementById('horat-edit').value = fim.split(' ')[1];
    document.getElementById('descricao-edit').value = descricao;
    document.getElementById('id-edit').value = idEvento;
  }
});

// Buscar eventos quando clica no dia
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
          containerEventos.innerHTML += `
            <div class="event-card" data-id="${ev.id_evento}">
              <h3>${ev.titulo_evento}</h3>
              <p><strong>Início:</strong> ${ev.data_evento} ${ev.horario_evento}</p>
              <p><strong>Término:</strong> ${ev.data_prazo} ${ev.hora_prazo}</p>
              <p><strong>Descrição:</strong> ${ev.descricao}</p>
            </div>
          `;
        });
      }
    } catch (error) {
      console.error("Erro ao buscar eventos:", error);
    }
  }
});
