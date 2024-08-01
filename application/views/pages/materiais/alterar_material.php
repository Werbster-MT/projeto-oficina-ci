<div id="content-form" class="content d-flex flex-column align-items-center">
    <h2 class="mb-4 w-100 text-start">Alterar Material</h2>
    <div class="col-12">
        <form action="<?= base_url('materiais/update/' . $material['id_material']) ?>" method="POST" class="form-generic">
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Material</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= $material['nome'] ?>" required>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" required><?= $material['descricao'] ?></textarea>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="row d-flex align-items-start justify-content-between">
                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <input type="number" class="form-control" id="quantidade" name="quantidade" value="<?= $material['quantidade'] ?>" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label for="precoCompra" class="form-label">Preço de Compra</label>
                            <input type="number" class="form-control" id="precoCompra" name="preco_compra" value="<?= $material['preco_compra'] ?>" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="mb-4">
                            <label for="precoVenda" class="form-label">Preço de Venda</label>
                            <input type="number" class="form-control" id="precoVenda" name="preco_venda" value="<?= $material['preco_venda'] ?>" step="0.01" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col-12 col-md-6 text-center">
                    <button type="submit" class="btn btn-responsive btn-primary">Salvar Alterações</button>
                </div>
            </div>
        </form>
    </div>
</div>