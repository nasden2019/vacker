<div class="content-wrapper">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><i class="mdi mdi-account"></i> Mi cuenta</h4>

          <div class="row">
            <div class="col-md-12 col-md-offset-2">

                <div class="box-header with-border">
                  <h3 class="box-title"> </h3>
                </div>

                <?= $this->Form->create($user, ['class' => 'form-horizontal', 'type' => 'file' ]) ?>
                  <div class="box-body">
                    <div class="form-group row">
                      <label for="email" class="col-sm-2 control-label"><i class="mdi mdi-email"></i> Email</label>
                      <div class="col-sm-10">
                        <?php echo $this->Form->input('email', ['class' => 'form-control', 'label' => false]); ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                      <div class="col-sm-10">
                        <?php echo $this->Form->input('nombre', ['class' => 'form-control', 'label' => false]); ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="apellido" class="col-sm-2 control-label">Apellido</label>
                      <div class="col-sm-10">
                        <?php echo $this->Form->input('apellido', ['class' => 'form-control', 'label' => false]); ?>
                      </div>
                    </div>
                    <!--div class="form-group row">
                      <label for="dni" class="col-sm-2 control-label">DNI</label>
                      <div class="col-sm-10">
                        <?php echo $this->Form->input('dni', ['class' => 'form-control', 'label' => false]); ?>
                      </div>
                    </div-->
                    <div class="form-group row">
                      <label for="email" class="col-sm-2 control-label"><i class="mdi mdi-camera"></i> Imagen</label>
                      <div class="col-sm-10">
                        <?php echo $this->Form->input('imagen', ['class' => 'form-control', 'label' => false, 'type' => 'file']); ?>
                        <?php if(!empty($user['imagen'])):?>
                        <div id="vista_imagen">
                          <div class="divImagen" style="float:left; background:url(<?php echo $this->Url->assetUrl('img/perfiles/'.$user['imagen']) ?>)no-repeat center center / cover; width:200px; height:200px;"></div>
                          <div style="float:left;" class="infoDiv"></div>
                        </div>
                        <?php endif;?>
                      </div>
                    </div>
                    <!--div class="form-group row">
                      <label for="genero" class="col-sm-2 control-label"><i class="mdi mdi-gender-female"></i> Genero</label>
                      <div class="col-sm-10">
                        <?php
                        echo $this->Form->input('sexo', ['empty' => true, 'class' => 'form-control select2','options' => $genero, 'label' => false]);
                        ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nombre" class="col-sm-2 control-label"><i class="mdi mdi-calendar"></i> Fecha de nacimiento</label>
                      <div class="col-sm-10">
                        <?php 
                          $new_date = '02/03/2018';
                          if (!empty($user->fecha_nacimiento)){
                            /*$middle = strtotime($user_data['fecha_nacimiento']);
                            $new_date = date('d/m/Y', $middle); */
                            $new_date = $user->fecha_nacimiento->i18nFormat('dd/MM/yyyy');
                          }

                        ?>
                        <?php echo $this->Form->input('fecha_nacimiento', ['required' => false, 'type'=>'text', 'class' => 'form-control datepicker1' ,'label' => false, 'value' => $new_date]); ?>
                      </div>
                    </div-->
                    <div class="form-group row">
                      <label for="nombre" class="col-sm-2 control-label"><i class="mdi mdi-phone"></i> Teléfono</label>
                      <div class="col-sm-10">
                        <?php echo $this->Form->input('telefono', ['class' => 'form-control', 'label' => false]); ?>
                      </div>
                    </div>
                    <!--div class="form-group row">
                      <label for="nombre" class="col-sm-2 control-label"><i class="mdi mdi-map-marker"></i> Direccion</label>
                      <div class="col-sm-10">
                        <?php echo $this->Form->input('direccion', ['class' => 'form-control', 'label' => false]); ?>
                      </div>
                    </div-->
                    <hr>

                    <div class="form-group row">
                      <label for="nuevo_pass" class="col-sm-2 control-label">Nueva clave</label>
                      <div class="col-sm-10">
                        <?php echo $this->Form->input('nuevo_pass', ['class' => 'form-control', 'type' => 'password', 'label' => false]); ?>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="repetir_pass" class="col-sm-2 control-label">Repetir clave</label>
                      <div class="col-sm-10 row">
                        <?php echo $this->Form->input('repetir_pass', ['class' => 'form-control', 'type' => 'password', 'label' => false]); ?>
                      </div>
                    </div>

                  </div>
                  <div class="box-footer">
                    <?= $this->Form->button(__('Actualizar mi perfil'), ["class" => "btn btn-success pull-right", "value" => 'editar']) ?>
                  </div>
                <?= $this->Form->end() ?>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    $.preImagen({
      input   : "#imagen",
      imgDiv  : ".divImagen",
      infDiv  : ".infoDiv"
    });
  });
</script>
