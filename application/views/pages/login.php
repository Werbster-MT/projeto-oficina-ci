<body>
    <section class="vh-100 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-6 d-none d-md-flex justify-content-center align-items-center image-container mb-4 mb-lg-0">
                    <div class="login-title">
                        <h1 class="text-primary">Olá, Visitante!</h1>
                        <h2 class="text-muted fs-4">Seja bem vindo ao sistema Oficina Auto.</h2>
                        <picture>
                            <source class="img-fluid" media="(min-width: 1400px)" srcset="<?=base_url('assets/imgs/login.svg')?>" alt="Imagem Login">
                            <img class="img-fluid" src="<?=base_url('assets/imgs/login.png')?>" alt="Imagem Login">
                        </picture>
                    </div>
                </div>    
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-12 mx-auto form-container">
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <h1 class="fs-3 card-title fw-bold mb-4 text-center text-primary">
                                <span><img class="img-fluid" src="<?=base_url('assets/imgs/tools.png')?>" alt="Icone Ferramentas"></span> Oficina Auto
                            </h1>
                            <!-- Verificação de mensagens de erro e exibição das mesmas -->
                            <?php 
                                if (isset($login_error)) {
                                    echo "<div class='alert alert-danger'>";
                                    // Exibição de mensagens de erro específicas com base no valor do parâmetro 'error'
                                        echo $login_error;
                                    echo "</div>";
                                }
                            ?>
                            <!-- Formulário de login -->
                            <form method="POST" class="needs-validation" action="<?= base_url()?>login/enter">
                                <div class="mb-3 input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="email" class="form-control" name="email" id="email" minlength="10" autocomplete="email" placeholder="Digite seu email" required autofocus>
                                </div>

                                <div class="mb-3 input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" name="senha" id="senha" minlength="4" autocomplete="current-password" placeholder="Digite sua senha" required>
                                    <span class="input-group-text" onclick="togglePasswordVisibility()"><i id="togglePasswordIcon" class="fas fa-eye"></i></span>
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Entrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('senha');
            var togglePasswordIcon = document.getElementById('togglePasswordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordIcon.classList.remove('fa-eye');
                togglePasswordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                togglePasswordIcon.classList.remove('fa-eye-slash');
                togglePasswordIcon.classList.add('fa-eye');
            }
        }
    </script>
