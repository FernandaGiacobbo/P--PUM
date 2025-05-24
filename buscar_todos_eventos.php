<?php
    include 'conecta_db.php';
    session_start();

    $id_estudante = $_SESSION['id'];
    $oMysql = conecta_db();

    $stmt = $oMysql->prepare("SELECT * FROM tb_evento WHERE id_estudante = ?");
    $stmt->bind_param("i", $id_estudante);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $eventos = array();

    while ($row = $resultado->fetch_assoc()) {
        $eventos[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($eventos);
?>