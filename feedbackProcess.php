<?php
include('conecta_db.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se campos existem antes de acessá-los
    $nome = isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $comentarios = isset($_POST['comentarios']) ? htmlspecialchars($_POST['comentarios']) : '';

    $conexao = conecta_db();

    if($conexao->connect_error){
        die("A conexão falhou: " . $conexao->connect_error);
    }

    $sql = "INSERT INTO tb_feedback (nome, email, rating, comentarios) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssis", $nome, $email, $rating, $comentarios);

    if($stmt->execute()){
        echo "<h1>Obrigado pelo seu feedback!</h1>";
        echo "<p>Seu feedback foi enviado com sucesso!.</p>";
    } else {
        echo "<h1>ERRO</h1><p>Não pôde enviar este formulário. Por favor, tente novamente depois.</p>";
    }

    $stmt->close();
    $conexao->close();
} else {
    echo "<h1>Acesso inválido.</h1><p>Esta página só pode ser acessada através do formulário de feedback.</p>";
}
?>