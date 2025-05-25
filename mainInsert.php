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
        $query = "INSERT INTO tb_tarefa (nome, detalhamento, data_tarefa, prazo, status_tarefa, usuario_id) VALUES ('$nome', '$detalhe', '$dataInc', '$datFim', '$status', $id_us)";
        $resultado = $oMysql->query($query);
        header('location: principal.php');
        exit(); 
    } else {
        echo "Erro ao inserir: " . $oMysql->error;
    }

?>
