<?php
// Habilita erros para depuração (remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclui a conexão com o banco de dados
include('conecta_db.php');

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valida e sanitiza os dados do formulário
    $nome = isset($_POST['nome']) ? htmlspecialchars(trim($_POST['nome'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $comentarios = isset($_POST['comentarios']) ? htmlspecialchars(trim($_POST['comentarios'])) : '';

    // Validação adicional (opcional)
    if (empty($nome) || empty($email) || empty($comentarios) || $rating < 1 || $rating > 5) {
        die("<h1>Erro</h1><p>Preencha todos os campos corretamente.</p>");
    }

    // Conecta ao banco de dados
    $conexao = conecta_db();
    if ($conexao->connect_error) {
        die("<h1>Erro</h1><p>Não foi possível conectar ao banco de dados.</p>");
    }

    // Prepara e executa a query
    $sql = "INSERT INTO tb_feedback (nome, email, rating, comentarios) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die("<h1>Erro</h1><p>Falha ao preparar a consulta SQL.</p>");
    }

    $stmt->bind_param("ssis", $nome, $email, $rating, $comentarios);
    if ($stmt->execute()) {
        // Mensagem de sucesso
        echo "<h1>Obrigado pelo seu feedback!</h1>";
        echo "<p>Seu feedback foi enviado com sucesso.</p>";
    } else {
        echo "<h1>Erro</h1><p>Não foi possível enviar o feedback. Tente novamente.</p>";
    }

    include 'header.php';

    $stmt->close();
    $conexao->close();
} else {
    // Se não for POST, redireciona para o formulário
    header("Location: feedbackGeral.php");
    exit();

}
?>