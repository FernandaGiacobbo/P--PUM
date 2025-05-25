<?php

session_start();


include_once('conecta_db.php');
$oMysql = conecta_db();

if (isset($_POST['submit'])){
    if (isset($_POST['id_duvidas'])) {
        $id_duvidas = intval($_POST['id_duvidas']);
    } else {
        die("ID da dúvida não fornecido.");
    }

    if(!empty($_POST['titulo']) && !empty($_POST['duvida'])){
        

        $titulo_duvidas = $oMysql->real_escape_string($_POST['titulo']);
        $texto_duvidas = $oMysql->real_escape_string($_POST['duvida']);
        $id_usuario = $_SESSION['id'];

        $query = "UPDATE tb_duvidas SET titulo_duvidas = '$titulo_duvidas', texto_duvidas = '$texto_duvidas', usuario_duvidas = $id_usuario WHERE id_duvidas = $id_duvidas";
        $resultado = $oMysql->query($query);

        if ($resultado) {
            header('Location: duvidasVisualizar.php');
        } else {
            echo "<p>Erro ao atualizar: " . $oMysql->error . "</p>";
        }

    }
} else {

    if (isset($_GET['id_duvidas'])) {
        $id_duvidas = intval($_GET['id_duvidas']);
    } else {
        die("ID da dúvida não fornecido.");
    }

    $query2 = "SELECT * FROM tb_duvidas WHERE id_duvidas = $id_duvidas";
    $resultado2 = $oMysql->query($query2);

    if ($resultado2 && $linhaDuvidas = $resultado2->fetch_object()) {
        $titulo = $linhaDuvidas->titulo_duvidas;
        $texto = $linhaDuvidas->texto_duvidas;
    } else {
        die("Dúvida não encontrada.");
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/duvidaVisualizar.css">
    <title>Duvidas Update</title>
</head>
<body>

    <?php include('header.php');?>

    <section class="home">

        <div class="caixaUpdate">
            <div class="updateDuvidas">
                <h2>Edite sua pergunta: <?php echo $titulo;?></h2>
                <form action="duvidaUpdate.php" method="post">
                    <input type="hidden" name="id_duvidas" value="<?php echo $id_duvidas; ?>">
                    <label >
                        <p>Titulo:</p>
                        <input type="text" placeholder="Escreva aqui:" name="titulo" value="<?php echo $titulo;?>">
                    </label>

                    <label >
                        <p>Sua duvida:</p>
                        <textarea name="duvida" id="" placeholder="Escreva sua duvida aqui!"><?php echo $texto; ?></textarea>
                    </label>

                    <div class="alingBotoes">
                        <button type="submit" name="submit" class="botoesUpdade">Enviar</button>
                        <a href="duvidasVisualizar.php" ><p class="botoesUpdade">Voltar</p></a>
                        <a href="duvidaDelete.php?id_duvidas=<?php echo $id_duvidas;?>" ><p class="botoesUpdade">Excluir</p></a>
                    </div>
                </form>
            </div>
            
        </div>

    </section>
</body>
</html>