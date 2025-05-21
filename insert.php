<?php

    session_start();
    

    if(isset($_POST['detalhamento'])){
        include_once('conecta_db.php');
        $oMysql = conecta_db();
        $query = "INSERT INTO tb_tarefa (nome, detalhamento, data_tarefa, prazo, status_tarefa, usuario_id) VALUES ('".$_POST['nomet']."', '".$_POST['detalhamento']."', '".$_POST['data']."', '".$_POST['prazo']."', '".$_POST['status']."', '".$_SESSION['id']."')";
        $resultado = $oMysql->query($query);
        header('location: principal.php');
        exit(); 
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="insert.css">
    <title>Inserir Tarefa</title>
</head>
<body>
<?php include 'header.php'; ?>
    <section class="home">


    <h1>Inserir Tarefas</h1>

    <div>

    
    

    
        <form method="POST" action="principal.php?page=1" class="formulario">
            <p>Insira o nome da tarefa</p>
            <input type="text" class="form-control" name="nomet" placeholder="digite">

            

            <p>Insira o detalhamento da tarefa</p>
            <input type="text" class="form-control" name="detalhamento" placeholder="digite">

            

            <p>Insira a data de inserção da tarefa</p>
            <input type="datetime-local" class="form-control" name="data" placeholder="digite">

            

            <p>Insira o prazo da tarefa</p>
            <input type="date" class="form-control" name="prazo" placeholder="digite">

            

            <p>Insira o status da tarefa</p>
            <select name="status">
                <option value="Completo">Completo</option>
                <option value="Em Andamento">Em andamento</option>
                <option value="Não Iniciado">Não iniciado</option>
            </select>

            
            


            <button class="btn btn-primary" type="submit">Adicionar</button>

        </form>

    </div>

    </section>


</body>
</html>