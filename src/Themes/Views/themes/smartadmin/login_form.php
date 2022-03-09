                    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                        <div class="d-flex align-items-center container p-0">
                            <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                                    <img src="<?php echo base_url(); ?>/assets/img/logo2.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                                    <!--<span class="page-logo-text mr-1">SmartAdmin WebApp</span>-->
                                </a>
                            </div>
                            <a href="page_register.html" class="btn-link text-white ml-auto">
                                Criar uma conta
                            </a>
                        </div>
                    </div>
                    <div class="flex-1" style="background: url(themes/smartadmin/assets/img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                            <div class="row">
                                <div class="col col-md-6 col-lg-7 hidden-sm-down pr-3">
                                    <h2 class="fs-xxl fw-500 mt-4 text-white">
                                        Sistema de gestão para nutricionistas. <br />Seja bem vindo!
                                        <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                                            O Delidiet veio para modernizar e agilizar o atendimento dos seus pacientes. Um sistema completo, com agendamento de consultas, plano alimentar, receitas e muito mais. E os seus pacientes ainda podem contar com aplicativo móvel para ter tudo isso na palma da mão!
                                        </small>
                                    </h2>
                                    <a href="#" class="fs-lg fw-500 text-white opacity-70">Saiba mais &gt;&gt;</a>
                                    <div class="d-sm-flex flex-column align-items-center justify-content-center d-md-block">
                                        <div class="px-0 py-1 mt-5 text-white fs-nano opacity-50">
                                            Visite nossas redes sociais
                                        </div>
                                        <div class="d-flex flex-row opacity-70">
                                            <a href="#" class="mr-2 fs-xxl text-white">
                                                <i class="fab fa-facebook-square"></i>
                                            </a>
                                            <a href="#" class="mr-2 fs-xxl text-white">
                                                <i class="fab fa-twitter-square"></i>
                                            </a>
                                            <a href="#" class="mr-2 fs-xxl text-white">
                                                <i class="fab fa-google-plus-square"></i>
                                            </a>
                                            <a href="#" class="mr-2 fs-xxl text-white">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
                                    <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none">
                                        Login seguro
                                    </h1>
                                    <div class="card p-4 rounded-plus bg-faded">
                                        <form id="js-login" novalidate="" action="">
                                            <div class="form-group">
                                                <label class="form-label" for="username">Email</label>
                                                <input type="email" id="username" class="form-control form-control-lg" placeholder="your id or email" value="drlantern@gotbootstrap.com" required>
                                                <div class="invalid-feedback">Email incorreto.</div>
                                                <div class="help-block">Informe seu email</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="password">Senha</label>
                                                <input type="password" id="password" class="form-control form-control-lg" placeholder="password" value="password123" required>
                                                <div class="invalid-feedback">Senha incorreta.</div>
                                                <div class="help-block">Informe sua senha</div>
                                            </div>
                                            <div class="form-group text-left">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="rememberme">
                                                    <label class="custom-control-label" for="rememberme"> Esqueceu sua senha? Clique aqui.</label>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-lg-6 pr-lg-1 my-2">
                                                    <button type="button" class="btn btn-info btn-block btn-lg">Criar uma conta <!--<i class="fab fa-google"></i>--></button>
                                                </div>
                                                <div class="col-lg-6 pl-lg-1 my-2">
                                                  <a href="<?php echo base_url(); ?>/dashboard">
                                                    <button id="js-login-btn" type="button" class="btn btn-danger btn-block btn-lg">Entrar</button>
                                                  </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                                <?php echo date('Y') ?> © Delidiet &nbsp;<a href='https://www.delidiet.com.br' class='text-white opacity-40 fw-500' title='delidiet.com.br' target='_blank'>delidiet.com.br</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- base vendor bundle: 
			 DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations 
						+ pace.js (recommended)
						+ jquery.js (core)
						+ jquery-ui-cust.js (core)
						+ popper.js (core)
						+ bootstrap.js (core)
						+ slimscroll.js (extension)
						+ app.navigation.js (core)
						+ ba-throttle-debounce.js (core)
						+ waves.js (extension)
						+ smartpanels.js (extension)
						+ src/../jquery-snippets.js (core) -->
        <script src="<?php echo base_url(); ?>/themes/smartadmin/assets/js/vendors.bundle.js"></script>
        <script src="<?php echo base_url(); ?>/themes/smartadmin/assets/js/app.bundle.js"></script>
        <script>
            $("#js-login-btn").click(function(event)
            {

                // Fetch form to apply custom Bootstrap validation
                var form = $("#js-login")

                if (form[0].checkValidity() === false)
                {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.addClass('was-validated');
                // Perform ajax submit here...
            });

        </script>
    </body>
    <!-- END Body -->
</html>