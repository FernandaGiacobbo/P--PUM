<?php

    include_once('conecta_db.php');
    $oMysql = conecta_db();

    if(isset($_GET['id_tarefa'])){
        $oMysql = conecta_db();
        $query = "DELETE FROM tb_tarefa WHERE id_tarefa = ".$_GET['id_tarefa'];
        $resultado = $oMysql->query($query);
        header('Location: principal.php');
        exit();
    }

?>