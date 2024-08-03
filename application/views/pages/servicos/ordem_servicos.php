<div class="content">
    <h2 class="mb-4">Ordem de Serviços</h2>
    <div class="table-responsive">
        <table id="<?=$table?>" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Cliente</th>
                    <th>ID Cliente</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ordem_servicos as $ordem_servico): ?>
                    <tr>
                        <td><?= $ordem_servico['id_ordem_servico'] ?></td>
                        <td><?= $ordem_servico['usuario'] ?></td>
                        <td><?= $ordem_servico['cliente_nome'] ?></td>
                        <td><?= $ordem_servico['cliente'] ?></td>
                        <td><?= $ordem_servico['total'] ?></td>
                        <td>
                            <a href="<?= base_url('servicos/view/' . $ordem_servico['id_ordem_servico']) ?>" class="btn btn-info btn-sm"><i class="fas fa-wrench"></i></a>
                            <a href="<?= base_url('servicos/edit/' . $ordem_servico['id_ordem_servico']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-pencil"></i></a>
                            <a href="<?= base_url('servicos/delete/' . $ordem_servico['id_ordem_servico']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta ordem de serviço?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
