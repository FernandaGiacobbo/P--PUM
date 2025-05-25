<?php

session_start();

if ($_GET['id_tarefa']) {
    $id_tarefa = $_GET['id_tarefa'];
    $_SESSION['id_tarefa'] = $id_tarefa; 

    include_once('conecta_db.php');
    $oMysql = conecta_db();

    $query1 = "SELECT * FROM tb_tarefa WHERE id_tarefa = $id_tarefa";
    $resultado1 = $oMysql->query($query1);

    if($resultado1){
        while($tarefa = $resultado1->fetch_object()){
            $nome = $tarefa->nome;
            $detalhamento = $tarefa->detalhamento;
            $data_tarefa = $tarefa->data_tarefa;
            $prazo = $tarefa->prazo;
            $status_tarefa = $tarefa->status_tarefa;
        }

    }


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/mainVisualizar.css">
    <title>Document</title>
</head>
<body>
    <?php include('header.php');?>

    <div class="caixa">

        
        
        <div class="caixa-editar">
            <div id="contador"></div>
            <form action="principal.php?page=2&id_tarefa=<?php echo $_GET['id_tarefa'];?>" method="post">
                
                <h2>Editar sua Tarefa: <?php echo $nome;?></h2>

                
                <label >
                    <p>Insira o nome da tarefa</p>
                    <input type="text" class="nome" name="nomet" placeholder="digite" value="<?php echo $nome;?>">
                </label>

                
                
                <label class="texto">
                  <p>Insira o detalhamento da tarefa</p>
                    <textarea name="detalhamento"  placeholder="Escreva aqui" class="textarea"><?php echo $detalhamento;?></textarea>
                </label>
                

                
              <div class="datas">
                    <label>
                      <p>Começo da tarefa</p>
                      <input type="date" class="data" name="data_insercao" value="<?php echo $data_tarefa; ?>">
                    </label>

                    <label>
                      <p>Termino da tarefa</p>
                      <input type="date" class="data" name="prazo" value="<?php echo $prazo; ?>">
                    </label>
              </div>
                
                
                <label >
                  <p>Insira o status da tarefa</p>
                    <select name="status" >
                        <option value="Concluido" <?php if ($status_tarefa == 'Concluido') echo 'selected'; ?>>Concluido</option>
                        <option value="Não Iniciado" <?php if ($status_tarefa == 'Não Iniciado') echo 'selected'; ?>> Não iniciado </option>
                        <option value="Em Andamento" <?php if ($status_tarefa == 'Em Andamento') echo 'selected'; ?>>Em andamento</option>
                        
                    </select>
                </label>

                <div class="botoes">
                  <a class="botao" href="principal.php">Voltar</a>
                  <button type="submit" name="submit" class="botao">Editar</button>
                  <a class="botao" href="principal.php?page=3&id_tarefa=<?php echo $_GET['id_tarefa']; ?>">Excluir</a>
                </div>
                
            </form>
        </div>

    </div>

    <script>
        function atualizarContador(dataFim) {
        const fim = new Date(dataFim).getTime();
        const contador = document.getElementById("contador");

        const intervalo = setInterval(() => {
            const agora = new Date().getTime();
            const restante = fim - agora;

            if (restante < 0) {
            clearInterval(intervalo);
            contador.innerHTML = "Prazo finalizado!";
            return;
            }

            const dias = Math.floor(restante / (1000 * 60 * 60 * 24));
            const horas = Math.floor((restante % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutos = Math.floor((restante % (1000 * 60 * 60)) / (1000 * 60));
            const segundos = Math.floor((restante % (1000 * 60)) / 1000);

            contador.innerHTML = `Faltam ${dias}d ${horas}h ${minutos}m ${segundos}s para o fim da tarefa`;
        }, 1000);
        }

        atualizarContador("<?= $prazo ?>");
    </script>
</body>
</html>