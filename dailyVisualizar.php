<?php

session_start();

include_once('conecta_db.php');
$oMysql = conecta_db();

$id_user = $_SESSION['id'];

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
                <div class="adicionar-daily">
                    <button id="abrir" class="add-daily">+</button>
                    <p>Adicionar registro de hoje</p>
                </div>
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
                        <div class="conselho-texto"><?php echo $linha->conselho_para_si; ?></div>
                        
                        <?php echo "<button class='editar' onclick=\"window.location.href='dailyEditar.php?id_daily=$linha->id_daily'\">Editar</button>";?>
                    </div>

                </div>

        <?php } }?>

        </div>

        <dialog id="modal"> 

            <form action="dailyCriar.php" method="post">

                <h2>Registre seu dia</h2>
                <h4>Todas as respostas são obrigatórias para melhor análise com Inteligência Artificial.*</h4>

                <!-- pergunta 1 -->
                <p class="pergunta" title="Resposta obrigatória">Como você se sentiu, de forma geral, em relação ao seu dia?*</p>
                <label>
                    <input type="radio" name="resumo_dia" value="Leve e equilibrado(a)" required> Leve e equilibrado(a) <br>
                </label>
                <label>
                    <input type="radio" name="resumo_dia" value="Produtivo(a) e realizado(a)"> Produtivo(a) e realizado(a) <br>
                </label>
                <label>
                    <input type="radio" name="resumo_dia" value="Corrido e desgastante"> Corrido e desgastante <br>
                </label>
                <label>
                    <input type="radio" name="resumo_dia" value="Confuso e desconectado(a)"> Confuso e desconectado(a) <br>
                </label>
                <label>
                    <input type="radio" name="resumo_dia" value="Satisfatório, dentro do possível"> Satisfatório, dentro do possível <br>
                </label>
                <label>
                    <input type="radio" name="resumo_dia" value="Frustrante ou abaixo do que eu esperava"> Frustrante ou abaixo do que eu esperava
                </label>

                <!-- pergunta 2 -->
                <p class="pergunta" title="Resposta obrigatória">Você conseguiu iniciar o dia como havia planejado?*</p>
                <label>
                    <input type="radio" name="inicio_planejado" value="Sim, dentro do que imaginei" required> Sim, dentro do que imaginei <br>
                </label>
                <label>
                    <input type="radio" name="inicio_planejado" value="Não exatamente, mas está tudo bem"> Não exatamente, mas está tudo bem <br>
                </label>
                <label>
                    <input type="radio" name="inicio_planejado" value="Não fiz um plano para hoje"> Não fiz um plano para hoje 
                </label>

                <!-- pergunta 3 -->
                <p class="pergunta" title="Resposta obrigatória">Quantas metas ou intenções você definiu para hoje? Lembre-se de considerar tanto tarefas quanto atitudes ou hábitos.*</p>
                <label>
                    <input type="number" name="metas_definidas" min="0" placeholder="0" required>
                </label>
                
                <!-- pergunta 4 -->
                <p class="pergunta" title="Resposta obrigatória">E quantas metas ou intenções você conseguiu concluir?*</p>
                <label>
                    <input type="number" name="metas_concluidas" min="0" placeholder="0" required>
                </label>
                
                <!-- pergunta 5 -->
                <p class="pergunta" title="Resposta obrigatória">Você adiantou ou resolveu algo que não estava nos seus planos para hoje?*</p>
                <label>
                    <input type="radio" name="adiantou_tarefa" value="1" required> Sim, e isso foi positivo <br>
                </label>
                <label>
                    <input type="radio" name="adiantou_tarefa" value="0"> Não, mantive o foco no que já havia planejado
                </label>
            
                <!-- pergunta 6 -->
                <p class="pergunta" title="Resposta obrigatória">Como foi sua postura diante dos desafios e pendências do dia?*</p>
                <label>
                    <input type="radio" name="postura_pendencias" value="Evitei lidar com eles" required> Evitei lidar com eles <br>
                </label>
                <label>
                    <input type="radio" name="postura_pendencias" value="Enfrentei com coragem"> Enfrentei com coragem <br>
                </label>
                <label>
                    <input type="radio" name="postura_pendencias" value="Me senti pressionado(a)"> Me senti pressionado(a) <br>
                </label>
                <label>
                    <input type="radio" name="postura_pendencias" value="Agi no automático"> Agi no automático <br>
                </label>
                <label>
                    <input type="radio" name="postura_pendencias" value="Observei com consciência e fiz o possível"> Observei com consciência e fiz o possível <br>
                </label>
                <label>
                    <input type="radio" name="postura_pendencias" value="Preferi deixar para outro momento"> Preferi deixar para outro momento
                </label>
                
                <!-- pergunta 7 -->
                <p class="pergunta" title="Resposta obrigatória">Como você se sentiu ao longo do dia? Reflita com sinceridade sobre suas emoções. Houve variações? Algum gatilho importante?*</p>
                <label>
                    <textarea name="emocao_dia" rows="6" cols="50" maxlength="300"
                    placeholder="Ex: Me senti um pouco ansioso, mas consegui gerenciar."
                    title="Descreva seu estado de espírito e emoções do dia." required></textarea>
                </label>

                <!-- pergunta 8 -->
                <p class="pergunta" title="Resposta obrigatória">Gostaria de deixar um lembrete ou conselho para si mesmo(a) amanhã?Algo que possa te inspirar, cuidar ou guiar quando um novo dia começar.*</p>
                <label>
                    <textarea name="conselho_para_si" rows="6" cols="50" maxlength="300" 
                    placeholder="Ex: Não se esqueça de respirar e ser gentil consigo mesmo."
                    title="Deixe um conselho ou lembrete para o seu eu de amanhã." required></textarea>
                </label>
            
                <!-- pergunta 9 -->
                <p class="pergunta" title="Resposta obrigatória">Deseja escrever algo livremente sobre o seu dia? Esse espaço é seu. Pode desabafar, agradecer, soltar ideias ou apenas respirar.*</p>
                <label>
                    <textarea name="texto_livre" rows="6" cols="50" maxlength="300" 
                    placeholder="Use este espaço para desabafar, agradecer ou registrar ideias." 
                    title="Espaço livre para anotações adicionais." required></textarea>
                </label>
                <br>

                <div class="botoes-container">
                    <button type="submit" id="submit" name="submit"> Enviar </button>
                    <!-- "suas informações de hoje foram salvas” -->
                    <button type="reset" id="fechar"> Cancelar </button>
                    <!-- “as informações preenchidas não serão salvas” -->
                </div>
            </form>
        </dialog>

    </div>

</section>

    <script>
        function abrirModalEdicao(idDaily) {
            window.location.href = `dailyEditar.php?id_daily=${idDaily}`;
        }
    </script>
    <script src="dailyVisualizar.js"></script>
</body>
</html>