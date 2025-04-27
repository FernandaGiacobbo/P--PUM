<?php

include 'header.php';
include_once('conecta_db.php');
$oMysql = conecta_db();

$id_us = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="dayli.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>


<body >

<section class="home">

<div class="conteiner">

    <div class="conteudo1">
        <h2>Dayli</h2>
        <button id="modal">Como foi seu dia?</button>
    </div>

    <div class="conteudo2">

    <?php
        
        $query = "SELECT * FROM tb_daily where usuario_id = $id_us AND (data_daily IS NOT NULL OR mooday_daily IS NOT NULL OR texto_daily IS NOT NULL);";
        $resultado = $oMysql->query($query);
        if($resultado) {
            while($linha = $resultado->fetch_object()){ 
            
                ?>
                <div class="cartao">
                    <div class="titulo">
                        <?php echo date('d - m - y', strtotime($linha->data_daily));?>
                    </div>

                    <div class="texto">
                        <?php echo "Seu dia foi: ". $linha->mooday_daily;?>
                        <hr>
                        <?php echo $linha->texto_daily;?>
                        <br>
                        <a href="Dailyeditar.php"><button class="Editar">Editar</button></a>
                    </div>
                    
                </div>
    <?php } }?>

    </div>

</div>

</section>

<div>

    <dialog class="form" id="criar">

    <h2>Sua rotina:</h2>

    <form action="criarDayli.php" method="post">
        <p>como foi seu dia?</p>
        <label><input type="radio" name="mood" value="Produtivo">Produtivo</label>
        <label><input type="radio" name="mood" value="Mais ou menos">Mais ou menos</label>
        <label><input type="radio" name="mood" value="Pouco produtivo">Pouco produtivo</label>

        <textarea name="daylist" placeholder="Um resumo do seu dia"></textarea>

        <button type="submit"id="Enviar" name="submit">Enviar</button>
        
    </form>
        <button id="Sair">Sair</button>

    </dialog>

 
    <script src="dayli.js"></script>
</div>

</body>
</html>