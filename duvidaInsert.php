<?php

session_start();

include_once('conecta_db.php');
$oMysql = conecta_db();

date_default_timezone_set('America/Sao_Paulo');
$data_duvidas = date('Y-m-d');

$id_usuario = $_SESSION['id'];

if (isset($_POST['submit']) ) {

    if (empty($_POST['titulo']) || empty($_POST['duvida'])) {
        header('Location: duvidasVisualizar.php?error=2');
        die();
    } elseif (strlen($_POST['duvida']) < 100) {
        header('Location: duvidasVisualizar.php?error=3');
        die();
    } elseif (strlen($_POST['duvida']) > 500) {
        header('Location: duvidasVisualizar.php?error=4');
        die();
    } else {
        $titulo = $oMysql->real_escape_string($_POST['titulo']);
        $texto = $oMysql->real_escape_string($_POST['duvida']);
        
        $query = "INSERT INTO tb_duvidas (titulo_duvidas, texto_duvidas, data_duvidas, usuario_duvidas) VALUES ('$titulo', '$texto', '$data_duvidas', $id_usuario)";
        $resultado = $oMysql->query($query);
        

        if ($resultado) {
            header('Location: duvidasVisualizar.php?sucesso=1');
            exit(); // Adicione exit() após header() para garantir o redirecionamento
        } else {
            // Se a query falhar, mostre o erro do MySQL
            echo "Erro ao inserir dúvida: " . $oMysql->error;
            die(); // Interrompa a execução para ver o erro
        }
            }
} else {
    die("erro");
}

?>