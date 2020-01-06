<div class="container">

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="separador" style="height: 50px;"></div>

                <!-- Seccion : proximos eventos -->
                <section class="seccion seccion_bco cf login">

                    <hr class="hr1"></hr>

                    <h2><strong>Restablecer contraseña</strong></h2>
                    <p class="descripcion">
                        Ingresá tu dirección de correo electrónico.
                    </p>

                    <div class="register-content">
                        <?= $this->Form->create() ?>
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 15px">
                                <?= $this->Form->input('email', ['placeholder' => __('Email'), 'class' => 'form-control', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="register-buttons">
                                    
                            <?= $this->Form->button(__('Enviar'), ['class' => 'btn greenlink btn-block btn-lg']); ?>
                        </div>

                        <hr class="hr3">

                    <?= $this->Form->end() ?>
                </div>

            </section>


            <div class="separador" style="height: 100px;"></div>
        </div>

    </div>

</div>

<div class="separador" style="height: 50px;"></div>
<?php $datos = [
  'usuario' => $this->request->session()->read('Auth.User'),
]; ?>