<?php

session_start();

if (!empty($_GET['id_daily'])) {
    include 'header.php';
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
            $opcao = $user_daily['mooday_daily'];
            $texto = $user_daily['texto_daily'];
        }

    } else {
        header('Location: dayli.php');
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
    <link rel="stylesheet" href="dayli.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>


<body >

<section class="home">


<div class="conteiner">

    <div class="conteudo2">

    <div class="cartao-editar">
            <form action="Dailyeditar2.php" method="post">
            <label><input type="radio" name="mood" value="Produtivo" <?php echo( $opcao  == 'Produtivo') ? 'checked' : '' ?>>Produtivo</label>
            <label><input type="radio" name="mood" value="Mais ou menos" <?php echo( $opcao  == 'Mais ou menos') ? 'checked' : '' ?>>Mais ou menos</label>
            <label><input type="radio" name="mood" value="Pouco produtivo" <?php echo( $opcao  == 'Pouco produtivo') ? 'checked' : '' ?>>Pouco produtivo</label>

            <textarea name="texto" class="texto-daily"><?php echo $texto;?></textarea>


                <button type="submit"id="Enviar-Editar" name="editar">Enviar</button>
                
            </form>

            <a href="dayli.php" id="SairEditar" class="botao12">&nbsp;&nbsp;&nbsp;<button  >Sair</button>&nbsp;&nbsp;&nbsp; </a>
            <?php echo "<a href='DayliExcluir.php?id_daily=$id_d' class='botao12'>&nbsp;<button >Excluir</button></a>"; ?>
            
    </div>

    </div>

    


</div>

</section>

</body>
</html>