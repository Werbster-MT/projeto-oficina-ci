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
        <?php if ($user['nivel_acesso'] === 'admin' || $user['nivel_acesso'] === 'mecanico'): ?>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span>Serviços</span>
                </a>
            </li>
        <?php endif; ?>
    
        <?php if ($user['nivel_acesso'] === 'admin' || $user['nivel_acesso'] === 'vendedor'): ?>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-money-bill"></i>
                    <span>Vendas</span>
                </a>
            </li>
        <?php endif; ?>
        
        <?php if ($user['nivel_acesso'] === 'admin' || $user['nivel_acesso'] === 'almoxarifado'): ?>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Materiais</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($user['nivel_acesso'] === 'admin'): ?>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="fa-solid fa-chart-simple"></i>
                    <span>Relatórios</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Serviços</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Vendas</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Materiais</a>
                    </li>
                </ul>
            </li>    
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Adicionar Usuário</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <div class="sidebar-footer">
        <a href="<?=base_url('login/logout')?>" class="sidebar-link">
        <i class="fa-solid fa-right-from-bracket"></i>
            <span>Sair</span>
        </a>
    </div>
</aside>