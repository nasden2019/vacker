<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth login-full-bg" style="background: url('/webroot/img/auth/login_1.jpg')no-repeat center center / cover;">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-dark text-left p-5">
                        <h2>Login</h2>
                        <h4 class="font-weight-light">Ingresá tus datos</h4>

                        <?= $this->Form->create(null, ['class' => 'pt-5']) ?>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <?= $this->Form->input('email', ['placeholder' => __('Email'), 'required' => true, 'class' => 'form-control', 'label' => false]) ?>
                                <i class="mdi mdi-account"></i>
                            </div>
                            <div class="form-group">
                                <label for="password">Clave</label>
                                <?= $this->Form->input('password', ['placeholder' => __('Clave'), 'required' => true, 'class' => 'form-control', 'label' => false]) ?>
                                <i class="mdi mdi-eye"></i>
                            </div>
                            <div class="mt-5">
                                <?= $this->Form->button(__('Entrar'), ['class' => 'btn btn-block btn-warning btn-lg font-weight-medium']); ?>
                            </div>
                            <div class="mt-3 text-center">
                                <a href="#" class="auth-link text-white">Olvidaste tu contraseña?</a>
                            </div>
                            
                        <?= $this->Form->end() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>