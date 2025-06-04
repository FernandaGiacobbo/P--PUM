<?php

    function conecta_db(){
        $db_name = "papum";
        $user = "root";
        $pass = "";
        $server = "localhost:3306";
    
        $conexao = new mysqli($server, $user, $pass, $db_name);
    
        if ($conexao->connect_error) {
            die("Erro na conexão: " . $conexao->connect_error);
        }

    return $conexao;
    }
    
?>