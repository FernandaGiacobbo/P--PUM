<?php

    session_start();
    $id_us = $_SESSION['id'];

    $nome = $_POST['nomet'];
    $detalhe = $_POST['detalhamento'];
    $dataInc = $_POST['data_insercao'];
    $datFim = $_POST['prazo'];
    $status = $_POST['status'];

    

    if(isset($_POST['submit'])){
        include_once('conecta_db.php');
        $oMysql = conecta_db();
        $query = "INSERT INTO tb_tarefa (nome_tarefa, detalhamento_tarefa, data_tarefa, prazo_tarefa, status_tarefa, usuario_tarefa) VALUES ('$nome', '$detalhe', '$dataInc', '$datFim', '$status', $id_us)";
        $resultado = $oMysql->query($query);
        header('location: principal.php');
        exit(); 
    } else {
        echo "Erro ao inserir: " . $oMysql->error;
    }

?>
