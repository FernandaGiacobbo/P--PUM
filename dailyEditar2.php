<?php

session_start();

include_once('conecta_db.php');
$oMysql = conecta_db();

if (isset($_POST['editar'])) {
    $id_d = $_SESSION['id_daily'];
    $opcao = $_POST['mood'];
    $tarefa = $_POST['tarefas'];
    $texto = $_POST['texto'];
    

    $query2 = "UPDATE tb_daily SET mooday_daily = '$opcao', tarefas_daily = '$tarefa', texto_daily = '$texto' WHERE id_daily = $id_d";
    $resultado2 = $oMysql->query($query2);

    header('Location: dailyVisualizar.php');
} else {
    echo"error0";
}

?>