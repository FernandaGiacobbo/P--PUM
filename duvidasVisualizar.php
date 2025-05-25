<?php

session_start();
$id_usuario = $_SESSION['id'];
$nome_usuario = $_SESSION['nome'];

if (!empty($id_usuario)) {
    date_default_timezone_set('America/Sao_Paulo');

    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $query = "SELECT * FROM tb_duvidas WHERE usuario_duvidas = $id_usuario ORDER BY id_duvidas DESC";
    $resultado = $oMysql->query($query);
} else {
    header('Location: index.html');
    die();
}




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
        <h2>Olá <?php echo $nome_usuario;?>, qual a sua duvida?</h2>
        <div class="criarDuvidas">
            <form action="duvidaInsert.php" method="post" id="formDuvida" >
                <label >
                    <p>Titulo:</p>
                    <input type="text" placeholder="Escreva aqui:" name="titulo">
                </label>

                <label >
                    <p>Sua duvida:</p>
                    <textarea name="duvida" id="" placeholder="Escreva sua duvida aqui!"></textarea>
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
        ?>

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

            </div>

            

        </div>

        <?php } }?>
        
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