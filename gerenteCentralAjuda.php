<?php

    session_start();
    $id_usuario = $_SESSION['id'];
    include_once('conecta_db.php');
    $oMysql = conecta_db();
if (!empty($id_usuario)) {

    

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central de Ajuda</title>
    <link rel="stylesheet" href="css/gerenteCentralAjuda.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=preview" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    <button id="excluirDuv" data-id="" class="btn2">Excluir Dúvida</button>
                </div>

                <div id="respostaDetalhe">
                    <h3>Respostas:</h3>
                    <div id="respostasLista">
                    
                    <p><strong>Usuário:</strong> </p>
                    </div>

                    <div id="respostaForm">
                        <br>
                        <p>Adicione sua resposta:</p>
                        <textarea name="respostaTexto" id="textoResposta" placeholder="adicione sua resposta"></textarea>
                        <button id="enviarResposta" class="btn2">Enviar</button>
                        <button id="cancelarResposta" class="btn2">Cancelar</button>
                        <button id="salvarEdicao" style="display:none;" class="btn">Salvar</button>
                    </div>
                    </div>
                </div>
            </div>
       
            <script src="js/gerenteCentralAjuda.js"></script>
    </section>




</body>
</html>

<?php
} else {
   header('Location: index.html');
    die();
}
?>