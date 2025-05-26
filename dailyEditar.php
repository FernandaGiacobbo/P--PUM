<?php

session_start();

if(!isset($_SESSION['id'])) {
    header('Location: index.html');
    exit();
}

if (!empty($_GET['id_daily'])) {
    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $id_daily = $_GET['id_daily'];
    $_SESSION['id_daily'] = $id_daily;

    $query = "SELECT * FROM tb_daily WHERE id_daily = $id_daily";
    $resultado = $oMysql->query($query);

    if ($resultado->num_rows > 0) { 
        while ($user_daily = mysqli_fetch_assoc($resultado)) {
            $id_da_daily = $user_daily['id_daily'];
            $data = $user_daily ['data_daily'];
            $resumo_dia = $user_daily['resumo_dia'];
            $inicio_planejado = $user_daily['inicio_planejado'];
            $metas_definidas = $user_daily['metas_definidas'];
            $metas_concluidas = $user_daily['metas_concluidas'];
            $adiantou_tarefa = $user_daily['adiantou_tarefa'];
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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily</title>
    <link rel="stylesheet" href="css/dailyEditar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <?php include 'header.php'; ?> <section class="home">
        <div class="main">
            <dialog id="modal-editar" class="modal-padrao">
                <form action="dailyEdicao.php" method="post">
                    <h2>Editar Daily</h2>
                
                    <p>Como você se sentiu, de forma geral, em relação ao seu dia?</p>
                    <label>
                        <input type="radio" name="resumo_dia" value="Leve e equilibrado(a)" required <?php echo ($resumo_dia == 'Leve e equilibrado(a)') ? 'checked' : ''; ?>> Leve e equilibrado(a) <br>
                    </label>
                    <label>
                        <input type="radio" name="resumo_dia" value="Produtivo(a) e realizado(a)"<?php echo( $resumo_dia  == 'Produtivo(a) e realizado(a)') ? 'checked' : ''; ?>> Produtivo(a) e realizado(a) <br>
                    </label>
                    <label>
                        <input type="radio" name="resumo_dia" value="Corrido e desgastante"<?php echo( $resumo_dia  == 'Corrido e desgastante') ? 'checked' : ''; ?>> Corrido e desgastante <br>
                    </label>
                    <label>
                        <input type="radio" name="resumo_dia" value="Confuso e desconectado(a)"<?php echo( $resumo_dia  == 'Confuso e desconectado(a)') ? 'checked' : ''; ?>> Confuso e desconectado(a) <br>
                    </label>
                    <label>
                        <input type="radio" name="resumo_dia" value="Satisfatório, dentro do possível"<?php echo( $resumo_dia  == 'Satisfatório, dentro do possível') ? 'checked' : ''; ?>> Satisfatório, dentro do possível <br>
                    </label>
                    <label>
                        <input type="radio" name="resumo_dia" value="Frustrante ou abaixo do que eu esperava"<?php echo( $resumo_dia  == 'Frustrante ou abaixo do que eu esperava') ? 'checked' : ''; ?>> Frustrante ou abaixo do que eu esperava <br>
                    </label>
                
                    <p>Você conseguiu iniciar o dia como havia planejado?</p>
                    <label>
                        <input type="radio" name="inicio_planejado" value="Sim, dentro do que imaginei" required <?php echo( $inicio_planejado  == 'Sim, dentro do que imaginei') ? 'checked' : '' ?>> Sim, dentro do que imaginei <br>
                    </label>
                    <label>
                        <input type="radio" name="inicio_planejado" value="Não exatamente, mas está tudo bem"<?php echo( $inicio_planejado == 'Não exatamente, mas está tudo bem') ? 'checked' : '' ?>> Não exatamente, mas está tudo bem <br>
                    </label>
                    <label>
                        <input type="radio" name="inicio_planejado" value="Não fiz um plano para hoje"<?php echo( $inicio_planejado  == 'Não fiz um plano para hoje') ? 'checked' : '' ?>> Não fiz um plano para hoje
                    </label>
                
                    <p>Quantas metas ou intenções você definiu para hoje? Lembre-se de considerar tanto tarefas quanto atitudes ou hábitos.</p>
                    <label>
                        <input type="number" name="metas_definidas" min="0" value="<?php echo isset($metas_definidas) ? $metas_definidas : '' ?>" required>
                    </label>
                
                    <p>E quantas dessas metas ou intenções você conseguiu concluir?</p>
                    <label>
                        <input type="number" name="metas_concluidas" min="0" value="<?php echo isset($metas_concluidas) ? $metas_concluidas : '' ?>" required>
                    </label>
                
                    <p>Você adiantou ou resolveu algo que não estava nos seus planos para hoje?</p>
                    <label>
                        <input type="radio" name="adiantou_tarefa" value="1"<?php echo (isset($adiantou_tarefa)&& $adiantou_tarefa == 1) ? 'checked' : ''?> required> Sim, e isso foi positivo <br>
                    </label>
                    <label>
                        <input type="radio" name="adiantou_tarefa" value="0"<?php echo (isset($adiantou_tarefa)&& $adiantou_tarefa == 0) ? 'checked' : ''?>> Não, mantive o foco no que já havia planejado
                    </label>
                
                    <p>Como foi sua postura diante dos desafios e pendências do dia?</p>
                    <label>
                        <input type="radio" name="postura_pendencias" value="Evitei lidar com eles" required <?php echo( $postura_pendencias  == 'Evitei lidar com eles') ? 'checked' : '' ?>> Evitei lidar com eles <br>
                    </label>
                    <label>
                        <input type="radio" name="postura_pendencias" value="Enfrentei com coragem"<?php echo( $postura_pendencias  == 'Enfrentei com coragem') ? 'checked' : '' ?>> Enfrentei com coragem <br>
                    </label>
                    <label>
                        <input type="radio" name="postura_pendencias" value="Me senti pressionado(a)"<?php echo( $postura_pendencias  == 'Me senti pressionado(a)') ? 'checked' : '' ?>> Me senti pressionado(a) <br>
                    </label>
                    <label>
                        <input type="radio" name="postura_pendencias" value="Agi no automático"<?php echo( $postura_pendencias  == 'Agi no automático') ? 'checked' : '' ?>> Agi no automático <br>
                    </label>
                    <label>
                        <input type="radio" name="postura_pendencias" value="Observei com consciência e fiz o possível"<?php echo( $postura_pendencias  == 'Observei com consciência e fiz o possível') ? 'checked' : '' ?>> Observei com consciência e fiz o possível <br>
                    </label>
                    <label>
                        <input type="radio" name="postura_pendencias" value="Preferi deixar para outro momento"<?php echo( $postura_pendencias  == 'Preferi deixar para outro momento') ? 'checked' : '' ?>> Preferi deixar para outro momento
                    </label>

                    <p>Como você se sentiu ao longo do dia? Reflita com sinceridade sobre suas emoções. Houve variações? Algum gatilho importante?</p>
                    <label>
                        <textarea rows="6" cols="50" maxlength="300" name="emocao_dia" required><?php echo $emocao_dia;?></textarea>
                    </label>

                    <p>Gostaria de deixar um lembrete ou conselho para si mesmo(a) amanhã?Algo que possa te inspirar, cuidar ou guiar quando um novo dia começar.</p>
                    <label>
                        <textarea rows="6" cols="50" maxlength="300" name="conselho_para_si" required><?php echo $conselho_para_si;?></textarea>
                    </label>

                    <p>Deseja escrever algo livremente sobre o seu dia? Esse espaço é seu. Pode desabafar, agradecer, soltar ideias ou apenas respirar.</p>
                    <label>
                        <textarea rows="6" cols="50" maxlength="300" name="texto_livre" required><?php echo $texto_livre;?></textarea>
                    </label>
                    <br>
                    
                    <div class="botoes-conteiner">
                        <button type="submit" id="botaosalvar" name="salvar-edicao">Salvar</button>

                        <button type="button" id="botaoexcluir" data-id-daily="<?php echo $id_da_daily; ?>">Excluir</button>
                        
                        <button type="button" id="botaocancelar">Cancelar</button>
                    </div>
                
                </form>
            </dialog>

        </div>
    </section>

    <script src="js/dailyEditar.js"></script>
</body>
</html>