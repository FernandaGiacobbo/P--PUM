<?php
include_once('conecta_db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login</title>
    <link rel="stylesheet" href="css/indexLogin.css">
</head>
<body>
    <div class="caixa">
        <div class="main">

            <div class="conteudo" id="partForm">

                <div class="form">

                    <h2>Login:</h2>
                    <form action="indexLogin.php" method="post">

                        <p>Qual seu e-mail? :</p>
                        <label for="" class="textinput">  
                            <input type="text" placeholder="Seu e-mail aqui" class="texto" name="email" required>
                        </label>

                        <p>Qual sua senha? :</p>
                        <label for="" class="textinput">
                            <input type="password" placeholder="Sua senha aqui" class="texto" name="senha" required>
                        </label>
                        
                        <button type="submit" name="submit" class="entre">Entre</button>

                    </form>
                </div>

            </div>
        
            <div class="conteudo" id="partBut">

                <p>Ainda não possui uma conta?</p> <br>
                <h3>Crie já e seja uma pessoa mais organizada:</h3>

                <button id="modal">Cadastre-se</button>
        
            </div>

            <dialog id="abirModal">

                <div class="conteudo">

                    <div class="form">
        
                        <h2>Login:</h2>
                        <form action="indexCadastro.php" method="post">

                            <label for="" class="textinput">
                                <p>Qual seu nome? :</p>
                                <input type="text" placeholder="Seu nome aqui" class="texto" name="nome" required>
                            </label>
        
                            <label for="" class="textinput">
                                <p>Qual seu e-mail? :</p>
                                <input type="email" placeholder="Seu e-mail aqui" class="texto" name="email" required>
                            </label>
        
                            <label for="" class="textinput">
                                <p>Qual sua senha? :</p>
                                <input type="password" placeholder="Sua senha aqui" class="texto" name="senha" required>
                            </label>
                            <div class="btnAling">
                                <button type="submit" name="cadastro">Entre</button>
                                <button type="reset" id="fecharModal">Fechar</button>
                            </div>
                        </form>
                    </div>
        
                </div>

            </dialog>

        </div>
    </div>

    <script src="js/indexLogin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
<script>
Swal.fire({
    title: 'e-mail já cadastrado!!!!',
    text: 'Realizar login ou insira novo e-mail',
    icon: 'warning',
    confirmButtonText: 'OK',
    backdrop: true,
    allowOutsideClick: false, 
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


<?php if (isset($_GET['error']) && $_GET['error'] == 2): ?>
<script>
Swal.fire({
    title: 'Padrão de senha incorreto',
    text: 'tente novamente seguindo o padrão exigido',
    icon: 'warning',
    confirmButtonText: 'OK',
    backdrop: true,
    allowOutsideClick: false, 
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