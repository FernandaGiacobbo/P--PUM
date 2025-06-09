<?php
session_start();

$id_usuario = $_SESSION['id'];

if(!empty($id_usuario)){

include_once('conecta_db.php');
$oMysql = conecta_db();

// Logo após a abertura da seção .home
if (isset($_SESSION['erro'])) {
    echo '<div class="mensagem erro">'.$_SESSION['erro'].'</div>';
    unset($_SESSION['erro']);
}

if (isset($_SESSION['sucesso'])) {
    echo '<div class="mensagem sucesso">'.$_SESSION['sucesso'].'</div>';
    unset($_SESSION['sucesso']);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="css/adminRegistro.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=preview" />

</head>
<body>

<?php
include 'adminHeader.php';
?>

<section class="home">
<h2>Registro de gerentes</h2>
<div class="tabela">
    <br>
    <div class="adicionar-gerente">
        <button class="botao-adicionar-gerente" hrer="">+</button>
        <p>Adicionar gerente</p>
    </div>
    <table class="table"> <tr>
                <th class="td_dec">ID</th> 
                <th class="td_dec">Nome</th> 
                <th class="td_dec">E-mail</th> 
                <th class="td_dec">Excluir</th> 
                <th class="td_dec">Editar</th>
            </tr>

            <?php
            //query para chamar todoss osa gerentes para a tabela
                $query = "SELECT id_usuario, nome_usuario, email_usuario, senha_usuario FROM tb_usuario where cargo = 'gerente' ORDER BY id_usuario";
                $resultado = $oMysql->query($query);
                if($resultado) {
                    while($linha = $resultado -> fetch_object()){
                        $botaoExcluir = "";
                        $botaoEditar = "";

                        $botaoExcluir = "<div class='botao-acao'><a class='success' href='adminExcluirGerente.php?id_usuario=".$linha->id_usuario."'>Excluir</a></div>";
                        $botaoEditar = "<div class='botao-acao'><a class='success' href='adminEditarGerente.php?id_usuario=".$linha->id_usuario."'>Editar</a></div>";

                        $html = "<tr class-'corpo_tb'>";
                        $html .= "<td class='td_dec'>".$linha->id_usuario."</td>";
                        $html .= "<td class='td_dec'>".$linha->nome_usuario."</td>";
                        $html .= "<td class='td_dec '>".$linha->email_usuario."</td>";
                        $html .= "<td class='td_dec alingbtnex'>".$botaoExcluir."</td>";
                        $html .= "<td class='td_dec alingbtned'>".$botaoEditar."</td>";
                        $html .= "</tr>";

                        echo $html;
                    }
                }
            ?>
        </table>
    </div>
</section>


<div id="modal-adicionar" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Cadastrar Novo Gerente</h2>
        <form id="form-adicionar-gerente" method="POST" action="adminCadastrarGerente.php">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar-senha">Confirmar Senha:</label>
                <input type="password" id="confirmar-senha" name="confirmar-senha" required>
            </div>
            <button type="submit" class="btn-submit">Cadastrar</button>
        </form>
    </div>
</div>

<script>
    // Pegar elementos
    const btnAdicionar = document.querySelector('.botao-adicionar-gerente');
    const modal = document.getElementById('modal-adicionar');
    const closeModal = document.querySelector('.close-modal');

    // Abrir modal quando clicar no botão de adicionar
    btnAdicionar.addEventListener('click', function() {
        modal.style.display = 'block';
    });

    // Fechar modal quando clicar no X
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Fechar modal quando clicar fora dele
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    // Validação do formulário (opcional)
    document.getElementById('form-adicionar-gerente').addEventListener('submit', function(e) {
        const senha = document.getElementById('senha').value;
        const confirmarSenha = document.getElementById('confirmar-senha').value;
        
        if (senha !== confirmarSenha) {
            e.preventDefault();
            alert('As senhas não coincidem!');
        }
    });
</script>


</body>
</html>


<?php
    } else {
        header('Location: index.php');
        die();
    }
?>