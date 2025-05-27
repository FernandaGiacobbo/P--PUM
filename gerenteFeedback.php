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
            $sql = "SELECT * FROM tb_feedback ORDER BY submitted_at DESC";
            $result = $conn->query($sql);
            
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
    
    <script>
        function openModal(feedbackId) {
            fetch('gerenteFeedbackDetalhes.php?id=' + feedbackId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalTitle').textContent = `Feedback de ${data.nome}`;
                    
                    let stars = '';
                    for (let i = 1; i <= 5; i++) {
                        stars += i <= data.rating ? '★' : '☆';
                    }
                    
                    document.getElementById('modalContent').innerHTML = `
                        <p><strong>Email:</strong> ${data.email}</p>
                        <p><strong>Avaliação:</strong> ${stars} (${getRatingText(data.rating)})</p>
                        <p><strong>Data:</strong> ${new Date(data.submitted_at).toLocaleString()}</p>
                        <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px;">
                            <strong>Comentário:</strong>
                            <p>${data.comentarios}</p>
                        </div>
                    `;
                    
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
            fetch('gerenteFeedbackLido.php?id=' + feedbackId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const item = document.querySelector(`.feedback-item[data-feedback-id="${feedbackId}"]`);
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