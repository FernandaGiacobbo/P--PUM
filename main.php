<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="main.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <title>Papum</title>
</head>
<body>
<?php 
  include ('header.php'); 
?>
<section class="home">

<div class="container">

<br>
<br>

  <?php
    $oMysql = conecta_db();
    $query1 = "SELECT status_tarefa FROM tb_tarefa where usuario_id = $id_us";
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

  <section id="containernome">
  <h2 class="nomem">Olá, <?php echo $logado;?></h2>

    <div class="caixa">
      <h3 class="mostrartarefas"> Você tem <?php echo $concluido;?> tarefas concluídas</h3>
    </div>

    <div class="caixa">
    <h3 class="mostrartarefas"> Você tem <?php echo $pendente;?> tarefas pendentes</h3>
    </div>

  </section>
  
  <br>

  <div class="table-responsive">

    <h3>Meus Afazeres</h3>
    <br>

    <button class="btn btn-primary" onclick="window.location.href='principal.php?page=1'">Adicionar Tarefa</button>

    <br>
    <br>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID tarefa</th>
          <th>Nome</th>
          <th>Detalhamento</th>
          <th>Data</th>
          <th>Prazo</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>

      <tbody>

        <?php
          
          $query = "SELECT * FROM tb_tarefa where usuario_id = $id_us";
          $resultado = $oMysql->query($query);
          if($resultado) {
              while($linha = $resultado->fetch_object()){

                  $botoes = "<a 
                      class='btn btn-success' href='principal.php?page=2&id_tarefa=".$linha->id_tarefa."'> Alterar </a>";
                  $botoes .= "<a class='btn btn-danger' href='principal.php?page=3&id_tarefa=".$linha->id_tarefa."'> Excluir </a>";
                  

                  $html = "<tr>";

                  $html .= "<td>".$linha->id_tarefa."</td>";
                  $html .= "<td>".$linha->nome."</td>";
                  $html .= "<td>".$linha->detalhamento."</td>";
                  $html .= "<td>".$linha->data_tarefa."</td>";
                  $html .= "<td>".$linha->prazo."</td>";
                  $html .= "<td>".$linha->status_tarefa."</td>";
                  $html .= "<td>".$botoes."</td>";
                  $html .= "</tr>";

                  echo $html;

              }
          }

        ?>

      </tbody>
    </table>

    
    </div>


  </div>

  </section>

</body>
</html>