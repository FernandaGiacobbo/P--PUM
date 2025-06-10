<?php

$id_us = $_SESSION['id'];
if (!empty($id_us)) {

$logado = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PA-PUM</title>
    <link rel="stylesheet" href="dailyVisualizar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=preview" />

</head>
<body>

    <?php 
        include 'gerenteHeader.php';
    ?>

<section class="home">
    


            <div class="caminho">
                <a href="gerentePerfil.php"><?php echo $logado;?></a> /
                <a href="gerenteMain.php">Home</a> 

            </div>

</section>

</body>
</html>

<?php
  } else {
    header('Location: index.php');
    die();
  }
?>