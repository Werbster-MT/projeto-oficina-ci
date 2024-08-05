<!DOCTYPE html>
<html>
<head>
    <title>Relatório PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Relatório</h2>
    <h3>Vendas</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Usuário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendas as $venda): ?>
                <tr>
                    <td><?= $venda['id_venda'] ?></td>
                    <td><?= $venda['data'] ?></td>
                    <td><?= $venda['usuario'] ?></td>
                    <td><?= $venda['total'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Serviços</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data Início</th>
                <th>Data Fim</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($servicos as $servico): ?>
                <tr>
                    <td><?= $servico['id_servico'] ?></td>
                    <td><?= $servico['data_inicio'] ?></td>
                    <td><?= $servico['data_fim'] ?></td>
                    <td><?= $servico['valor'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Materiais</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Preço Compra</th>
                <th>Preço Venda</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($materiais as $material): ?>
                <tr>
                    <td><?= $material['id_material'] ?></td>
                    <td><?= $material['nome'] ?></td>
                    <td><?= $material['quantidade'] ?></td>
                    <td><?= $material['preco_compra'] ?></td>
                    <td><?= $material['preco_venda'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>