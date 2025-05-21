<?php

session_start();

if (!empty($_GET['id_daily'])) {
    
    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $id_d = $_GET['id_daily'];
    $_SESSION['id_daily'] = $id_d;

    $query = "SELECT * FROM tb_daily WHERE id_daily = $id_d";
    $resultado = $oMysql->query($query);

    if ($resultado->num_rows > 0) {
        while ($user_daily = mysqli_fetch_assoc($resultado)) {
            $iday = $user_daily['id_daily'];
            $data = $user_daily['data_daily'];
            $resumo_dia = $user_daily['resumo_dia'];
            $inicio_planejado = $user_daily['inicio_planejado'];
            $metas_definidas = $user_daily['metas_definidas'];
            $metas_concluidas = $user_daily['metas_concluidas'];
            $adiantou_tarefa = $user_daily['adiantou_tareda'];
            $postura_pendencias = $user_daily['postura_pendencias'];
            $emocao_dia = $user_daily['emocao_dia'];
            $conselho_para_si=$user_daily['conselho_para_si'];
            $texto_livre = $user_daily['texto_livre'];

        }

        

    } else {
        header('Location: dailyVizualizar.php');
    }
} else {
    echo "erro";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="dailyEditar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>


<body >

<?php include 'header.php'; ?>

<section class="home">


<div class="conteinerEDITAR">



    <div class="cartao-editar">
           <form action="dailyEditar2.php" method="post">

                <h2>Editar</h2>
                <h2>Registre seu dia</h2>

                <!-- pergunta 1 -->
                <p>Como você se sentiu, de forma geral, em relação ao seu dia?</p>
                <label>
                    <input type="radio" name="resumo_dia" value="Leve e equilibrado(a)" <?php echo( $resumo_dia  == 'Leve e equilibrado(a)') ? 'checked' : '' ?>> Leve e equilibrado(a)
                    <input type="radio" name="resumo_dia" value="Produtivo(a) e realizado(a)" <?php echo( $opcao  == 'Produtivo(a) e realizado(a)') ? 'checked' : '' ?>> Produtivo(a) e realizado(a)
                    <input type="radio" name="resumo_dia" value="Corrido e desgastante" <?php echo( $opcao  == 'Corrido e desgastante') ? 'checked' : '' ?>> Corrido e desgastante
                    <input type="radio" name="resumo_dia" value="Confuso e desconectado(a)" <?php echo( $opcao  == 'Confuso e desconectado(a)') ? 'checked' : '' ?>> Confuso e desconectado(a)
                    <input type="radio" name="resumo_dia" value="Satisfatório, dentro do possível" <?php echo( $opcao  == 'Satisfatório, dentro do possível') ? 'checked' : '' ?>> Satisfatório, dentro do possível
                    <input type="radio" name="resumo_dia" value="Frustrante ou abaixo do que eu esperava" <?php echo( $opcao  == 'Frustrante ou abaixo do que eu esperava') ? 'checked' : '' ?>> Frustrante ou abaixo do que eu esperava
                </label>

                <!-- pergunta 2 -->
                <p>Você conseguiu iniciar o dia como havua planejado?</p>
                <label>
                    <input type="radio" name="inicio_planejado" value="Sim, dentro do que imaginei" <?php echo( $opcao  == 'Sim, dentro do que imaginei') ? 'checked' : '' ?>> Sim, dentro do que imaginei
                    <input type="radio" name="inicio_planejado" value="Não exatamente, mas está tudo bem" <?php echo( $opcao  == 'Não exatamente, mas está tudo bem') ? 'checked' : '' ?>> Não exatamente, mas está tudo bem
                    <input type="radio" name="inicio_planejado" value="Não fiz um plano para hoje" <?php echo( $opcao  == 'Não fiz um plano para hoje') ? 'checked' : '' ?>> Não fiz um plano para hoje
                </label>

                <!-- pergunta 3 -->
                <p>Quantas metas ou intenções você definiu para hoje? Lembre-se de considerar tanto tarefas quanto atitudes ou hábitos.</p>
                <label>
                    <input type="number" name="metas_definidas" min="0" value="<?php echo isset($metas_definidas) ? $metas_definidas : '' ?>">
                </label>

                <!-- pergunta 4 -->
                <p>E quantas dessas metas ou intenções você conseguiu concluir?</p>
                <label>
                    <input type="number" name="metas_concluidas" min="0" value="<?php echo isset($metas_concluidas) ? $metas_concluidas : '' ?>">
                </label>

                <!-- pergunta 5 -->
                <p>Você adiantou ou resolveu algo que não estava nos seus planos para hoje?</p>
                <label>
                    <input type="radio" name="adiantou_tarefa" value="1" <?php echo (isset($adiantou_algo)&& $adiantou_algo == 1) ? 'checked' : ''?>> Sim, e isso foi positivo
                    <input type="radio" name="adiantou_tarefa" value="0" <?php echo (isset($adiantou_algo)&& $adiantou_algo == 1) ? 'checked' : ''?>> Não, mantive o foco no que já havia planejado
                </label>

                <!-- pergunta 6 -->
                <p>Como foi sua postura diante dos desafios e pendências do dia?</p>
                <label>
                    <input type="radio" name="postura_pendencias" value="Evitei lidar com eles" <?php echo( $opcao  == 'Evitei lidar com eles') ? 'checked' : '' ?>> Evitei lidar com eles
                    <input type="radio" name="postura_pendencias" value="Enfrentei com coragem" <?php echo( $opcao  == 'Enfrentei com coragem') ? 'checked' : '' ?>> Enfrentei com coragem
                    <input type="radio" name="postura_pendencias" value="Me senti pressionado(a)" <?php echo( $opcao  == 'Me senti pressionado(a)') ? 'checked' : '' ?>> Me senti pressionado(a)
                    <input type="radio" name="postura_pendencias" value="Agi no automático" <?php echo( $opcao  == 'Agi no automático') ? 'checked' : '' ?>> Agi no automático
                    <input type="radio" name="postura_pendencias" value="Observei com consciência e fiz o possível" <?php echo( $opcao  == 'Observei com consciência e fiz o possível') ? 'checked' : '' ?>> Observei com consciência e fiz o possível
                    <input type="radio" name="postura_pendencias" value="Preferi deixar para outro momento" <?php echo( $opcao  == 'Preferi deixar para outro momento') ? 'checked' : '' ?>> Preferi deixar para outro momento
                </label>

                <!-- pergunta 7 -->
                <p>Como você se sentiu ao longo do dia? Reflita com sinceridade sobre suas emoções. Houve variações? Algum gatilho importante?</p>
                <label>
                    <input type="text" name="emocao_dia" value="<?php echo isset($emocao_dia) ? $emocao_dia : ''?>">
                </label>

                <!-- pergunta 8 -->
                <p>Gostaria de deixar um lembrete ou conselho para si mesmo(a) amanhã?Algo que possa te inspirar, cuidar ou guiar quando um novo dia começar.</p>
                <label>
                    <input type="text" name="conselho_para_si" value="<?php echo isset ($conselho_para_si) ? $conselho_para_si : ''?>">
                </label>

                <!-- pergunta 9 -->
                <p>Deseja escrever algo livremente sobre o seu dia? Esse espaço é seu. Pode desabafar, agradecer, soltar ideias ou apenas respirar.</p>
                <label>
                    <input type="text" name="texto_livre" value="<?php echo isset($texto_livre) ? $texto_livre : ''?>">     
                </label>

                
                <button type="submit" name="submit">Salvar</button>
                
            </form>
                <label>
                    <a href="dailyExcluir.php?id_daily=<?php echo $id_d; ?>"  ><button>Excluir</button></a>
                    <a href="dailyVisualizar.php"  ><button  >Cancelar</button></a>
                </label>
            <br><br><br><br><br>

            
            

    </div>

    


</div>

</section>

</body>
</html>