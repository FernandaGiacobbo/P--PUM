<?php

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papum</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
        }

        .sidebar {
            width: 150px;
            height: 100vh;
            background: linear-gradient(45deg,rgb(31, 100, 96),rgb(68, 165, 160));
            color: white;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar h1 {
            margin-bottom: 30px;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            margin: 15px 0;
            font-size: 18px;
            transition: all 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 15px;
            border-radius: 5px;
        }

        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Menu</h1>
        <a href="#">🏠 Home</a>
        <a href="#">⚡ Dashboard</a>
        <a href="#">🌐 Explorar</a>
        <a href="#">📂 Meu Conteúdo</a>
        <a href="#">👤 Perfil</a>
    </div>

</body>