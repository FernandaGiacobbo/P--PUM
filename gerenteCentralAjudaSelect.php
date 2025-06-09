<?php

include_once('conecta_db.php');
$oMysql = conecta_db();

$id = intval($_GET['id']);

$query = "SELECT 
            d.titulo_duvidas, 
            d.texto_duvidas, 
            d.data_duvidas, 
            u.nome_usuario 
          FROM tb_duvidas d
          JOIN tb_usuario u ON d.usuario_duvidas = u.id_usuario
          WHERE d.id_duvidas = $id";

$resultado = $oMysql->query($query);
$duvida = $resultado->fetch_assoc();

$query2 = "SELECT 
                      r.id_resposta AS id, 
                      r.texto_resposta AS texto, 
                      u.nome_usuario AS usuario
                    FROM tb_resDuvidas r
                    JOIN tb_usuario u ON r.usuario_resposta = u.id_usuario
                    WHERE r.duvida_resposta = $id";

$resultado2 = $oMysql->query($query2);
$respostas = [];

while ($row = $resultado2->fetch_assoc()) {
    $respostas[] = $row;
}

//Executa a consulta das respostas e armazena todas em um array.

//Retorna todos os dados em formato JSON para uso no JavaScript -> gerenteCentralajuda.php

echo json_encode([
    'titulo' => $duvida['titulo_duvidas'],
    'texto' => $duvida['texto_duvidas'],
    'data' => $duvida['data_duvidas'],
    'usuario' => $duvida['nome_usuario'],
    'respostas' => $respostas
]);
?>