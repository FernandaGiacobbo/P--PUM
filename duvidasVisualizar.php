<?php

session_start();
$id_usuario = $_SESSION['id'];
$nome_usuario = $_SESSION['nome'];

date_default_timezone_set('America/Sao_Paulo');

include_once('conecta_db.php');
$oMysql = conecta_db();

$query = "SELECT * FROM tb_duvidas WHERE usuario_duvidas = $id_usuario ORDER BY id_duvidas DESC";
$resultado = $oMysql->query($query);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/duvidaVisualizar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Duvidas</title>
</head>
<body>

<?php include('header.php');?>
    
<section class="home">
    <div class="caixa">
        <h2>Olá <?php echo $nome_usuario;?>, qual a sua duvida?</h2>
        <div class="criarDuvidas">
            <form action="duvidaInsert.php" method="post">
                <label >
                    <p>Titulo:</p>
                    <input type="text" placeholder="Escreva aqui:" name="titulo">
                </label>

                <label >
                    <p>Sua duvida:</p>
                    <textarea name="duvida" id="" placeholder="Escreva sua duvida aqui!"></textarea>
                </label>

                <div class="botoes" >
                    <button type="submit" name="submit" class="btn">Enviar</button>
                    <button type="reset" name="reset" id="cancelar" class="btn">Cancelar</button>
                </div>
            </form>
        </div>

        <?php 
                if($resultado) {
                    while ($duvidasLinha = $resultado->fetch_object()){
                        $id_duvidas = $duvidasLinha->id_duvidas;
                        $titulo = $duvidasLinha->titulo_duvidas;
                        $texto = $duvidasLinha->texto_duvidas;
                        $data = date('d - m - y', strtotime($linha->data_daily));
        ?>

        <div class="visualizarDuvidas">

            <div class="duvidasCriadas">
                

                    <h2><?php echo $titulo;?></h2>
                            
                
                
                
                <div class="textoDuvida">
                    <?php echo $texto;?>
                </div>
                <div class="headerDuvida">
                    <a href="duvidaUpdate.php?id_duvidas=<?php echo $id_duvidas; ?>">Editar</a>
                    <p class="dataPostagem"> Publicado em: <?php echo $data;?> </p>
                    </div>

            </div>

            

        </div>

        <?php } }?>
        
    </div>
</section>



</body>
</html>