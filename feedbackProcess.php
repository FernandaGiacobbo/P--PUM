<?php
// Habilita erros para depuração (remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclui a conexão com o banco de dados
include('conecta_db.php');

// Definindo os limites de caracteres
define('MIN_CHARS', 20);
define('MAX_CHARS', 1000);

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valida e sanitiza os dados do formulário
    $nome = isset($_POST['nome']) ? htmlspecialchars(trim($_POST['nome'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $comentarios = isset($_POST['comentarios']) ? htmlspecialchars(trim($_POST['comentarios'])) : '';
    
    // Inclui o header antes de qualquer output
    include 'header.php';
    
    // Validação do comprimento do comentário
    $comentarioLength = strlen($comentarios);
    if ($comentarioLength < MIN_CHARS) {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Feedback</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Mensagem muito curta",
                    text: "A mensagem deve conter no mínimo '.MIN_CHARS.' caracteres.",
                    confirmButtonColor: "#3A4A68",
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>';
        exit();
    }
    
    if ($comentarioLength > MAX_CHARS) {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Feedback</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Mensagem muito longa",
                    text: "A mensagem deve conter no máximo '.MAX_CHARS.' caracteres.",
                    confirmButtonColor: "#3A4A68",
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // Validação adicional
    if (empty($nome) || empty($email) || empty($comentarios) || $rating < 1 || $rating > 5) {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Feedback</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Preencha todos os campos corretamente.",
                    confirmButtonColor: "#3A4A68",
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // Conecta ao banco de dados
    $conexao = conecta_db();
    if ($conexao->connect_error) {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Feedback</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Não foi possível conectar ao banco de dados.",
                    confirmButtonColor: "#3A4A68",
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // Prepara e executa a query
    $sql = "INSERT INTO tb_feedback (nome, email, rating, comentarios) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Feedback</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Falha ao preparar a consulta SQL.",
                    confirmButtonColor: "#3A4A68",
                });
            </script>
        </body>
        </html>';
        exit();
    }

    $stmt->bind_param("ssis", $nome, $email, $rating, $comentarios);
    if ($stmt->execute()) {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Feedback</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Obrigado pelo seu feedback!",
                    text: "Seu feedback foi enviado com sucesso.",
                    confirmButtonColor: "#3A4A68",
                }).then(() => {
                    window.location.href = "feedbackGeral.php";
                });
            </script>
        </body>
        </html>';
    } else {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Feedback</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Não foi possível enviar o feedback. Tente novamente.",
                    confirmButtonColor: "#3A4A68",
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>';
    }

    $stmt->close();
    $conexao->close();
} else {
    // Se não for POST, redireciona para o formulário
    header("Location: feedbackGeral.php");
    exit();
}
?>