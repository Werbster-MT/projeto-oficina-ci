<script>
    document.addEventListener("DOMContentLoaded", function() {
    const materiaisContainer = document.getElementById('materiais-container');
    const addMaterialButton = document.querySelector('.btn-add-material');

    function addEventListenersToMaterialItem(materialItem) {
        materialItem.querySelector('.material-select').addEventListener('change', function(event) {
            const preco = event.target.selectedOptions[0].dataset.preco;
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

        const removeButton = materialItem.querySelector('.btn-remove-material');
        if (removeButton) {
            removeButton.addEventListener('click', function() {
                materialItem.remove();
                updateTotal();
            });
        }
    }

    addMaterialButton.addEventListener('click', function() {
        const materialItem = document.querySelector('.material-item');
        const newMaterialItem = materialItem.cloneNode(true);

        newMaterialItem.querySelector('.material-select').value = '';
        newMaterialItem.querySelector('.quantidade-input').value = '';
        newMaterialItem.querySelector('.preco-input').value = '';
        newMaterialItem.querySelector('.subtotal-input').value = '';

        if (!newMaterialItem.querySelector('.btn-remove-material')) {
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('btn', 'btn-danger', 'btn-remove-material');
            removeButton.textContent = 'Remover';

            const buttonContainer = document.createElement('div');
            buttonContainer.classList.add('col-2', 'd-flex', 'align-items-end', 'mb-3');
            buttonContainer.appendChild(removeButton);

            newMaterialItem.appendChild(buttonContainer);
        }

        addEventListenersToMaterialItem(newMaterialItem);

        materiaisContainer.appendChild(newMaterialItem);
    });

    function updateSubtotal(materialItem) {
        const quantidade = materialItem.querySelector('.quantidade-input').value;
        const preco = materialItem.querySelector('.preco-input').value;
        const subtotal = quantidade * preco;
        materialItem.querySelector('.subtotal-input').value = subtotal.toFixed(2);
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal-input').forEach(function(subtotalInput) {
            total += parseFloat(subtotalInput.value);
        });
        document.getElementById('total').value = total.toFixed(2);
    }

    // Adiciona os eventos aos itens de material iniciais
    const initialMaterialItems = document.querySelectorAll('.material-item');
    initialMaterialItems.forEach(function(materialItem) {
        addEventListenersToMaterialItem(materialItem);
    });
});
</script>
