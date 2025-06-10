<?php
$tempoExpiracao = 86400; //limita a 86400s = 1 dia a sessão do usuário caso não tenha nenhuma inatividade

ini_set('session.gc_maxlifetime', $tempoExpiracao); // controla quanto tempo o php mantém os dados no servidor 
session_set_cookie_params($tempoExpiracao); //Controla quanto tempo o PHP mantém os dados da sessão no servidor após inatividade.

session_start();

$logado = $_SESSION['nome'];

// Verifica se houve inatividade superior a 1 dia
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tempoExpiracao)) {
    session_unset();    
    session_destroy();  // destrói a sessão
    header('Location: index.php'); 
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // atualiza tempo da última atividade

    $id_usuario = $_SESSION['id'];

    if(!empty($id_usuario)) {
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks - Área do Gerente</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="gerenteFeedback.css">
</head>
<body>
    <?php include 'gerenteHeader.php'; ?>
    
    <div class="container">
        <h1><i class="fas fa-comments"></i> Feedbacks Recebidos</h1>
        
        <div class="feedback-list" id="feedbackList">
            <?php
            include 'conecta_db.php';
            
            $conn = conecta_db();

            // Consulta todos os feedbacks ordenando do mais recente ao mais antigo
            $sql = "SELECT * FROM tb_feedback ORDER BY submitted_at DESC";
            $result = $conn->query($sql);
            
            //Se houver feedbacks, entra no while para exibir cada um
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $status_class = $row['lido'] ? 'read' : '';
                    $status_badge = $row['lido'] ? 
                        '<span class="status-badge read-badge"><i class="fas fa-check"></i> Lido</span>' : 
                        '<span class="status-badge unread-badge"><i class="fas fa-exclamation"></i> Não lido</span>';
                    
                    echo '
                    <div class="feedback-item '.$status_class.'" data-feedback-id="'.$row['id'].'" onclick="openModal('.$row['id'].')">
                        <div class="feedback-header">
                            <span class="feedback-name">'.$row['nome'].'</span>
                            <span class="feedback-rating">'.str_repeat('★', $row['rating']).str_repeat('☆', 5 - $row['rating']).'</span>
                        </div>
                        <div class="feedback-email">'.$row['email'].'</div>
                        <div class="feedback-date">'.date('d/m/Y H:i', strtotime($row['submitted_at'])).'</div>
                        '.$status_badge.'
                    </div>
                    ';
                }
            } else {
                echo '<p>Nenhum feedback recebido ainda.</p>';
            }
            $conn->close();
            ?>
        </div>
    </div>
    
    <div class="modal" id="feedbackModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Detalhes do Feedback</h2>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            
            <div id="modalContent"></div>
            <div class="action-buttons" id="actionButtons"></div>
        </div>
    </div>


            <div class="caminho">
                <a href="gerentePerfil.php"><?php echo $logado;?></a> /
                <a href="gerenteMain.php">Home</a> / 
                <a href="gerenteFeedback.php"><b>Feedback</b></a>
            </div>
    
    <script>
        function openModal(feedbackId) {

            //Faz uma requisição ao backend para pegar os detalhes completos do feedback (nome, comentário, etc)
            fetch('gerenteFeedbackDetalhes.php?id=' + feedbackId)
                .then(response => response.json())
                .then(data => {
                    //Atualiza o título do modal dinamicamente com o nome da pessoa
                    document.getElementById('modalTitle').textContent = `Feedback de ${data.nome}`;
                    
                    let stars = '';
                    for (let i = 1; i <= 5; i++) {
                        stars += i <= data.rating ? '★' : '☆';
                    }
                    //Monta o conteúdo do feedbaack usando os dados recebidos da API
                    document.getElementById('modalContent').innerHTML = `
                        <p><strong>Email:</strong> ${data.email}</p>
                        <p><strong>Avaliação:</strong> ${stars} (${getRatingText(data.rating)})</p>
                        <p><strong>Data:</strong> ${new Date(data.submitted_at).toLocaleString()}</p>
                        <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px;">
                            <strong>Comentário:</strong>
                            <p>${data.comentarios}</p>
                        </div>
                    `;
                    //Se ainda não tiver sido lido, exibe o botão "Marcar como lido"
                    let buttons = '';
                    if (!data.lido) {
                        buttons += `
                            <button class="btn btn-mark-read" onclick="markAsRead(${data.id})">
                                <i class="fas fa-check"></i> Marcar como lido
                            </button>
                        `;
                    }
                    buttons += `
                        <button class="btn btn-close" onclick="closeModal()">
                            <i class="fas fa-times"></i> Fechar
                        </button>
                    `;
                    
                    document.getElementById('actionButtons').innerHTML = buttons;
                    document.getElementById('feedbackModal').style.display = 'flex';
                });
        }
        
        function closeModal() {
            document.getElementById('feedbackModal').style.display = 'none';
        }
        
        function markAsRead(feedbackId) {

            //Envia uma requisição para atualizar o status do feedback na banco de dados
            fetch('gerenteFeedbackLido.php?id=' + feedbackId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const item = document.querySelector(`.feedback-item[data-feedback-id="${feedbackId}"]`);

                        // Atualiza visualmente o card do feedback para "lido", sem recarregar a página
                        item.classList.add('read');
                        item.querySelector('.status-badge').outerHTML = `
                            <span class="status-badge read-badge"><i class="fas fa-check"></i> Lido</span>
                        `;
                        document.getElementById('actionButtons').innerHTML = `
                            <button class="btn btn-close" onclick="closeModal()">
                                <i class="fas fa-times"></i> Fechar
                            </button>
                        `;
                    }
                });
        }
        
        function getRatingText(rating) {
            //Converte a nota numérica em texto para exibir junto com as estrelas
            const ratings = {
                1: 'Péssimo',
                2: 'Ruim',
                3: 'Mediano',
                4: 'Bom',
                5: 'Excelente'
            };
            return ratings[rating] || '';
        }
    </script>
</body>
</html>

<?php
    } else {
        header('Location: index.php');
        die();
    }
?>