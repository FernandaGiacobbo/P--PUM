<?php
    include 'conecta_db.php';
    session_start();

    if (isset($_GET['data'])) {
        $data = $_GET['data'];
        $id_estudante = $_SESSION['id'];
        $oMysql = conecta_db();

        $stmt = $oMysql->prepare("SELECT * FROM tb_evento WHERE data_evento = ? AND id_estudante = ?");
        $stmt->bind_param("si", $data, $id_estudante);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $eventos = [];

        while ($row = $resultado->fetch_assoc()) {
            $eventos[] = $row;
        }

        echo json_encode($eventos);
    }
?>