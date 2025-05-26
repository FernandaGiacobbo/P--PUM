
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=preview" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>PA-PUM</title>
</head>

<body>

<?php 
  include 'header.php'; 
?>


<section class="home">
    
  <div class="container">

  
  

    <?php
        $oMysql = conecta_db();
        $query1 = "SELECT status_tarefa FROM tb_tarefa where usuario_tarefa = $id_us";
        $resultado1 = $oMysql->query($query1);

        $concluido = 0;
        $pendente = 0;

        $cont_linhas = mysqli_num_rows($resultado1);

        for($i = 0; $i < $cont_linhas; $i++){

            $status = mysqli_fetch_assoc($resultado1);

            if ($status['status_tarefa'] != 'Completo') {
              $pendente += 1;
            } else {
              $concluido += 1;
            }
        
          
        }


      //pegando as infos dos status 

    ?>

      <div class="caixa">
    
            <h2 class="nomem">Bom te ver novamente, <?php echo $logado;?>!!</h2>

            <h3>
              Você possui <b><?php echo $pendente;?> </b class="vermelho"> tarefas pendentes e <b class="verde"><?php echo $concluido;?> </b>concluidas!
            </h3>

      
      </div>
    
    
    

    <div class="corpo">

      <h3>Meus Afazeres</h3>
      
            <div class="tabela">

                  <button class="botao" id="abrir">Adicionar Tarefa</button>

                <table class="table">
                  
                    <tr>
                      <th>Nome</th>
                      <th>Detalhamento</th>
                      <th>Data</th>
                      <th>Prazo</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  

                  

                    <?php
                      
                      $query = "SELECT * FROM tb_tarefa where usuario_tarefa = $id_us ORDER BY id_tarefa DESC";
                      $resultado = $oMysql->query($query);
                      if($resultado) {
                          while($linha = $resultado->fetch_object()){

                              $botoes = ""; 

                              $botoes .= "<a class='success' href='mainVisualizar.php?id_tarefa=".$linha->id_tarefa."'> <span class='material-symbols-outlined'>preview</span> Visualizar</a>";
                              

                              $html = "<tr class='corpo_tb'>";
                              $html .= "<td class='td_dec'>".$linha->nome_tarefa."</td>";
                              $html .= "<td class='td_dec'><div class='td_scroll'>".htmlspecialchars($linha->detalhamento_tarefa)."</div></td>";
                              $html .= "<td class='td_dec'>".$linha->data_tarefa."</td>";
                              $html .= "<td class='td_dec'>".$linha->prazo_tarefa."</td>";
                              $html .= "<td class='td_dec'>".$linha->status_tarefa."</td>";
                              $html .= "<td class='td_dec alingbtn'>".$botoes."</td>";
                              $html .= "</tr>";

                              echo $html;

                          }
                      }

                    ?>

                  
                </table>
            </div>

              
    </div>


  </div>

  <dialog id="modal">
    <div class="caixaModal">
        <form action="mainInsert.php" method="post">

                <h2>Inserir sua Tarefa:</h2>

                
                <label >
                    <p>Insira o nome da tarefa</p>
                    <input type="text" class="nome" name="nomet" placeholder="digite">
                </label>

                
                
                <label class="texto">
                  <p>Insira o detalhamento da tarefa</p>
                    <textarea name="detalhamento"  placeholder="Escreva aqui" class="textarea"></textarea>
                </label>
                

                
              <div class="datas">
                    <label>
                      <p>Começo da tarefa</p>
                      <input type="date" class="data" name="data_insercao">
                    </label>

                    <label>
                      <p>Termino da tarefa</p>
                      <input type="date" class="data" name="prazo">
                    </label>
              </div>
                
                
                <label >
                  <p>Insira o status da tarefa</p>
                    <select name="status">
                        <option value="Não Iniciado">Não iniciado</option>
                        <option value="Em Andamento" >Em andamento</option>
                        
                    </select>
                </label>

                <div class="botoesModal">
                  <button type="submit" name="submit">Criar</button>
                  <button type="reset" id="sair">Sair</button>
                </div>
                

        </form>                 
    </div>
  </dialog>

    <div id="cronometro">
      <h1>Cronômetro Pomodoro</h1>

      <div class="inputs-pomodoro">
        <label>Foco: <input type="number" id="tempoFoco" value="25"></label>
        <label>Intervalo: <input type="number" id="tempoIntervalo" value="5"></label>
      </div>

      <div id="timer">25:00</div>
      <p id="status">Foco</p>

      <div class="botoes-cronometro">
        <button onclick="startTimer()">Iniciar</button>
        <button onclick="pauseTimer()">Pausar</button>
        <button onclick="resetTimer()">Resetar</button>
      </div>
    </div>


</section>

<script src="js/principal.js"></script>

</body>
</html>