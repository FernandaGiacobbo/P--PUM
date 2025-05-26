<?php
session_start();

$id_us = $_SESSION['id'];

include_once('conecta_db.php');
$oMysql = conecta_db();

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
        <button class="botao-adicionar-gerente">+</button>
        <p>Adicionar gerente</p>
    </div>
    <table class="table"> <tr>
                <th class="td_dec">ID</th> <th class="td_dec">Nome</th> <th class="td_dec">E-mail</th> <th class="td_dec">Senha</th> <th class="td_dec">Excluir</th> </tr>

            <?php
            //query para chamar todoss osa gerentes para a tabela
                $query = "SELECT id_usuario, nome_usuario, email_usuario, senha_usuario FROM tb_usuario where cargo = 'gerente' ORDER BY id_usuario";
                $resultado = $oMysql->query($query);
                if($resultado) {
                    while($linha = $resultado -> fetch_object()){
                        $botao = "";

                        $botao .= "<a class='success' href='adminExluirGerente.php?id_usuario=".$linha->id_usuario."'> Excluir </a>";

                        $html = "<tr class-'corpo_tb'>";
                        $html .= "<td class='td_dec'>".$linha->id_usuario."</td>";
                        $html .= "<td class='td_dec'>".$linha->nome_usuario."</td>";
                        $html .= "<td class='td_dec'>".$linha->email_usuario."</td>";
                        $html .= "<td class='td_dec'>".$linha->senha_usuario."</td>";
                        $html .= "<td class='td_dec alingbtn'>".$botao."</td>";
                        $html .= "</tr>";

                        echo $html;
                    }
                }
            ?>
        </table>
    </div>
</section>
</body>
</html>