<!DOCTYPE html>
<html lang="en">
<head>
  <title>Lista de Registros</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Usuários</h2>
  <p>Log de usuários:</p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Ação</th>
        <th>ID</th>
        <th>Cargo</th>
      </tr>
    </thead>
    <tbody>
	<?php


        include_once('conecta_db.php');
		$oMysql = conecta_db();
		$query = "SELECT * FROM tb_usuario";
		$resultado = $oMysql->query($query);
		
        if ($resultado) {
            while ($linha = $resultado->fetch_object()) {
                if ($linha->cargo == 'estudante') {
                    $botoes = "<a class='btn btn-success' href='?action=promover&id_usuario=".$linha->id_usuario."'>Promover</a>";
                } elseif ($linha->cargo == 'gerente') {
                    $botoes = "<a class='btn btn-warning' href='?action=rebaixar&id_usuario=".$linha->id_usuario."'>Rebaixar</a>";
                }

                $botoes .= "<a class='btn btn-danger' href='index.php?page=3&id_usuario=".$linha->id_usuario."'>Excluir</a>";

                $html = "<tr>";
                $html .= "<td>".$botoes."</td>";
                $html .= "<td>".$linha->id_usuario."</td>";
                $html .= "<td>".$linha->nome_usuario."</td>";
                $html .= "<td>".$linha->cargo."</td>";
                $html .= "</tr>";
                echo $html;
            }
        }


        if (isset($_GET['action']) && isset($_GET['id_usuario'])) {
            $id_usuario = $_GET['id_usuario'];
            $action = $_GET['action'];

            if ($action == 'promover') {
                $query_update = "UPDATE tb_usuario SET cargo = 'gerente' WHERE id_usuario = $id_usuario";
                if ($oMysql->query($query_update)) {
                    echo "<div class='alert alert-success mt-3'>Usuário promovido para gerente!</div>";
                    // header("Location: home_admin.php"); chamar pra recarregar e ficar mais funcional
                } else {
                    echo "<div class='alert alert-danger mt-3'>Erro ao promover usuário.</div>";
                }
            } elseif ($action == 'rebaixar') {
                $query_update = "UPDATE tb_usuario SET cargo = 'estudante' WHERE id_usuario = $id_usuario";
                if ($oMysql->query($query_update)) {
                    echo "<div class='alert alert-warning mt-3'>Usuário rebaixado para estudante.</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Erro ao rebaixar usuário.</div>";
                }
            }
            elseif ($action == 'excluir') {
                $query_delete = "DELETE FROM tb_usuario WHERE id_usuario = $id_usuario";
                if ($oMysql->query($query_delete)) {
                    echo "<div class='alert alert-danger mt-3'>Usuário excluído com sucesso!</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Erro ao excluir usuário.</div>";
                }
            }
        }
	?>
	</tbody>
  </table>
</div>

</body>
</html>
