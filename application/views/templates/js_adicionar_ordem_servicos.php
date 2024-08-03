<!-- Template do Material Item oculto -->
<div class="row align-items-end material-item mb-3 d-none" id="material-template">
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

<!-- Template do Serviço Item oculto -->
<div class="row align-items-end servico-item mb-3 d-none" id="servico-template">
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
    <div class="col-12 col-md-2 mb-3">
        <button type="button" class="btn btn-danger btn-remove-servico">Remover</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const servicosContainer = document.getElementById('servicos-container');
    const addServicoButton = document.querySelector('.btn-add-servico');
    const materiaisContainer = document.getElementById('materiais-container');
    const addMaterialButton = document.querySelector('.btn-add-material');
    const totalInput = document.getElementById('total');
    const materialTemplate = document.getElementById('material-template');
    const servicoTemplate = document.getElementById('servico-template');

    function addEventListenersToServicoItem(servicoItem) {
        servicoItem.querySelector('.servico-select').addEventListener('change', function(event) {
            const valor = parseFloat(event.target.selectedOptions[0].dataset.valor || 0);
            const servicoItem = event.target.closest('.servico-item');
            servicoItem.querySelector('.valor-servico-input').value = valor;
            updateTotal();
        });

        const removeButton = servicoItem.querySelector('.btn-remove-servico');
        if (removeButton) {
            removeButton.addEventListener('click', function() {
                servicoItem.remove();
                updateTotal();
                checkAtLeastOneService();
            });
        }
    }

    function addEventListenersToMaterialItem(materialItem) {
        materialItem.querySelector('.material-select').addEventListener('change', function(event) {
            const preco = parseFloat(event.target.selectedOptions[0].dataset.preco || 0);
            const materialItem = event.target.closest('.material-item');
            materialItem.querySelector('.preco-input').value = preco;
            updateSubtotal(materialItem);
            updateTotal();
        });

        materialItem.querySelector('.quantidade-input').addEventListener('input', function(event) {
            const materialItem = event.target.closest('.material-item');
            updateSubtotal(materialItem);
            updateTotal();
        });

        materialItem.querySelector('.btn-remove-material').addEventListener('click', function() {
            materialItem.remove();
            updateTotal();
        });
    }

    addServicoButton.addEventListener('click', function() {
        const newServicoItem = servicoTemplate.cloneNode(true);
        newServicoItem.id = '';
        newServicoItem.classList.remove('d-none');

        newServicoItem.querySelector('.servico-select').value = '';
        newServicoItem.querySelector('.data-inicio-input').value = '';
        newServicoItem.querySelector('.data-fim-input').value = '';
        newServicoItem.querySelector('.valor-servico-input').value = '';

        addEventListenersToServicoItem(newServicoItem);

        servicosContainer.appendChild(newServicoItem);
    });

    addMaterialButton.addEventListener('click', function() {
        const newMaterialItem = materialTemplate.cloneNode(true);
        newMaterialItem.id = '';
        newMaterialItem.classList.remove('d-none');

        newMaterialItem.querySelector('.material-select').value = '';
        newMaterialItem.querySelector('.quantidade-input').value = '';
        newMaterialItem.querySelector('.preco-input').value = '';
        newMaterialItem.querySelector('.subtotal-input').value = '';

        addEventListenersToMaterialItem(newMaterialItem);

        materiaisContainer.appendChild(newMaterialItem);
    });

    function updateSubtotal(materialItem) {
        const quantidade = parseFloat(materialItem.querySelector('.quantidade-input').value || 0);
        const preco = parseFloat(materialItem.querySelector('.preco-input').value || 0);
        const subtotal = quantidade * preco;
        materialItem.querySelector('.subtotal-input').value = subtotal.toFixed(2);
    }

    function updateTotal() {
        let total = 0;

        // Adicionar valores dos serviços
        document.querySelectorAll('.valor-servico-input').forEach(function(valorInput) {
            const valor = parseFloat(valorInput.value || 0);
            if (!isNaN(valor)) {
                total += valor;
            }
        });

        // Adicionar subtotais dos materiais
        document.querySelectorAll('.subtotal-input').forEach(function(subtotalInput) {
            const subtotal = parseFloat(subtotalInput.value || 0);
            if (!isNaN(subtotal)) {
                total += subtotal;
            }
        });

        totalInput.value = total.toFixed(2);
    }

    function checkAtLeastOneService() {
        const servicoItems = document.querySelectorAll('.servico-item');
        if (servicoItems.length === 0) {
            alert('Pelo menos um serviço deve permanecer ao atualizar a ordem de serviço.');
            const newServicoItem = servicoTemplate.cloneNode(true);
            newServicoItem.id = '';
            newServicoItem.classList.remove('d-none');

            newServicoItem.querySelector('.servico-select').value = '';
            newServicoItem.querySelector('.data-inicio-input').value = '';
            newServicoItem.querySelector('.data-fim-input').value = '';
            newServicoItem.querySelector('.valor-servico-input').value = '';

            addEventListenersToServicoItem(newServicoItem);
            servicosContainer.appendChild(newServicoItem);
        }
    }

    const initialServicoItems = document.querySelectorAll('.servico-item');
    initialServicoItems.forEach(function(servicoItem) {
        addEventListenersToServicoItem(servicoItem);
    });

    const initialMaterialItems = document.querySelectorAll('.material-item');
    initialMaterialItems.forEach(function(materialItem) {
        addEventListenersToMaterialItem(materialItem);
    });

    // Atualizar total inicial quando a página é carregada
    updateTotal();
});
</script>
