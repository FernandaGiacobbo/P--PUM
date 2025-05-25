const abrirModal = document.getElementById("abrir");
const modal = document.getElementById("modal");
const fecharModal = document.getElementById("sair");


abrirModal.onclick = function (){
    modal.showModal();
}

fecharModal.onclick = function (){
    modal.close();
}

let tempoFoco = 25;
let tempoIntervalo = 5;
let emFoco = true;
let timer;
let tempoRestante = tempoFoco * 60;

const dingFim = new Audio('ding.ogg');

function updateSettings(resetTempo = true) {
  tempoFoco = parseInt(document.getElementById("tempoFoco").value);
  tempoIntervalo = parseInt(document.getElementById("tempoIntervalo").value);

  if (resetTempo) {
    tempoRestante = tempoFoco * 60;
    emFoco = true;
    document.getElementById("status").innerText = "Foco";
  }

  updateDisplay();
}


function updateDisplay() {
  const minutes = Math.floor(tempoRestante / 60).toString().padStart(2, '0');
  const seconds = (tempoRestante % 60).toString().padStart(2, '0');
  document.getElementById("timer").innerText = `${minutes}:${seconds}`;
}

function startTimer() {
  updateSettings(); // Isso já atualiza foco e intervalo

  if (tempoFoco < 5) {
    Swal.fire({
      title: "Tempo Insuficiente",
      text: "O tempo mínimo para foco é 5 minutos",
      icon: "warning"
    });
    return;
  }

  // Só inicializa tempo se não houver um tempo restante válido já salvo
  if (!localStorage.getItem('tempoFinal')) {
    tempoRestante = tempoFoco * 60;
    emFoco = true;
    localStorage.setItem('tempoFinal', Date.now() + tempoRestante * 1000);
    localStorage.setItem('emFoco', emFoco);
  }

  localStorage.setItem('timerAtivo', 'true');
  continuarTimer();
}



function continuarTimer() {
  if (timer) clearInterval(timer);

  timer = setInterval(() => {
    if (tempoRestante > 0) {
      tempoRestante--;
      updateDisplay();
    } else {
      dingFim.play();
      emFoco = !emFoco;
      tempoRestante = (emFoco ? tempoFoco : tempoIntervalo) * 60;

      // Atualiza o tempo final salvo
      localStorage.setItem('tempoFinal', Date.now() + tempoRestante * 1000);
      localStorage.setItem('emFoco', emFoco);
      document.getElementById("status").innerText = emFoco ? "Foco" : "Pausa";
      updateDisplay();
    }
  }, 1000);
}


function pauseTimer() {
  clearInterval(timer);
  localStorage.removeItem('timerAtivo');
  localStorage.removeItem('tempoFinal');
  localStorage.removeItem('emFoco');
}

function resetTimer() {
  clearInterval(timer);
  updateSettings();
  localStorage.removeItem('timerAtivo');
  localStorage.removeItem('tempoFinal');
  localStorage.removeItem('emFoco');
}


window.addEventListener('load', () => {
  const ativo = localStorage.getItem('timerAtivo');
  const tempoFinalSalvo = parseInt(localStorage.getItem('tempoFinal'));
  const emFocoSalvo = localStorage.getItem('emFoco');

  updateSettings(false); // Atualiza valores sem resetar o tempo restante

  if (ativo && tempoFinalSalvo && emFocoSalvo !== null) {
    const tempoAgora = Date.now();
    tempoRestante = Math.floor((tempoFinalSalvo - tempoAgora) / 1000);
    emFoco = emFocoSalvo === 'true';

    if (tempoRestante > 0) {
      document.getElementById("status").innerText = emFoco ? "Foco" : "Pausa";
      updateDisplay();
      continuarTimer();
    } else {
      // tempo expirado, iniciar novo ciclo
      dingFim.play();
      emFoco = !emFoco;
      tempoRestante = (emFoco ? tempoFoco : tempoIntervalo) * 60;
      localStorage.setItem('tempoFinal', Date.now() + tempoRestante * 1000);
      localStorage.setItem('emFoco', emFoco);
      document.getElementById("status").innerText = emFoco ? "Foco" : "Pausa";
      updateDisplay();
      continuarTimer();
    }
  } else {
    updateDisplay();
  }
});




