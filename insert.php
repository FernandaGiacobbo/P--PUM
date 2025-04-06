<?php

    if(isset($_POST['detalhamento'])){
        $oMysql = conecta_db();
        $query = "INSERT INTO tb_tarefa (nome, detalhamento, data_tarefa, prazo, status_tarefa) VALUES ('".$_POST['nomet']."', '".$_POST['detalhamento']."', '".$_POST['data']."', '".$_POST['prazo']."', '".$_POST['status']."')";
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
    <link rel="stylesheet" href="insert.css">
    <title>Inserir Tarefa</title>
</head>
<body>

    <section class="home">


    <h1>Inserir Tarefas</h1>

    <div>

    <br>
    <br>

    
        <form method="POST" action="index.php?page=1" class="formulario">
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

    </section>


</body>
</html>