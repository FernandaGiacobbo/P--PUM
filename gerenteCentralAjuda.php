<?php

    session_start();
    include_once('conecta_db.php');
    $oMysql = conecta_db();


    

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
                                    WHEN r.id_resposta IS NOT NULL THEN 'Respondida'
                                    ELSE 'Não Respondida'
                                END AS status
                            FROM 
                                tb_duvidas d
                            JOIN 
                                tb_usuario u ON d.usuario_duvidas = u.id_usuario
                            LEFT JOIN 
                                tb_resDuvidas r ON d.id_duvidas = r.duvida_resposta";
                    $resulrado1 = $oMysql->query($query1);
                    if($resulrado1){
                        while ($duvidasL = $resulrado1->fetch_object()) {
                            $id_dus = $duvidasL->id_duvidas;
                            $nome_us = $duvidasL->nome_usuario;
                            $titulo_us = $duvidasL->titulo_duvidas;
                            $duvida_us = $duvidasL->texto_duvidas;
                            $data_us = $duvidasL->data_duvidas;
                ?>
                    <div class="caixaDuvidas">
                        <p class="nome"><?php echo $nome_us;?></p>
                        <h3><?php echo $titulo_us;?></h3>
                        <div class="textoDuvidas">
                            <p><?php echo $duvida_us;?></p>
                        </div>
                        <p class="dia"><?php echo $data_us;?></p>
                        <div class="btn">
                            <button class="botoes">Excluir</button>
                            <button class="botoes" id="abrirResposta">Responder</button>
                        </div>
                        
                    </div>
                <?php }}?>
                
            </div>
        </div>
       
        
    </section>

    <dialog id="dialog">
        <form action="" method="post">
            <h3>Responder: </h3>
            <textarea name="resposta" id="" placeholder="Digite aqui:"></textarea>
            <div class="btnModal">
                <button type="submit" class="botoesModal">Enviar</button>
                <button type="reset" class="botoesModal" id="cancelar">Cancelar</button>
            </div>                              
        </form>
    </dialog>
    
    <script>
        

        const modal = document.getElementById('dialog');
        const abrirModal = document.getElementById('abrirResposta');
        const fecharModal = document.getElementById('cancelar');

        abrirModal.onclick = function () {
            modal.showModal();
        };

        fecharModal.onclick = function () {
            modal.close();
        };
    </script>


</body>
</html>