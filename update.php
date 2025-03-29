<?php

if(isset($_POST['id_tarefa'])){
    $oMysql = conecta_db();
    $query = "UPDATE tb_tarefa SET 
              nome = '" . $_POST['nomet'] . "', 
              detalhamento = '" . $_POST['detalhamento'] . "', 
              data_tarefa = '" . $_POST['data'] . "', 
              prazo = '" . $_POST['prazo'] . "', 
              status_tarefa = '" . $_POST['status'] . "' 
              WHERE id_tarefa = " . $_GET['id_tarefa'];
              
    $resultado = $oMysql->query($query);
    header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Inserir Tarefa</title>
</head>
<body>

    <h1>Inserir Tarefas - ID tarefa: <?php echo $_GET['id_tarefa'];?></h1>

    <div>

    <br>
    <br>
    <br>
    <br>
    <br>

    
        <form method="POST" action="index.php?page=2&id_tarefa=<?php echo $_GET['id_tarefa'];?>" class="formulario">
            <p>Insira o nome da tarefa</p>
            <input type="text" class="form-control" name="nomet" placeholder="digite">

            <br>

            <p>Insira o detalhamento da tarefa</p>
            <input type="text" class="form-control" name="detalhamento" placeholder="digite">

            <br>

            <p>Insira a data de inserção da tarefa</p>
            <input type="datetime-local" class="form-control" name="data" placeholder="digite">

            <br>

            <p>Insira o prazo da tarefa</p>
            <input type="date" class="form-control" name="prazo" placeholder="digite">

            <br>

            <p>Insira o status da tarefa</p>
            <select name="status">
                <option value="Completo">Completo</option>
                <option value="Em Andamento">Em andamento</option>
                <option value="Não Iniciado">Não iniciado</option>
            </select>

            <br>
            <br>


            <button class="btn btn-primary" type="submit">Adicionar</button>

        </form>

    </div>

    <style>
        .formulario {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
    </style>

</body>
</html>