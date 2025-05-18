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
            $opcao = $user_daily['mooday_daily'];
            $texto = $user_daily['texto_daily'];
            $tarefas = $user_daily['tarefas_daily'];
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
                <h2>Registre seu dia:</h2>

                <p>Você considera que seu dia foi:</p>
                <label for="">
                    <input type="radio" name="mood" value="Produtivo" <?php echo( $opcao  == 'Produtivo') ? 'checked' : '' ?>> Produtivo
                    <input type="radio" name="mood" value="Poderia ser melhor" <?php echo( $opcao  == 'Poderia ser melhor') ? 'checked' : '' ?>> Poderia ser melhor
                    <input type="radio" name="mood" value="Pouco produtivo" <?php echo( $opcao  == 'Pouco produtivo') ? 'checked' : '' ?>> Pouco produtivo
                </label>

                
                <p>Você conseguiu concluir suas tarefas?</p>
                <label for="">
                    <input type="radio" name="tarefas" value="Sim" <?php echo( $tarefas  == 'Sim') ? 'checked' : '' ?>> Sim
                    <input type="radio" name="tarefas" value="Não" <?php echo( $tarefas  == 'Não') ? 'checked' : '' ?>> Não
                </label>
                

                <p>Conte um pouco sobre seu dia:</p>
                <label for="" class="texto">
                    <textarea name="daily" id="" ><?php echo $texto;?></textarea>
                </label>
                
                <label for="" >
                    <button type="submit"id="Enviar-Editar" name="editar">Enviar</button>
                </label>
                
                
            </form>
                <label for="" >
                    <a href="dailyExcluir.php?id_daily=<?php echo $id_d; ?>"  ><button>Excluir</button></a>
                    <a href="dailyVisualizar.php"  ><button  >Cancelar</button></a>
                </label>
            <br><br><br><br><br>

            
            

    </div>

    


</div>

</section>

</body>
</html>