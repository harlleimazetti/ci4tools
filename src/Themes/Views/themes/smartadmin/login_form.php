                    
<div class="flex-1">

    <div class="flex-1 w-100 h-100 hidden-sm-down" style="position: absolute !important; background: url(<?php echo base_url(); ?>/public/assets/img/estudante_13.jpg) no-repeat right -50em top fixed; background-size: cover;">

    </div>

    <div class="height-10 w-100 shadow-0 px-4 bg-transparent">
        <div class="d-flex align-items-center container p-0">
            <div class="page-logo width-mobile-auto mt-2 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                <a href="<?php echo base_url(); ?>/home" class="page-logo-link press-scale-down d-flex align-items-center">
                    <img src="<?php echo base_url(); ?>/public/assets/img/logo_validador_estudantil_276x30.png" alt="Validador Estudantil" aria-roledescription="logo">
                    <span class="page-logo-text mr-1">Validador Estudantil</span>
                </a>
            </div>
            <!--
            <a href="#" class="btn-link text-white ml-auto">
                Criar uma conta
            </a>
            -->
        </div>
    </div>

    <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
        <div class="row">
            <div class="col col-md-5 col-lg-5 pr-3 bg-white">
                <h2 class="fs-xxl fw-500 mt-1 mb-4 color-primary-500">
                    Acesso ao sistema de gestão de carteira estudantil.
                    <!--
                    <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                        Descrição
                    </small>
                    -->
                </h2>

                <form id="form-login" method="post" action="<?php echo base_url() ?>/sistema/login/auth">
                    <div class="form-group">
                        <label class="form-label" for="login">Email</label>
                        <input type="email" name="login" id="login" class="form-control form-control-md" placeholder="Email" value="" required>
                        <div class="invalid-feedback">Email incorreto.</div>
                        <!--<div class="help-block">Informe seu email</div>-->
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Senha</label>
                        <input type="password" name="password" id="password" class="form-control form-control-md" placeholder="Senha" value="" required>
                        <div class="invalid-feedback">Senha incorreta.</div>
                        <!--<div class="help-block">Informe sua senha</div>-->
                    </div>
                    <!--
                    <div class="form-group text-left">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme">
                            <label class="custom-control-label" for="rememberme"> Esqueceu sua senha? Clique aqui.</label>
                        </div>
                    </div>
                    -->
                    <div class="row no-gutters">
                        <div class="col-lg-6 pr-lg-1 my-2">
                            <button type="button" class="btn btn-primary btn-block btn-md">Criar uma conta <!--<i class="fab fa-google"></i>--></button>
                        </div>
                        <div class="col-lg-6 pl-lg-1 my-2">
                            <button id="btn-login" type="button" class="btn bg-warning-800 btn-block btn-md color-white">Entrar</button>
                        </div>
                    </div>
                </form>

                <!--<a href="#" class="fs-lg fw-500 text-white opacity-70">Saiba mais &gt;&gt;</a>-->

                <div class="d-sm-flex flex-column align-items-center justify-content-center d-md-block">
                    <div class="px-0 py-1 mt-5 color-primary-500 fs-nano opacity-90">
                        Visite nossas redes sociais
                    </div>
                    <div class="d-flex flex-row opacity-90">
                        <a href="#" class="mr-2 fs-xxl color-primary">
                            <i class="fab fa-facebook-square"></i>
                        </a>
                        <a href="#" class="mr-2 fs-xxl color-primary">
                            <i class="fab fa-twitter-square"></i>
                        </a>
                        <a href="#" class="mr-2 fs-xxl color-primary">
                            <i class="fab fa-google-plus-square"></i>
                        </a>
                        <a href="#" class="mr-2 fs-xxl color-primary">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-7 col-lg-7 col-xl-4 ml-auto" >
              <!--
                hidden-sm-down
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
                                <button type="button" class="btn btn-info btn-block btn-lg">Criar uma conta <i class="fab fa-google"></i></button>
                            </div>
                            <div class="col-lg-6 pl-lg-1 my-2">
                              <a href="<?php //echo base_url(); ?>/dashboard">
                                <button id="js-login-btn" type="button" class="btn btn-danger btn-block btn-lg">Entrar</button>
                              </a>
                            </div>
                        </div>
                    </form>
                </div>
              -->
            </div>

            <div class="pos-bottom pos-left pos-right p-3 text-center color-primary-500">
              <?php echo date('Y') ?> © Validador Estudantil &nbsp;<a href='https://www.validadorestudantil.com.br' class='text-primary opacity-70 fw-500' title='validadorestudantil.com.br' target='_blank'>validadorestudantil.com.br</a>
            </div>

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
<script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/vendors.bundle.js"></script>
<script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/datagrid/datatables/datatables.bundle.js"></script>
<script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/app.bundle.js"></script>
<script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/formplugins/select2/select2.bundle.js"></script>
<script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/fileupload/jquery.fileupload.js"></script>
<script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/notifications/toastr/toastr.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/js/axios.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/js/libraries/js.cookie/js.cookie.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/js/javascripts.js" type="module"></script>
</body>
<!-- END Body -->
</html>