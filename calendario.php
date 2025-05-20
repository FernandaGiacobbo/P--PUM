<?php

include 'header.php';
include 'conecta_db.php';

if (
    isset($_POST['titulo_evento']) &&
    isset($_POST['data_evento']) &&
    isset($_POST['horario_evento']) &&
    isset($_POST['data_prazo']) &&
    isset($_POST['hora_prazo']) &&
    isset($_POST['descricao'])
) {
    $oMysql = conecta_db();

    $titulo = $_POST['titulo_evento'];
    $datai = $_POST['data_evento'];
    $horai = $_POST['horario_evento'];
    $datat = $_POST['data_prazo'];
    $horat = $_POST['hora_prazo'];
    $descricao = $_POST['descricao'];

    $query = "INSERT INTO tb_evento (titulo_evento, data_evento, horario_evento, data_prazo, hora_prazo, descricao)
              VALUES ('$titulo', '$datai', '$horai', '$datat', '$horat', '$descricao')";

    $resultado = $oMysql->query($query);

}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Calendário</title>
  <link rel="stylesheet" href="calendario.css">

</head>
<body>


<section class="home">
  <section class="calendario">
    <div class="calendar-container">

      <div class="calendar-header">
        <button id="prev">&#8592;</button>
        <h2 id="month-year"></h2>
        <button id="next">&#8594;</button>
      </div>

      <div class="calendar-days">
        <div>DOM</div><div>SEG</div><div>TER</div><div>QUA</div>
          <div>QUI</div><div>SEX</div><div>SÁB</div>
        </div>
        <div class="calendar-dates" id="calendar-dates"></div>
          <div class="botao-add">
        <button id="openModal" class="add-event-btn">Adicionar Evento</button>
      </div>
      </div>

      <!-- Modal Adicionar-->
        <div id="modal" class="modal">
          <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Adicionar Evento</h2>

            <div class="modal-form">
              <form class="modal-form" method="POST">

                <label>Título</label>
                <input name="titulo_evento" type="text" placeholder="Título do evento">

                <label>Data de início</label>
                <input name="data_evento" type="date">
                <input name="horario_evento" type="time">

                <label>Data de término</label>
                <input name="data_prazo" type="date">
                <input name="hora_prazo" type="time">

                <label>Descrição</label>
                <textarea name="descricao" placeholder="Escreva uma descrição..."></textarea>

                <button type="submit" class="save-event">Salvar</button>

              </form>
            </div>
          </div>
      </div>


      <!-- Modal Editar e Deletar -->
      <div id="modal-edit" class="modal">
        <div class="modal-content">
          <span class="close-add" id="close-edit">&times;</span>
          <h2>Editar Evento</h2>
          <div class="modal-form">
            <form method="POST" class="modal-form">
              <label>Título</label>
              <input id="titulo-edit" name="titulo_evento" type="text" placeholder="Título do evento">
              
              <label>Data de início</label>
              <input id="datai-edit" name="data_evento" type="date">
              <input id="horai-edit" name="horario_evento" type="time">
              
              <label>Data de término</label>
              <input id="datat-edit" name="data_prazo" type="date">
              <input id="horat-edit" name="hora_prazo" type="time">
              
              <label>Descrição</label>
              <textarea id="descricao-edit" name="descricao" placeholder="Escreva uma descrição..."></textarea>
              
              <input type="hidden" id="id-edit" name="id_evento">
              
              <button id="botaoDeletar" type="button" class="delete-evento">Deletar</button>
              <button type="button" class="edit-evento">Alterar</button>
            </form>
          </div>
        </div>
    </div>

    <!-- Modal confirmar exclusão -->
    <div id="modalDelete" class="modal-deletar">
      <div class="modal-content">
        <span class="close-delete"></span>
        <h2>Confirmar Exclusão</h2>
        <p>Tem certeza que deseja deletar este evento?</p>
        <div class="modal-buttons">
          <button id="confirmDelete" class="delete-confirm">Deletar</button>
          <button id="cancelDelete" class="delete-cancel">Cancelar</button>
        </div>
      </div>
    </div>

    <!-- Modal confirmar edição -->
    <div id="modalEditar" class="modal-editar">
      <div class="modal-content">
        <span class="close-edit"></span>
        <h2>Confirmar Alterações</h2>
        <p>Tem certeza que deseja alterar este evento?</p>
        <div class="modal-buttons">
          <button id="confirmEdit" class="edit-confirm">Alterar</button>
          <button id="cancelEdit" class="edit-cancel">Cancelar</button>
        </div>
      </div>
    </div>




    </section>


    <section class="eventos-adicionados">
      <p>Eventos do dia</p>

      <br>

      <div id="eventosDoDia">
        
      </div>
    </section>
  

    </section>

    <script src="calendario.js"></script>

  </section>

</body>
</html>
