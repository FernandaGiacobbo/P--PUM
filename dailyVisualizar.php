<?php

session_start();


include_once('conecta_db.php');
$oMysql = conecta_db();

$id_us = $_SESSION['id'];

//busca a dau=ily do dia 
$query3 = "SELECT * FROM tb_daily WHERE id_usuario = $id_us AND data_daily = CURDATE()";
$resultado = $oMysql->query($query3);

//vai verificar se o select anterior tinha algum resultado

if ($resultado && $linha = $resultado->fetch_assoc()) {
    $resumo_dia = $linha['resumo_dia'];
    $inicio_planejado = $linha['inicio_planejado'];
    $metas_definidas = $linha['metas_definidas'];
    $metas_concluidas = $linha['metas_concluidas'];
    $adiantou_tarefa = $linha['adiantou_tarefa'];
    $postura_pendencias = $linha['postura_pendencias'];
    $emocao_dia = $linha['emocao_dia'];
    $conselho_para_si = $linha['conselho_para_si'];
    $texto_livre = $linha['texto_livre'];
} else {
    //isso daqui é  que vai ser executado caso não haja uma daily registrada pro dia atual 
    $resumo_dia = "";
    $inicio_planejado = "";
    $metas_definidas = "";
    $metas_concluidas = "";
    $adiantou_tarefa = "";
    $postura_pendencias = "";
    $emocao_dia = "";
    $conselho_para_si = "";
    $texto_livre = "";
    //basiicamente criou um conjunto de tudo, só que vazio, sem valores
}


?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily</title>
    <link rel="stylesheet" href="dailyVisualizar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>


<body >
<?php include 'header.php'; ?>

