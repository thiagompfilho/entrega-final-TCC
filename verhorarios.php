<?php
include_once('mysql.php');

$pdo = conectar();

// Verificar se o formulário de pesquisa foi enviado
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];

    // consulta para buscar horários disponíveis que correspondem à pesquisa
    $sql = "SELECT * FROM tb_agendas WHERE statusa = 'A' AND horario LIKE :search_term";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search_term', "%$search_term%", PDO::PARAM_STR);
    $stmt->execute();

    // buscando todas as linhas da tabela
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // consulta padrão para exibir todos os horários disponíveis
    $sql = "SELECT * FROM tb_agendas WHERE statusa = 'A'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // buscando todas as linhas da tabela
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de clientes Agendados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
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

        </style>
</head>

<body background="img/planodefundo1.webp">
    <div class="container">
        <h2 class="text-center">Lista de Horários Disponíveis</h2>
        <form method="post" class="form-inline justify-content-center my-4">
            <div class="form-group">
                <input type="text" class="form-control mr-2" name="search_term" placeholder="Pesquisar por hora">
                <button type="submit" class="btn btn-primary" name="search">Pesquisar</button>
            </div>
        </form>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Hora</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Serviços</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $r) { ?>
                    <tr>
                    <td><?php echo date('H:i', strtotime($r['horario'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($r['dataag'])); ?></td>
                        <td><?php echo $r['statusa']; ?></td>
                        <td><?php echo $r['procedimento']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="pga1.php" class="btn btn-secondary">Voltar</a>
    </div>
</body>

</html>
