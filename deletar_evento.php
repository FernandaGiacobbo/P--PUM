<?php
include 'conecta_db.php';

$oMysql = conecta_db();

if (isset($_POST['id_evento'])) {
  $id = (int) $_POST['id_evento']; // segurança básica
  $sql = "DELETE FROM tb_evento WHERE id_evento = $id";

  if ($oMysql->query($sql)) {
    echo "Evento deletado.";
  } else {
    echo "Erro ao deletar: " . $oMysql->error;
  }
} else {
  echo "ID não informado.";
}
?>
