<div class="content">
   <div class="table-responsive">
        <table id="vendasTable" class="table table-bordered table-striped">
            <h2 class="mb-4">Vendas</h2>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Usuário</th>
                    <th>Cliente</th>
                    <th>ID Cliente</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($vendas as $venda):?>
                    <tr>
                        <td><?= $venda['id_venda'] ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($venda['data'])) ?></td>
                        <td><?= $venda['usuario'] ?></td>
                        <td><?= $venda['cliente_nome']?></td>
                        <td><?= $venda['id_cliente']?></td>
                        <td>R$<?= number_format($venda['total'], 2, ',', '.') ?></td>
                        <td>
                            <!-- Link para editar a venda, passando o ID da venda como parâmetro na URL -->
                            <a href="<?= base_url('vendas/show_materials/'.$venda['id_venda']) ?>" class="btn btn-info"><i class="fas fa-cubes"></i></a> 
                            <a href="<?= base_url('vendas/edit/'.$venda['id_venda']) ?>" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a>
                            <a href="<?= base_url('vendas/delete/'.$venda['id_venda']) ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
