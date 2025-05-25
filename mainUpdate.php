<?php


if (isset($_POST['submit']) && isset($_GET['id_tarefa'])) {
    $id_tarefa = $_GET['id_tarefa'];
    $nome = $_POST['nomet'] ;
    $detalhamento = $_POST['detalhamento'];
    $data_tarefa = $_POST['data_insercao'];
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