<section class="home">

    <div class="main">

        <div class="cabecalho">
            <h1>Daily</h1> 
            <label for=""> 
                Adicione como foi seu dia: <button id="abrir">Aqui</button>
            </label>
            
        </div>
        <hr>
        <div class="conteudo">

        <?php
        
        $query = "SELECT * FROM tb_daily where id_usuario = $id_us AND (data_daily IS NOT NULL);";
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

                <input type="hidden" name="id_daily" value="<?php echo isset($linha['id_daily']) ? $linha['id_daily'] : ''; ?>">

                <h2>Registre seu dia</h2>

                <!-- pergunta 1 -->
                <p class="pergunta">Como você se sentiu, de forma geral, em relação ao seu dia?</p>
                <label>
                    <input type="radio" name="resumo_dia" value="Leve e equilibrado(a)" <?php echo( $resumo_dia  == 'Leve e equilibrado(a)') ? 'checked' : '' ?>> Leve e equilibrado(a) <br>
                    <input type="radio" name="resumo_dia" value="Produtivo(a) e realizado(a)" <?php echo( $resumo_dia  == 'Produtivo(a) e realizado(a)') ? 'checked' : '' ?>> Produtivo(a) e realizado(a) <br>
                    <input type="radio" name="resumo_dia" value="Corrido e desgastante" <?php echo( $resumo_dia  == 'Corrido e desgastante') ? 'checked' : '' ?>> Corrido e desgastante <br>
                    <input type="radio" name="resumo_dia" value="Confuso e desconectado(a)" <?php echo( $resumo_dia  == 'Confuso e desconectado(a)') ? 'checked' : '' ?>> Confuso e desconectado(a) <br>
                    <input type="radio" name="resumo_dia" value="Satisfatório, dentro do possível" <?php echo( $resumo_dia  == 'Satisfatório, dentro do possível') ? 'checked' : '' ?>> Satisfatório, dentro do possível <br>
                    <input type="radio" name="resumo_dia" value="Frustrante ou abaixo do que eu esperava" <?php echo( $resumo_dia  == 'Frustrante ou abaixo do que eu esperava') ? 'checked' : '' ?>> Frustrante ou abaixo do que eu esperava
                </label>

                <!-- pergunta 2 -->
                <p class="pergunta">Você conseguiu iniciar o dia como havua planejado?</p>
                <label>
                    <input type="radio" name="inicio_planejado" value="Sim, dentro do que imaginei" <?php echo( $inicio_planejado  == 'Sim, dentro do que imaginei') ? 'checked' : '' ?>> Sim, dentro do que imaginei <br>
                    <input type="radio" name="inicio_planejado" value="Não exatamente, mas está tudo bem" <?php echo( $inicio_planejado  == 'Não exatamente, mas está tudo bem') ? 'checked' : '' ?>> Não exatamente, mas está tudo bem <br>
                    <input type="radio" name="inicio_planejado" value="Não fiz um plano para hoje" <?php echo( $inicio_planejado  == 'Não fiz um plano para hoje') ? 'checked' : '' ?>> Não fiz um plano para hoje 
                </label>

                <!-- pergunta 3 -->
                <p class="pergunta">Quantas metas ou intenções você definiu para hoje? Lembre-se de considerar tanto tarefas quanto atitudes ou hábitos.</p>
                <label>
                    <input type="number" name="metas_definidas" min="0" value="<?php echo isset($metas_definidas) ? $metas_definidas : '' ?>">
                </label>
                
                <!-- pergunta 4 -->
                <p class="pergunta">E quantas metas ou intenções você conseguiu concluir?</p>
                <label>
                    <input type="number" name="metas_concluidas" min="0" value="<?php echo isset($metas_concluidas) ? $metas_concluidas : '' ?>">
                </label>
                
                <!-- pergunta 5 -->
                <p class="pergunta">Você adiantou ou resolveu algo que não estava nos seus planos para hoje?</p>
                <label>
                    <input type="radio" name="adiantou_tarefa" value="1" <?php echo (isset($adiantou_algo)&& $adiantou_algo == 1) ? 'checked' : ''?>> Sim, e isso foi positivo <br>
                    <input type="radio" name="adiantou_tarefa" value="0" <?php echo (isset($adiantou_algo)&& $adiantou_algo == 1) ? 'checked' : ''?>> Não, mantive o foco no que já havia planejado
                </label>
            
                <!-- pergunta 6 -->
                <p class="pergunta">Como foi sua postura diante dos desafios e pendências do dia?</p>
                <label>
                    <input type="radio" name="postura_pendencias" value="Evitei lidar com eles" <?php echo( $postura_pendencias == 'Evitei lidar com eles') ? 'checked' : '' ?>> Evitei lidar com eles <br>
                    <input type="radio" name="postura_pendencias" value="Enfrentei com coragem" <?php echo( $postura_pendencias  == 'Enfrentei com coragem') ? 'checked' : '' ?>> Enfrentei com coragem <br>
                    <input type="radio" name="postura_pendencias" value="Me senti pressionado(a)" <?php echo( $postura_pendencias == 'Me senti pressionado(a)') ? 'checked' : '' ?>> Me senti pressionado(a) <br>
                    <input type="radio" name="postura_pendencias" value="Agi no automático" <?php echo( $postura_pendencias  == 'Agi no automático') ? 'checked' : '' ?>> Agi no automático <br>
                    <input type="radio" name="postura_pendencias" value="Observei com consciência e fiz o possível" <?php echo( $postura_pendencias  == 'Observei com consciência e fiz o possível') ? 'checked' : '' ?>> Observei com consciência e fiz o possível <br>
                    <input type="radio" name="postura_pendencias" value="Preferi deixar para outro momento" <?php echo( $postura_pendencias == 'Preferi deixar para outro momento') ? 'checked' : '' ?>> Preferi deixar para outro momento
                </label>
                
                <!-- pergunta 7 -->
                <p class="pergunta">Como você se sentiu ao longo do dia? Reflita com sinceridade sobre suas emoções. Houve variações? Algum gatilho importante?</p>
                <label>
                    <textarea name="emocao_dia" rows="6" cols="50" maxlength="300"> <?php echo isset($emocao_dia) ? $emocao_dia : ''?> </textarea>
                </label>

                <!-- pergunta 8 -->
                <p class="pergunta">Gostaria de deixar um lembrete ou conselho para si mesmo(a) amanhã?Algo que possa te inspirar, cuidar ou guiar quando um novo dia começar.</p>
                <label>
                    <textarea name="conselho_para_si" rows="6" cols="50" maxlength="300"> <?php echo isset ($conselho_para_si) ? $conselho_para_si : ''?></textarea>
                </label>
            
                <!-- pergunta 9 -->
                <p class="pergunta">Deseja escrever algo livremente sobre o seu dia? Esse espaço é seu. Pode desabafar, agradecer, soltar ideias ou apenas respirar.</p>
                <label>
                    <textarea name="texto_livre" rows="6" cols="50" maxlength="300"><?php echo isset($texto_livre) ? $texto_livre : ''?></textarea>  
                </label>
                <br>

                <button type="submit">Salvar</button>

            </form>
        </dialog>

    </div>

    <script src="dailyVisualizar.js"></script>

    <br><br><br><br>

</section>

</body>
</html>