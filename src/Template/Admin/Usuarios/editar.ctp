<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <h4 class="card-title">Editar Usuario</h4>

                <?= $this->Form->create($usuario, ['type' => 'file']) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('nombre', ['class' => 'form-control', 'label' => false]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Apellido</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('apellido', ['class' => 'form-control', 'label' => false]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                                 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">E-mail</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('email', ['class' => 'form-control', 'label' => false]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Clave</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('password', ['class' => 'form-control', 'label' => false,'required' => false]); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                     
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Telefono</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('telefono', ['required' => true, 'class' => 'form-control', 'label' => false]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Roles</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('rol', ['class' => 'form-control select2', 'options' => $roles, 'empty' => 'Seleccione Rol', 'label' => false,'empty' => 'Seleccione Rol']); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="imagen" class="col-sm-3 col-form-label">Imagen perfil</label>
                                <?= $this->Form->input('imagen', ['class' => 'form-control', 'label' => false, 'type' => 'file','required'=>false]); ?>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group row">
                                    <?php echo $this->Html->image('perfiles/'.$usuario->imagen, ['alt' => 'Logo']);?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <?= $this->Html->link(
                            'Cancelar',
                            [
                                'controller' => 'usuarios',
                                'action' => 'index'
                            ], [
                                'class' => 'btn btn-light'
                            ]
                        ) ?>
                    </div>
                    
                <?= $this->Form->end() ?>
                
            </div>
        </div>
    </div>
</div>