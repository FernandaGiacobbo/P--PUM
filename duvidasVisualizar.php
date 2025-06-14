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
$nome_usuario = $_SESSION['nome'];

if (!empty($id_usuario)) {
    date_default_timezone_set('America/Sao_Paulo');

    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $query = "SELECT * FROM tb_duvidas WHERE usuario_duvidas = $id_usuario ORDER BY id_duvidas DESC";
    $resultado = $oMysql->query($query);

} else {
    header('Location: index.php');
    die();
}

$logado = $_SESSION['nome'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/duvidaVisualizar.css">
    
    <title>Duvidas</title>
</head>
<body>

<?php include('header.php');?>
    
<section class="home">
    <div class="caixa">
        <h2>Olá, <?php echo $nome_usuario;?>! Qual a sua dúvida?</h2>
        <div class="criarDuvidas">
            <form action="duvidaInsert.php" method="post" id="formDuvida" >
                <label >
                    <p>Título:</p>
                    <input class="inputs" type="text" placeholder="Escreva aqui:" name="titulo">
                </label>

                <label >
                    <p>Sua dúvida:</p>
                    <textarea class="inputs" name="duvida" id="" placeholder="Escreva sua dúvida aqui!"></textarea>
                </label>

                <div class="botoes" >
                    <button type="submit" name="submit" class="btn">Enviar</button>
                    <button type="button" id="cancelar" class="btn">Cancelar</button>
                </div>
            </form>
        </div>

        <?php 
                if($resultado) {
                    while ($duvidasLinha = $resultado->fetch_object()){
                        $id_duvidas = $duvidasLinha->id_duvidas;
                        $titulo = $duvidasLinha->titulo_duvidas;
                        $texto = $duvidasLinha->texto_duvidas;
                        $data = date('d - m - Y', strtotime($duvidasLinha->data_duvidas));

                        $query2 = "SELECT 
                                        r.id_resposta,
                                        r.texto_resposta,
                                        r.data_resposta,
                                        u.nome_usuario
                                    FROM
                                        tb_resDuvidas r
                                    JOIN
                                        tb_usuario u on r.usuario_resposta = u.id_usuario
                                    WHERE 
                                        r.duvida_resposta = $id_duvidas ";
                        $resposta2 = $oMysql->query($query2);   
        ?>

        <br>
        

        <div class="visualizarDuvidas">

            <div class="duvidasCriadas">
                

                    <h2><?php echo $titulo;?></h2>
                            
                
                
                
                <div class="textoDuvida">
                    <?php echo $texto;?>
                </div>
                <div class="headerDuvida">
                    <a href="duvidaUpdate.php?id_duvidas=<?php echo $id_duvidas; ?>">Editar</a>
                    <p class="dataPostagem"> Publicado em: <?php echo $data;?> </p>
                </div>

                              <?php
                                    if($resposta2){
                                        while ($linhaRes = $resposta2->fetch_object()) {
                                            $nomeUsuarioRes = $linhaRes->nome_usuario;
                                            $textoRes = $linhaRes->texto_resposta;
                                            $dataRes = date('d - m - Y', strtotime($linhaRes->data_resposta));
                                        
                                ?>

                                    <div class="resDuvidas">
                                        <?php
                                            echo $nomeUsuarioRes;
                                            echo $textoRes;
                                            echo $dataRes;
                                        ?>
                                    </div>

                                <?php }}?>

            </div>
            

        </div>

        <?php } }?>

    <div class="caminho">
        <a href="usuarioPerfil.php"><?php echo $logado;?></a> /
        <a href="principal.php">Home</a> / 
        <a href="duvidasvisualizar.php"><b>Duvidas</b></a>
    </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("cancelar").addEventListener("click", function(e) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Suas informações serão apagadas.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, cancelar',
        cancelButtonText: 'Não, voltar',
        customClass: {
            popup: 'popup-personalizado',
            confirmButton: 'botao-confirmar',
            cancelButton: 'botao-cancelar'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Reseta o formulário
            document.getElementById("formDuvida").reset();

            // Exibe mensagem de sucesso
            Swal.fire({
                title: 'Cancelado!',
                text: 'Mensagem excluida',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'popup-personalizado',
                    confirmButton: 'botao-confirmar'
                }
            });
        }
    });
});
</script>


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

<?php if (isset($_GET['error']) && $_GET['error'] == 2): ?>
<script>
Swal.fire({
    title: 'Campos incompletos',
    text: 'Porfavor preencha todos os campos!!',
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

</body>
</html>