<div id="content-form" class="content d-flex flex-column align-items-center">
    <h2 class="mb-4 w-100 text-start">Adicionar Ordem de Serviço</h2>
    <div class="col-12">
        <form action="<?= base_url('servicos/store') ?>" method="POST" class="form-generic">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div id="servicos-container">
                        <div class="row align-items-end servico-item mb-3">
                            <div class="col-12 col-md-4 mb-3">
                                <label for="servicos" class="form-label">Serviço</label>
                                <select class="form-select servico-select" name="servicos[]" required>
                                    <option value="">Selecione um serviço</option>
                                    <?php foreach ($servicos as $servico): ?>
                                        <option value="<?= $servico['id_servico_info'] ?>" data-valor="<?= $servico['valor'] ?>">
                                            <?= $servico['nome'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <label for="data_inicio" class="form-label">Data de Início</label>
                                <input type="date" class="form-control data-inicio-input" name="datas_inicio[]" required>
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <label for="data_fim" class="form-label">Data de Fim</label>
                                <input type="date" class="form-control data-fim-input" name="datas_fim[]">
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <label for="valor_servico" class="form-label">Valor do Serviço</label>
                                <input type="number" class="form-control valor-servico-input" step="0.01" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mb-3">
                        <button type="button" class="btn btn-success btn-add-servico">Adicionar Serviço</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div id="materiais-container">
                        <div class="row align-items-end material-item mb-3">
                            <div class="col-12 col-md-4 mb-3">
                                <label for="materiais" class="form-label">Material</label>
                                <select class="form-select material-select" name="materiais[]">
                                    <option value="">Selecione um material</option>
                                    <?php foreach ($materiais as $material): ?>
                                        <option value="<?= $material['id_material'] ?>" data-preco="<?= $material['preco_venda'] ?>">
                                            <?= $material['nome'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <label for="quantidades" class="form-label">Quantidade</label>
                                <input type="number" class="form-control quantidade-input" name="quantidades[]" step="1">
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <label for="precos" class="form-label">Preço Unitário</label>
                                <input type="number" class="form-control preco-input" name="precos[]" step="0.01" readonly>
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <label for="subtotais" class="form-label">Subtotal</label>
                                <input type="number" class="form-control subtotal-input" step="0.01" readonly>
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <button type="button" class="btn btn-danger btn-remove-material">Remover</button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mb-3">
                        <button type="button" class="btn btn-success btn-add-material">Adicionar Material</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-2 mb-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <select class="form-select" id="cliente" name="cliente" required>
                        <option value="">Selecione um cliente</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente['id_cliente'] ?>"><?= $cliente['nome'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 col-md-2 mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" class="form-control" id="total" name="total" step="0.01" readonly required>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-responsive btn-primary">Salvar Ordem de Serviço</button>
                </div>
            </div>
        </form>
    </div>
</div>