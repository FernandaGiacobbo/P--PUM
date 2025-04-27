<?php
include 'conecta_db.php';

if (isset($_GET['data'])) {
    $data = $_GET['data'];
    $oMysql = conecta_db();

    $stmt = $oMysql->prepare("SELECT * FROM tb_evento WHERE data_evento = ?");
    $stmt->bind_param("s", $data);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $eventos = [];

    while ($row = $resultado->fetch_assoc()) {
        $eventos[] = $row;
    }

    echo json_encode($eventos);
}
?>
