<?php
session_start();
include_once('conecta_db.php');
$oMysql = conecta_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    // Validações básicas
    if (empty($nome) || empty($email) || empty($senha)) {
        $_SESSION['erro'] = 'Todos os campos são obrigatórios!';
        header('Location: adminRegistro.php');
        exit;
    }
    
    // Verificar se o email já existe
    $query = "SELECT id_usuario FROM tb_usuario WHERE email_usuario = ?";
    $stmt = $oMysql->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $_SESSION['erro'] = 'Este e-mail já está cadastrado!';
        header('Location: adminRegistro.php');
        exit;
    }
    
    // Criptografar a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
    // Inserir no banco de dados
    $query = "INSERT INTO tb_usuario (nome_usuario, email_usuario, senha_usuario, cargo) VALUES (?, ?, ?, 'gerente')";
    $stmt = $oMysql->prepare($query);
    $stmt->bind_param('sss', $nome, $email, $senhaHash);
    
    if ($stmt->execute()) {
        $_SESSION['sucesso'];
    } else {
        $_SESSION['erro'];
    }
    
    header('Location: adminRegistro.php');
    exit;
} else {
    header('Location: adminRegistro.php');
    exit;
}
?>