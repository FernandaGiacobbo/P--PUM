<?php
$tempoExpiracao = 86400; //limita a 86400s = 1 dia a sessão do usuário caso não tenha nenhuma inatividade

ini_set('session.gc_maxlifetime', $tempoExpiracao); // controla quanto tempo o php mantém os dados no servidor 
session_set_cookie_params($tempoExpiracao); //Controla quanto tempo o PHP mantém os dados da sessão no servidor após inatividade.

session_start();

// Verifica se houve inatividade superior a 1 dia
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tempoExpiracao)) {
    session_unset();    
    session_destroy();  // destrói a sessão
    header('Location: index.php'); 
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // atualiza tempo da última atividade

$id_usuario = $_SESSION['id'];

if(!empty($id_usuario)){

include_once('conecta_db.php');
$oMysql = conecta_db();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=preview" />
    <link rel="stylesheet" href="css/adminVisualizar.css">
    <title>Estudantes</title>
</head>
<body>
    
    <?php include 'adminHeader.php'; ?>

    <section class="home">
        <h2>Estudantes Cadastrados</h2>
        
        <div class="tabela">
            <table class="table">
                <thead>
                    <tr>
                        <th class="td_dec">ID</th>
                        <th class="td_dec">Nome</th>
                        <th class="td_dec">E-mail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT id_usuario, nome_usuario, email_usuario FROM tb_usuario WHERE cargo='estudante'";
                    $resultado = $oMysql->query($query);

                    if($resultado && $resultado->num_rows > 0) {
                        while($linha = $resultado->fetch_object()) {
                            echo "<tr class='corpo_tb'>";
                            echo "<td class='td_dec'>".htmlspecialchars($linha->id_usuario)."</td>";
                            echo "<td class='td_dec'>".htmlspecialchars($linha->nome_usuario)."</td>";
                            echo "<td class='td_dec'>".htmlspecialchars($linha->email_usuario)."</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='td_dec'>Nenhum estudante cadastrado</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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