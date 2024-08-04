<aside id="sidebar">
    <div class="d-flex">
        <button class="toggle-btn btn-logo" type="button">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="sidebar-logo">
            <img class="img-fluid" src="<?=base_url('assets/imgs/tools.png')?>" alt="Imagem Ferramentas" width="25" height="25">
            <a href="#">Oficina Auto</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <?php if ($user['nivel_acesso'] === 'mecanico'): ?>
            <li class="sidebar-item">
                <a href="<?=base_url('servicos')?>" class="sidebar-link">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span>Ordem de Serviços</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?=base_url('servicos/new')?>" class="sidebar-link">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Adicionar Ordem de Serviço</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($user['nivel_acesso'] === 'vendedor'): ?>
            <li class="sidebar-item">
                <a href="<?=base_url('vendas')?>" class="sidebar-link">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Vendas</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?=base_url('vendas/new')?>" class="sidebar-link">
                    <i class="fas fa-cart-plus"></i>
                    <span>Adicionar Venda</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($user['nivel_acesso'] === 'almoxarifado'): ?>
            <li class="sidebar-item">
                <a href="<?=base_url('materiais')?>" class="sidebar-link">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Materiais</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?=base_url('materiais/new')?>" class="sidebar-link">
                    <i class="fa-solid fa-box-open"></i>
                    <span>Adicionar Material</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($user['nivel_acesso'] === 'admin'): ?>
            <li class="sidebar-item">
                <a href="<?=base_url('dashboard')?>" class="sidebar-link">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="<?=base_url('relatorios')?>" class="sidebar-link">
                    <i class="fas fa-chart-simple"></i>
                    <span>Relatórios</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="<?=base_url('vendas')?>" class="sidebar-link">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Vendas</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="<?=base_url('materiais')?>" class="sidebar-link">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Materiais</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="<?=base_url('servicos')?>" class="sidebar-link">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span>Ordem de Serviços</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="<?=base_url('dashboard/new')?>" class="sidebar-link">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Adicionar Usuário</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <div class="sidebar-footer">
        <a href="<?=base_url('login/logout')?>" class="sidebar-link">
        <i class="fa-solid fa-power-off"></i>
            <span>Sair</span>
        </a>
    </div>
</aside>
