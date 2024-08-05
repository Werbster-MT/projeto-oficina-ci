<div class="content mt-5 mb-5">
    <h2>Atualizar Dados</h2>
    <div class="row pt-4">
        <div class="col-12 col-md-6">
            <form action="<?=base_url('usuario/update')?>" method="post">
                <div class="form-group mb-3">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="<?= $user['nome'] ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= $user['email'] ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="senha">Nova Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="nivel_acesso">Nível de Acesso</label>
                    <input type="text" name="nivel_acesso" id="nivel_acesso" class="form-control" value="<?= $user['nivel_acesso'] ?>" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        </div>
    </div>
</div>
