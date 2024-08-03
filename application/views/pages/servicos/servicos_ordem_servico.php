<div class="content">
    <h2 class="mb-4">Detalhes da Ordem de Serviço</h2>

    <div class="row mb-3">
        <div class="col-12">
            <h4>Serviços</h4>
            <div class="table-responsive">
                <table id="servicosTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Serviço</th>
                            <th>Nome do Serviço</th>
                            <th>Data de Início</th>
                            <th>Data de Fim</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($servicos as $servico): ?>
                            <tr>
                                <td><?= $servico['id_servico'] ?></td>
                                <td><?= $servico['servico_nome'] ?></td>
                                <td><?= date('d/m/Y', strtotime($servico['data_inicio'])) ?></td>
                                <td><?= !empty($servico['data_fim']) ? date('d/m/Y', strtotime($servico['data_fim'])) : 'N/A' ?></td>
                                <td>R$ <?= number_format($servico['valor'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-12">
            <h4>Materiais</h4>
            <div class="table-responsive">
                <table id="materiaisTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Material</th>
                            <th>Nome do Material</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materiais as $material): ?>
                            <tr>
                                <td><?= $material['id_material'] ?></td>
                                <td><?= $material['material_nome'] ?></td>
                                <td><?= $material['quantidade'] ?></td>
                                <td>R$ <?= number_format($material['preco_unitario'], 2, ',', '.') ?></td>
                                <td>R$ <?= number_format($material['subtotal'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#servicosTable').DataTable({
        "language": {
            "url": "<?=base_url('assets/js/pt-BR.json')?>" // URL para o arquivo de tradução
        }
    });
    $('#materiaisTable').DataTable({
        "language": {
            "url": "<?=base_url('assets/js/pt-BR.json')?>" // URL para o arquivo de tradução
        }
    });
});
</script>