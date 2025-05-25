<?php

session_start();

include_once('conecta_db.php');
$oMysql = conecta_db();

$id_user = $_SESSION['id'];

//busca a dau=ily do dia 
// $query3 = "SELECT * FROM tb_daily WHERE id_usuario = $id_us AND data_daily = CURDATE()";
// $resultado = $oMysql->query($query3);

?>

<!DOCTYPE html>
<html lang="pt-br">
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


            <!-- botão de adicionar dia novo -->
            <label> 
                Adicione como foi seu dia: <button id="abrir">Aqui</button>
            </label>
            
        </div>
        <hr>
        <div class="conteudo">

        <?php
        
        $query = "SELECT * FROM tb_daily where id_usuario = $id_user ORDER BY data_daily DESC";
        $resultado = $oMysql->query($query);
        if($resultado) {
            while($linha = $resultado->fetch_object()){ ?>

                <div class="cartao">
                    <div class="cabeca">
                        <h3><?php echo date('d - m - y', strtotime($linha->data_daily));?></h3>
                    </div>

                    <div class="corpo">
                        <?php echo "Seu dia foi: " . $linha->resumo_dia; ?> <br><br>
                        <?php echo "Metas:" ?> <br>
                        <?php echo "Definidas: " . $linha->metas_definidas . " | Concluídas: " . $linha->metas_concluidas; ?> <br>
                        <?php echo $linha->conselho_para_si; ?> 
                        
                        <?php echo "<a href='dailyEditar.php?id_daily=$linha->id_daily'><button class='Editar'>Editar</button></a>";?>
                    </div>

                </div>

        <?php } }?>

        </div>

        <dialog id="modal"> 

            <form action="dailyCriar.php" method="post">

                <h2>Registre seu dia</h2>

                <!-- pergunta 1 -->
                <p class="pergunta">Como você se sentiu, de forma geral, em relação ao seu dia?</p>
                <label>
                    <input type="radio" name="resumo_dia" value="Leve e equilibrado(a)"> Leve e equilibrado(a) <br>
                    <input type="radio" name="resumo_dia" value="Produtivo(a) e realizado(a)"> Produtivo(a) e realizado(a) <br>
                    <input type="radio" name="resumo_dia" value="Corrido e desgastante"> Corrido e desgastante <br>
                    <input type="radio" name="resumo_dia" value="Confuso e desconectado(a)"> Confuso e desconectado(a) <br>
                    <input type="radio" name="resumo_dia" value="Satisfatório, dentro do possível"> Satisfatório, dentro do possível <br>
                    <input type="radio" name="resumo_dia" value="Frustrante ou abaixo do que eu esperava"> Frustrante ou abaixo do que eu esperava
                </label>

                <!-- pergunta 2 -->
                <p class="pergunta">Você conseguiu iniciar o dia como havia planejado?</p>
                <label>
                    <input type="radio" name="inicio_planejado" value="Sim, dentro do que imaginei"> Sim, dentro do que imaginei <br>
                    <input type="radio" name="inicio_planejado" value="Não exatamente, mas está tudo bem"> Não exatamente, mas está tudo bem <br>
                    <input type="radio" name="inicio_planejado" value="Não fiz um plano para hoje"> Não fiz um plano para hoje 
                </label>

                <!-- pergunta 3 -->
                <p class="pergunta">Quantas metas ou intenções você definiu para hoje? Lembre-se de considerar tanto tarefas quanto atitudes ou hábitos.</p>
                <label>
                    <input type="number" name="metas_definidas" min="0" placeholder="0" required>
                </label>
                
                <!-- pergunta 4 -->
                <p class="pergunta">E quantas metas ou intenções você conseguiu concluir?</p>
                <label>
                    <input type="number" name="metas_concluidas" min="0" placeholder="0" required>
                </label>
                
                <!-- pergunta 5 -->
                <p class="pergunta">Você adiantou ou resolveu algo que não estava nos seus planos para hoje?</p>
                <label>
                    <input type="radio" name="adiantou_tarefa" value="1"> Sim, e isso foi positivo <br>
                    <input type="radio" name="adiantou_tarefa" value="0"> Não, mantive o foco no que já havia planejado
                </label>
            
                <!-- pergunta 6 -->
                <p class="pergunta">Como foi sua postura diante dos desafios e pendências do dia?</p>
                <label>
                    <input type="radio" name="postura_pendencias" value="Evitei lidar com eles"> Evitei lidar com eles <br>
                    <input type="radio" name="postura_pendencias" value="Enfrentei com coragem"> Enfrentei com coragem <br>
                    <input type="radio" name="postura_pendencias" value="Me senti pressionado(a)"> Me senti pressionado(a) <br>
                    <input type="radio" name="postura_pendencias" value="Agi no automático"> Agi no automático <br>
                    <input type="radio" name="postura_pendencias" value="Observei com consciência e fiz o possível"> Observei com consciência e fiz o possível <br>
                    <input type="radio" name="postura_pendencias" value="Preferi deixar para outro momento"> Preferi deixar para outro momento
                </label>
                
                <!-- pergunta 7 -->
                <p class="pergunta">Como você se sentiu ao longo do dia? Reflita com sinceridade sobre suas emoções. Houve variações? Algum gatilho importante?</p>
                <label>
                    <textarea name="emocao_dia" rows="6" cols="50" maxlength="300"></textarea>
                </label>

                <!-- pergunta 8 -->
                <p class="pergunta">Gostaria de deixar um lembrete ou conselho para si mesmo(a) amanhã?Algo que possa te inspirar, cuidar ou guiar quando um novo dia começar.</p>
                <label>
                    <textarea name="conselho_para_si" rows="6" cols="50" maxlength="300"></textarea>
                </label>
            
                <!-- pergunta 9 -->
                <p class="pergunta">Deseja escrever algo livremente sobre o seu dia? Esse espaço é seu. Pode desabafar, agradecer, soltar ideias ou apenas respirar.</p>
                <label>
                    <textarea name="texto_livre" rows="6" cols="50" maxlength="300"></textarea>
                </label>
                <br>


                <label>
                    <button type="submit" name="submit"> Enviar </button>
                    <button type="reset" id="fechar"> Cancelar </button>
                </label>

            </form>
        </dialog>

    </div>

    <script src="dailyVisualizar.js"></script>

</section>

</body>
</html>