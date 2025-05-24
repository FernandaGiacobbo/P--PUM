<?php
include 'conecta_db.php';

$oMysql = conecta_db();
$query = "SELECT * FROM tb_evento";
$resultado = $oMysql->query($query);

$eventos = array();
while ($row = $resultado->fetch_assoc()) {
    $eventos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($eventos);
?>