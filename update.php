<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id_tarefa'])) {
    $id_tarefa = $_GET['id_tarefa'];
    $nome = $_POST['nomet'] ;
    $detalhamento = $_POST['detalhamento'];
    $data_tarefa = $_POST['data'];
    $prazo = $_POST['prazo'];
    $status_tarefa = $_POST['status'];

    $oMysql = conecta_db();
    
    if ($oMysql) {
        $query = "UPDATE tb_tarefa SET nome = ?, detalhamento = ?, data_tarefa = ?, prazo = ?, status_tarefa = ? WHERE id_tarefa = ?";
        $stmt = $oMysql->prepare($query);
        $stmt->bind_param("sssssi", $nome, $detalhamento, $data_tarefa, $prazo, $status_tarefa, $id_tarefa);
        
        if ($stmt->execute()) {
            header('Location: principal.php');
            exit();
        } else {
            echo "Erro ao atualizar a tarefa: " . $stmt->error;
        }
        
        $stmt->close();
        $oMysql->close();
    } else {
        echo "Erro na conexão com o banco de dados.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="update.css">
    <title>Inserir Tarefa</title>
</head>
<body>

<section class="home">

    <h1>Atualizar Tarefas - ID tarefa: <?php echo $_GET['id_tarefa'];?></h1>

    <div>

    <br>
    <br>

    
        <form method="POST" action="principal.php?page=2&id_tarefa=<?php echo $_GET['id_tarefa'];?>" class="formulario">
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

