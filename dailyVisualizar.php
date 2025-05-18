<?php

session_start();


include_once('conecta_db.php');
$oMysql = conecta_db();

$id_us = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dayli</title>
    <link rel="stylesheet" href="dailyVisualizar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>


<body >
<?php include 'header.php'; ?>

<section class="home">

    <div class="main">

        <div class="cabecalho">
            <h1>Daily:</h1> 
            <label for=""> 
                Adicione como foi seu dia: <button id="abrir">Aqui</button>
            </label>
            
        </div>
        <hr>
        <div class="conteudo">

        <?php
        
        $query = "SELECT * FROM tb_daily where usuario_id = $id_us AND (data_daily IS NOT NULL OR mooday_daily IS NOT NULL OR texto_daily IS NOT NULL);";
        $resultado = $oMysql->query($query);
        if($resultado) {
            while($linha = $resultado->fetch_object()){ ?>

                <div class="cartao">
                    <div class="cabeca">
                        <h3><?php echo date('d - m - y', strtotime($linha->data_daily));?></h3>
                    </div>

                    

                    <div class="corpo">
                        <?php echo "Seu dia foi: ". $linha->mooday_daily;?>
                        <br>
                        <?php echo "Suas tarefas foram concluidas? ". $linha->tarefas_daily;?>
                            
                        <br><br>
                        
                            <?php echo $linha->texto_daily;?>
                            <br>
                            <?php echo "<a href='dailyEditar.php?id_daily=$linha->id_daily'><button class='Editar'>Editar</button></a>";?>

                    </div>

                </div>

        <?php } }?>

            
        </div>

        <dialog id="modal"> 

            <form action="dailyCriar.php" method="post">

                <h2>Registre seu dia:</h2>

                <p>Você considera que seu dia foi:</p>
                <label for="">
                    <input type="radio" name="mood" value="Produtivo"> Produtivo
                    <input type="radio" name="mood" value="Poderia ser melhor"> Poderia ser melhor
                    <input type="radio" name="mood" value="Pouco produtivo"> Pouco produtivo
                </label>

                
                <p>Você conseguiu concluir suas tarefas?</p>
                <label for="">
                    <input type="radio" name="tarefas" value="Sim"> Sim
                    <input type="radio" name="tarefas" value="Não"> Não
                </label>
                

                <p>Conte um pouco sobre seu dia:</p>
                <label for="" class="texto">
                    <textarea name="daily" id="" placeholder="Escreva aqui" class="textarea"></textarea>
                </label>
                
                <label for="" >
                    <button type="submit" name="submit">Enviar </button>
                    <button  type="reset" id="fechar">Cancelar</button>
                </label>
                

            </form>
        </dialog>

    </div>

    <script src="dailyVisualizar.js"></script>

    <br><br><br><br>

</section>

</body>
</html>