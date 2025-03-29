<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <title>Papum</title>
</head>
<body>
  
  <div class="table-responsive">

    <h3>Meus Afazeres</h3>
    <button class="btn btn-primary" onclick="window.location.href='index.php?page=1'">Adicionar Tarefa</button>

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

        
          $oMysql = conecta_db();
          $query = "SELECT * FROM tb_tarefa";
          $resultado = $oMysql->query($query);
          if($resultado) {
              while($linha = $resultado->fetch_object()){

                  $botoes = "<a 
                      class='btn btn-success' href='index.php?page=2&id_tarefa=".$linha->id_tarefa."'> Alterar </a>";
                  $botoes .= "<a class='btn btn-danger' href='index.php?page=3&id_tarefa=".$linha->id_tarefa."'> Excluir </a>";
                  

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

</body>
</html>