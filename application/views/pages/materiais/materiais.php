<div class="content">
   <div class="table-responsive">
        <table id="materiaisTable" class="table table-bordered table-striped">
            <h2 class="mb-4">Materiais</h2>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Preço Compra</th>
                    <th>Preço Venda</th>
                    <th>Habilitado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($materiais as $material):?>
                    <tr>
                        <td><?= $material['id_material'] ?></td>
                        <td><?= $material['nome'] ?></td>
                        <td><?= $material['quantidade'] ?></td>
                        <td>R$<?= number_format($material['preco_compra'], 2, ',', '.') ?></td>
                        <td>R$<?= number_format($material['preco_venda'], 2, ',', '.') ?></td>
                        <td>
                            <?php if ($material['habilitado'] == 0): ?>
                                <span class="fw-bold text-danger">Não</span>
                            <?php else: ?>
                                <span class="fw-bold text-success">Sim</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="<?= base_url('materiais/edit/'.$material['id_material']) ?>" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a>
                            <a href="<?= base_url('materiais/enable/'.$material['id_material']) ?>" class="btn btn-success"><i class="fa-solid fa-check"></i></a>
                            <a href="<?= base_url('materiais/disable/'.$material['id_material']) ?>" class="btn btn-danger"><i class="fa-solid fa-ban"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>