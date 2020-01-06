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
    <div class="form-group d-flex align-content-center">
        <input type="checkbox" id="check" name="remember_me"/>
        
        <span>
            Mantener la sesión iniciada en este navegador.
        </span>
    </div>

    <div class="mt-5">
        <?= $this->Form->button(__('Entrar'), ['class' => 'btn btn-block btn-warning btn-lg font-weight-medium']); ?>
    </div>
    <div class="mt-3 text-center">
         <small>¿Olvidaste tu contraseña? <a href="<?=HOST?>recordar">Recordar contraseña</a>.</small>
    </div>
    
<?= $this->Form->end() ?>