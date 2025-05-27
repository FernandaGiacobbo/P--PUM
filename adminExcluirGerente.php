<?php
session_start();
include_once('conecta_db.php');
$oMysql = conecta_db();

// Verifica se o ID foi passado na URL
if(isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    
    try {
        // Prepara a query de exclusão
        $query = "DELETE FROM tb_usuario WHERE id_usuario = ? AND cargo = 'gerente'";
        $stmt = $oMysql->prepare($query);
        $stmt->bind_param('i', $id_usuario);
        
        // Executa a exclusão
        if($stmt->execute()) {
            // Verifica se alguma linha foi afetada
            if($stmt->affected_rows > 0) {
                $_SESSION['sucesso'];
            } else {
                $_SESSION['erro'];
            }
        } else {
            $_SESSION['erro'];
        }
    } catch (Exception $e) {
        $_SESSION['erro'] = 'Erro ao excluir: ' . $e->getMessage();
    }
} else {
    $_SESSION['erro'] = 'ID do usuário não especificado.';
}

// Redireciona de volta para a página de registro
header('Location: adminRegistro.php');
exit;
?>