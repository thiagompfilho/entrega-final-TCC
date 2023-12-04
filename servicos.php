<?php
//session_start();
include_once('mysql.php');

$pdo = conectar();

// Inicializa a variável de pesquisa
$pesquisa = '';

// Verifica se o formulário de pesquisa foi enviado
if (isset($_POST['btnPesquisar'])) {
    $pesquisa = $_POST['pesquisa'];

    // Consulta, traz dados da tabela filtrando pelo nome do serviço
    $sql = "SELECT * FROM tb_servicos WHERE nome LIKE :pesquisa";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':pesquisa', '%' . $pesquisa . '%', PDO::PARAM_STR);
    $stmt->execute();

    // Buscando todas as linhas da tabela
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Se o formulário de pesquisa não foi enviado, traz todos os serviços
    $sql = "SELECT * FROM tb_servicos";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Buscando todas as linhas da tabela
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de serviços cadastrados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            background-color: #343a40;
            color: #fff;
        }

        .btn-alteracao {
            background-color: #ffc107;
            color: #333;
        }

        .btn-exclusao {
            background-color: #dc3545;
            color: #fff;
        }

        /* Adicione estilos para a barra de pesquisa */
        .pesquisa-container {
            margin-bottom: 20px;
        }
    </style>
</head>

<body background="img/planodefundo1.webp">
    <div class="container">
        <h2 class="text-center">Lista de Serviços Cadastrados</h2>

        <!-- Barra de pesquisa -->
        <div class="pesquisa-container">
            <form method="POST" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Pesquisar por nome do serviço" name="pesquisa" value="<?php echo $pesquisa; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" name="btnPesquisar">Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabela de serviços -->
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $r) { ?>
                    <tr>
                        <td><?php echo $r['codservico']; ?></td>
                        <td><?php echo $r['nome']; ?></td>
                        <td>R$ <?php echo number_format($r['valor'], 2, ',', '.'); ?></td>
                        <td><?php echo $r['ativo']; ?></td>
                        <td>
                            <a href="servalt.php?id=<?php echo $r['codservico']; ?>" class="btn btn-alteracao">ALTERAÇÃO</a>
                            <a href="servex.php?id=<?php echo $r['codservico']; ?>" class="btn btn-exclusao">EXCLUSÃO</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="somenteadm.php" class="btn btn-secondary">Voltar</a>
        <a href="servcadas.php" class="btn btn-primary">Cadastro de Serviço</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>
