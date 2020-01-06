<div class="container">

    <div class="row">

        <div class="col-md-8">

            <div class="separador" style="height: 50px;"></div>

                <!-- Seccion : proximos eventos -->
                <section class="seccion seccion_bco cf login">

                    <hr class="hr1"></hr>
                    <div class="container">
                        
                        <div class="row justify-content-center align-content-center" style="min-height: 50vh;">
                            
                            <div class="col-sm-5">
                                    <h2 class="titulo-box">Cambiar Contraseña</h2>
                                    <p>Por favor no compartas tu clave con nadie, nadie del soporte de DoctorYA va a solicitartela.</p>

                                    <?= $this->Form->create(null, ['id' => 'formChangePassword', 'class' => 'form-perfil']) ?>
                                    <hr>
                                    <?php
                                    $email = $_GET['email'];
                                    $clave = $_GET['clave'];
                                    ?>

                                    <?= $this->Form->hidden('clave', ['value' => $clave]) ?>
                                    <?= $this->Form->hidden('email', ['value' => $email]) ?>

                            </div>
                            
                            <div class="col-sm-1"></div>

                            <div class="col-sm-5">
                                <div class="login-box">
                                    <div class="login-box-body">

                                            <div class="form-group has-feedback">
                                                <label>Nueva contraseña</label>
                                                <div class="input password">
                                                    <?= $this->Form->input('nuevo_pass', ['type' => 'password', 'required' => true, 'class' => 'form-control', 'label' => false, 'placeholder' => __('Nueva Contraseña'), 'title' =>  __('Nueva Contraseña'), 'autocomplete' => 'off']); ?>
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label>Repetir contraseña</label>
                                                <div class="input password">
                                                    <?= $this->Form->input('repetir_pass', ['type' => 'password', 'required' => true, 'class' => 'form-control', 'label' => false, 'placeholder' => __('Repetir Contraseña'), 'title' => __('Repetir Contraseña'), 'autocomplete' => 'off']); ?>
                                                </div>
                                            </div>

                                    </div>

                                    <div class="text-center margen-botones">
                                        <?= $this->Form->submit(__('Guardar'), ["class" => "btn btn-redondo btn-color chico"]) ?>
                                    </div>
                                    <?= $this->Form->end()?>

                                </div>
                            </div>

                        </div>

                    </div>

                </section>


                <div class="separador" style="height: 50px;"></div>
            </div>
        </div>
    </div>
</div>


