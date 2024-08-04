<div class="content mt-5 mb-5">
    <h2>Adicionar Usuário</h2>
    <div class="row pt-4">
        <div class="col-12 col-md-6">
            <form action="<?=base_url('dashboard/store')?>" method="post">
                <div class="form-group mb-3">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="nivel_acesso">Nivel de Acesso</label>
                    <select name="nivel_acesso" id="nivel_acesso" class="form-control" required>
                        <option value="admin">Administrador</option>
                        <option value="vendedor">Vendedor</option>
                        <option value="mecanico">Mecânico</option>
                        <option value="almoxarifado">Almoxarifado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Adicionar</button>
            </form>
        </div>
    </div>
</div>
