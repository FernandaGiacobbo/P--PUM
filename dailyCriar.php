<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');//transforma a data padrão para São Paulo 

$id_us = $_SESSION['id'];
$data = date('Y-m-d');

include_once('conecta_db.php');
$oMysql = conecta_db();


if (isset($_POST['submit'])){

    $query2 = "SELECT data_daily, id_daily FROM tb_daily WHERE id_usuario = $id_us AND data_daily = '$data'";

    $resultado2 = $oMysql->query($query2);
    
    if ($res = mysqli_fetch_assoc($resultado2)) {
        $id_day = $res['id_daily'];
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>"; 
        echo "<script>
                Swal.fire({
                    title: 'Atenção!',
                    text: 'Suas informações de hoje já foram registradas.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'dailyEditar.php?id_daily=$id_day';
                });
              </script>";
        exit();
    } else {
        $data = date('Y-m-d');
        $resumo_dia = $_POST['resumo_dia'] ?? '';
        $inicio_planejado = $_POST['inicio_planejado'] ?? '';
        $metas_definidas = (int)($_POST['metas_definidas'] ?? '0'); //botei esse int só pra garantir msm q a informação vai ser um int
        $metas_concluidas = (int)($_POST['metas_concluidas'] ?? '0');
        $adiantou_tarefa = (int)($_POST['adiantou_tarefa'] ?? '0');
        $postura_pendencias = $_POST['postura_pendencias'] ?? '';
        $emocao_dia = $_POST['emocao_dia'] ?? '';
        $conselho_para_si = $_POST['conselho_para_si'];
        $texto_livre = $_POST['texto_livre'];
        
        $query = "INSERT INTO tb_daily(data_daily, resumo_dia, inicio_planejado, metas_definidas, metas_concluidas, adiantou_tarefa, postura_pendencias, emocao_dia, conselho_para_si, texto_livre, id_usuario) 
                    VALUES ('$data', '$resumo_dia', '$inicio_planejado', '$metas_definidas', '$metas_concluidas', '$adiantou_tarefa', '$postura_pendencias', '$emocao_dia', '$conselho_para_si', '$texto_livre', '$id_us')";
        $registro = $oMysql->query($query);

        header('location: dailyVisualizar.php');
    }

}

?>