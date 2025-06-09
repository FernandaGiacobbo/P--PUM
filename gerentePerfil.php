<?php
$tempoExpiracao = 86400; //limita a 86400s = 1 dia a sessão do usuário caso não tenha nenhuma inatividade

ini_set('session.gc_maxlifetime', $tempoExpiracao); // controla quanto tempo o php mantém os dados no servidor 
session_set_cookie_params($tempoExpiracao); //Controla quanto tempo o PHP mantém os dados da sessão no servidor após inatividade.

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


if(!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
} else {
    include_once('conecta_db.php');
    $oMysql = conecta_db();

    include 'gerenteHeader.php';

        $senha_log = $_SESSION['senha'];
        $email_log = $_SESSION['email'];
        $logado = $_SESSION['nome'];
        $id_us = $_SESSION['id']; 
        $cargo = $_SESSION['cargo'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usuarioPerfil.css">

    <title>Perfil</title>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <section class="home">
        <section class="quadro-infos">
            <h3 class="titulo-caixa">Perfil</h3>


            <div class="nome">
                <div class="titulos-labels">
                    <h1>Nome:</h1>
                    <div class="placeholder"><?php echo $logado;?></div>
                </div>
            </div>

            <div class="email">
                <div class="titulos-labels">
                    <h1>E-mail:</h1>
                    <div class="placeholder"><?php echo $email_log;?></div>
                </div>
            </div>

            <br>
            
           <button type="button" class="edit " onclick="irParaEditar()">Editar</a></button>
            <button type="submit" class="delete" id="Excluir" name="Excluir" onclick="confirmarExclusao()">Excluir</a></button>
            <button type="submit" class="logout" id="Excluir" name="Excluir" onclick="confirmarLogout()">Sair</button>


    </section>
</section>

<script>
function confirmarLogout() {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você realmente quer finalizar a sessão?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, sair',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redireciona somente após confirmação
            window.location.href = "sairsession.php?id_usuario=<?php echo $id_us; ?>";
        }
    });
}

function confirmarExclusao(){
        Swal.fire({
        title: 'Tem certeza?',
        text: "Você realmente quer excluir seu perfil?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redireciona somente após confirmação
            window.location.href = "usuarioExcluir.php";
        }
    });
}

function irParaEditar(){
    window.location.href = "gerenteUpdate.php";
}

</script>



</body>
</html>