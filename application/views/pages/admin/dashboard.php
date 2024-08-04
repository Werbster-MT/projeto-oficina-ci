<div class="content">
    <h2>Dashboard</h2>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Entradas do Dia</p>
                        <h6 class="mb-0"><?= number_format($entradas_dia, 2, ',', '.') ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-chart-bar fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Saídas do Dia</p>
                        <h6 class="mb-0"><?= number_format($saidas_dia, 2, ',', '.') ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-chart-area fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Saldo do Mês</p>
                        <h6 class="mb-0"><?= number_format($saldo_mes, 2, ',', '.') ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-chart-pie fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Vendas do Dia</p>
                        <h6 class="mb-0"><?= $vendas_dia ?></h6>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-tools fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Serviços do Dia</p>
                        <h6 class="mb-0"><?= $servicos_dia ?></h6>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-cubes fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Materiais Cadastrados</p>
                        <h6 class="mb-0"><?= $materiais_cadastrados ?></h6>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-users fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total de Funcionários</p>
                        <h6 class="mb-0"><?= $total_funcionarios ?></h6>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-user-friends fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total de Clientes</p>
                        <h6 class="mb-0"><?= $total_clientes ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid pt-4 px-4 mb-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="mb-0">Vendas do Mês</h3>
                    </div>
                    <canvas id="vendasChart" width="300" height="150"></canvas>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="mb-0">Serviços do Mês</h3>
                    </div>
                    <canvas id="servicosChart" width="300" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inclusão do Chart.js para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // Gráfico de Faturamento Mensal de Vendas
        var ctxVendas = document.getElementById('vendasChart').getContext('2d');
        var vendasChart = new Chart(ctxVendas, {
            type: 'line',
            data: {
                labels: [<?php foreach ($faturamento_mensal_vendas as $data) { echo '"' . $data['data'] . '",'; } ?>],
                datasets: [{
                    label: 'Faturamento Diário de Vendas',
                    data: [<?php foreach ($faturamento_mensal_vendas as $data) { echo $data['faturamento_mensal'] . ','; } ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Faturamento Mensal de Serviços
        var ctxServicos = document.getElementById('servicosChart').getContext('2d');
        var servicosChart = new Chart(ctxServicos, {
            type: 'line',
            data: {
                labels: [<?php foreach ($faturamento_mensal_servicos as $data) { echo '"' . $data['data'] . '",'; } ?>],
                datasets: [{
                    label: 'Faturamento Diário de Serviços',
                    data: [<?php foreach ($faturamento_mensal_servicos as $data) { echo $data['faturamento_mensal'] . ','; } ?>],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>