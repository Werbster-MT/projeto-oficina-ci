<div class="content mt-5 mb-5">
    <h2>Relatórios</h2>
    <div class="row pt-4">
        <div class="col-12">
            <a href="<?=base_url('relatorios/download_pdf')?>" class="btn btn-primary mb-3">Download PDF</a>
            <div class="table-responsive">
                <h3>Vendas</h3>
                <table class="table table-bordered">
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
                <table class="table table-bordered">
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
                <table class="table table-bordered">
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
            </div>
        </div>
    </div>
</div>
