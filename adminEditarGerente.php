<?php
$tempoExpiracao = 86400; //limita a 86400s = 1 dia a sessão do usuário caso não tenha nenhuma inatividade

ini_set('session.gc_maxlifetime', $tempoExpiracao); // controla quanto tempo o php mantém os dados no servidor 
session_set_cookie_params($tempoExpiracao); //Controla quanto tempo o PHP mantém os dados da sessão no servidor após inatividade.

session_start();

// Verifica se houve inatividade superior a 1 dia
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tempoExpiracao)) {
    session_unset();    
    session_destroy();  // destrói a sessão
    header('Location: index.php'); 
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // atualiza tempo da última atividade

include_once('conecta_db.php');
$oMysql = conecta_db();

$id_usuario = $_SESSION['id'];

if(!empty($id_usuarioS)){

// Verifica se o ID foi passado na URL
if(isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Busca os dados do gerente no banco
    $query = "SELECT id_usuario, nome_usuario, email_usuario FROM tb_usuario WHERE id_usuario = ? AND cargo = 'gerente'";
    $stmt = $oMysql->prepare($query);
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0) {
        $gerente = $resultado->fetch_object();
    } else {
        $_SESSION['erro'];
        header('Location: adminRegistro.php');
        exit;
    }
} else {
    $_SESSION['erro'];
    header('Location: adminRegistro.php');
    exit;
}

// Se o formulário for enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Validações básicas
    if (empty($nome) || empty($email)) {
        $_SESSION['erro'] = 'Nome e e-mail são obrigatórios!';
        header('Location: adminEditarGerente.php?id_usuario='.$id_usuario);
        exit;
    }

    // Verifica se o e-mail já existe (exceto para o próprio usuário)
    $query = "SELECT id_usuario FROM tb_usuario WHERE email_usuario = ? AND id_usuario != ?";
    $stmt = $oMysql->prepare($query);
    $stmt->bind_param('si', $email, $id_usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['erro'] = 'Este e-mail já está cadastrado!';
        header('Location: adminEditarGerente.php?id_usuario='.$id_usuario);
        exit;
    }

    // Atualiza os dados no banco
    if(!empty($senha)) {
        // Se a senha foi alterada (sem hash)
        $query = "UPDATE tb_usuario SET nome_usuario = ?, email_usuario = ?, senha_usuario = ? WHERE id_usuario = ?";
        $stmt = $oMysql->prepare($query);
        $stmt->bind_param('sssi', $nome, $email, $senha, $id_usuario);
    } else {
        // Se a senha não foi alterada
        $query = "UPDATE tb_usuario SET nome_usuario = ?, email_usuario = ? WHERE id_usuario = ?";
        $stmt = $oMysql->prepare($query);
        $stmt->bind_param('ssi', $nome, $email, $id_usuario);
    }

    if ($stmt->execute()) {
        $_SESSION['sucesso'];
    } else {
        $_SESSION['erro'];
    }

    header('Location: adminRegistro.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Gerente</title>
    <link rel="stylesheet" href="css/adminRegistro.css">
</head>
<body>

<?php include 'adminHeader.php'; ?>

<section class="home">
    <h2>Editar Gerente</h2>
    <div class="tabela">
        <form method="POST" action="adminEditarGerente.php?id_usuario=<?php echo $id_usuario; ?>">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($gerente->nome_usuario); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($gerente->email_usuario); ?>" required>
            </div>
            <div class="form-group">
                <label for="senha">Nova Senha (deixe em branco para manter a atual):</label>
                <input type="password" id="senha" name="senha">
            </div>
            <button type="submit" class="btn-submit">Atualizar</button>
        </form>
    </div>
</section>

</body>
</html>

<?php
    } else {
        header('Location: index.php');
        die();
    }
?>