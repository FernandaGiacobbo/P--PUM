
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


$id_usuario = $_SESSION['id'];
$logado = $_SESSION['nome'];

if(!empty($id_usuario)) {

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/feedback.css">
    <!-- Adicionando SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="feedback-container">
        <h1><i class="fa fa-comments"></i> Compartilhe seu Feedback</h1>
        <p>Adoraríamos ouvir a sua opinião! (Mínimo de 20 caracteres)</p>
        <form action="feedbackProcess.php" method="POST" class="feedback-form" id="feedbackForm">
            <div class="form-group">
                <label for="nome"><i class="fa fa-user"></i>Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Coloque seu nome" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fa fa-envelope"></i>E-mail</label>
                <input type="email" name="email" id="email" placeholder="Coloque seu e-mail" required>
            </div>
            <div class="form-group">
            <label for="rating"><i class="fa fa-star"></i> Rating</label>
            <select name="rating" id="rating" required>
                <option value="" disabled selected>Selecione um rating</option>
                <option value="5">Excelente</option>
                <option value="4">Bom</option>
                <option value="3">Mediano</option>
                <option value="2">Ruim</option>
                <option value="1">Péssimo</option>
            </select>
            </div>
            <div class="form-group">
            <label for="comentarios"><i class="fa fa-comment"></i>Comentários</label>
            <textarea name="comentarios" id="comentarios" placeholder="Escreva sua mensagem (mínimo 20 caracteres)..." rows="5" required></textarea>
            <small id="charCount">0 caracteres</small>
            </div>
            <button type="submit" class="btn"><i class="fa fa-paper-plane"></i>Enviar Feedback</button>
        </form>
            
    </div>

            <div class="caminho">
                <a href="usuarioPerfil.php"><?php echo $logado;?></a> /
                <a href="principal.php">Home</a> / 
                <a href="feedbackGeral.php"><b>feedback</b></a>
            </div>

    <script>
        // Definindo os limites de caracteres
        const MIN_CHARS = 20;
        const MAX_CHARS = 1000;
        
        // Contador de caracteres em tempo real
        document.getElementById('comentarios').addEventListener('input', function() {
            const charCount = this.value.length;
            document.getElementById('charCount').textContent = `${charCount} caracteres`;
            
            if (charCount < MIN_CHARS) {
                document.getElementById('charCount').style.color = 'red';
            } else {
                document.getElementById('charCount').style.color = 'green';
            }
        });
        
        // Validação do formulário antes de enviar
        document.getElementById('feedbackForm').addEventListener('submit', function(e) {
            const comentarios = document.getElementById('comentarios').value;
            
            if (comentarios.length < MIN_CHARS) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Mensagem muito curta',
                    text: `A mensagem deve conter no mínimo ${MIN_CHARS} caracteres.`,
                    confirmButtonColor: '#3085d6',
                });
            }
        });
    </script>
</body>
</html>

<?php
} else {
    header('Location: index.php');
}
?>