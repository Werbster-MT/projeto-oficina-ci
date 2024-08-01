<!-- Inclusão do JS do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    const hamBurger = document.querySelector(".toggle-btn");
    hamBurger.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand");
    });
</script>

<script>
// Inicializa o DataTable com tradução para o português
$(document).ready(function() {
    $('#materiaisTable').DataTable({
        "language": {
            "url": "<?=base_url('assets/js/pt-BR.json')?>" // URL para o arquivo de tradução
        }
    });
});
</script>