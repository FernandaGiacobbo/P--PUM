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

if(!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}

include_once('conecta_db.php');
$oMysql = conecta_db();

$logado = $_SESSION['nome'];
$id_user = $_SESSION['id'];
$data_inicio = date('Y-m-d', strtotime('-7 days'));
$data_fim = date('Y-m-d');

// 1. Buscar dados da semana
$query = "SELECT * FROM tb_daily 
          WHERE id_usuario = $id_user 
          AND data_daily BETWEEN '$data_inicio' AND '$data_fim'
          ORDER BY data_daily ASC";
$resultado = $oMysql->query($query);

$dados_semana = [];
$total_metas = 0;
$total_concluidas = 0;
$emocao_textos = [];

if($resultado) {
    while($linha = $resultado->fetch_assoc()) {
        $dados_semana[] = $linha;
        $total_metas += $linha['metas_definidas'];
        $total_concluidas += $linha['metas_concluidas'];
        $emocao_textos[] = $linha['emocao_dia'];
    }
}

// 2. Preparar prompt para IA
$prompt = "Analise estes dados de produtividade e emoções da semana:\n\n";
$prompt .= "- Total de metas: $total_metas\n";
$prompt .= "- Metas concluídas: $total_concluidas\n";
$prompt .= "- Registros emocionais:\n" . implode("\n", $emocao_textos) . "\n\n";
$prompt .= "Forneça uma análise objetiva em 3 parágrafos, destacando padrões e sugerindo melhorias.";

// 3. Chamada DIRETA à API OpenAI
function chamarOpenAI($prompt) {
    $api_key = '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';

    $url = 'https://api.openai.com/v1/chat/completions';
    
    $dados = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $resposta = curl_exec($ch);
    curl_close($ch);

    $dados_resposta = json_decode($resposta, true);
    return $dados_resposta['choices'][0]['message']['content'] ?? "Erro na análise.";
}

// 4. Gerar análise
$analise_ia = chamarOpenAI($prompt);
?>

<?php
$css_debug = realpath('css/usuarioDesempenho.css');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Desempenho Semanal</title>
    <link rel="stylesheet" href="css/usuarioDesempenho.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <section class="home">
        <div class="container">
            <h1>Análise Semanal</h1>
            
            <!-- Métricas Básicas -->
            <div class="metricas">
                <p>Metas definidas: <?= $total_metas ?></p>
                <p>Metas concluídas: <?= $total_concluidas ?></p>
                <p>Taxa de sucesso: <?= round(($total_concluidas/$total_metas)*100, 2) ?>%</p>
            </div>
            
            <!-- Análise da IA -->
            <h2>Análise Personalizada</h2>
            <div class="analise">
                <?= htmlspecialchars($analise_ia) ?>
            </div>
            
        </div>
            <div class="caminho">
        <a href="usuarioPerfil.php"><?php echo $logado;?></a> /
        <a href="principal.php">Home</a> / 
        <a href="usuarioDesempenho  .php"><b>Desempenho</b></a>
    </div>
    </section>
</body>
</html>