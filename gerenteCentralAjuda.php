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
    include_once('conecta_db.php');
    $oMysql = conecta_db();
if (!empty($id_usuario)) {

$logado = $_SESSION['nome'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central de Ajuda</title>
    <link rel="stylesheet" href="css/gerenteCentralAjuda.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=preview" />
    

</head>
<body>
    
    <?php 
        include 'gerenteHeader.php';
    ?>

    <section class="home">
        <?php
            $query2 = "SELECT COUNT(*) AS total_nao_respondidas
                        FROM tb_duvidas d
                        LEFT JOIN tb_resDuvidas r ON d.id_duvidas = r.duvida_resposta
                        WHERE r.id_resposta IS NULL";
            $resultado2 = $oMysql->query($query2);
            $naoRes = $resultado2->fetch_assoc();
            $quantidade_nao_respondidas = $naoRes['total_nao_respondidas'];
        ?>

        <div class="caixa">
            <h2>Você possui <b><?php echo $quantidade_nao_respondidas;?></b> duvidas não repondidas:</h2>
            <div class="duvidas">

                <?php
                    $query1 = "SELECT
                                    d.id_duvidas,
                                    d.titulo_duvidas,
                                    d.texto_duvidas,
                                    d.data_duvidas,
                                    u.nome_usuario AS nome_usuario,
                                    CASE
                                        WHEN MAX(r.id_resposta) IS NOT NULL THEN 'Respondida'
                                        ELSE 'Não Respondida'
                                    END AS status
                                FROM
                                    tb_duvidas d
                                JOIN
                                    tb_usuario u ON d.usuario_duvidas = u.id_usuario
                                LEFT JOIN
                                    tb_resDuvidas r ON d.id_duvidas = r.duvida_resposta
                                GROUP BY
                                    d.id_duvidas, d.titulo_duvidas, d.texto_duvidas, d.data_duvidas, u.nome_usuario
                                ORDER BY
                                    d.id_duvidas DESC";
                    $resulrado1 = $oMysql->query($query1);
                    if($resulrado1){
                        while ($duvidasL = $resulrado1->fetch_object()) {
                            $id_dus = $duvidasL->id_duvidas;
                            $nome_us = $duvidasL->nome_usuario;
                            $titulo_us = $duvidasL->titulo_duvidas;
                            $duvida_us = $duvidasL->texto_duvidas;
                            $data_us = $duvidasL->data_duvidas;
                            $status_class = ($duvidasL->status == 'Não Respondida') ? 'nao-respondida' : 'respondida';
                ?>
                    <div class="caixaDuvidas <?php echo $status_class; ?>" data-id=<?php echo $id_dus?>>
                        <p class="nome"><?php echo $nome_us;?></p>
                        <h3><?php echo $titulo_us;?></h3>
                        <div class="textoDuvidas">
                            <p><?php echo $duvida_us;?></p>
                        </div>
                        <p class="dia"><?php echo $data_us;?></p>
                        
                    </div>
                <?php }}?>
                
            </div>
        </div>


            <div id="duvidamodal" class="modal" style="display:none;">

                <div class="caixaModal" >
                <span class="close" id="closeModal">×</span>

                <div id="duvidaDetalhe">
                    <h2 id="modalTitulo"></h2>
                    <p id="modalTexto"></p>
                    <p><strong>Usuário:</strong> <span id="modalUsuario"></span></p>
                    <p><strong>Data:</strong> <span id="modalData"></span></p>
                    <button id="excluirDuv" data-id="" class="btn2">Excluir</button>
                </div>

                <div id="respostaDetalhe">
                    <h3>Respostas:</h3>
                    <div id="respostasLista">
                    
                    <p><strong>Usuário:</strong> </p>
                    </div>

                    //no form você add o input 

                    <form id="respostaForm" action="gerenteCentralAjudaInsert.php" method="POST">
                        <br>
                        <p>Adicione sua resposta:</p>
                        <textarea name="texto" id="textoResposta" placeholder="adicione sua resposta" required></textarea>
                        <input type="hidden" name="id" id="respostaDuvidaId">
                        <button type="submit" id="enviarResposta" class="btn2">Enviar</button>
                        <button type="button" id="cancelarResposta" class="btn2">Cancelar</button>
                        <button type="button" id="salvarEdicao" style="display:none;" class="btn2">Salvar</button>
                    </form>

                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="js/gerenteCentralAjuda.js"></script>

            <div class="caminho">
                <a href="gerentePerfil.php"><?php echo $logado;?></a> /
                <a href="gerenteMain.php">Home</a> / 
                <a href="gerenteCentralAjuda.php"><b>Duvidas</b></a>
            </div>
    </section>

<?php if (isset($_GET['error']) && $_GET['error'] == 3): ?>
<script>
Swal.fire({
    title: 'Tamanho da mensagem!!',
    text: 'A sua mensagem tem que ter no mínimo 100 caracteres.',
    icon: 'warning',
    confirmButtonText: 'OK',
    customClass: {
            popup: 'popup-personalizado',
            confirmButton: 'botao-confirmar',
            cancelButton: 'botao-cancelar'
        }
}).then(() => {
    
    const url = new URL(window.location.href);
    url.searchParams.delete('error');
    window.history.replaceState({}, document.title, url);
});

</script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 4): ?>
<script>
Swal.fire({
    title: 'Tamanho da mensagem!!',
    text: 'A sua mensagem tem que ter no máximo 500 caracteres.',
    icon: 'warning',
    confirmButtonText: 'OK',
    customClass: {
            popup: 'popup-personalizado',
            confirmButton: 'botao-confirmar',
            cancelButton: 'botao-cancelar'
        }
}).then(() => {
    
    const url = new URL(window.location.href);
    url.searchParams.delete('error');
    window.history.replaceState({}, document.title, url);
});

</script>
<?php endif; ?>


<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
<script>
Swal.fire({
    title: 'Dúvida enviada!',
    text: 'Dúvida enviada com sucesso, aguarde sua resposta.',
    icon: 'success',
    confirmButtonText: 'OK',
    customClass: {
            popup: 'popup-personalizado',
            confirmButton: 'botao-confirmar',
            cancelButton: 'botao-cancelar'
        }
}).then(() => {
    
    const url = new URL(window.location.href);
    url.searchParams.delete('sucesso');
    window.history.replaceState({}, document.title, url);
});

</script>
<?php endif; ?>

</body>
</html>

<?php
} else {
   header('Location: index.php');
    die();
}
?>