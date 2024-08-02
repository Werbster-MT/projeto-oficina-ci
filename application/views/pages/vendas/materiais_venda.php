<div class="content">
   <div class="table-responsive">
        <table id="materiaisVendaTable" class="table table-bordered table-striped">
            <h2 class="mb-4">Materiais da Venda</h2>
            <thead>
                <tr>
                    <th>ID Venda</th>
                    <th>Nome do Material</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($materiais as $material): ?>
                    <tr>
                        <td><?= $material['id_venda'] ?></td>
                        <td><?= $material['material_nome'] ?></td> <!-- Atualizado para usar material_nome -->
                        <td><?= $material['quantidade'] ?></td>
                        <td>R$<?= number_format($material['preco_unitario'], 2, ',', '.') ?></td>
                        <td>R$<?= number_format($material['subtotal'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>