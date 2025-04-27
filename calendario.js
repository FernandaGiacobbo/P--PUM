const monthYear = document.getElementById("month-year");
const datesContainer = document.getElementById("calendar-dates");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");
const hoje = new Date();
let currentDate = new Date();

// FUNÇÃO DE RENDERIZAR CALENDÁRIO
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

// BOTÕES DE MUDAR MÊS
prevBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderizarCalendario();
};

nextBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderizarCalendario();
};

// MODAL
const modal = document.getElementById("modal");
const openModalBtn = document.getElementById("openModal");
const closeBtn = document.querySelector(".close");

openModalBtn.onclick = () => {
  modal.style.display = "flex";
};

closeBtn.onclick = () => {
  modal.style.display = "none";
};

window.onclick = (e) => {
  if (e.target === modal) {
    modal.style.display = "none";
  }
};

// BUSCAR EVENTOS NO DIA CLICADO
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
            <div class="event-card">
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


// INICIALIZA CALENDÁRIO NA PÁGINA
renderizarCalendario();

document.addEventListener('DOMContentLoaded', function () {

  const modalAdd = document.getElementById("modal-add");
  const modalEdit = document.getElementById("modal-edit");
  const closeAdd = document.getElementById("close-add");
  const closeEdit = document.getElementById("close-edit");
  // Abrir modal de edição ao clicar no evento
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
      document.getElementById('id-edit').value = idEvento; // <-- adiciona aqui o ID no campo hidden
    }
  });

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
  
  

  document.getElementById("botao-deletar").addEventListener("click", async function () {
    const id = this.dataset.id;
  
    if (confirm("Tem certeza que quer apagar esse evento?")) {
      try {
        await fetch(`deletar_evento.php?id=${id}`, { method: 'POST' });
        alert("Evento deletado com sucesso!");
        modalEdit.style.display = "none";
        renderizarCalendario(); // recarrega eventos, se quiser
      } catch (error) {
        console.error("Erro ao deletar evento:", error);
        alert("Erro ao deletar evento.");
      }
    }
  });
  

  // Fechar o modal de adicionar
  closeAdd.addEventListener('click', function () {
    modalAdd.style.display = "none";
  });

  // Fechar o modal de editar
  closeEdit.addEventListener('click', function () {
    modalEdit.style.display = "none";
  });

  // Fecha clicando fora dos modais
  window.addEventListener('click', function (e) {
    if (e.target == modalAdd) {
      modalAdd.style.display = "none";
    }
    if (e.target == modalEdit) {
      modalEdit.style.display = "none";
    }
  });

});



